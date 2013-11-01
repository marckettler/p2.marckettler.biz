<?php
class users_controller extends base_controller
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function signup()
	{		
		# Setup view
		$this->template->content = View::instance('v_users_signup');
		$this->template->title   = "Sign Up";
        $this->template->content->common_form_inputs = View::instance("v_common_form_inputs");
		# Render template
		echo $this->template;	
	} #end signup
	
	public function p_signup()
	{
		$this->userObj->signup($_POST);
		Router::redirect("/users/profile/");
	} #end signup post
		
	public function login($error = NULL)
	{
		# Setup view
		$this->template->content = View::instance("v_users_login");
		$this->template->title   = "Log In";
        $this->template->content->error = $error;
        $this->template->content->common_form_inputs = View::instance("v_common_form_inputs");
        # Add blooper specific css
        $client_files_head = Array("/css/blooper.css");
        $this->template->client_files_head = Utils::load_client_files($client_files_head);
		echo $this->template;
	} #end login
	
	public function p_login()
	{	
		# Check to see if User is in the database login method will sanitize inputs
		$user_token = $this->userObj->login($_POST['email'],$_POST['password']);
		
		if($user_token)
		{
			Router::redirect("/");
		}
		else
		{	
			# Invalid loging attempt redirect to login page
			Router::redirect("/users/login/error");
		}		
	} # end login post	
		
	public function logout()
	{
		#Log the current user out
		$this->userObj->logout($this->user->email);
		#Redirect to index
		Router::redirect('/');
	} # end logout
	
	public function profile()
	{
		#Secure the page by redirecting users not logged in
		if(!$this->user)
		{
			Router::redirect('/users/login');
		}
		else
		{
			#Setup view
			$this->template->content = View::instance('v_users_profile');
			$this->template->title = "Profile of ".$this->user->first_name;
			echo $this->template;
		}
	} # end profile

    private function get_all_users()
    {
        # Build the query to get all the users
        $q = "SELECT * FROM users";

        # Execute the query to get all the users.
        return DB::instance(DB_NAME)->select_rows($q);

    } # end get_all_users

    private function get_followers()
    {
        # Build the query to figure out what connections does this user already have?
        # I.e. who are they following
        $q = "SELECT *
        FROM users_users
        WHERE user_id = ".$this->user->user_id;

        # Execute this query with the select_array method
        # select_array will return our results in an array and use the "users_id_followed" field as the index.
        # This will come in handy when we get to the view
        # Store our results (an array) in the variable $connections
        return DB::instance(DB_NAME)->select_array($q, 'user_id_followed');
    } # end get_followers

    private function get_following_me()
    {
        # Build the query to figure out who is following me
        $q = "SELECT *
        FROM users_users
        WHERE user_id_followed = ".$this->user->user_id;

        # Execute this query with the select_array method
        # select_array will return our results in an array and use the "users_id" field as the index.
        # This will come in handy when we get to the view
        return DB::instance(DB_NAME)->select_array($q, 'user_id');
    }

	public function show_all_users()
	{
        # Set up the View
        $this->template->content = View::instance("v_show_all_users");
        $this->template->title   = "Users";
        $this->template->content->current_user_id = $this->user->user_id;

        # Pass data (users and connections) to the view
        $this->template->content->users       = $this->get_all_users();
        $this->template->content->connections = $this->get_followers();

        # Render the view
        echo $this->template;
	} # end show_all_users

    public function follow($user_id_followed)
    {
        # Prepare the data array to be inserted
        $data = Array(
            "created" => Time::now(),
            "user_id" => $this->user->user_id,
            "user_id_followed" => $user_id_followed
        );

        # Do the insert
        DB::instance(DB_NAME)->insert('users_users', $data);

        # Send them back
        Router::redirect("/users/show_all_users");
    } # end follow

    public function followed_by()
    {
        # Set up the View
        $this->template->content = View::instance("v_following");
        $this->template->title   = "Users Following Me";

        # Pass data (users and connections) to the view
        $this->template->content->users       = $this->get_all_users();
        $this->template->content->connections = $this->get_following_me();

        # Render the view
        echo $this->template;
    }

    public function following()
    {
        # Set up the View
        $this->template->content = View::instance("v_following");
        $this->template->title   = "Users I Follow";
        $this->template->content->current_user_id = $this->user->user_id;

        # Pass data (users and connections) to the view
        $this->template->content->users       = $this->get_all_users();
        $this->template->content->connections = $this->get_followers();

        # Render the view
        echo $this->template;
    } #end following

    public function unfollow($user_id_to_unfollow)
    {
        $cond = "WHERE user_id =".$this->user->user_id." AND user_id_followed = ".$user_id_to_unfollow;
        DB::instance(DB_NAME)->delete('users_users', $cond );
        Router::redirect("/users/show_all_users");
    } # end unfollow
} # eoc
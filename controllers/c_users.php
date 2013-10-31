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
		$this->template->content = View::instance('v_users_login');
		$this->template->title   = "Log In";
        $this->template->content->error = $error;
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
	
	public function show_all_users()
	{
        # Set up the View
        $this->template->content = View::instance("v_show_all_users");
        $this->template->title   = "Users";
        $this->template->content->current_user_id = $this->user->user_id;

        # Build the query to get all the users
        $q = "SELECT * FROM users";

        # Execute the query to get all the users.
        # Store the result array in the variable $users
        $users = DB::instance(DB_NAME)->select_rows($q);

        # Build the query to figure out what connections does this user already have?
        # I.e. who are they following
        $q = "SELECT *
        FROM users_users
        WHERE user_id = ".$this->user->user_id;

        # Execute this query with the select_array method
        # select_array will return our results in an array and use the "users_id_followed" field as the index.
        # This will come in handy when we get to the view
        # Store our results (an array) in the variable $connections
        $connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');

        # Pass data (users and connections) to the view
        $this->template->content->users       = $users;
        $this->template->content->connections = $connections;

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

    public function following()
    {
        # Set up the View
        $this->template->content = View::instance("v_show_all_users");
        $this->template->title   = "Users";
        $this->template->content->current_user_id = $this->user->user_id;

        # Get the users I am following
        $q = "SELECT *
        FROM users_users
        WHERE user_id = ".$this->user->user_id;

        # Execute this query with the select_array method
        # select_array will return our results in an array and use the "users_id_followed" field as the index.
        # This will come in handy when we get to the view
        # Store our results (an array) in the variable $connections
        $connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');

        # Pass data (users and connections) to the view
        $this->template->content->users       = $users;
        $this->template->content->connections = $connections;

        # Render the view
        echo $this->template;
    }
} # eoc
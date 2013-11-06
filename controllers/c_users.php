<?php
class users_controller extends base_controller
{
    /*-------------------------------------------------------------------------------------------------
      Users Controller
     -------------------------------------------------------------------------------------------------*/
	public function __construct()
	{
		parent::__construct();
	}
	# Render Sign up page
	public function signup()
	{
        # If logged in goto index
        if($this->user)
        {
            Router::redirect("/");
        }
		# Setup view
		$this->template->content = View::instance('v_users_signup');
		$this->template->title   = "Sign Up";
        $this->template->content->common_form_inputs = View::instance("v_common_form_inputs");
		# Render template
		echo $this->template;	
	} #end signup

    # Process Signup
	public function p_signup()
	{
        $_POST['first_name'] = $this->stop_xss($_POST['first_name']);
        $_POST['last_name'] = $this->stop_xss($_POST['last_name']);
        # User Object performs sanitized input
        $this->user = $this->userObj->signup($_POST);
        # Creates and Saves an avatar
        $this->userObj->create_initial_avatar($this->user["user_id"]);
        $this->userObj->login($_POST["email"],$_POST["password"]);
        # Sign up complete forward to profile page
		Router::redirect("/profile/view/");
	} #end signup post

    # Render Log In Page
	public function login($error = NULL)
	{
        # If logged in goto index
        if($this->user)
        {
            Router::redirect("/");
        }
		# Setup view
		$this->template->content = View::instance("v_users_login");
		$this->template->title   = "Log In";
        if($error=="error")
        {
            $this->template->content->error = $error;
        }
        $this->template->content->common_form_inputs = View::instance("v_common_form_inputs");
		echo $this->template;
	} #end login

    # Process login
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
			# Invalid login attempt redirect to login page with error flag
			Router::redirect("/users/login/error");
		}		
	} # end login post	

    # Logout
	public function logout()
	{
		#Log the current user out
		$this->userObj->logout($this->user->email);
		#Redirect to index
		Router::redirect('/');
	} # end logout

    # Render Show all Users Page
	public function show_all_users($param = NULL)
	{
        # Set up the View
        $this->template->content = View::instance("v_users_show_all_users");
        $this->template->title   = "Users";
        $this->template->content->current_user_id = $this->user->user_id;

        # Pass data (users and connections) to the view
        $this->template->content->users       = $this->get_all_users();
        $this->template->content->following = $this->get_following($this->user->user_id);
        ($param=="new_follow" ? $this->template->content->new_follow=$param : "do nothing");
        ($param=="new_unfollow" ? $this->template->content->new_unfollow=$param : "do nothing" );
        # Render the view
        echo $this->template;
	} # end show_all_users

    # Currently logged in user follows passed in user_id
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
        Router::redirect("/users/show_all_users/new_follow");
    } # end follow

    public function followed_by()
    {
        # Set up the View
        $this->template->content = View::instance("v_users_following_me");
        $this->template->title   = "Users Following Me";

        # Pass data (users and connections) to the view
        $this->template->content->users       = $this->get_all_users();
        $this->template->content->following_me = $this->get_following_me($this->user->user_id);
        $this->template->content->following = $this->get_following($this->user->user_id);
        # Render the view
        echo $this->template;
    }

    public function following()
    {
        # Set up the View
        $this->template->content = View::instance("v_users_following");
        $this->template->title   = "Users I Follow";
        $this->template->content->current_user_id = $this->user->user_id;

        # Pass data (users and connections) to the view
        $following = $this->get_following($this->user->user_id);
        $this->template->content->users       = $this->get_all_users();
        $this->template->content->following = $following;
        if(empty($following))
        {
            $this->template->content->not_following = true;
        }
        # Render the view
        echo $this->template;
    } #end following

    public function unfollow($user_id_to_unfollow)
    {
        $cond = DB::instance(DB_NAME)->sanitize("WHERE user_id =".$this->user->user_id." AND user_id_followed = ".$user_id_to_unfollow);
        DB::instance(DB_NAME)->delete('users_users', $cond );
        Router::redirect("/users/show_all_users/new_unfollow");
    } # end unfollow

    # DB call that gets all users
    protected function get_all_users()
    {
        # Build the query to get all the users
        $q = "SELECT * FROM users";
        return DB::instance(DB_NAME)->select_rows($q);

    } # end get_all_users
} # eoc
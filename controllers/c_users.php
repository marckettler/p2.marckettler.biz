<?php
class users_controller extends base_controller
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
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
	
	public function p_signup()
	{
        $_POST['first_name'] = $this->stop_xss($_POST['first_name']);
        $_POST['last_name'] = $this->stop_xss($_POST['last_name']);
        $this->user = $this->userObj->signup($_POST);
        $this->userObj->create_initial_avatar($this->user["user_id"]);
        $avatar_img = new Image($this->user->avatar);
        $avatar_img->resize(100,100);
        $avatar_img->save_image($this->user->avatar);
		Router::redirect("/profile/view/");
	} #end signup post
		
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

	public function show_all_users()
	{
        # Set up the View
        $this->template->content = View::instance("v_users_show_all_users");
        $this->template->title   = "Users";
        $this->template->content->current_user_id = $this->user->user_id;

        # Pass data (users and connections) to the view
        $this->template->content->users       = $this->get_all_users();
        $this->template->content->connections = $this->get_following();

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
        $this->template->content = View::instance("v_users_following_me");
        $this->template->title   = "Users Following Me";

        # Pass data (users and connections) to the view
        $this->template->content->users       = $this->get_all_users();
        $this->template->content->following_me = $this->get_following_me();
        $this->template->content->following = $this->get_following();
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
        $this->template->content->users       = $this->get_all_users();
        $this->template->content->following = $this->get_following();

        # Render the view
        echo $this->template;
    } #end following

    public function unfollow($user_id_to_unfollow)
    {
        $cond = DB::instance(DB_NAME)->sanitize("WHERE user_id =".$this->user->user_id." AND user_id_followed = ".$user_id_to_unfollow);
        DB::instance(DB_NAME)->delete('users_users', $cond );
        Router::redirect("/users/show_all_users");
    } # end unfollow
} # eoc
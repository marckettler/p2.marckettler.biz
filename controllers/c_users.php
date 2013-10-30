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
	
	public function list_all_users()
	{
		echo "not yet implemented";	
	}
} # eoc
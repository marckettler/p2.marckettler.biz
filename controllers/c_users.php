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
		# More data we want stored with the user
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();
		
		# Encrypt the password  
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);            
		
		# Create an encrypted token via their email address and a random string
		$_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string()); 
		
		# Insert this user into the database 
		$user_id = DB::instance(DB_NAME)->insert("users", $_POST);
		
		# For now, just confirm they've signed up - 
		# You should eventually make a proper View for this
		echo $user_id." You're signed up now <a href='http://p2.marckettler.loc/'>Click Me</a>";		
	} #end signup post
		
	public function login()
	{
		# Setup view
		$this->template->content = View::instance('v_users_login');
		$this->template->title   = "Log In";
		echo $this->template;
	} #end login
	
	public function p_login()
	{
		# Sanitize the user entered data
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);
		
		# Check to see if User is in the database 
		$user_token = $this->userObj->login($_POST['email'],$_POST['password']);
		
		if($user_token)
		{
			Router::redirect("/users/profile/".$this->user->first_name);
		}
		else
		{	
			# Invalid loging attempt redirect to login page
			Router::redirect("/users/login/");
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
		if(!$this->user)
		{
			Router::redirect('users/login');
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
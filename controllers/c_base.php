<?php

class base_controller {
	
	public $user;
	public $userObj;
	public $template;
	public $email_template;

	/*-------------------------------------------------------------------------------------------------

	-------------------------------------------------------------------------------------------------*/
	public function __construct() {
						
		# Instantiate User obj
			$this->userObj = new User();
			
		# Authenticate / load user
			$this->user = $this->userObj->authenticate();					
						
		# Set up templates
			$this->template 	  = View::instance('_v_template');
			$this->email_template = View::instance('_v_email');			
								
		# So we can use $user in views			
			$this->template->set_global('user', $this->user);
			
	}

    # Method to clean inputs that include XSS Attacks
    protected function stop_xss($input)
    {
        return strip_tags($input);
    } # End stop_xss

    # DB call that gets all users as a
    protected function get_all_users()
    {
        # Build the query to get all the users
        $q = "SELECT * FROM users";

        # Execute the query to get all the users no need to sanitize
        # as there is no user input in the query
        return DB::instance(DB_NAME)->select_rows($q);

    } # end get_all_users

    # DB Call to return users following the logged in user as an array
    protected function get_following()
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
    } # End get_following

    protected function get_following_me()
    {
        # Build the query to figure out who is following me
        $q = "SELECT *
        FROM users_users
        WHERE user_id_followed = ".$this->user->user_id;

        # Execute this query with the select_array method
        # select_array will return our results in an array and use the "users_id" field as the index.
        # This will come in handy when we get to the view
        # user_id is the user that is following me
        return DB::instance(DB_NAME)->select_array($q, 'user_id');
    } # End get_following_me
} # eoc

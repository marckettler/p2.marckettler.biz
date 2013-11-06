<?php

class base_controller {
	
	public $user;
	public $userObj;
	public $template;
	public $email_template;
    public $bloopify;
	/*-------------------------------------------------------------------------------------------------
    Base Controller for all other controllers
	-------------------------------------------------------------------------------------------------*/
	public function __construct()
    {
		# Instantiate User obj
			$this->userObj = new User();

		# Authenticate / load user
   			$this->user = $this->userObj->authenticate();
		# Set up templates
			$this->template 	  = View::instance('_v_template');
			$this->email_template = View::instance('_v_email');
		# So we can use $user in views			
			$this->template->set_global('user', $this->user);
        # Trigger Bloopify
            $this->bloopify = $this->is_bloopified();
            $this->template->set_global('bloopify', $this->bloopify);
	} # end constructor

    # Method to clean inputs that include XSS Attacks
    protected function stop_xss($input)
    {
        # Probably need to do more than this
        return strip_tags($input);
    } # End stop_xss

    # Check to see if logged in user is bloopified or not
    private function is_bloopified()
    {
        # MEMBERS ONLY FEATURE!!!!!
        if(!$this->user)
        {
            return false;
        }

        $q = "SELECT bloopify FROM users WHERE user_id=".$this->user->user_id;
        $row = DB::instance(DB_NAME)->select_row($q);
        return $row['bloopify'];
    } # end is_bloopified

    # DB Call to return users the current user is following as an array
    # Used in more than one subclass. Trying to stay DRY
    protected function get_following($user_id)
    {
        # Build the query to figure out what connections does this user already have?
        # I.e. who are they following
        $q = "SELECT *
        FROM users_users
        WHERE user_id = ".$user_id;

        # Execute this query with the select_array method
        # select_array will return our results in an array and use the "users_id_followed" field as the index.
        # This will come in handy when we get to the view
        # Store our results (an array) in the variable $connections
        return DB::instance(DB_NAME)->select_array($q, 'user_id_followed');
    } # End get_following

    # DB Call to return users following the logged in user as an array
    # Used in more than one subclass. Trying to stay DRY
    protected function get_following_me($user_id)
    {
        # Build the query to figure out who is following me
        $q = "SELECT *
        FROM users_users
        WHERE user_id_followed = ".$user_id;

        # Execute this query with the select_array method
        # select_array will return our results in an array and use the "users_id" field as the index.
        # This will come in handy when we get to the view
        # user_id is the user that is following me
        return DB::instance(DB_NAME)->select_array($q, 'user_id');
    } # End get_following_me
} # eoc

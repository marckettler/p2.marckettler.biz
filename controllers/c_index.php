<?php

class index_controller extends base_controller {
	
	/*-------------------------------------------------------------------------------------------------
    Controller for landing page
	-------------------------------------------------------------------------------------------------*/
	public function __construct() {
		parent::__construct();
	} # end constructor
		
	/*-------------------------------------------------------------------------------------------------
	Accessed via http://localhost/index/index/
	-------------------------------------------------------------------------------------------------*/
	public function index() {
		
		# Any method that loads a view will commonly start with this
		# First, set the content of the template with a view file
			$this->template->content = View::instance('v_index_index');
			
		# Now set the <title> tag
			$this->template->title = "This is Blooper";
	      					     		
		# Render the view
			echo $this->template;

	} # End index
} # End of class

<?php

class bloopify_controller extends base_controller {

    /*-------------------------------------------------------------------------------------------------
    Controller for the Bloopify Feature
    -------------------------------------------------------------------------------------------------*/
    public function __construct() {
        parent::__construct();
        # Members only
        if(!$this->user)
        {
            Router::redirect("/");
        }
    } # end constructor

    # Flip the bloopify switch for the current user
    public function bloopify_me($param)
    {
        $array = ($this->bloopify ? array("bloopify" => 0) : array("bloopify" => 1));
        $cond = "WHERE user_id=".$this->user->user_id;
        DB::instance(DB_NAME)->update("users",$array,$cond);
        # Catch the $param and convert it to the location we just came from.
        $loc = str_replace(" ","/",$param);
        Router::redirect("/".$loc);
    } # end bloopify_me
} # End of class

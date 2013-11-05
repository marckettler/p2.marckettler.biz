<?php

class bloopify_controller extends base_controller {

    /*-------------------------------------------------------------------------------------------------

    -------------------------------------------------------------------------------------------------*/
    public function __construct() {
        parent::__construct();
        if(!$this->user)
        {
            Router::redirect("/");
        }
    }

    public function bloopify_me($param)
    {
        $array = ($this->bloopify ? array("bloopify" => 0) : array("bloopify" => 1));
        $cond = "WHERE user_id=".$this->user->user_id;
        DB::instance(DB_NAME)->update("users",$array,$cond);
        $loc = str_replace(" ","/",$param);
        Router::redirect("/".$loc);
    }
} # End of class

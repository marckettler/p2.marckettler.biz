<?php
class profile_controller extends base_controller
{
	public function __construct()
	{
		parent::__construct();
        if(!$this->user){
            Router::redirect("/");
        }
	}

    public function view($updated = NULL)
    {
        #Setup view
        $this->template->content = View::instance('v_profile_view');
        $this->template->title = "Profile of ".$this->user->first_name;
        if($updated=="updated")
        {
            $this->template->content->updated = $updated;
        }
        $this->template->content->num_following = count($this->get_following());
        $this->template->content->num_following_me = count($this->get_following_me());
        echo $this->template;
    } # end view

    public function edit($email_error = NULL)
    {
        #Setup view
        $this->template->content = View::instance('v_profile_edit');
        $this->template->title = "Profile of ".$this->user->first_name;
        if($email_error=="email_error")
        {
            $this->template->content->email_error = $email_error;
        }
        echo $this->template;
    } # end edit

    public function p_edit()
    {
        # Check to see if email is unchanged
        $email_unchanged = $this->user->email == $_POST["email"];
        $first_name_unchanged = $this->user->first_name == $_POST["first_name"];
        $last_name_unchanged = $this->user->last_name == $_POST["last_name"];
        $email_unique = $this->userObj->confirm_unique_email($_POST["email"]);

        if( $email_unchanged || $email_unique)
        {
            # Email valid to change now check to if they changed something
            if($email_unchanged && $first_name_unchanged && $last_name_unchanged)
            {
                # If nothing has changed redirect to redirect to view
                Router::redirect("/profile/view");
            }

            # set up query to update user
            $_POST["modified"] = Time::now();
            $cond = "WHERE user_id=".$this->user->user_id;
            DB::instance(DB_NAME)->update("users",$_POST,$cond);
            Router::redirect("/profile/view/updated");
        }
        else
        {
            Router::redirect("/profile/edit/email_error");
        }
    } # end p_edit
} # eoc
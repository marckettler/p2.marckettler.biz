<?php
class posts_controller extends base_controller
{
	
	public function __construct()
	{
		parent::__construct();
        if(!$this->user){
            Router::redirect("/");
        }
	}
	
	public function add()
	{		
		# Setup view
        $this->template->content = View::instance('v_posts_add');
        $this->template->title = "New Post";
        # Render template
        echo $this->template;
	} #end add_post

    public function p_add(){
        # Associate this post with this user
        $_POST['user_id'] = $this->user->user_id;

        # Add unix timestamps of when the post was created/modified
        $_POST['created'] = Time::now();
        $_POST['modified'] = Time::now();
        # Prevent xss attacks.
        $_POST['content'] = $this->stop_xss($_POST['content']);
        # Insert using DB function that will sanitize the input
        DB::instance(DB_NAME)->insert('posts',$_POST);

        Router::redirect('/posts/view/new_post');
    }
	
	public function view($param = NULL)
	{
        # Set up the View
        $this->template->content = View::instance('v_posts_view');
        $this->template->title   = "Posts";
        if($param=="new_post")
        {
            $this->template->content->new_post   = $param;
        }

        if($param=="my" || $param=="new_post")
        {
            $posts = $this->get_my_posts();
        }
        else
        {
            $posts = $this->get_following_posts();
        }
        # Pass data to the View
        $this->template->content->posts = $posts;

        # Render the View
        echo $this->template;
    } # end view_posts
} # eoc
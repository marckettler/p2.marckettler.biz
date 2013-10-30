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
	
	public function add_post()
	{		
		# Setup view
        $this->template->content = View::instance('v_add_post');
        $this->template->title = "New Post";

        # Render template
        echo $this->template;
	} #end add_post

    public function p_add_post(){
        # Associate this post with this user
        $_POST['user_id'] = $this->user->user_id;

        # Add unix timestamps of when the post was created/modified
        $_POST['created'] = Time::now();
        $_POST['modified'] = Time::now();

        # Insert using DB function that will sanitize the input
        DB::instance(DB_NAME)->insert('posts',$_POST);

        echo "Post added <a href='/users/profile'>Back to Profile</a>";
    }
	
	public function view_posts()
	{
        # Set up the View
        $this->template->content = View::instance('v_view_posts');
        $this->template->title   = "Posts";

        # Build the query
        $q = "SELECT
            posts .* ,
            users.first_name,
            users.last_name
        FROM posts
        INNER JOIN users
            ON posts.user_id = users.user_id";

        # Run the query
        $posts = DB::instance(DB_NAME)->select_rows($q);

        # Pass data to the View
        $this->template->content->posts = $posts;

        # Render the View
        echo $this->template;

    } # end view_posts
} # eoc
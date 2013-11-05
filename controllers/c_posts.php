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

        if($param=="my" || $param=="new_post" || $param=="delete_post")
        {
            $posts = $this->get_my_posts();
            $this->template->content->my_posts = true;
        }
        else
        {
            $posts = $this->get_following_posts();
            $this->template->content->followers_posts = true;
            $this->template->content->like = $this->get_posts_liked();
            $this->template->content->dislike = $this->get_posts_disliked();
        }
        # Pass data to the View
        $this->template->content->posts = $posts;

        # Render the View
        echo $this->template;
    } # end view_posts

    public function edit()
    {
        # Set up the View
        $this->template->content = View::instance('v_posts_edit');
        $this->template->title   = "Edit Post";
        # Pass data to the View
        $post_id = $_POST['post_id'];
        $q = "SELECT * FROM posts WHERE post_id=".$post_id;
        $post = DB::instance(DB_NAME)->select_row($q);
        $this->template->content->post = $post;

        # Render the View
        echo $this->template;
    } # end edit

    public function p_edit()
    {
        # Add unix timestamps of when the post was created/modified
        $_POST['modified'] = Time::now();
        # Prevent xss attacks.
        $_POST['content'] = $this->stop_xss($_POST['content']);
        $cond = "WHERE post_id=".$_POST['post_id'];
        # Insert using DB function that will sanitize the input
        DB::instance(DB_NAME)->update('posts',$_POST,$cond);

        Router::redirect('/posts/view/new_post');
    } # end p_edit

    public function p_like()
    {
        # Check to see if this post is currently disliked
        if($this->is_post_disliked($_POST['post_id']))
        {
            # If so delete from users_dislike_posts
            $this->delete_dislike($_POST['post_id']);
        }
        $_POST['user_id'] = $this->user->user_id;
        # Insert using DB function that will sanitize the input
        DB::instance(DB_NAME)->insert_row('users_like_posts',$_POST);

        Router::redirect('/posts/view/like_post');
    } # end p_like

    public function p_dislike()
    {
        # Check to see if this post is currently disliked
        if($this->is_post_liked($_POST['post_id']))
        {
            # If so delete from users_dislike_posts
            $this->delete_like($_POST['post_id']);
        }
        $_POST['user_id'] = $this->user->user_id;
        # Insert using DB function that will sanitize the input
        DB::instance(DB_NAME)->insert_row('users_dislike_posts',$_POST);

        Router::redirect('/posts/view/dislike_post');
    } # end p_dislike

    public function delete()
    {
        $this->delete_post($_POST['post_id']);
        Router::redirect('/posts/view/delete_post');
    } # end delete

    # DB call to get all users posts of users the currently logged in user follows
    private function get_following_posts()
    {
        # Build the query
        $q = "SELECT first_name, last_name, followers.created, content, followers.modified, followers.post_id
         FROM users,
          (SELECT user_id_followed, content, posts.created, posts.modified, posts.post_id
          FROM users_users, posts
          WHERE users_users.user_id = ".$this->user->user_id."
          AND user_id_followed = posts.user_id) as followers
          WHERE user_id = user_id_followed
          ORDER BY last_name DESC, first_name DESC, created DESC;";
        return DB::instance(DB_NAME)->select_rows($q);
    }

    private function delete_post($post_id)
    {
        $cond = DB::instance(DB_NAME)->sanitize("WHERE user_id =".$this->user->user_id." AND post_id = ".$post_id);
        DB::instance(DB_NAME)->delete("posts",$cond);
    }

    private function delete_like($post_id)
    {
        $cond = "WHERE user_id =".$this->user->user_id." AND post_id = ".$post_id;
        DB::instance(DB_NAME)->delete("users_like_posts",$cond);
    }

    private function delete_dislike($post_id)
    {
        $cond = "WHERE user_id =".$this->user->user_id." AND post_id = ".$post_id;
        DB::instance(DB_NAME)->delete("users_dislike_posts",$cond);
    }

    private function is_post_disliked($post_id)
    {
        return DB::instance(DB_NAME)->query("SELECT *
                                             FROM users_dislike_posts
                                             WHERE post_id=".$post_id."
                                             AND user_id=".$this->user->user_id);
    }

    private function is_post_liked($post_id)
    {
        return DB::instance(DB_NAME)->query("SELECT *
                                             FROM users_like_posts
                                             WHERE post_id=".$post_id."
                                             AND user_id=".$this->user->user_id);
    }

    # DB Call to return users following the logged in user as an array
    private function get_posts_liked()
    {
        # Build the query to figure out what connections does this user already have?
        # I.e. who are they following
        $q = "SELECT *
        FROM users_like_posts
        WHERE user_id = ".$this->user->user_id;

        # Execute this query with the select_array method
        # select_array will return our results in an array and use the "users_id_followed" field as the index.
        # This will come in handy when we get to the view
        # Store our results (an array) in the variable $connections
        return DB::instance(DB_NAME)->select_array($q, 'post_id');
    } # End get_posts_liked

    # DB Call to return users following the logged in user as an array
    private function get_posts_disliked()
    {
        # Build the query to figure out what connections does this user already have?
        # I.e. who are they following
        $q = "SELECT *
        FROM users_dislike_posts
        WHERE user_id = ".$this->user->user_id;

        # Execute this query with the select_array method
        # select_array will return our results in an array and use the "users_id_followed" field as the index.
        # This will come in handy when we get to the view
        # Store our results (an array) in the variable $connections
        return DB::instance(DB_NAME)->select_array($q, 'post_id');
    } # End get_posts_disliked

    # DB call to get all of the posts of the currently logged in user
    private function get_my_posts()
    {
        # Build the query
        $q = "SELECT post_id, first_name, last_name, posts.created, content, posts.modified, users.user_id AS user_id
         FROM users, posts
         WHERE users.user_id = ".$this->user->user_id."
         AND users.user_id = posts.user_id
         ORDER BY modified DESC;";
        return DB::instance(DB_NAME)->select_rows($q);
    }
} # eoc
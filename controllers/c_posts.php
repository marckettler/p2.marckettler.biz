<?php
class posts_controller extends base_controller
{
    /*-------------------------------------------------------------------------------------------------
    Post Controller
    -------------------------------------------------------------------------------------------------*/
    public function __construct()
	{
		parent::__construct();
        # Members Only
        if(!$this->user)
        {
            Router::redirect("/");
        }
	}

    # Render /post/add
	public function add()
	{		
		# Setup view
        $this->template->content = View::instance('v_posts_add');
        $this->template->title = "New Post";
        # Render template
        echo $this->template;
	} #end add

    # Process add post form
    public function p_add(){
        # Associate this post with current user
        $_POST['user_id'] = $this->user->user_id;

        # Add unix timestamps of when the post was created/modified
        $_POST['created'] = Time::now();
        $_POST['modified'] = Time::now();
        # Prevent xss attacks.
        $_POST['content'] = $this->stop_xss($_POST['content']);
        # Insert using DB function that will sanitize the input
        DB::instance(DB_NAME)->insert('posts',$_POST);

        Router::redirect('/posts/view/new_post');
    } # end p_add

    # Render post/view
    # $param are trigger flags for the various different views that can be rendered
	public function view($param = NULL)
	{
        # Set up the View
        $this->template->content = View::instance('v_posts_view');
        $this->template->title   = "Posts";

        # Check to see if the view being called is associated with the current user
        if($param=="my" || $param=="new_post" || $param=="delete_post" || $param=="edit_post")
        {
            $posts = $this->get_my_posts();
            $this->template->content->my_posts = true;
            if($param=="new_post")
            {
                $this->template->content->new_post   = $param;
            }
            elseif($param=="edit_post")
            {
                $this->template->content->edit_post   = $param;
            }
            elseif($param=="delete_post")
            {
                $this->template->content->delete_post   = $param;
            }
        }
        else
        {
            # Posts are not the current users posts
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

    # Render view for editing a post
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

    # process edit post form
    public function p_edit()
    {
        # Add unix timestamps of when the post was created/modified
        $_POST['modified'] = Time::now();
        # Prevent xss attacks.
        $_POST['content'] = $this->stop_xss($_POST['content']);
        $cond = "WHERE post_id=".$_POST['post_id'];
        # Insert using DB function that will sanitize the input
        DB::instance(DB_NAME)->update('posts',$_POST,$cond);

        Router::redirect('/posts/view/edit_post');
    } # end p_edit

    # process like button
    public function p_like()
    {
        # Check to see if this post is currently liked
        if($this->is_post_disliked($_POST['post_id']))
        {
            # If so delete from users_like_posts
            $this->delete_dislike($_POST['post_id']);
        }
        # associate like with current user post_id comes from $_POST
        $_POST['user_id'] = $this->user->user_id;
        # Insert using DB function that will sanitize the input
        DB::instance(DB_NAME)->insert_row('users_like_posts',$_POST);

        Router::redirect('/posts/view/like_post');
    } # end p_like

    # process dislike button
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

    # associate like with current user post_id comes from $_POST
    public function delete()
    {
        $this->delete_post($_POST['post_id']);
        Router::redirect('/posts/view/delete_post');
    } # end delete

    # private helper function to keep code DRY
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

    # private helper function to keep code DRY
    # DB call to delete a post
    private function delete_post($post_id)
    {
        $cond = DB::instance(DB_NAME)->sanitize("WHERE user_id =".$this->user->user_id." AND post_id = ".$post_id);
        DB::instance(DB_NAME)->delete("posts",$cond);
    } # end delete_post

    # private helper function to keep code DRY
    # DB call to delete a like
    private function delete_like($post_id)
    {
        $cond = "WHERE user_id =".$this->user->user_id." AND post_id = ".$post_id;
        DB::instance(DB_NAME)->delete("users_like_posts",$cond);
    } # end delete_like

    # private helper function to keep code DRY
    # DB call to delete a dislike
    private function delete_dislike($post_id)
    {
        $cond = "WHERE user_id =".$this->user->user_id." AND post_id = ".$post_id;
        DB::instance(DB_NAME)->delete("users_dislike_posts",$cond);
    } #end delete_dislike

    # private helper function
    # DB call to check if current user likes the selected post
    private function is_post_disliked($post_id)
    {
        return DB::instance(DB_NAME)->query("SELECT *
                                             FROM users_dislike_posts
                                             WHERE post_id=".$post_id."
                                             AND user_id=".$this->user->user_id);
    } # end is_post_disliked

    # private helper function
    # DB call to check if the current user like the selected post
    private function is_post_liked($post_id)
    {
        return DB::instance(DB_NAME)->query("SELECT *
                                             FROM users_like_posts
                                             WHERE post_id=".$post_id."
                                             AND user_id=".$this->user->user_id);
    }# end is_post_liked

    # Private helper function
    # DB Call to return an array of the posts the current user likes
    private function get_posts_liked()
    {
        # Build the query to see which posts the current user likes
        $q = "SELECT *
        FROM users_like_posts
        WHERE user_id = ".$this->user->user_id;

        # Execute this query with the select_array method
        # To return an array
        return DB::instance(DB_NAME)->select_array($q, 'post_id');
    } # End get_posts_liked

    # Private helper function
    # DB Call to return an array of the posts the current user dislikes
    private function get_posts_disliked()
    {
        # Build the query to see which posts the current user dislikes
        $q = "SELECT *
        FROM users_dislike_posts
        WHERE user_id = ".$this->user->user_id;

        # Execute this query with the select_array methods
        return DB::instance(DB_NAME)->select_array($q, 'post_id');
    } # End get_posts_disliked

    # Private helper function
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
    } # end get_my_posts
} # eoc
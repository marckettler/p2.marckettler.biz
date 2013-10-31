<!DOCTYPE html>
<html>
    <head>
        <title><?php if(isset($title)) echo $title; ?></title>
    
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="/css/bootstrap.css" type="text/css" rel="stylesheet" media="screen" />
        <!-- Controller Specific JS/CSS -->
        <?php if(isset($client_files_head)) echo $client_files_head; ?>
        
    </head>
    
    <body>
        <div class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                <a href="/" class="navbar-brand">Blooper</a>
                <button class="navbar-toggle" data-toggle = "collapse" data-target=".navHeaderCollapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse navHeaderCollapse">
                    <ul class="nav navbar-nav navbar-left">
                        <?php if($user): ?>
                            <li><a href="/users/profile">Profile</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Posts <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="/posts/add_post">Add Post</a></li>
                                    <li><a href="/posts/view_posts">View Posts</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="/users/show_all_users">Display All Users</a></li>
                                    <li><a href="/users/show_followers">Who I Follow</a></li>
                                    <li><a href="/users/show_following">Who Follows Me</a></li>
                                </ul>
                            </li>
                            <li><a href="/users/logout">Log Out</a></li>
                        <?php else: ?>
                            <li><a href="/users/login">Log In</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    
        <?php if(isset($content)) echo $content; ?>
    
        <?php if(isset($client_files_body)) echo $client_files_body; ?>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="/js/jquery-2.0.3.js" type="text/javascript"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>
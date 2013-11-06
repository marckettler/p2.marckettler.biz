<!DOCTYPE html>
<html>
    <head>
        <title><?php if(isset($title)) echo $title; ?></title>
        <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <![endif]-->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet" media="screen" />
        <link href="/css/blooper.css" type="text/css" rel="stylesheet" />
        <!-- Controller Specific JS/CSS -->
        <?php if(isset($client_files_head)) echo $client_files_head; ?>
    </head>
    <body>

        <div class="navbar navbar-default navbar-static-top">
            <div class="navbar-header">
                <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="/" class="navbar-brand">Blooper</a>
            </div>
            <div class="collapse navbar-collapse navHeaderCollapse">
                <ul class="nav navbar-nav navbar-left">
                    <?php if($user): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=($bloopify ? "Bloop" : "Pro");?>file <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="/profile/edit">Edit</a></li>
                                <li><a href="/profile/view">View</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=($bloopify ? "Bloops" : "Posts");?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="/posts/add">New <?=($bloopify ? "Bloop" : "Post");?></a></li>
                                <li><a href="/posts/view/my">View My <?=($bloopify ? "Bloops" : "Posts");?></a></li>
                                <li><a href="/posts/view/following">View Other <?=($bloopify ? "Bloops" : "Posts");?></a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=($bloopify ? "Bloopers" : "Users");?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="/users/show_all_users">Display All <?=($bloopify ? "Bloopers" : "Users");?></a></li>
                                <li><a href="/users/following">Who I <?=($bloopify ? "Bloop" : "Follow");?></a></li>
                                <li><a href="/users/followed_by">Who <?=($bloopify ? "Bloops" : "Follows");?> Me</a></li>
                            </ul>
                        </li>
                        <li <?=($bloopify ? "" : 'class="active"');?>><a href="/bloopify/bloopify_me/<?= str_replace("/","%20",ROUTER::$routed_uri);?>"><?=($bloopify ? "UnBloopify" : "Bloopify");?></a></li>
                        <li><a href="/users/logout"><?=($bloopify ? "Bloop" : "Log");?> Out</a></li>
                    <?php else: ?>
                        <li><a href="/users/login"><?=($bloopify ? "Bloop" : "Sign");?> In</a></li>
                        <li><a href="/users/signup"><?=($bloopify ? "Bloop" : "Sign");?> Up</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div> <!-- /div.navbar -->
        <?php if(isset($content)) echo $content; ?>

        <?php if(isset($client_files_body)) echo $client_files_body; ?>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="/js/jquery-2.0.3.min.js" type="text/javascript"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>
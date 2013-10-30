<div class="”container”">
	<h1>Welcome to <?=APP_NAME?><?php if($user) echo ', '.$user->first_name; ?></h1>
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <ul class="nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="/users/signup">Sign Up</a></li>
                    <li><a href="/users/login">Log In</a></li>
                    <li><a href="#">Downloads</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            </div>
    </div>    
</div>
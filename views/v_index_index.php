<p>
	<h1>Welcome to <?=APP_NAME?><?php if($user) echo ', '.$user->first_name; ?></h1>
	<ul>
    	<li><a href="/users/signup">Sign Up</a></li>
        <li><a href="/users/login">Log In</a></li>
    </ul>
</p>
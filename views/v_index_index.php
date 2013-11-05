<div class="container" xmlns="http://www.w3.org/1999/html">
    <article class="jumbotron text-center">
<? if($user):?>
        <!-- display landing page for logged in user -->
        <h1>Welcome back <?=$user->first_name?></h1>
<? else: ?>
        <!-- display landing page for non member -->
        <h1>Welcome to <?=APP_NAME?>!</h1>
        <p>To start blooping you must <a class="btn btn-danger btn-sm" href="/users/signup">Bloop up!</a></p>
<? endif ?>
        <p>Blooper is <?=($bloopify ? "" : "not");?> the only place you can:</p>
        <p>
            <span class="text-danger"><?=($bloopify ? "Bloop" : "Sign");?> Up!</span>
            <span class="text-primary"><?=($bloopify ? "Bloop" : "Sign");?> In!</span>
            <span class="text-warning"><?=($bloopify ? "Bloop" : "Log");?> Out!</span>
            <span class="text-success"><?=($bloopify ? "Bloop" : "Add Posts");?>!</span><br>
            List all <?=($bloopify ? "Bloopers" : "Users");?>!<br>
            <?=($bloopify ? "Bloop" : "Follow");?> and <?=($bloopify ? "UnBloop" : "UnFollow");?> the other <?=($bloopify ? "Bloopers" : "Users");?>!<br>
            View the <?=($bloopify ? "Bloop" : "Posts");?> of the <?=($bloopify ? "Bloopers" : "Users");?> you <?=($bloopify ? "Bloop" : "Follow");?>!<br>
            <span class="badge">+1</span> View your <?=($bloopify ? "Bloop" : "Pro");?>file!<br>
            <span class="badge">+1</span> Edit your <?=($bloopify ? "Bloop" : "Pro");?>file!<br>
            <span class="badge">+1</span> Edit your <?=($bloopify ? "Bloop" : "Posts");?>!<br>
            <span class="badge">+1</span> Delete your <?=($bloopify ? "Bloop" : "Posts");?>!<br>
            <span class="badge">+1</span> <?=($bloopify ? "Bloop" : "Like");?> and <?=($bloopify ? "DisBloop" : "DisLike");?> other <?=($bloopify ? "Blooper" : "User");?>'s <?=($bloopify ? "Bloops" : "Posts");?>!<br>
            <span class="badge">+1</span> The Amazing Bloopify and UnBloopify menu option<br>
            <?=($bloopify ? "We are not a knock off of Twitter it is just happenstance that Tweet is to Twitter as Bloop is to Blooper<br>" : "");?>
        </p>
    </article>
</div>
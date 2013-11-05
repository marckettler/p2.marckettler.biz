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
        <p>Blooper is the only place you can:</p>
        <p>
            <span class="text-danger">Bloop Up!</span>
            <span class="text-primary"> Bloop In!</span>
            <span class="text-warning"> Bloop Out!</span>
            <span class="text-success"> Bloop!</span>
            List all Bloopers!<br>
            Bloop and UnBloop the other Bloopers!<br>
            View the Bloops of the Bloopers you Bloop!<br>
            <span class="badge">+1</span> View your Bloopfile!<br>
            <span class="badge">+1</span> Edit your Bloopfile!<br>
            <span class="badge">+1</span> Edit your Bloops!<br>
            <span class="badge">+1</span> Delete your Bloops!<br>
            <span class="badge">+1</span> Bloop and DisBloop other Blooper's Bloops!<br>
            We are not a knock off of Twitter it is just happenstance that Tweet is to Twitter as Bloop is to Blooper<br>

        </p>
    </article>
</div>
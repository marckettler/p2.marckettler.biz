<? if($user):?>
    <!-- display landing page for logged in user -->
    <article class="container">
        <img class="img-responsive img-rounded" src="<?=$user->avatar?>" alt="User's Avatar"/>
    </article>
<? else: ?>
    <!-- display landing page for non member -->
    <div class="container">
        <article class="jumbotron">
            <h1>Welcome to <?=APP_NAME?>!</h1>
            <p class="text-center">To start blooping you must <a class="btn btn-danger" href="/users/signup">Sign up!</a></p>
        </article>
    </div>
<? endif ?>
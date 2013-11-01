<div class="container">
    <article class="row">
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="page-header">
                        <h3><?=$user->first_name;?> <?=$user->last_name;?> - <?=$user->email;?></h3>
                    </div>
                    <p>
                        Member Since: <?=Time::display($user->created)?><br>
                        Last Login: <?=Time::display($user->last_login)?><br>
                        Last Profile Edit: <?=Time::display($user->modified)?><br>
                        You are following <?=$num_following;?> other users<br>
                        There are <?=$num_following_me;?> users following you<br>
                    </p>
                    <img class="img-responsive img-rounded" src="<?=$user->avatar?>" alt="User's Avatar"/>
                </div>
            </div>
        </div>
    </article>
</div>
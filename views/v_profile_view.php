<div class="container">
    <article class="panel panel-default">
        <div class="panel-heading">
            <p class="panel-title"><strong><?=$user->first_name;?> <?=$user->last_name;?> - <?=$user->email;?></strong></p>
        </div>
        <div class="panel-body">
        <? if(isset($updated)): ?>
            <p class="text-center">
                <strong class="text-success">You have successfully updated your profile</strong>
            </p>
        <? endif; ?>
            Created: <?=Time::display($user->created)?><br>
            Last Login: <?=Time::display($user->last_login)?><br>
            Last Profile Edit: <?=Time::display($user->modified)?><br>
            You are following <span class="badge"><?=$num_following;?></span> other users<br>
            There are <span class="badge"><?=$num_following_me;?></span> users following you<br>
        </div>
    </article>
</div>
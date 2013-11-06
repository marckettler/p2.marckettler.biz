<div class="container">
    <article class="panel panel-default">
        <div class="panel-heading">
            <p class="panel-title"><strong><?=$user_profile['first_name'];?> <?=$user_profile['last_name'];?> - <?=$user_profile['email'];?></strong></p>
        </div>
        <div class="panel-body">
        <? if(isset($updated)): ?>
            <p class="text-center">
                <strong class="text-success">You have successfully updated your <?=($bloopify ? "Bloop" : "Pro");?>file</strong>
            </p>
        <? endif; ?>
            <p class="h4">
                Created: <?=Time::display($user_profile['created'])?><br>
                Last <?=($bloopify ? "Bloop" : "Log");?> in: <?=Time::display($user_profile['last_login'])?><br>
                Last <?=($bloopify ? "Bloop" : "Pro");?>file Edit: <?=Time::display($user_profile['modified'])?><br>
                <?=($user->user_id==$user_profile['user_id'] ? "You are" : $user_profile['first_name']." is")?> <?=($bloopify ? "Bloop" : "Follow");?>ing <span class="badge"><?=$num_following;?></span> other <?=($bloopify ? "Bloopers" : "Users");?><br>
                There are <span class="badge"><?=$num_following_me;?></span> <?=($bloopify ? "Bloopers Bloop" : "Users Follow");?>ing <?=($user->user_id==$user_profile['user_id'] ? "you" : $user_profile['first_name'])?><br>
            </p>
        </div>
    </article>
</div>
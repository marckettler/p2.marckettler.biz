<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="page-header">
                <h3><?=$user->first_name;?> <?=$user->last_name;?> - <?=$user->email;?></h3>
            </div>
            <? if(isset($updated)): ?>
                <p class="text-center">
                    <strong class="text-success">You have successfully updated your profile</strong>
                </p>
            <? endif; ?>
            <ul class="media-list">
                <li class="media">
                    <div class="row">
                        <div class="col-sm-5">
                            <img class="media-object img-responsive img-rounded" src="<?=$user->avatar_small?>" alt="User's Avatar">
                        </div>
                        <div class="media-body col-sm-5">
                            <div class="well">Since: <?=Time::display($user->created)?></div>
                            <div class="well">Last Login: <?=Time::display($user->last_login)?></div>
                            <div class="well">Last Profile Edit: <?=Time::display($user->modified)?></div>
                            <div class="well">You are following <span class="badge"><?=$num_following;?></span> other users</div>
                            <div class="well">There are <span class="badge"><?=$num_following_me;?></span> users following you</div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
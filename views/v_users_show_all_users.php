<div class="container">
    <? if(isset($new_follow)): ?>
        <h3 class="alert-success text-center text-success">You have <?=($bloopify ? "Blooped a Blooper!" : "Followed a User!");?></h3>
    <? elseif(isset($new_unfollow)): ?>
        <h3 class="alert-danger text-center text-danger">You have <?=($bloopify ? "UnBlooped a Blooper!" : "UnFollowed a User!");?></h3>
    <? endif;?>
    <? foreach($users as $user): ?>
        <? if(!($user['user_id'] == $current_user_id)): #skip the logged in user?>
            <article class="panel panel-default">
                <div class="page-header">
                    <h2 class="text-center"><?=$user['first_name']?> <?=$user['last_name']?></h2>
                </div>
                <div class="panel-body text-center">
                <? if(isset($following[$user['user_id']])): ?>
                    <a class="btn btn-danger btn-sm" href='/users/unfollow/<?=$user['user_id']?>'>Un<?=($bloopify ? "Bloop" : "Follow");?> Me!</a>
                <? else: ?>
                    <a class="btn btn-success btn-sm" href="/users/follow/<?=$user['user_id']?>"><?=($bloopify ? "Bloop" : "Follow");?> Me!</a>
                <? endif; ?>
                    <a class="btn btn-info btn-sm" href="/profile/view/<?=$user['user_id']?>">View <?=($bloopify ? "Bloopfile" : "Profile");?></a>
                </div>
            </article>
        <? endif; ?>
    <? endforeach; ?>
</div>
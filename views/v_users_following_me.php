<div class="container">
    <? if(isset($not_following_me)): ?>
        <h3 class="alert-info text-center">
            You are not being <?=($bloopify ? "Bloop" : "Follow");?>ed by anyone :(<br>
            Click <a class="btn btn-sm btn-primary" href="/posts/add">Here</a> and <?=($bloopify ? "Bloop" : "Post");?> something to whine about not being <?=($bloopify ? "Blooped" : "Followed");?>!
        </h3>
    <? endif;
    foreach($users as $user): ?>
        <?php if(isset($following_me[$user['user_id']])): ?>
            <article class="panel panel-default">
                <div class="page-header">
                    <h2 class="text-center"><?=$user['first_name']?> <?=$user['last_name']?></h2>
                </div>
                <div class="panel-body text-center">
                    <?php if(isset($following[$user['user_id']])): ?>
                        <a class="btn btn-danger btn-sm" href='/users/unfollow/<?=$user['user_id']?>'>Un<?=($bloopify ? "Bloop" : "Follow");?> Me!</a>
                    <?php else: ?>
                        <a class="btn btn-success btn-sm" href='/users/follow/<?=$user['user_id']?>'><?=($bloopify ? "Bloop" : "Follow");?> Me!</a>
                    <?php endif; ?>
                        <a class="btn btn-info btn-sm" href="/profile/view/<?=$user['user_id']?>">View <?=($bloopify ? "Bloopfile" : "Profile");?></a>
                </div>
            </article>
        <? endif; ?>
    <?php endforeach; ?>
</div>
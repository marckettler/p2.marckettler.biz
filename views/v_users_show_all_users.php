<div class="container">
    <?php foreach($users as $user): ?>
        <?php if(!($user['user_id'] == $current_user_id)): #skip the logged in user?>
            <article class="panel panel-default">
                <div class="page-header">
                    <h2 class="text-center"><?=$user['first_name']?> <?=$user['last_name']?></h2>
                </div>
                <div class="panel-body text-center">
                <?php if(isset($connections[$user['user_id']])): ?>
                    <a class="btn btn-danger btn-sm" href='/users/unfollow/<?=$user['user_id']?>'>Un<?=($bloopify ? "Bloop" : "Follow");?> Me!</a>
                <?php else: ?>
                    <a class="btn btn-success btn-sm" href='/users/follow/<?=$user['user_id']?>'><?=($bloopify ? "Bloop" : "Follow");?> Me!</a>
                <?php endif; ?>
                </div>
            </article>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
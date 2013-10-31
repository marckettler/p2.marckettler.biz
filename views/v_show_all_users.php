<article class="container">
    <?php foreach($users as $user): ?>
        <?php if(!($user['user_id'] == $current_user_id)): #skip the logged in user?>
            <article class="container">
                <div class="panel panel-default">
                    <p class="panel-body">
                        <?=$user['first_name']?> <?=$user['last_name']?>
                        <?php if(isset($connections[$user['user_id']])): ?>
                            <a href='/users/unfollow/<?=$user['user_id']?>'>Unfollow</a>
                        <?php else: ?>
                            <a href='/users/follow/<?=$user['user_id']?>'>Follow</a>
                        <?php endif; ?>
                    </p>
                </div>
            </article>
        <?php endif; ?>
    <?php endforeach; ?>
</article>
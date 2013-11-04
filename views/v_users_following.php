<div class="container">
    <?php foreach($users as $user): ?>
        <?php if(isset($connections[$user['user_id']])): ?>
            <article class="panel panel-default">
                <div class="panel-body">
                    <?=$user['first_name']?> <?=$user['last_name']?>
                    <a href='/users/unfollow/<?=$user['user_id']?>'>Unfollow</a>
                </div>
            </article>
        <? endif; ?>
    <?php endforeach; ?>
</div>
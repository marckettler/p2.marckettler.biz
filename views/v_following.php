<article class="container">
    <?php foreach($users as $user): ?>
        <!-- Skip the currently logged in user -->
        <!-- Print this user's name -->
        <?=$user['first_name']?> <?=$user['last_name']?>

        <!-- If there exists a connection with this user, show a unfollow link -->
        <?php if(isset($connections[$user['user_id']])): ?>
            <a href='/users/unfollow/<?=$user['user_id']?>'>Unfollow</a>

            <!-- Otherwise, show the follow link -->
        <?php else: ?>
            <a href='/users/follow/<?=$user['user_id']?>'>Follow</a>
        <?php endif; ?>
        <br><br>
    <?php endforeach; ?>
</article>
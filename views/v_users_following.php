<div class="container">
    <? if(isset($not_following)): ?>
        <h3 class="alert-info text-center">
            You are not <?=($bloopify ? "Bloop" : "Follow");?>ing anyone :(<br>
            Click <a class="btn btn-sm btn-primary" href="/users/show_all_users">Here</a> and <?=($bloopify ? "Bloop" : "Follow");?> some other <?=($bloopify ? "Bloopers" : "Users");?>!
        </h3>
    <? endif;
    foreach($users as $user): ?>
        <?php if(isset($following[$user['user_id']])): ?>
            <article class="panel panel-default">
                <div class="page-header">
                    <h2 class="text-center"><?=$user['first_name']?> <?=$user['last_name']?></h2>
                </div>
                <div class="panel-body text-center">
                    <a class="btn btn-danger btn-sm" href='/users/unfollow/<?=$user['user_id']?>'>Un<?=($bloopify ? "Bloop" : "Follow");?> Me!</a>
                    <a class="btn btn-info btn-sm" href="/profile/view/<?=$user['user_id']?>">View <?=($bloopify ? "Bloopfile" : "Profile");?></a>
                </div>
            </article>
        <? endif; ?>
    <?php endforeach; ?>
</div>
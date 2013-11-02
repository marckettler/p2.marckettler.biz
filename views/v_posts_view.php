<div class="container">
    <? if(isset($new_post)): ?>
        <h3 class="text-center"><strong class="text-success">You have added a new post</strong></h3>
    <? endif; ?>
    <?php foreach($posts as $post): ?>
        <article class="container">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="page-header">
                        <h3><?=$post['first_name']?> <?=$post['last_name']?> posted:</h3>
                    </div>
                    <p><?=$post['content']?></p>
                </div>
                <div class="panel-footer">
                    <time>
                        <?=Time::display($post['created'])?>
                    </time>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
</div>
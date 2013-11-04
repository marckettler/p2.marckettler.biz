<div class="container">
    <? if(isset($new_post)): ?>
        <h3 class="alert-success text-center text-success">Oops you Blooped it again!</h3>
    <? endif; ?>
    <?php foreach($posts as $post): ?>
        <article class="panel panel-default">
            <div class="panel-heading">
                <h3><?=$post['first_name']?> <?=$post['last_name']?> posted:</h3>
            </div>
            <div class="panel-body">
                <?=$post['content']?>
            </div>
            <div class="panel-footer">
                <time>
                    <?=Time::display($post['created'])?>
                </time>
            </div>
        </article>
    <?php endforeach; ?>
</div>
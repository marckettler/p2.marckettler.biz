<article class="container">
    <?php foreach($posts as $post): ?>

        <article class="container">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><?=$post['first_name']?> <?=$post['last_name']?> posted:</h3>
                </div>
                <div class="panel-body">
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
</article>
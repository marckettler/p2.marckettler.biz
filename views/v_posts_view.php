<div class="container">
    <? if(isset($new_post)): ?>
        <h3 class="alert-success text-center text-success">Oops you Blooped it again!</h3>
    <? endif; ?>
    <?php foreach($posts as $post): ?>
        <article class="panel panel-default">
            <div class="panel-heading">
                <h4>
                <? if(isset($post['user_id'])): ?>
                    You
                <? else: ?>
                    <?=$post['first_name']?> <?=$post['last_name']?>
                <? endif;?>
                    Blooped
                </h4>
            </div>
            <div class="panel-body">
                <?=$post['content']?>
            </div>
            <div class="panel-footer">
                <p>
                    <?=Time::display($post['created'])?>
                </p>
                <? if(isset($post['user_id'])): ?>
                    <form class="form-inline" role="form" method="POST" action="/posts/edit">
                        <input type="hidden" name="post_id" value="<?=$post['post_id']?>">
                        <button type="submit" class="btn btn-primary btn-sm">Edit This Bloop</button>
                    </form>
                    <form class="form-inline" role="form" method="POST" action="/posts/delete">
                        <input type="hidden" name="post_id" value="<?=$post['post_id']?>">
                        <button type="submit" class="btn btn-danger btn-sm">Delete This Bloop</button>
                    </form>
                <? elseif(!isset($dislike[$post['post_id']]) && !isset($like[$post['post_id']])):?>
                    <form class="form-inline" role="form" method="POST" action="/posts/p_like">
                        <input type="hidden" name="post_id" value="<?=$post['post_id']?>">
                        <button type="submit" class="btn btn-success btn-sm">Bloop &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="glyphicon glyphicon-thumbs-up"></span> </button>
                    </form>
                    <form class="form-inline" role="form" method="POST" action="/posts/p_dislike">
                        <input type="hidden" name="post_id" value="<?=$post['post_id']?>">
                        <button type="submit" class="btn btn-danger btn-sm">DisBloop <span class="glyphicon glyphicon-thumbs-down"></span> </button>
                    </form>
                <? elseif(isset($like[$post['post_id']])): ?>
                    <form class="form-inline" role="form" method="POST" action="/posts/p_dislike">
                        <input type="hidden" name="post_id" value="<?=$post['post_id']?>">
                        <button type="submit" class="btn btn-danger btn-sm">DisBloop <span class="glyphicon glyphicon-thumbs-down"></span> </button>
                    </form>
                <? else:?>
                    <form class="form-inline" role="form" method="POST" action="/posts/p_like">
                        <input type="hidden" name="post_id" value="<?=$post['post_id']?>">
                        <button type="submit" class="btn btn-success btn-sm">Bloop <span class="glyphicon glyphicon-thumbs-up"></span> </button>
                    </form>
                <? endif;?>
            </div>
        </article>
    <?php endforeach; ?>
</div>
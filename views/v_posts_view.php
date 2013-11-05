<div class="container">
    <? if(isset($new_post)): ?>
        <h3 class="alert-success text-center text-success"><?=($bloopify ? "Oops you Blooped it again!" : "You added a Post");?></h3>
    <? endif; ?>
    <? if(empty($posts)):
        if(isset($my_posts)):?>
        <p class="text-center alert-info">
            You have no <?=($bloopify ? "Bloops" : "Posts");?> :(. Click <a class="btn btn-sm btn-primary" href="/posts/add">here</a> and start <?=($bloopify ? "Bloop" : "Post");?>ing!
        </p>
        <? else: ?>
        <p class="text-center alert-info">
            The <?=($bloopify ? "Bloopers" : "Users");?> you are <?=($bloopify ? "Bloop" : "Follow");?>ing have no <?=($bloopify ? "Bloops" : "Posts");?> :(<br>
            Click <a class="btn btn-sm btn-primary" href="/users/show_all_users">here</a> and start <?=($bloopify ? "Bloop" : "Follow");?>ing other <?=($bloopify ? "Bloopers" : "Users");?>!
        </p>
        <? endif;
    endif; ?>
    <? foreach($posts as $post): ?>
        <article class="panel panel-default">
            <div class="panel-heading">
                <h4>
                <? if(isset($post['user_id'])): ?>
                    You
                <? else: ?>
                    <?=$post['first_name']?> <?=$post['last_name']?>
                <? endif;?>
                    <?=($bloopify ? "Bloop" : "Post");?>ed
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
                        <button type="submit" class="btn btn-primary btn-sm">Edit This <?=($bloopify ? "Bloop" : "Post");?></button>
                    </form>
                    <form class="form-inline" role="form" method="POST" action="/posts/delete">
                        <input type="hidden" name="post_id" value="<?=$post['post_id']?>">
                        <button type="submit" class="btn btn-danger btn-sm">Delete This <?=($bloopify ? "Bloop" : "Post");?></button>
                    </form>
                <? elseif(!isset($dislike[$post['post_id']]) && !isset($like[$post['post_id']])):?>
                    <form class="form-inline" role="form" method="POST" action="/posts/p_like">
                        <input type="hidden" name="post_id" value="<?=$post['post_id']?>">
                        <button type="submit" class="btn btn-success btn-sm"><?=($bloopify ? "Bloop" : "Like");?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="glyphicon glyphicon-thumbs-up"></span> </button>
                    </form>
                    <form class="form-inline" role="form" method="POST" action="/posts/p_dislike">
                        <input type="hidden" name="post_id" value="<?=$post['post_id']?>">
                        <button type="submit" class="btn btn-danger btn-sm">Dis<?=($bloopify ? "Bloop" : "Like");?> <span class="glyphicon glyphicon-thumbs-down"></span> </button>
                    </form>
                <? elseif(isset($like[$post['post_id']])): ?>
                    <form class="form-inline" role="form" method="POST" action="/posts/p_dislike">
                        <input type="hidden" name="post_id" value="<?=$post['post_id']?>">
                        <button type="submit" class="btn btn-danger btn-sm">Dis<?=($bloopify ? "Bloop" : "Like");?> <span class="glyphicon glyphicon-thumbs-down"></span> </button>
                    </form>
                <? else:?>
                    <form class="form-inline" role="form" method="POST" action="/posts/p_like">
                        <input type="hidden" name="post_id" value="<?=$post['post_id']?>">
                        <button type="submit" class="btn btn-success btn-sm"><?=($bloopify ? "Bloop" : "Like");?> <span class="glyphicon glyphicon-thumbs-up"></span> </button>
                    </form>
                <? endif;?>
            </div>
        </article>
    <?php endforeach; ?>
</div>
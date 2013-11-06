<div class="container">
    <? if(isset($new_post)): ?>
        <h3 class="alert-success text-center text-success"><?=($bloopify ? "Oops you Blooped it again!" : "You added a Post");?></h3>
    <? elseif(isset($edit_post)): ?>
        <h3 class="alert-success text-center text-success">You Edited <span class="glyphicon glyphicon-arrow-down"></span> that <?=($bloopify ? "Bloop" : "Post");?></h3>
    <? elseif(isset($delete_post)): ?>
        <h3 class="alert-success text-center text-success">You Deleted a <?=($bloopify ? "Bloop" : "Post");?> Ohhh the <?=($bloopify ? "Bloop" : "Human");?>ity!!!</h3>
    <? endif; ?>
    <? if(empty($posts)):
        if(isset($my_posts)):?>
        <h3 class="text-center alert-info">
            You have no <?=($bloopify ? "Bloops" : "Posts");?> :(. Click <a class="btn btn-sm btn-primary" href="/posts/add">here</a> and start <?=($bloopify ? "Bloop" : "Post");?>ing!
        </h3>
        <? else: ?>
        <h3 class="text-center alert-info">
            The <?=($bloopify ? "Bloopers" : "Users");?> you are <?=($bloopify ? "Bloop" : "Follow");?>ing have no <?=($bloopify ? "Bloops" : "Posts");?> :(<br>
            Click <a class="btn btn-sm btn-primary" href="/users/show_all_users">here</a> and start <?=($bloopify ? "Bloop" : "Follow");?>ing other <?=($bloopify ? "Bloopers" : "Users");?>!
        </h3>
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
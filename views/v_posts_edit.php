<div class="container">
    <article class="panel panel-default">
        <div class="page-header">
            <h2 class="text-center">Edit your Bloop</h2>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="/posts/p_edit">
                <input type="hidden" name="post_id" value="<?=$post['post_id']?>">
                <div class="form-group">
                    <label for="inputContent" class="col-sm-2 control-label">Type It:</label>
                    <div class="col-sm-10">
                        <textarea name="content" class="form-control" id="inputContent" required><?=$post['content']?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Bloop It!</button>
                    </div>
                </div>
            </form>
        </div>
    </article>
</div>
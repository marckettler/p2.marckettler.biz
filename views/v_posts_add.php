<div class="container">
    <article class="row">
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="page-header">
                        <h2 class="text-center">Type in the content of your new post</h2>
                    </div>
                    <form class="form-horizontal" role="form" method="POST" action="/posts/p_add">
                        <div class="form-group">
                            <label for="inputContent" class="col-sm-2 control-label">New Post:</label>
                            <div class="col-sm-10">
                                <textarea name="content" class="form-control" id="inputContent" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Add Post</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </article>
</div>
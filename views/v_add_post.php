<div class="container">
    <form class="form-horizontal" role="form" method="POST" action="/posts/p_add_post">
        <div class="form-group">
            <label for="inputContent" class="col-sm-2 control-label">New Post:</label>
            <div class="col-sm-10">
                <textarea name="content" class="form-control" id="inputContent" required></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Add Post</button>
            </div>
        </div>
    </form>
</div>
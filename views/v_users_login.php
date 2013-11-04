<div class="container">
    <article class="panel panel-default">
        <div class="page-header">
            <h2 class="text-center">Bloop it after you Bloop In!</h2>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="/users/p_login">
            <? if(isset($error)): ?>
                <div class="text-center text-danger">
                    <h3>Your Login information was incorrect.</h3>
                </div>
            <?
            endif;

            echo $common_form_inputs;
            ?>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Bloop on!</button>
                    </div>
                </div>
            </form>
        </div>
    </article>
</div>
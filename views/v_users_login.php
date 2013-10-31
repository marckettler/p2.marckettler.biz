<article class="container">
    <form class="form-horizontal" role="form" method="POST" action="/users/p_login">
        <? if($error): ?>
        <div class="text-center text-danger text-">
            <h3>Your Login information was incorrect.</h3>
        </div>
        <?
            endif;

            require_once("/views/v_common_form_inputs.php");
        ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Remember me
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Sign in</button>
            </div>
        </div>
    </form>
</article>
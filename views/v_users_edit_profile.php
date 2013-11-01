<div class="container">
    <article class="row">
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="page-header">
                        <h2 class="text-center">Edit your profile by changing the fields below.</h2>
                    </div>
                    <form class="form-horizontal" role="form" method="POST" action="/users/p_login">
                        <div class="form-group">
                            <label for="inputFirstName" class="col-sm-2 control-label">First Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="first_name" class="form-control" id="inputFirstName" value="<?=$user->first_name;?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputLastName" class="col-sm-2 control-label">Last Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="last_name" class="form-control" id="inputLastName" value="<?=$user->last_name;?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email" required>
                            </div>
                        </div>
                            <?=$user->first_name;?> <?=$user->last_name;?> - <?=$user->email;?>
                            Member Since: <?=Time::display($user->created)?><br>
                            Last Login: <?=Time::display($user->last_login)?><br>
                            Last Profile Edit: <?=Time::display($user->modified)?><br>
                            You are following <?=$num_following;?> other users<br>
                            There are <?=$num_following_me;?> users following you<br>
                    </form>
                    <img class="img-responsive img-rounded" src="<?=$user->avatar?>" alt="User's Avatar"/>
                </div>
            </div>
        </div>
    </article>
</div>
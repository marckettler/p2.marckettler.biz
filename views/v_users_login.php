<form method='POST' action='/users/p_login'>
    <div>
        <label for='email'>Email</label>
        <input type='text' name='email'>
        <br>

        <label for='password'>Password</label>
        <input type='password' name='password'>
        <br>

        <?php if(isset($error)): ?>
            <div class='error'>
            Login failed. Please double check your email and password.
            </div>
        <?php endif; ?>
        <input type='submit'>
    </div>
</form>
<? if(isset($_GET['error'])) echo $_GET['error'];?>
<form method='POST' action='/users/p_signup'>

    <label for 'first_name'>First Name</label>
    <input type='text' name='first_name' required='required' >
    <br>

    <label for 'last_name'>Last Name</label>
    <input type='text' name='last_name' required='required'>
    <br>

    <label for 'email'>Email</label>
    <input type='email' name='email' required='required' placeholder='Enter a valid email address'>
    <br>

    <label for 'password'>Password</label>
    <input type='password' name='password' required="required">
    <br><br>

    <input type='submit'>

</form>
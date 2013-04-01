<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$_SESSION['username'] = $_POST['username'];
$_SESSION['password'] = $_POST['password'];
header('Location: index');
}
?>
<div class="login-wrapper">
	<form method="post">
		<p>Username</p>
		<input name="username" placehoder="Please enter your username" />
		<p>Password</p>
		<input name="password" type="password" placehoder="Please Enter your password" />
		<input type="submit" value="Login" />
	</form>
</div>
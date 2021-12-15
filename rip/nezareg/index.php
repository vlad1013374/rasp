<?php
session_start();
require '../rb/rb.php';
R::setup('mysql:host=localhost;dbname=vlad1013374_mail','vlad1013374_vladislav', 'rb049674');
?>

<form method="POST">
	<input type="text" name ="login">
	<input type="password" name="password">
	<input type="submit" name="enter" >
</form>

<?php
	

	if (isset($_POST['enter'])) {
		$user = R::findOne('user', 'login = ?', array($_POST['login']));
		if ($user) {
			if(password_verify($_POST['password'], $user->password)){
				$_SESSION['logged_user'] = $user;
				header ('Location:'.$_SERVER['PHP_SELF']);
			}else{
				echo 'Введён неверный пароль!';
			}
		}else{
			echo 'Пользователь не найден!';
		}
	}
/*
	require '../rb/rb.php';
	R::setup('mysql:host=localhost;dbname=vlad1013374_mail','vlad1013374_vladislav', 'rb049674');

	header( 'Location: '.$_SERVER['PHP_SELF'] );
*/
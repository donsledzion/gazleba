<?php
session_start();

if (!isset($_SESSION['logged_ID']))
{
	if(isset($_POST['login']))
	{
		$login = filter_input(INPUT_POST, 'login');
		$password = filter_input(INPUT_POST, 'pass');
		
		require_once "database.php";
		
		$matchPass = $db->prepare('SELECT login, password FROM admins WHERE login = :login');
		$matchPass->bindValue(':login', $login, PDO::PARAM_STR);
		$matchPass->execute();
		
		echo $matchPass->rowCount()."<br/>";
		
		$user = $matchPass->fetch();
		
		echo $password." ".$user['password']."<br/>";
		
		if(password_verify($password, $user['password']))
		{
			$_SESSION['logged_ID'] = $user['login'] ;
			unset($_SESSION['bad_attempt']);
		}
		else
		{
			$_SESSION['bad_attempt'] = true ;
			header('Location: admin.php');
			exit();
		}
	}
	else
	{
		header('Location: admin.php');
		exit();
	}
}

header('Location: index.php');
echo $_SESSION['logged_ID']."<br/>" ;
echo 'dane logowania poprawne, trwa logowanie';



?>
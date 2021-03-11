<?php
session_start();

if (isset($_SESSION['logged_ID']))
{
	header ('Location: index.php') ;
	exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Zaloguj do panelu administracyjnego</title>
    <meta name="description" content="Używanie PDO - odczyt z bazy MySQL">
    <meta name="keywords" content="php, kurs, PDO, połączenie, MySQL">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="container">

        <main>
            <article>
                <form action="login.php" method="post">
                    <input type="text" name="login" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'">
					
                    <input type="password" name="pass" placeholder="haslo" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'">
					
                    <input type="submit" value="Zaloguj się!">
                </form>
            </article>
        </main>

    </div>
</body>
</html>

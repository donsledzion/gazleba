<?php

session_start();

require_once 'database.php' ;

if (isset($_POST['FV']))
{
	//udana walidacja? Załóżmy, że tak!
	$all_OK = true ; //ustawienie flagi! dowolna niepoprawność zmieni flagę na false
	
	
	//Sprawdź długość numeru faktury VAT (nie krótsza niż 3 znaki, nie dłuższa niż 50znaków)
	$fv = $_POST['FV'];
	if((strlen($fv)<3)||(strlen($fv)>50))
	{
		$all_OK = false ;
		$_SESSION['e_fv']="Numer faktury musi mieć od 3 do 50 znaków";
	}
	
	//Jeżeli numer faktury spełnia warunek długości (3 do 50 znaków) to sprawdź czy już nie ma takiej faktury w bazie
	
	if(!isset($_SESSION['e_fv']))
	{
		$fv_query = $db->prepare("SELECT 1 FROM gaz_rozliczenia WHERE numer_FV=?");
		//$fv_query->bindValue(':FV', $_POST[FV], PDO::PARAM_STR);
		//$fv_query->execute;
		$fv_query -> execute([$_POST[FV]]);
		if($fv_query->fetchColumn())
		{
			$all_OK = false ;
			$_SESSION['e_fv']="Faktura o podanym numerze już istnieje w bazie!";
		}
	}
	
	
	//Sprawdź poprawność dat rozliczenia
	if(date(strtotime($_POST['data_DO'])-strtotime($_POST['data_OD']))<0) //sprawdź czy data "kolejna" jest późniejsza od daty "poprzedniej"
	{
		$all_OK = false ;
		$_SESSION['e_date']="wskazane daty muszą być rosnące";
	}
	
	//Sprawdź poprawność wielkości odczytów
	if($_POST['odczyt_DO']<$_POST['odczyt_OD'])
	{
		$all_OK = false ;
		$_SESSION['e_amount']="odczyt bieżący nie może być mniejszy od poprzedniego";
	}
	
	
	//dopisać warunki sprawdzające poprawność wprowdzonych danych - daty i kwoty, etc
	if($all_OK == true)
	{	
	$query = $db -> prepare('INSERT INTO gaz_rozliczenia VALUES(:FV, :odczyt_OD, :odczyt_DO, :energia_kWh, :faktura_netto, :sprzedaz_netto, :data_OD, :data_DO)');
	$query->bindValue(':FV', $_POST[FV], PDO::PARAM_STR);
	$query->bindValue(':data_OD', $_POST[data_OD], PDO::PARAM_STR);
	$query->bindValue(':data_DO', $_POST[data_DO], PDO::PARAM_STR);
	$query->bindValue(':odczyt_OD', $_POST[odczyt_OD], PDO::PARAM_STR);
	$query->bindValue(':odczyt_DO', $_POST[odczyt_DO], PDO::PARAM_STR);
	$query->bindValue(':energia_kWh', $_POST[energia_kWh], PDO::PARAM_STR);
	$query->bindValue(':faktura_netto', $_POST[faktura_netto], PDO::PARAM_STR);
	$query->bindValue(':sprzedaz_netto', $_POST[sprzedaz_netto], PDO::PARAM_STR);
	$query->execute();
	}
	
} else {
	header('Location: index.php') ;
	exit();
}
	header('Location: index.php');
?>

<?php
session_start();
require_once "database.php";
if (!isset($_SESSION['logged_ID'])){
	header('Location: admin.php') ;
	exit();
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Zużycie gazu w Urzędzie Miejskim w Łebie</title>
    <meta name="description" content="Dodawanie wpisów o zestawieniach zużycia gazu w Urzędzie Miejskim w Łebie">
    <meta name="keywords" content="Gaz, LPG, Łeba, Urząd Miejski w Łebie">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="container" style="width:900px;">

        <header>
            <h1>ROZLICZENIA GAZU W URZĘDZIE MIEJSKIM W ŁEBIE</h1>
			<p><a href="logout.php">Wyloguj się!</a></p>
        </header>

        <main>
			<article class="rozliczenie">				
				<form method="post" action="save.php">
					<table id="dodajRozliczenie">
						<thead>
							<tr>
								<th><label>Numer faktury<br/>VAT</th>
								<th colspan="2"><label>ROZLICZENIE</th>
								<th colspan="2"><label>WSKAZANIE [m3]</th>
								<th style="width:40px;"><label>zużycie<br/>energii [kWh]</th>
								<th colspan="2"><label>wartość netto [PLN]</th>
							</tr>
						</thead>
						
						<tbody>
							<tr> 								
								<td rowspan="2"><input type="text" name="FV" style="width:190px;" tabindex=1><br/>
								<?php
								if(isset($_SESSION['e_fv']))
								{
									echo '<div class="error">'.$_SESSION['e_fv'].'</div>';
									unset($_SESSION['e_fv']) ;
								}
								?>
								</label></td>
								<td>OD</td>
								<td><input type="date" name="data_OD" style="width:110px;"  tabindex=2></label></td>
								<td>OD</td>
								<td><input type="number" name="odczyt_OD" style="width:80px;" tabindex=4></label></td>
								<td rowspan="2"><input type="number" name="energia_kWh"  style="width:60px;" tabindex=6></label></td>
								<td>faktury</td>
								<td><input type="number" step="0.01" name="faktura_netto" style="width:80px;" tabindex=7></label></td>
							</tr>
							
							<tr>
								<td>DO</td>
								<td><input type="date" name="data_DO" style="width:110px;" tabindex=3>
								<?php
								if(isset($_SESSION['e_date']))
								{
									echo '<div class="error">'.$_SESSION['e_date'].'</div>';
									unset($_SESSION['e_date']) ;
								}
								?>
								</label></td>
								<td>DO</td>
								<td><input type="number" name="odczyt_DO" style="width:80px;" tabindex=5>
								<?php
								if(isset($_SESSION['e_amount']))
								{
									echo '<div class="error">'.$_SESSION['e_amount'].'</div>';
									unset($_SESSION['e_amount']) ;
								}
								?>
								</label></td>
								<td>paliwa</td>
								<td><input type="number" step="0.01" name="sprzedaz_netto" style="width:80px;" tabindex=8></label></td>
							</tr>
						</tbody>
					</table>
					<input type="submit" value="Dodaj rozliczenie" tabindex=9>
		</form>
			</article>
		  
		   <?php
		   
		   $registryQuery = $db->query('SELECT * FROM gaz_rozliczenia ORDER BY rozliczenie_data_OD DESC');
		   $records = $registryQuery->fetchAll();
		   
		   //print_r($records);		   
		   ?>
			<article class="rozliczenie">
				<table style="border-collapse:collapse;">
					<thead>
						<tr><th colspan="11">Łącznie rekordów: <?= $registryQuery ->rowCount() ?></th></tr>
						<tr>
						<th>Nr faktury VAT</th>
						<th colspan="2">rozliczenie</th>
						<th colspan="2">wskazanie</th>
						<th colspan="2">zużycie</th>
						<th colspan="2">wartości brutto [PLN]</th>
						<th colspan="2">należność [PLN]</th>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td colspan="11" style="background-color: white;"></td>
							</tr>
						<?php
						$VAT = 1.23 ;
						foreach($records as $record)
						{
							echo "
							<tr>
								<td rowspan=\"2\">{$record['numer_FV']}</td>
								<td>OD</td>
								<td>{$record['rozliczenie_data_OD']}</td>
								<td>OD</td>
								<td>{$record['stan_OD']}</td>
								<td>gazu [m3]</td>
								<td>" ;
								echo $record['stan_DO'] - $record['stan_OD'] ;
								echo "</td>
								<td>sprzedaż</td>
								<td>{$record['netto_zakup']}</td>
								<td>netto</td>
								<td>{$record['netto_FV']}</td>
							</tr>
							
							<tr>
								<td>DO</td>
								<td>{$record['rozliczenie_data_DO']}</td>
								<td>OD</td>
								<td>{$record['stan_DO']}</td>
								<td>energii [kWh]</td>
								<td>";
								echo $record['energia'] ; echo "</td>
								<td>dystrybucja</td>
								<td>" ;
								echo $record['netto_FV'] - $record['netto_zakup'] ;
								echo "
								</td>
								<td>brutto</td>
								<td>" ;
								echo $record['netto_FV']*$VAT;
								echo "</td>
								
							</tr>
							
							<tr>
								<td colspan=\"11\" style=\"background-color: white;\"></td>
							</tr>
							
							";
						}
						//$date1 = strtotime('2017-10-31') ;
						//$date2 = strtotime('2017-10-01') ;
						//echo date('d',$date1 - $date2) ;
						?>
					</tbody>
				</table>
			</article>
        </main>

    </div>
</body>
</html>
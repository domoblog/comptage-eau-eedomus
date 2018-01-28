<?php
/*************************************************************************************/
/*                     ### Report conso Eau eedomus SQL V1.0 ###                     */
/*                                                                                   */
/*                       Developpement par Aurel@domo-blog.fr                        */
/*                                                                                   */
/*************************************************************************************/

include ('parametres.php');

mysql_connect($server, $sqllogin, $sqlpass) OR die('Erreur de connexion à la base');
mysql_select_db('historique') OR die('Erreur de sélection de la base');  
    $requete = mysql_query('SELECT SUM(conso) FROM eau WHERE WEEK(date) = WEEK(curdate()) AND YEAR(date) = YEAR(curdate())') OR die('Erreur de la requête MySQL'); 
	     while($resultat = mysql_fetch_row($requete))  
     {  
		$consohebdo = $resultat[0];
	 }
	 
mysql_connect($server, $sqllogin, $sqlpass) OR die('Erreur de connexion à la base'); 
mysql_select_db('historique') OR die('Erreur de sélection de la base');  
    $requete = mysql_query('SELECT SUM(conso) FROM eau WHERE MONTH(date) = MONTH(curdate()) AND YEAR(date) = YEAR(curdate())') OR die('Erreur de la requête MySQL'); 
	     while($resultat = mysql_fetch_row($requete))  
     {  
		$consomensuelle = $resultat[0];
	 }

mysql_connect($server, $sqllogin, $sqlpass) OR die('Erreur de connexion à la base');
mysql_select_db('historique') OR die('Erreur de sélection de la base');  
    $requete = mysql_query('SELECT SUM(conso) FROM eau WHERE YEAR(date) = YEAR(curdate())') OR die('Erreur de la requête MySQL'); 
	     while($resultat = mysql_fetch_row($requete))  
     {  
		$consoannuelle = $resultat[0];
	 }
mysql_close();


// conversion en m3
$consohebdom3 = ($consohebdo / 1000);
$consomensuellem3 = ($consomensuelle / 1000);
$consoannuellem3 = ($consoannuelle / 1000);

// Tarifs
$consohebdoprix = ($consohebdom3 * $prix_m3);
$consomensuelleprix = ($consomensuellem3 * $prix_m3);
$consoannuelleprix = ($consoannuellem3 * $prix_m3);


//******************************************** Changement d'année ***********************************************
$annee_jour = date('Y');
$annee_veille = strftime("%Y", mktime(0, 0, 0, date('m'), date('d')-1, date('Y'))); 

if ($annee_jour > $annee_veille)
{
	$consoannuellem3 = 0;
	$consoannuelleprix = 0;
}


//******************************************** Update conso hebdo***********************************************
$url = "http://$IPeedomus/api/set?action=periph.value";
$url .= "&api_user=$api_user";
$url .= "&api_secret=$api_secret";
$url .= "&periph_id=$periph_hebdo";
$url .= "&value=$consohebdoprix";

$result = file_get_contents($url);

if (strpos($result, '"success": 1') == false)
{
  echo "Une erreur est survenue sur l'update hebdo: [".$result."]";
}
else
{
 echo "update hebdo ok<br/>";
}

//******************************************** Update conso mensuelle***********************************************
$url = "http://$IPeedomus/api/set?action=periph.value";
$url .= "&api_user=$api_user";
$url .= "&api_secret=$api_secret";
$url .= "&periph_id=$periph_mensuel";
$url .= "&value=$consomensuelleprix";

$result = file_get_contents($url);

if (strpos($result, '"success": 1') == false)
{
  echo "Une erreur est survenue sur l'update mensuel: [".$result."]";
}
else
{
 echo "update mensuel ok<br/>";
}

//******************************************** Update conso annuelle***********************************************
$url = "http://$IPeedomus/api/set?action=periph.value";
$url .= "&api_user=$api_user";
$url .= "&api_secret=$api_secret";
$url .= "&periph_id=$periph_annuel";
$url .= "&value=$consoannuelleprix";

$result = file_get_contents($url);

if (strpos($result, '"success": 1') == false)
{
  echo "Une erreur est survenue sur l'update annuel: [".$result."]";
}
else
{
 echo "update annuel ok<br/>";
}

//******************************************** Update conso hebdo m3***********************************************
$url = "http://$IPeedomus/api/set?action=periph.value";
$url .= "&api_user=$api_user";
$url .= "&api_secret=$api_secret";
$url .= "&periph_id=$periph_hebdom3";
$url .= "&value=$consohebdom3";

$result = file_get_contents($url);

if (strpos($result, '"success": 1') == false)
{
  echo "Une erreur est survenue sur l'update kwh hebdo: [".$result."]";
}
else
{
 echo "update m3 hebdo ok<br/>";
}

//******************************************** Update conso mensuelle m3***********************************************
$url = "http://$IPeedomus/api/set?action=periph.value";
$url .= "&api_user=$api_user";
$url .= "&api_secret=$api_secret";
$url .= "&periph_id=$periph_mensuelm3";
$url .= "&value=$consomensuellem3";

$result = file_get_contents($url);

if (strpos($result, '"success": 1') == false)
{
  echo "Une erreur est survenue sur l'update kwh mensuel: [".$result."]";
}
else
{
 echo "update m3 mensuel ok<br/>";
}

//******************************************** Update conso annuelle m3***********************************************
$url = "http://$IPeedomus/api/set?action=periph.value";
$url .= "&api_user=$api_user";
$url .= "&api_secret=$api_secret";
$url .= "&periph_id=$periph_annuelm3";
$url .= "&value=$consoannuellem3";

$result = file_get_contents($url);

if (strpos($result, '"success": 1') == false)
{
  echo "Une erreur est survenue sur l'update kwh annuel: [".$result."]";
}
else
{
 echo "update m3 annuel ok<br/>";
}


//-----------------------Import des données de comparaison--------------------------
mysql_connect($server, $sqllogin, $sqlpass) OR die('Erreur de connexion à la base');
mysql_select_db('historique') OR die('Erreur de sélection de la base');  
    $requete = mysql_query('SELECT conso FROM eau ORDER BY id DESC'); 

	     while($resultat = mysql_fetch_row($requete))  
     {  
		$consoj1 = $resultat[0];
	 }

mysql_close();

mysql_connect($server, $sqllogin, $sqlpass) OR die('Erreur de connexion à la base');
mysql_select_db('historique') OR die('Erreur de sélection de la base');  
    $requete = mysql_query('SELECT conso FROM eau ORDER BY id DESC LIMIT 1,1');
	     while($resultat = mysql_fetch_row($requete))  
     {  
		$consoj2 = $resultat[0];
	 }

mysql_close();


if ($consoj1 < $consoj2){
$bilan = '1';
}
elseif ($consoj1 > $consoj2) {
$bilan = '0';
}


//******************************************** Update bilan***********************************************
$url = "http://$IPeedomus/api/set?action=periph.value";
$url .= "&api_user=$api_user";
$url .= "&api_secret=$api_secret";
$url .= "&periph_id=$etatbilan";
$url .= "&value=$bilan";

$result = file_get_contents($url);

if (strpos($result, '"success": 1') == false)
{
  echo "Une erreur est survenue sur l'update bilan: [".$result."]";
}
else
{
 echo "update bilan ok<br/>";
}
echo $consoj1;
echo $consoj2;
echo $bilan;

?>
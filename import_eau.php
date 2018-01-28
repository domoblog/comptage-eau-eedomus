<?php

/*************************************************************************************/
/*                 ### Report conso d'eau eedomus SQL V1.0 ###                       */
/*                                                                                   */
/*                       Developpement par Aurel@domo-blog.fr                        */
/*                                                                                   */
/*************************************************************************************/
 
// Import du json depuis l'api eedomus et extraction de la valeur
$url =  "http://".$IPeedomus."/api/get?action=periph.caract&periph_id=".$periph_id."&api_user=".$api_user."&api_secret=".$api_secret."";

//URL distante via le clould eedomus
//$url =  "http://api.eedomus.com/get?action=periph.caract&periph_id=".$periph_id."&api_user=".$api_user."&api_secret=".$api_secret."";
          $arr = json_decode(utf8_encode(file_get_contents($url)));
 		  $conso = $arr->body->last_value;
		  $datereleve = $arr->body->last_value_change;
		  
$db = mysql_connect($server, $sqllogin, $sqlpass);
mysql_select_db('historique',$db);
$sql = ' INSERT INTO eau( date, conso ) VALUES ("'.$datereleve.'", "'.$conso.'")';

$req = mysql_query($sql);
if ($req) { echo utf8_encode("<div class=\"envoi\"><b>Enregistrement effectu&eacute;</b></div>"); }
else { echo 'Erreur SQL !<br />'.$sql.'<br />'.mysql_error(); }

mysql_close();
?>

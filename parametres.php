<?php
/*************************************************************************************/
/*                 ### Report conso d'eau eedomus SQL V1.0 ###                       */
/*                                                                                   */
/*                       Developpement par Aurel@domo-blog.fr                        */
/*                                                                                   */
/*************************************************************************************/
 
//*************************************** API eedomus *********************************
// Identifiants de l'API eeDomus
$api_user = "CollezVotreApiUserEedomus";
$api_secret = "CollezVotreCleApiEedomus";

//*************************************** Param network *******************************
//@IP eedomus
$IPeedomus="AdresseIpBoxEedomus";
//server MySQL
$server='localhost';
//MySQL login
$sqllogin='IndiquezLeCompteSQL';
//MySQL password
$sqlpass='IndiquezLeMotDePasseSQL';
 
 
//*************************************** codes api couts eau *************************
//numero du peripherique relevé hebdo
$periph_hebdo=11111;
//numero du peripherique relevé mensuel
$periph_mensuel=22222;
//numero du peripherique relevé annuel
$periph_annuel=33333;
 
//*************************************** codes api m3 eau ****************************
//hebdo m3
$periph_annuel=44444;
//hebdo m3
$periph_hebdom3=55555;
//mensuel m3
$periph_mensuelm3=66666;
//annuel m3
$periph_annuelm3=77777;
 
//*************************************** codes api relevé eau *************************
//numero du peripherique de relevé d'eau
$periph_rlv_elec=88888;
//tarif du m3
$prix_m3=5.39;
//bilan conso
$etatbilan=99999;
?>

<?php

//Tableau avec les joueurs 
$array1 = array( "NC", "A0","A2","A4","A6", "B0", "B2", "B4", "B6" ,"C0", "C2", "C4", "C6","D0","D2","D4", "D6" ,"E0", "E2","E4","E6");
$jA = "B0";
$victoires = array("A6","B0","B2");
$defaites = array("B2");
//$defaites = array("B2","B2","B2");

//Fonction qui premet la  position du joueur
function calcule_diff(&$tab, $joueur, $adversaire)
{
     $posjou=0;
     $posadv=0;
    echo 'joueur = '.$joueur.'<br> adversaire = '.$adversaire.'<br>';

     for($i=0;$i < count($tab) ;$i++) 
     { 

          if( $tab[$i] == $joueur) {

              $posjou=$i;

              echo'Position du joueur dans le tableau'+$posjou+'<br>';

          }elseif ($tab[$i] == $adversaire) {

              $posadv=$i;

              echo'Position de l\' adversaire dans le tableau'+$posadv+'<br>';

    
          }
      //echo 'position joueur = '.$posjou.'<br> position adversaire = '.$posadv.'<br>';

       }

      return   $posjou - $posadv;
}



 $re=calcule_diff($array1,"B0","A6");

 echo $re;

function calcule_point_victoire($diff)
{
  switch($diff)
  {
    case -2: 
    return 1;
    break;
    case -1:
    return 2;
    break;
    case 0:
    return 3;
    break;
    case 1:
    return 4;
    break;
    case 2:
    return 5;
    break;
  }
}


function calcule_point_defaite($diff)
{
  switch($diff)
  {
    case -2:
    return -5;
    break;
    case -1:
    return -4;
    break;
    case 0:
    return -3;
    break;
    case 1:
    return -2;
    break;
    case 2:
    return -1;
    break;
  }
}

function calcule_points($niveau,$victoires,$defaites)
{
  $resultat = 0;
  foreach($victoires as $adversaire)
  {
    $diff = calcule_diff($array1,$niveau,$adversaire);
    if (($diff > -3) or ($diff < 3)) $resultat = $resultat + calcule_point_victoire($diff);
  }
  echo 'résultat des victoires ='.$resultat.'<br>';
  foreach($defaites as $adversaire)
  {
    $diff = calcule_diff($array1,$niveau,$adversaire);
    if (($diff > -3) or ($diff < 3)) $resultat = $resultat + calcule_point_defaite($diff);
    echo 'différence = '.$diff.'<br>';
  }
  return $resultat;
}

//echo calcule_points($jA,$victoires,$defaites);



?>
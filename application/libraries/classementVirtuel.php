<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ClassementVirtuel {

//Tableau avec les joueurs 
private $tableau = array("NC","A0","A2","A4","A6","B0","B2","B4","B6","C0","C2","C4","C6","D0","D2","D4","D6","E0","E2","E4","E6");
//$jA = "B0";
//$victoires = array("A6","B0","E6","A6","A6");
//$defaites = array("B2","B4","B0");
//$defaites = array("B2","B2","B2");


//Fonction qui renvoit la position de l'adversaire par rapport au joueur 
public function calcule_diff(&$tab, $joueur, $adversaire)
{
     $posjou=0;
     $posadv=0;
     //echo 'joueur = '.$joueur.'<br> adversaire = '.$adversaire.'<br>';

     for($i=0;$i < count($tab) ;$i++) 
     { 
          if($tab[$i] == $joueur) {

              $posjou=$i;

              //echo'Position du joueur dans le tableau'.$posjou.'<br>';

          }
          if ($tab[$i] == $adversaire) {

              $posadv=$i;

              //echo'Position de l\' adversaire dans le tableau'.$posadv.'<br>';
          }
      }
      //echo 'diff = '+($posjou-$posadv);
      
      return   $posadv - $posjou;
}


public function calcule_point_victoire($diff)
{
  switch($diff)
  {
    case -2: 
    return 5;
    break;
    case -1:
    return 4;
    break;
    case 0:
    return 3;
    break;
    case 1:
    return 2;
    break;
    case 2:
    return 1;
    break;
    default: 0;
    break;
  }
}


public function calcule_point_defaite($diff)
{
  switch($diff)
  {
    case -2:
    return -1;
    break;
    case -1:
    return -2;
    break;
    case 0:
    return -3;
    break;
    case 1:
    return -4;
    break;
    case 2:
    return -5;
    break;
    default: 0;
    break;
  }
}

public function calcule_points($niveau,$victoires,$defaites)
{
  $resultat = 0;
  global $tableau;
  foreach($victoires as $adversaire)
  {
    $diff = $this->calcule_diff($tableau,$niveau,$adversaire);
    //echo 'diff = '.$diff.'<br>';
    //if (($diff > -3) or ($diff < 3)) $resultat = $resultat + calcule_point_victoire($diff);
    $resultat = $resultat + $this->calcule_point_victoire($diff);
    //echo 'resultat = '+$resultat.'<br>';
  }
  //echo 'résultat des victoires ='.$resultat.'<br>';
  foreach($defaites as $adversaire)
  {
    $diff = $this->calcule_diff($tableau,$niveau,$adversaire);
    //echo 'diff = '.$diff.'<br>';
    //if (($diff > -3) or ($diff < 3)) $resultat = $resultat + calcule_point_defaite($diff);
    $resultat = $resultat + $this->calcule_point_defaite($diff);
    //echo 'resultat = '+$resultat.'<br>';
  }
  //echo 'résultat des defaites ='.$resultat.'<br>';
    return $resultat;
}

//echo calcule_points($jA,$victoires,$defaites);


public function classement_virtuel($classement,$victoires,$defaites)
{
  global $tableau;
  //On fait un premier calcul avec son classement
  $pts = $this->calcule_points($classement,$victoires,$defaites);
  if($pts == 0) return $classement; 
  //Si résultat > 0 , on monte d'un classement
  if($pts > 0)
  {
    do
    {
      $temp = $pts;
      $classement = $this->monte($classement);
      $pts = $this->calcule_points($classement,$victoires,$defaites);
    }while(abs($pts) < abs($temp) && $pts > 0);
    return $classement;
  } 
  //Sinon on descend
  if($pts < 0)
  {
    $i = 0;
    do
    {
      $i++;
      $temp = $pts;
      $classement = $this->descend($classement);
      $pts = $this->calcule_points($classement,$victoires,$defaites);
      //echo 'temp : ' .$temp. '| classement : ' .$classement. '| pts : ' .$pts. '<br>';
      }while(abs($pts) < abs($temp) && $pts < 0);
    return $classement;
  } 
}

public function monte($classement)
{
  global $tableau;
  $index = array_search($classement, $tableau);
  if($index !== FALSE)
  {
    return $tableau[$index - 1];
  }
}

public function descend($classement)
{
  global $tableau;
  $index = array_search($classement, $tableau);
  if($index !== FALSE)
  {
    return $tableau[$index + 1];
  }
}
}
/*echo 'nouveau classement : ' .classement_virtuel($jA,$victoires,$defaites);

$jB = 'B2';
echo 'nouveau classement : ' .classement_virtuel($jB,$victoires,$defaites);
$jC = 'B4';
echo 'nouveau classement : ' .classement_virtuel($jC,$victoires,$defaites);*/


?>
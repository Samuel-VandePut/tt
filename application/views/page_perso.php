

 <div class="container">
       <div class="row">
              <div class="col-md-8">
<?php
              echo'<h3 class="my-4 text-left">Bienvenue '.$nom.' '.$prenom.'</h3>';
?>

              </div>
              <div class="container"> 
                    <table class="table table-bordered">
                            <thead>
                              <tr>
                              <th>Classement</th>
                              <th>Pool</th>
                              <th>Rencontre</th>
                              <th>Interclub</th>
                              <th>Match</th>
                              <th>Defaite</th>
                              <th>Victoire</th>
                              </tr>
                            </thead>
                      <tbody>
                  
          <?php
              var_dump($joueur);die();
              if(count($joueur) > 0 ){
                    foreach ($joueur as $row)
                    {
                    
                          echo'<tr>
                                  <td>'.$row->classement.'</td>';
                              echo'<td>'.$row->FK_pool.'</td>';
                              echo'<td>'.$row->id_rencontre.'</td>';
                              echo'<td>'.$row->FK_interclub.'</td>';
                              echo'<td>'.$row->id_match.'</td>';
                              if (!empty($row->defaite)) {

                                  echo'<td>'.$row->defaite.'</td>';
                              }
                              else
                              {
                                echo'<td><p class="text-center"> * </p></td>';
                              }

                              if (!empty($row->victoire)) {
                                
                                    echo'<td>'.$row->victoire.'</td>';
                                }
                                else
                                {
                                    echo'<td><p class="text-center"> * </p></td>';
                                }
                                
                              echo'</tr>';
                      }
                      

              }else{
                      echo'<p class="text-center">Desolé,nous n\'avons aucune information </p>';
              }
            ?>
                                    
                          </tbody>
                    </table>
             </div>  
         </div>
    </div>';
    
 
    
   

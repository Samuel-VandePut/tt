

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
                                 <th>Nombre de match</th>
                                 <th>Nombre  de victoire </th> 
                                 <th>Nombre de defaite </th>                            
                              </tr>
                            </thead>
                      <tbody>
                  
          <?php
              if(count($joueur) > 0 ){
                          //var_dump  ($T_match);
                         echo'<tr>';
                              foreach ($total as $row)
                              {
                                echo'<td>'.$row->classement.'</td>';
                              }
                              echo'<td>'.$T_match.'</td>';
                              echo'<td>'.$victoire.'</td>';
                              echo'<td>'.$defaite.'</td>';
                         echo'</tr>';
                     
                      

              }else{
                      echo'<p class="text-center">Desolé,nous n\'avons aucune information </p>';
              }
            ?>
                                    
                          </tbody>
                    </table>
                    <br>
                    <div class="col-md-8">
                         <button type="button" id="btnClassement" class="btn btn-primary">Classement Virtuel</button>
                    </div>
                    <br>
                    <div id="classement" class="col-md-4"></div>
                    <div class="container"> 
                    <table class="table table-bordered">
                            <thead>
                              <tr>                      
                                 <th>Date des matchs</th>
                                 <th>Defaite</th>
                                 <th>Victoire</th>
                              </tr>
                            </thead>
                      <tbody>
                  
          <?php
              if(count($joueur) > 0 ){

                 
                    foreach ($joueur as $row)
                    {
                           echo'<tr>    
                                <td>'.$row->date.'</td>';                    

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
    </div>
    
 
     
    
   

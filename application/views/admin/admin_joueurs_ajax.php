<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {

    //datatables
    table = $('#table_pool_3').DataTable({ 
 
        "responsive": true,
        // Load data for the table's content from an Ajax source
        "ajax": "<?php echo site_url()?>joueur/ajax_joueurs/3"
    });

    table = $('#table_pool_4').DataTable({ 
 
        "responsive": true,
        // Load data for the table's content from an Ajax source
        "ajax": "<?php echo site_url()?>joueur/ajax_joueurs/4"
            
    });

    $('#table_pool_3 tbody').on( 'click', 'input[type="button"]', function () {
        var table = $('#table_pool_3').DataTable();
        var cell = table.cell($(this).parent('td'));
        change_button(cell);
    } );

    $('#table_pool_4 tbody').on( 'click', 'input[type="button"]', function () {
        var table = $('#table_pool_4').DataTable();
        var cell = table.cell($(this).parent('td'));
        change_button(cell);
    } );

    function change_button(cell)
    {
        if(cell.data().indexOf("Présent") !== -1) cell.data("<input type=\"button\" value=\"Absent\">").draw();
        else cell.data("<input type=\"button\" value=\"Présent\">").draw();
    }

    $("#equipe-modal").on("hidden.bs.modal", function () {
        $("#modal_table_effectif").DataTable().destroy();
        $("#modal_table_reserve").DataTable().destroy();
    });
});

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function generate_team(pool)
{    
    //** Algo
    //Supprimer les joueurs indisponibles
    //Dans les joueurs qui restent mettre ceux qui ont joué lors du dernier interclub dans une autre liste
    //Si le nbre de joueurs est < 4 => prendre les joueurs de l'équipe réserve qui n'ont pas joués lors de l'avant dernier IC et qui ont le plus de victoires pour compléter l'équipe.
    //Ultérieurement, proposer une équipe type en fonction de la forme de chaque joueur.
    var table = $('#table_pool_'+pool).DataTable();

    //Supprimer les joueurs indisponibles / ne garder que les disponibles 
    //var nodes = [];
    var joueurs = [];
    var joueurs_reserve = [];

    //*** Remove joueurs absents ***//
    table.rows().every(function(rowIdx, tableLoop, rowLoop) { if(this.data()[5].indexOf("Présent") !== -1) joueurs.push(table.row(this.node()).data()); });
    //*** /Remove joueurs absents ***//
    
    if(joueurs.length > 4)
    {
        get_joueurs_last_ic(function(data){

            //*** Générer réserves dernier IC ***//
            var ids = [];
            joueurs.forEach(function(joueur) 
            {
                data.joueurs_last.forEach(function(j) 
                { 
                    if(j.FK_joueur === joueur[0]) //Si le joueur a joué lors du dernier IC
                    {
                        ids.push(joueur[0]); //je récupère l'id
                    }
                });
            });

            ids.forEach(function(i) //boucler a travers les id des joueurs qui ont déjà joué le dernier IC
            {
                var index = joueurs.findIndex(x => x[0] == i); //trouver l'index correspondant au jouer avec l'id
                var joueur = joueurs.splice(index, 1); //(index, nbre d'élement à retirer)//Retirer le joueur de la liste joueurs
                joueurs_reserve.push.apply(joueurs_reserve, joueur); //Mettre le joueur dans la liste réserve
            });
            //*** //Générer réserves dernier IC ***//
            if(joueurs.length < 4)
            {
                alert("equipe < 4");
                //Départager par le nombre de victoires lors des 5 derniers matchs     
                while(joueurs.length < 4 && joueurs_reserve.length > 0) //tant que l'équipe effective n'est pas pleine et qu'il reste des réserves
                {
                    var points = 0;
                    var temp = 0;
                    var index = 0;
                    for(var i = 0; i < joueurs_reserve.length; i++) //Boucler a travers les joueurs réserves
                    {
                        points = occurrences(joueurs_reserve[i][4],"w");
                        if(temp < points)
                        {
                            temp = points;
                            index = i;    
                        }
                    }
                    var joueur = joueurs_reserve.splice(index, 1); //Retirer le joueur de la liste joueurs_reserve
                    joueurs.push.apply(joueurs, joueur); //Mettre le joueur dans la liste principale
                }
                show_modal(pool,joueurs,joueurs_reserve);
            }
            else if(joueurs.length > 4)
            {
                alert("equipe > 4 | joueurs.length = " + joueurs.length);
                //Départager par le nombre de victoires lors des 5 derniers matchs     
                while(joueurs.length > 4) //tant que l'équipe effective est surchargée
                {
                    var points = 0;
                    var temp = 5;
                    var index = 0;
                    for(var i = 0; i < joueurs.length; i++) //Boucler a travers les joueurs effectifs
                    {
                        points = occurrences(joueurs[i][4],"w");
                        alert("joueurs = " + joueurs[i][1] + " | points :" + points);
                        if(temp > points)
                        {
                            temp = points;
                            index = i;
                        }
                    }
                    alert("joueurs :" + joueurs[index][1] + " a été retiré");
                    var joueur = joueurs.splice(index, 1); //Retirer le joueur de la liste joueurs_reserve
                    joueurs_reserve.push.apply(joueurs_reserve, joueur); //Mettre le joueur dans la liste principale
                }
                show_modal(pool,joueurs,joueurs_reserve);
            }
            else if(joueurs.length == 4)
            {
                alert("equipe == 4");
                show_modal(pool,joueurs,joueurs_reserve);
            }
            //Si le nombre de joueurs de l'équipe principale est inférieur à 4,
            //***Classer joueurs_reserve en fonction des critères de sélection***
            /*ids = [];
            joueurs_reserve.forEach(function(joueur) 
            {
                data.joueurs_slast.forEach(function(j) 
                { 
                    if(j.FK_joueur === joueur[0]) //Si le joueur a joué lors de l'avant dernier IC
                    {
                        ids.push(joueur[0]);//je récupère l'id
                    }
                });
            });*/

            //if(ids != 0)// Si ids != 0 => classer les joueurs défavorisés en ordre utile
            //{
            /*ids.forEach(function(i) //boucler a travers les id des joueurs qui ont déjà joué le dernier IC
            {
                var index = joueurs_reserve.findIndex(x => x[0] == i); //trouver l'index correspondant au joueur avec l'id
                var joueur = joueurs_reserve.splice(index, 1); //Retirer le joueur de la liste joueurs_reserve
                joueurs_reserve.push.apply(joueurs_reserve, joueur); //Mettre le joueur dans le fond de la liste
            });*/
            //if(ids > (4 - joueurs.length)) //Si il y a plus de réserves n'ayant pas joué lors de l'avant dernier IC que de joueurs manquants
            //{
                  
            //}
            //else //on prend juste les joueurs disponibles
            //{

            //}
            //}
            //else //Sinon classer les joueurs en fonction du nbr de victoires
            //{
                /*$.ajax({
                    url : "<?php //echo site_url('Home/ajax_upload')?>",
                    type: "GET",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data)
                    {

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                    
                    }
                });*/                
            //}

            /*while(joueurs.length < 4 && joueurs_reserve.length > 0) //Prendre des réserves pour compléter l'équipe principale
            {
                var joueur_r = joueurs_reserve.splice(0,1);
                joueurs.push.apply(joueurs, joueur_r); 
            }*/

            //show_modal(pool,joueurs,joueurs_reserve);

        });    
    }
    else
    {
        show_modal(pool,joueurs,joueurs_reserve);
    }

    //Récupérer le nombre de matchs
    /*joueurs.forEach(function(joueur) {
        var joueur = table.row(joueur).data();
        matchs = get_matchs(joueur[0]);
    });*/
    //Mettre dans le fond de la liste les joueurs qui ont joué lors du dernier interclub
    //Récupérer le nombre de rencontres et la forme de chaque joueurs
}

function show_modal(pool,joueurs,joueurs_reserve) 
{
    $("h3.modal-title").text("Equipe Division " + pool);
    $("#modal_table_effectif").DataTable({
        "bFilter": false,
        "paging":   false,
        "ordering": false,
        "info":     false,
        data: joueurs
    })
    $("#modal_table_reserve").DataTable({
        "bFilter": false,
        "paging":   false,
        "ordering": false,
        "info":     false,
        data: joueurs_reserve
    })

    $("#equipe-modal").modal(); 
}

function check_played(result){
    joueurs.forEach(function(joueur) 
    {
        if(result.indexOf(joueur[1]) > -1) alert("il a joué");
        else alert("il n a pas joué");
    });
}

function get_joueurs_last_ic(handleData)
{
    $.ajax({
        url : "<?php echo site_url('Rencontre/ajax_get_joueurs_lastIC')?>",
        type: "GET",
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {
            handleData(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            return null;
        }
    });
}


function hide()
{
    $("#modal_table_effectif").DataTable().destroy();
    $("#modal_table_reserve").DataTable().destroy();
    $('#modal_form').modal('hide');
}

function occurrences(string, subString, allowOverlapping) {

    string += "";
    subString += "";
    if (subString.length <= 0) return (string.length + 1);

    var n = 0,
        pos = 0,
        step = allowOverlapping ? 1 : subString.length;

    while (true) {
        pos = string.indexOf(subString, pos);
        if (pos >= 0) {
            ++n;
            pos += step;
        } else break;
    }
    return n;
}

</script>
 
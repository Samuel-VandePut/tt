<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {
    clear_localStorage();
    //localStorage.clear();
    //datatables
    table = $('#table_pool_3').DataTable({ 
        "bPaginate": false,
        "responsive": true,
        /*"order": [[ 4, "asc" ]],*/
        // Load data for the table's content from an Ajax source
        "ajax": "<?php echo site_url()?>joueur/ajax_joueurs"
    });

    $('#table_pool_3 tbody').on( 'click', 'input[type="button"]', function () {
        var table = $('#table_pool_3').DataTable();
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

function generate_team()
{    
    //** Algo
    //Supprimer les joueurs indisponibles
    //Créer une liste de joueurs par pool
    //Dans les joueurs qui restent mettre ceux qui ont joué lors du dernier interclub dans une autre liste
    //Si le nbre de joueurs est < 4 => prendre les joueurs de l'équipe réserve qui n'ont pas joués lors de l'avant dernier IC et qui ont le plus de victoires pour compléter l'équipe.
    //Ultérieurement, proposer une équipe type en fonction de la forme de chaque joueur.
 

    var table = $('#table_pool_3').DataTable();

    //Supprimer les joueurs indisponibles / ne garder que les disponibles 
    //var nodes = [];
    var joueurs = [];

    //*** Remove joueurs absents ***//
    table.rows().every(function(rowIdx, tableLoop, rowLoop) { if(this.data()[6].indexOf("Présent") !== -1) joueurs.push(table.row(this.node()).data()); });
    //*** /Remove joueurs absents ***//

    //var reserve_reserve = [];
    get_joueurs_last_ic(function(data){
        while(joueurs.length > 0)
        {
            //alert("joueurs : " + joueurs.length);
            //alert("reserve : " + reserve_reserve.length);
            var groupe = [];
            var reserve = [];
            var ids = [];
            var pool = "";
            var i = 'A';
            //alert("initialisation variables => pool : " + pool);
            //Créer une liste de joueur de même pool
            var first = joueurs[0]; //On prend le premier joueur de la liste comme variable temporaire
            joueurs.forEach(function(joueur){
                pool = first[4];
                if(joueur[4] == first[4]) 
                {
                    ids.push(joueur[0]);
                }
            });
            
            ids.forEach(function(i) //boucler a travers les ids
            {
                var index = joueurs.findIndex(x => x[0] == i); //trouver l'index correspondant au jouer avec l'id
                var joueur = joueurs.splice(index, 1); //(index, nbre d'élement à retirer)//Retirer le joueur de la liste joueurs
                groupe.push.apply(groupe, joueur);
            });
            //alert("groupe de meme pool" + groupe);

    
            if(groupe.length  > 4)
            {
                //alert("groupe > 4 : " + groupe.length);
                //*** Générer réserves et avantagés du dernier IC ***//
                var result = get_advantages(groupe, data.joueurs_last);
                var advantages = result.advantages;
                //alert("avantagés : " + advantages.length + " | " + advantages);
                reserve = reserve.concat(result.reserve);
                //alert("reserve : " + reserve.length + " | " + reserve);
                //*** //Générer réserves et avantagés du dernier IC ***//

                //alert("pool : " + pool + " | reserve : " + reserve);
                //Tant qu'il reste des avantagés, on créer des équipes avec
                do
                {
                    //console.log("avantagés :" + advantages);
                    //console.log("reserves :" + reserve);
                    var result = create_team(advantages, reserve);
                    var team = result.team;
                    advantages = result.groupe;
                    reserve = result.reserve;
                    //console.log("creation equipe " + pool + i + " :" + team);
                    charge_local_storage(pool, i, team);
                    i = nextChar(i);
                }while(advantages.length > 0);

                //console.log("reserve : " + reserve.length);
                while(reserve.length >= 3) // Une fois les avantagés utilisés, on vide les réserves.
                {
                    //créer une équipe
                    var result = create_team(advantages, reserve);
                    var team = result.team;
                    groupe = result.groupe;
                    reserve = result.reserve;
                    //console.log("creation equipe " + pool + i + " avec réserves:" + team);
                    charge_local_storage(pool, i, team);
                    i = nextChar(i);
                }

                if(reserve.length > 0) charge_local_storage(pool, "reserve", reserve);
                //reserve_reserve.push.apply(reserve_reserve, reserve);
                //console.log("reserve de la reserve : ", reserve_reserve);
            }
            else
            {
                charge_local_storage(pool, i, groupe);
            }
        }

    });
    show_page_equipe();
}

function clear_localStorage()
{
    for (var a in localStorage) {
        localStorage.removeItem(a);
    }
}

function nextChar(c) {
    return String.fromCharCode(c.charCodeAt(0) + 1);
}

function show_modal(joueurs,joueurs_reserve) 
{
    $("h3.modal-title").text("Equipes");
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

function get_advantages(groupe, joueurs_last)
{
    var ids = [];
    var reserve = [];

    groupe.forEach(function(joueur) 
    {
        joueurs_last.forEach(function(j) 
        {
            //alert("j.FK_joueur = " + j.FK_joueur + "| joueur[0] =" + joueur[0]);
            if(j.FK_joueur === joueur[0]) //Si le joueur a joué lors du dernier IC
            {
                ids.push(joueur[0]); //je récupère l'id
                //alert("ids push");
            }
        });
    });

    ids.forEach(function(i) //boucler a travers les id des joueurs qui ont déjà joué le dernier IC
    {
        var index = groupe.findIndex(x => x[0] == i); //trouver l'index correspondant au jouer avec l'id
        var joueur = groupe.splice(index, 1); //(index, nbre d'élement à retirer)//Retirer le joueur de la liste joueurs
        reserve.push.apply(reserve, joueur); //Mettre le joueur dans la liste réserve
    });

    return {
            advantages: groupe,
            reserve: reserve
    };
}

function create_team(groupe, reserve)
{
    var team = [];
    if(groupe.length < 4)
    {
        //alert("equipe < 4");
        //Départager par le nombre de victoires lors des 5 derniers matchs     
        while(groupe.length < 4 && reserve.length > 0) //tant que l'équipe effective n'est pas pleine et qu'il reste des réserves
        {
            var points = 0;
            var temp = 0;
            var index = 0;
            for(var i = 0; i < reserve.length; i++) //Boucler a travers les joueurs réserves
            {
                points = occurrences(reserve[i][4],"w");
                if(temp < points)
                {
                    temp = points;
                    index = i;    
                }
            }
            var joueur = reserve.splice(index, 1); //Retirer le joueur de la liste joueurs_reserve
            groupe.push.apply(groupe, joueur); //Mettre le joueur dans la liste principale
        }
        //alert("pool : " + pool + "| groupe : " + groupe + " | reserve : " + reserve);
        //charge_local_storage(pool, groupe, reserve);
        return {
            team: groupe,
            groupe: [],
            reserve: reserve
        };
    }
    else if(groupe.length > 4)
    {
        //alert("groupe > 4 ");
        //Départager par le nombre de victoires lors des 5 derniers matchs     
        while(groupe.length > 4) //tant que l'équipe effective est surchargée
        {
            var points = 0;
            var temp = 5;
            var index = 0;
            for(var i = 0; i < groupe.length; i++) //Boucler a travers les joueurs effectifs
            {
                points = occurrences(groupe[i][4],"w");
                //alert("joueurs = " + joueurs[i][1] + " | points :" + points);
                if(temp > points)
                {
                    temp = points;
                    index = i;
                }
            }
            //alert("joueurs :" + joueurs[index][1] + " a été retiré");
            var joueur = groupe.splice(index, 1); //Retirer le joueur de la liste principale
            var advantages = [];
            advantages.push.apply(advantages, joueur); //Mettre le joueur dans la liste réserve
        }
        //alert("pool : " + pool + "| groupe : " + groupe + " | reserve : " + reserve);
        //charge_local_storage(pool, groupe, reserve);
        return {
            team: groupe,
            groupe: advantages,
            reserve: reserve
        };
    }
    else if(groupe.length == 4)
    {
        //alert("equipe == 4");
        //charge_local_storage(pool, groupe, reserve);
        return {
            team: groupe,
            groupe: [],
            reserve: reserve
        };
    }
}

function charge_local_storage(pool, nom, team)
{
    //localStorage.removeItem("team" + pool + nom);
    team = JSON.stringify(team);

    localStorage.setItem("team" + pool + nom, team);
    //reserve.push.apply(reserve, localStorage.getItem("reserve"));
    //localStorage.setItem("reserve",reserve);
}

function show_page_equipe()
{
             /*   for (var i = 0; i < localStorage.length; i++){
                console.log(localStorage.key(i) + " : " + localStorage.getItem(localStorage.key(i)));
            }*/
    window.location = "<?php echo site_url('Home/Equipes')?>";
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
 
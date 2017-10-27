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
});

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function generate_team(pool)
{    
    //** Algo
    //Supprimer les joueurs indisponibles
    //Dans les joueurs qui restent mettre ceux qui ont joué lors du dernier interclub dans le fond de la liste
    //Si le nbre de joueurs est < 4 => prendre les joueurs qui ont le moins de matchs pour compléter l'équipe.
    //Ultérieurement, proposer une équipe type en fonction de la forme de chaque joueur.
    var table = $('#table_pool_'+pool).DataTable();

    //Supprimer les joueurs indisponibles / ne garder que les disponibles 
    //var nodes = [];
    var joueurs = [];
    var joueurs_reserve = [];
    table.rows().every(function(rowIdx, tableLoop, rowLoop) {
        /*if(this.data()[5].indexOf("Absent") !== -1) nodes.push(this.node()); 
        else joueurs.push(table.row(this.node()).data());*/
        if(this.data()[5].indexOf("Présent") !== -1) joueurs.push(table.row(this.node()).data());
    });
    /*nodes.forEach(function(node) {
        table.row(node).remove().draw();
    });*/
    //mettre dans le fond de la liste, les joueurs qui ont joué lors du dernier intermatch
    //retirer les joueurs excédentaires pour en laisser 4 et une ou deux réserves

    //1.Récupérer les id_joueur qui ont joué le dernier interclub
    //var joueurs_ic = get_joueurs_last_ic();
    //var joueurs_ic = [];
    //get_joueurs_last_ic(check_played());

    $.ajax({
        url : "<?php echo site_url('Rencontre/ajax_get_joueurs_lastIC')?>",
        type: "GET",
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data){
            var ids = [];
            joueurs.forEach(function(joueur) 
            {
                //alert(joueur);
                data.joueurs.forEach(function(j) 
                { 
                    //alert("id_joueur = " + joueur[0] + " | id_joueur_joué = " + j.FK_joueur);
                    if(j.FK_joueur === joueur[0]) 
                    {
                        ids.push(joueur[0]);
                        //alert("il a joué");
                    }
                });
                        
                /*data.joueurs.filter(function(joueur)
                { 
                    if(joueur.FK_joueur === joueur[0]) alert("il a joué");  
                });*/
                /*if(data.indexOf(joueur[1]) > -1) alert("il a joué");
                else alert("il n a pas joué");*/
            });


            ids.forEach(function(i) //boucler a travers les id des joueurs qui ont déjà joué le dernier IC
            {
                var index = joueurs.findIndex(x => x[0] == i);
                //alert("id = " + i + " | index = " + index);
                var joueur = joueurs.splice(index, 1); //(index, nbre d'élement à retirer)
                //joueurs.splice(-1, 0, joueur);
                //alert(joueur);
                joueurs_reserve.push.apply(joueurs_reserve, joueur);
                //joueurs_reserve.splice(-1,0,joueur); 
            });

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
            
            
            /*joueurs = $("#modal_table").DataTable();

            var ids = joueurs.column(0).data();

            data.joueurs.forEach(function(j) 
            { 
                var index = ids.indexOf(j.FK_joueur);
                ids.splice(-1, 0, index);
            });
            joueurs.page(0).draw(false);*/

            $("#equipe-modal").modal();     
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });
    //Récupérer le nombre de matchs
    /*joueurs.forEach(function(joueur) {
        var joueur = table.row(joueur).data();
        matchs = get_matchs(joueur[0]);
    });*/
    //Mettre dans le fond de la liste les joueurs qui ont joué lors du dernier interclub
    //Récupérer le nombre de rencontres et la forme de chaque joueurs
}

function check_played(result){
    joueurs.forEach(function(joueur) 
    {
        if(result.indexOf(joueur[1]) > -1) alert("il a joué");
        else alert("il n a pas joué");
    });
}

function get_joueurs_last_ic(callback)
{
    $.ajax({
        url : "<?php echo site_url('Rencontre/ajax_get_joueurs_lastIC')?>",
        type: "GET",
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: callback
    });
}


function hide()
{
    $('#modal_form').modal('hide');
}


function upload()
{
    $('#btnUpload').text('en cours...'); //change button text
    $('#btnUpload').attr('disabled',true); //set button disable 

    var formData = new FormData($('#form-upload')[0]);
    $.ajax({
        url : "<?php echo site_url('Home/ajax_upload')?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {
            $('#btnUpload').text('Ajouter image'); //change button text
            $('#btnUpload').attr('disabled',false); //set button enable 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnUpload').text('Ajouter image'); //change button text
            $('#btnUpload').attr('disabled',false); //set button enable 
 
        }
    });
}

</script>
 
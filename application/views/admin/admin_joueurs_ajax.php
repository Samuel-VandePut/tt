<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {
 
    //datatables
    table = $('#table_pool_3').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "responsive": true,
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('joueur/ajax_list/3')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [      
        ],
 
    });

        //datatables
    table = $('#table_pool_4').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "responsive": true,
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('joueur/ajax_list/4')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [      
        ],
 
    });
  
});

 
function check(id)
{
    //if($('[name="dispo'+id+'"]').attr('checked') == 'checked')
    
    $.ajax({
        url : "<?php echo site_url('joueur/ajax_set_dispo')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="dispo'+data.id_personne+'"]').attr('checked', true); // Checks it
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
 
function uncheck(id)
{
    $.ajax({
        url : "<?php echo site_url('joueur/ajax_set_indispo')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="dispo'+data.id_personne+'"]').attr('checked', false); // Unchecks it
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
 
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function generate_team_3()
{
    //var table = $('#example').DataTable();

    $.ajax({
        url : "<?php echo site_url('joueur/ajax_generate_teams')?>",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function generate_team_4()
{    
    //** Algo
    //Supprimer les joueurs indisponibles
    //Dans les joueurs qui restent mettre ceux qui ont joué lors du dernier interclub dans le fond de la liste
    //Si le nbre de joueurs est < 4 => prendre les joueurs qui ont le moins de matchs pour compléter l'équipe.
    //Ultérieurement, proposer une équipe type en fonction de la forme de chaque joueur.
    var table = $('#table_pool_4').DataTable();

    //var listJoueur = [];

    //Supprimer les joueurs indisponibles
    table.rows().every( function () { //Boucler à travers le tableau

        var d = this.data(); //Récupérer la ligne
        //listJoueur.push(d);
        
        if(d[5].indexOf("checked") !== -1) { table.row(d).remove().draw(false); } //Si la ligne contient "checked" => delete
        
        // // invalidate the data DataTables has cached for this row
    });

    //Mettre dans le fond de la liste les joueurs qui ont joué lors du dernier interclub
    table.rows().every( function () { //Boucler à travers le tableau

        var d = this.data(); //Récupérer la ligne

    });

    //Récupérer le nombre de rencontres et la forme de chaque joueurs
    table.rows().every( function () { //Boucler à travers le tableau

        var d = this.data(); //Récupérer la ligne

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
 
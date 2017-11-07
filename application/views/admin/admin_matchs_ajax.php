<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {


    $('#alert').hide(); 
    //datatables
    /*table = $('#table_files').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "responsive": true,
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php //echo site_url('Home/filesList')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [      
        ],
 
    });*/
 


    table = $('#table_matchs').DataTable({

        columns: [{
            "title": "Date",
            "data": "date"
        }, {
            "title": "Nom",
            "data": "nom"
        }, {
            "title": "Prenom",
            "data": "prenom"
        }, {
            "title": "Victoire",
            "data": "victoire"
        }, {
            "title": "Defaite",
            "data": "defaite"
        }],
        "responsive": true,
        "bFilter": false,
        "paging":   false,
        "ordering": false,
        data: ''
    });
    
    $('#apply_matchs').on('click', function(){
        var obj = tableToObj();
        
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url('Match/ajax_add')?>",
            data: {json: JSON.stringify(obj) },
            dataType: 'json',
            success: function(data)
            {
                if(data.status) 
                {
                    $('#alert').empty();
                    $("#alert").removeClass('alert-danger');
                    $("#alert").addClass('alert-success');
                    $("#alert").append('<p class="text-center"><strong>Les matchs ont étés ajoutés avec succès</strong></p>');
                    $("#alert").show();
                }                    
                else
                {
                    $('#alert').empty();
                    $("#alert").addClass('alert-danger');
                    $("#alert").append('<p class="text-center"><strong>Les matchs n\'ont pas étés ajoutés</strong></p>'); 
                    $("#alert").show();   
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                return null;
            }
        });
    });

    $("#file").on("change", function(evt) {
        var f = evt.target.files[0];
        if (f) {
            var r = new FileReader();
            r.onload = function(e) {
                table.rows.add($.csv.toObjects(e.target.result)).draw();
            }
            r.readAsText(f);
        } else {
            alert("Failed to load file");
        }
    });
});
 
function reload_table()
{
    //table.ajax.reload(null,false); //reload datatable ajax
}

function hide()
{
    $('#modal_form').modal('hide');
}

function upload()
{
    //if(confirm('Etes-vous sur d\'ajouter les matchs?'))
    //{
    $('#btnUpload').text('en cours...'); //change button text
    $('#btnUpload').attr('disabled',true); //set button disable 
    $('#alert').empty();

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

            $("#table_matchs").DataTable().destroy(); //détruire la table avant de la repeupler
            //datatables
            table = $('#table_matchs').DataTable({ 
         
                "responsive": true,
                "bFilter": false,
                "paging":   false,
                "ordering": false,
                // Load data for the table's content from an Ajax source
                data: data.matchs
            });
 
            if(!data.status['error']) //if success close modal and reload ajax table
            {
                $('#alert').addClass('alert-success');
                $('#alert').append('<p class="text-center"><strong>Félicitation !</strong> Votre fichier a bien été ajouté</p>');
                $('#alert').show();
            }
            else
            {
                $('#alert').addClass('alert-danger');
                $('#alert').append('<p class="text-center"><strong>Désolé.</strong> ' + data.status['error'] + '</p>');
                $('#alert').show();         
            }
            $('#btnUpload').text('Ajouter'); //change button text
            $('#btnUpload').attr('disabled',false); //set button enable 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#alert').addClass('alert-danger');
            $('#alert').append('<p class="text-center"><strong>Désolé.</strong>'+errorThrown+' Erreur lors du téléchargement des données</p>');
            $('#alert').show();           
            $('#btnUpload').text('Ajouter'); //change button text
            $('#btnUpload').attr('disabled',false); //set button enable 
 
        }
    });
    //}
    $("#upload-modal").modal('hide'); 
}

function tableToObj()
{
    // Loop through grabbing everything
    var myRows = [];
    var $headers = $("th");
    var $rows = $("#table_matchs tbody tr").each(function(index) {
      $cells = $(this).find("td");
      myRows[index] = {};
      $cells.each(function(cellIndex) {
      myRows[index][$($headers[cellIndex]).html()] = $(this).html();        
      });    
    });

    // Let's put this in the object like you want and convert to JSON (Note: jQuery will also do this for you on the Ajax request)
    var myObj = {};
    myObj.matchs = myRows;
    return myObj;
}



function show_modal()
{
    $('#alert').empty();
    $('#alert').removeClass('alert-danger');
    $('#alert').hide();
    $.ajax({
        url : "<?php echo site_url('Home/ajax_interclub')?>",
        type: "POST",
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {
            for (i = 0; i < data.interclub.length; i++)
            {
                $('#select-interclub').append('<option value="'+data.interclub[i].id_interclub+'">'+data.interclub[i].date+'</option>');
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });

    $("#upload-modal").modal(); 
}

</script>
 
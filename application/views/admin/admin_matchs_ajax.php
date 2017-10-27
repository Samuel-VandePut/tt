<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {
 
    $('#alert').hide(); 
    //datatables
    table = $('#table_files').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "responsive": true,
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Home/filesList')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [      
        ],
 
    });

    table = $('#table_matchs').DataTable({
        "responsive": true,
        data: ''
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
    if(confirm('Etes-vous sur d\'ajouter les matchs?'))
    {
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
                $('#alert').append('<p class="text-center"><strong>Désolé.</strong> ' + data.status['error'] + '</p>');
                $('#alert').show();           
                $('#btnUpload').text('Ajouter'); //change button text
                $('#btnUpload').attr('disabled',false); //set button enable 
     
            }
        });
    }
    
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
 
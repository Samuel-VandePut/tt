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
  
});

$(document).ready(function() {
 
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

function generate_teams()
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
 
            if(data.status) //if success close modal and reload ajax table
            {
                //Ajouter l'image
                $('#gallery').append('<div class="col-md-4"><img name="'+data.id+'" src="'+base_url+'assets/img/projets/'+data.name+'" class="img-responsive"><input onclick="delete_image('+data.id+')" type="button" name="remove_photo" value="Delete"/></div>');
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
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
 
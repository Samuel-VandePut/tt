<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {
 
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('joueur/ajax_list')?>",
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
 
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('service/ajax_add')?>";
    } else {
        url = "<?php echo site_url('service/ajax_update')?>";
    }
 
    // ajax adding data to database
 
    var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {
 
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
        }
    });
}
 
function delete_service(id)
{
    if(confirm('Are you sure delete this service?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('service/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
 
    }
}

 
function delete_image(id_img,id_service)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('service/ajax_delete_img')?>/"+id_img+"/"+id_service,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success delete image
                $("img[name="+id_img+"]").parent().remove();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
 
    }
}


function add_image()
{
    $('#btnAddImg').text('saving...'); //change button text
    $('#btnAddImg').attr('disabled',true); //set button disable 

    var formData = new FormData($('#form-select')[0]);
    $.ajax({
        url : "<?php echo site_url('service/ajax_add_img')?>/",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {
            $('#photo-preview').append('<div class="col-md-4"><img name="'+$( "#select-image" ).val()+'" src="'+base_url+'assets/img/projets/'+$( "#select-image option:selected" ).text()+'" class="img-responsive"><input name="'+$( "#select-image option:selected" ).text()+'" type="button" onclick="delete_image('+$( "#select-image" ).val()+','+$('[name="id"]').val()+')" value="Supprimer"/></div>');

            $('#btnAddImg').text('Ajouter'); //change button text
            $('#btnAddImg').attr('disabled',false); //set button enable 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnAddImg').text('Ajouter'); //change button text
            $('#btnAddImg').attr('disabled',false); //set button enable 
        }
    });
}

function hide()
{
    $('#modal_form').modal('hide');
}

</script>
 
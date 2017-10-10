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

</script>
 
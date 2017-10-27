<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {
 
    $('#alert').hide(); 
    //datatables
    table = $('#table_interclubs').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "responsive": true,
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Interclub/ajax_list')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [      
        ],
 
    });
    
});
 
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
}

function hide()
{
    $('#modal_form').modal('hide');
}

function show_modal()
{
    $('#alert').empty();
    $('#alert').removeClass('alert-danger');
    $('#alert').hide();
    $("#interclub-modal").modal(); 
}

function add_interclub()
{
    if(confirm('Etes-vous sur d\'ajouter l\'interclub?'))
    {
        var formData = new FormData($('#form-interclub')[0]);
        $.ajax({
            url : "<?php echo site_url('Interclub/ajax_add_interclub')?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data)
            {
                if(data.status)
                {
                    $("#interclub-modal").modal('toggle');
                    reload_table();
                } 

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

</script>
 
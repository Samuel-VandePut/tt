<script type="text/javascript">

var save_method; //for save method string
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {

    
    //Lors du clic sur bouton apply, ajouter les matchs dans la DB
    $('#btnClassement').on('click', function(){
        $.ajax({
            type: 'GET',
            url: "<?php echo site_url('Home/classementVirtuel')?>",
            dataType: 'json',
            success: function(data)
            {
                if($('#classement').is(':empty'))
                {
                    $('#classement').append('<p>Votre classement virtuel est => <span class="blue">'+data.classementVirtuel.classement+'</span></p>');    
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                return null;
            }
        });
    });

});


</script>
 
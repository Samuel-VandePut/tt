<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {

    $('#alert').hide();

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
    
    //Lors du clic sur bouton apply, ajouter les matchs dans la DB
    $('#apply_matchs').on('click', function(){
        var obj = tableToObj();
        //trier les matchs par nom
        obj.rows.sort(function(a,b) {return (a.Nom > b.Nom) ? 1 : ((b.Nom > a.Nom) ? -1 : 0);} );
        //Trier les matchs par joueurs
        var result = get_joueurs_matchs(obj);
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url('Match/ajax_add')?>",
            data: {json: JSON.stringify(result) },
            dataType: 'json',
            success: function(data)
            {
                if(data.status) 
                {
                    $('#alert').empty();
                    $("#alert").addClass('alert-danger');
                    $("#alert").append('<p class="text-center"><strong>'+data.status.error+'</strong></p>'); 
                    $("#alert").show();  
                }                    
                else
                { 
                    $('#alert').empty();
                    $("#alert").removeClass('alert-danger');
                    $("#alert").addClass('alert-success');
                    $("#alert").append('<p class="text-center"><strong>Les matchs ont étés ajoutés avec succès</strong></p>');
                    $("#alert").show();
                } 
                window.scrollTo(0, 0);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                return null;
            }
        });
    });

    //Lorsqu'un fichier a été sélectionné, peupler la table
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

//Renvoit un tableau de joueur contenant chacun les matchs appartenant à celui-ci
function get_joueurs_matchs(obj)
{
    var joueurs = [];
    var matchs = [];
    var temp = obj.rows[0];
    for (var i = 0; i < obj.rows.length; i++) {
        if (temp.Nom == obj.rows[i].Nom && temp.Prenom == obj.rows[i].Prenom) {
            matchs.push(obj.rows[i]);
        }
        else
        {
            if(matchs.length <= 4) joueurs.push(matchs);
            else break;
            matchs = [];
            matchs.push(obj.rows[i]);
        }

        temp = obj.rows[i];
    }
    joueurs.push(matchs);
    return joueurs;
}

function hide()
{
    $('#modal_form').modal('hide');
}

function tableToObj()
{
    var myRows = [];
    var $headers = $("th");
    var $rows = $("#table_matchs tbody tr").each(function(index) {
      $cells = $(this).find("td");
      myRows[index] = {};
      $cells.each(function(cellIndex) {
      myRows[index][$($headers[cellIndex]).html()] = $(this).html();        
      });    
    });

    var myObj = {};
    myObj.rows = myRows;
    return myObj;
}

</script>
 
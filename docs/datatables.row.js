var table = $('#example').DataTable();
 
$('#example tbody').on( 'click', 'tr', function () {
    console.log( table.row( this ).data() );
} );




var table = $('#example').DataTable();
 
$('#example tbody').on( 'click', 'tr', function () {
    var d = table.row( this ).data();
     
    d.counter++;
 
    table
        .row( this )
        .data( d )
        .draw();
} );



var table = $('#example').DataTable();
 
table.rows().every( function () {
    var d = this.data();
 
    d.counter++; // update data source for the row
 
    this.invalidate(); // invalidate the data DataTables has cached for this row
} );
 
// Draw once all updates are done
table.draw();







var pupils = [
    new Pupil(),
    new Pupil(),
    new Pupil(),
    new Pupil()
];
 
// Create table with data set
var table = $('#example').DataTable( {
    data: pupils
} );
 
var rows = table.rows( 0 ).data();
 
alert( 'Pupil name in the first row is: '+ rows[0].name() );
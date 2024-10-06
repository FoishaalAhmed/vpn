$(document).ready(function(){
    $('#data-table-simple').DataTable();

    var categoryTable = $('#table_category').DataTable({
        "order": [[ 0, 'desc' ]],
		"displayLength": 10,
        "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]]

    });

    var channelTable = $('#table_channel').DataTable({
		"order": [[ 0, 'desc' ]],
		"displayLength": 10,
        "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
    });
	
	
    var popularChannelTable = $('#table_channel_popular').DataTable({
		buttons: [
            'copy', 'excel', 'pdf'
        ],
        "order": [[ 1, 'asc' ]],
		"displayLength": 5,
        "lengthMenu": [[5, 10, -1], [5, 10, "All"]]
        
    });
    //, searching: false, paging: false, info: false
	
    var userTable = $('#table_user').DataTable({
		"order": [[ 0, 'desc' ]],
		"displayLength": 10,
        "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
    });
	
    var notificationTable = $('#table_notification').DataTable({
		"order": [[ 0, 'desc' ]],
		"displayLength": 10,
        "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
    });
	
	$('#dropdownCategory li a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
		// Get the column API object
        var column = categoryTable.column( $(this).attr('data-column') );
        // Toggle the visibility
        column.visible( ! column.visible() );
		
		$("#dropdownCategory li .active").removeClass('active');
		if(column.visible()){
			$(this).parent().removeClass('active'); 
		}else{
			$(this).parent().addClass('active'); 
		}
		e.preventDefault();
    } );
	
	$('#dropdownChannel li a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
		// Get the column API object
        var column = channelTable.column( $(this).attr('data-column') );
        // Toggle the visibility
        column.visible( ! column.visible() );
		
		$("#dropdownChannel li .active").removeClass('active');
		if(column.visible()){
			$(this).parent().removeClass('active'); 
		}else{
			$(this).parent().addClass('active'); 
		}
		e.preventDefault();
    } );
	
	$('#dropdownNotification li a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
		// Get the column API object
        var column = notificationTable.column( $(this).attr('data-column') );
        // Toggle the visibility
        column.visible( ! column.visible() );
		
		$("#dropdownNotification li .active").removeClass('active');
		if(column.visible()){
			$(this).parent().removeClass('active'); 
		}else{
			$(this).parent().addClass('active'); 
		}
		e.preventDefault();
    } );
	
	
	
	$('#dropdownUser li a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
		// Get the column API object
        var column = userTable.column( $(this).attr('data-column') );
        // Toggle the visibility
        column.visible( ! column.visible() );
		
		$("#dropdownUser li .active").removeClass('active');
		if(column.visible()){
			$(this).parent().removeClass('active'); 
		}else{
			$(this).parent().addClass('active'); 
		}
		e.preventDefault();
    } );
	
	var groupColumn = 4;

    var table = $('#table_channel_group').DataTable({
        "columnDefs": [
            { "visible": false, "targets": groupColumn }
        ],
        "order": [[ groupColumn, 'desc' ]],
        "displayLength": 10,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="blue white-text"><td colspan="6">'+group+'</td></tr>'
                    );

                    last = group;
                }
            } );
        },
		"lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
    });

    // Order by the grouping
    $('#data-table-row-grouping tbody').on( 'click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
            table.order( [ 2, 'desc' ] ).draw();
        }
        else {
            table.order( [ 2, 'asc' ] ).draw();
        }
    });


    });

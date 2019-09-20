
$('#DataTable').DataTable({
	'language': {
		'url': datatable_lang,
	},
	// 'stateSave': true,
	'autoWidth': false,
	'responsive': true,
	'processing': true,
	'serverSide': true,
	'order': [
		//[1, 'desc']
	],
	'columnDefs': [
		{'targets': 'no-sort', 'orderable': false, 'searchable': false},
		{'targets': 'th-action', 'orderable': false, 'searchable': false},
		{ 'targets': [0], 'width': '20px'},
		{ 'targets': [5], 'width': '70px'}
	],
	'lengthMenu': [
		[10, 30, 50, 100, -1],
		[10, 30, 50, 100, 'All']
	],
	'ajax': {
		'type': 'POST',
		'url': window.location.href
	},
	'drawCallback': function( settings ) {
		var api_table = this.api();
		dataTableDrawCallback();

		$('.delete_single').on('click', function(i) {
			var data_pk = [];
			data_pk = [$(this).attr('data-pk')];
			var url = window.location.href + '/delete';
			cfSwalDelete(data_pk, api_table, url);
		});

		$('.delete_multi').on('click', function() {
			var data_pk = [];
			var url = window.location.href + '/delete';
			$('.row_data:checked').each(function(i) {
				data_pk[i] = $(this).val();
			});
			if (data_pk != '' && data_pk != 'on') {
				cfSwalDelete(data_pk,api_table,url);
			}
		});
	}
});


$('#form_add').on('submit',function(event){
	event.preventDefault()
	$('.submit_add').find('i').removeClass().addClass('icon-spinner2 spinner mr-2');
	var form = $('#form_add');
	$.ajax({
		url: window.location.href + '/add-new',
		type: 'POST',
		data: form.serialize(),
		dataType: 'json',
		cache: false,
		success:function(data){
			if (data['success']==true) {
				$(location).attr('href',admin_url + a_mod);
			} else {
				cfNotif(data['alert']);
				$('.submit_add').find('i').removeClass().addClass('fa fa-check mr-2');
			}
		}
	})
});

$('#form_update').on('submit',function(event){
	event.preventDefault()
	$('.submit_update').find('i').removeClass().addClass('icon-spinner2 spinner mr-2');
	var form = $('#form_update');
	$.ajax({
		type: 'POST',
		data: form.serialize(),
		dataType: 'json',
		cache: false,
		success:function(data){
			cfNotif(data['alert']);
			$('.submit_update').find('i').removeClass().addClass('fa fa-save mr-2');
			$('html, body').animate({scrollTop:0});
		}
	})
});
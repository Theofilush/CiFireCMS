/*---------------------------------------
 * Button Go to top.
 *---------------------------------------
*/
$(document).scroll(function () {
	var _sgtp = $(this).scrollTop();
	if (_sgtp > 100) {
		$('#gotop').show();
	} else {
		$('#gotop').hide();
	}
});

// klik link to top scroll
$('#gotop').on('click', function(e) {
	e.preventDefault();
	$('html, body').animate({scrollTop:0}, '100');
	return false;
});


/*---------------------------------------
 * Post DataTable.
 *---------------------------------------
*/
$('#DataTable').DataTable({
	'language': {
		'url': _LANGTABLE,
	},
	'stateSave': true,
	'autoWidth': false,
	'responsive': true,
	'processing': true,
	'serverSide': true,
	'order': [],
	'columnDefs': [
		{'targets': 'no-sort', 'orderable': false, 'searchable': false},
		{'targets': 'th-action', 'orderable': false, 'searchable': false},
		{ 'targets': [0], 'width': '20px'},
		{ 'targets': [4], 'width': '70px'}
	],
	'lengthMenu': [
		[10, 30, 50, 100, -1],
		[10, 30, 50, 100, 'All']
	],
	'ajax': {
		'type': 'POST',
		'url': window.location.href,
	},
	'drawCallback': function( settings ) {
		var api_table = this.api();

		$('.dataTables_length select').select2({
			minimumResultsForSearch: Infinity,
			dropdownAutoWidth: true,
			width: 'auto'
		});

		$('[data-toggle="tooltip"]').tooltip();

		$('.row_data:checkbox').on('click', function(a) { 
			$(this).is('.row_data:checked') ? $(this).closest('table tbody tr').addClass('table-danger') : $(this).closest('table tbody tr').removeClass('table-danger') 
		});
		$('.select_all').on('click', function(a) {
			var a = this.checked;
			$('.row_data').each(function() {
				this.checked = a, a == this.checked && $(this).closest('table tbody tr').removeClass('table-danger'), this.checked && $(this).closest('table tbody tr').addClass('table-danger')
			})
		});

		$('.delete_single').on('click', function(i) {
			var data_pk = [];
			data_pk = [$(this).attr('data-pk')];
			cfSwalDelete(data_pk,api_table,_MEMBER_URL+_MOD+'/delete');
		});

		$('.delete_multi').on('click', function() {
			var data_pk = [];
			$('.row_data:checked').each(function(i) {
				data_pk[i] = $(this).val();
			});
			if (data_pk != '' && data_pk != 'on') {
				cfSwalDelete(data_pk,api_table,_MEMBER_URL+_MOD+'/delete');
			}
		});

		$('.headline_toggle').on('click', function() {
			$(this).find('i').removeClass().addClass('fa fa-spinner fa-pulse');
			var data_pk = $(this).attr('data-id');
			$.ajax({
				url: _MEMBER_URL + _MOD + '/headline',
				type: 'POST',
				dataType: 'json',
				data:{pk: data_pk,},
				success:function(response){
					if (response['status']==true) {
						var classRow = '.'+response['index'];
						var content = response['html'];
						$(classRow).html(content);
						cfNotif(response['alert']);
					} else {
						cfNotif(response['alert']);
					};
					$('.headline_toggle').find('i').removeClass().addClass('fa fa-star');
				}
			});
		});
	}
});


/*---------------------------------------
 * Submit Add Post.
 *---------------------------------------
*/
$('#form_post_add').on('submit',function(e){
	e.preventDefault();
	$('.btn_submit_post').find('i').removeClass().addClass('fa fa-spinner fa-pulse');
	tinyMCE.triggerSave();
	var form = $('#form_post_add');
	var formData = new FormData(this);
	$.ajax({
		url: window.location.href,
		type: 'POST',
		data: formData,
		dataType: 'json',
		contentType: false,  
        processData: false,
        cache: false,
		success:function(data){
			if (data['success']==true) {
				$(location).attr('href',_MEMBER_URL + _MOD);
			} else {
				cfNotif(data['alert']);
			}
			$('.btn_submit_post').find('i').removeClass().addClass('fa fa-check');
		}
	})
	return false;
});


/*---------------------------------------
 * Submit Update Post.
 *---------------------------------------
*/
$('#form_post_update').on('submit',function(e){
	e.preventDefault();
	$('.btn_submit_post').find('i').removeClass().addClass('fa fa-spinner fa-pulse mr-2');
	tinyMCE.triggerSave();
	var form = $('this');
	var formData = new FormData(this);
	$.ajax({
		url: window.location.href,
		type: 'POST',
		data: formData,
		dataType: 'json',
		contentType: false,  
        processData: false,
        cache: false,
		success:function(data){
			if (data['success']==true) {
				cfNotif(data['alert']);
				$('.btn_submit_post').find('i').removeClass().addClass('fa fa-save mr-2');
			} else {
				cfNotif(data['alert']);
				$('.btn_submit_post').find('i').removeClass().addClass('fa fa-save mr-2');
			}
		}
	})
	return false;
});


/*---------------------------------------
 * Submit Update Profile.
 *---------------------------------------
*/
$('#form_profile').on('submit',function(e){
	e.preventDefault();
	$('.btn_submit_profile').find('i').removeClass().addClass('fa fa-spinner fa-pulse mr-2');
	var form = $(this).serialize();
	$.ajax({
		url: _MEMBER_URL + _MOD,
		type: 'POST',
		data: form,
		dataType: 'json',
        cache: false,
		success:function(data){
			if (data['success']==true) {
				cfNotif(data['alert']);
				$('.btn_submit_profile').find('i').removeClass().addClass('fa fa-save mr-2');
			} else {
				cfNotif(data['alert']);
				$('.btn_submit_profile').find('i').removeClass().addClass('fa fa-save mr-2');
			}
		}
	})
});

$('.btn_edit_photo').on('click', function(e){
	e.preventDefault;
	$('#modal_edit_photo').modal('show');
});

$('.modal_delete').on('click', function(e){
	e.preventDefault;
	$('#modal_delete').modal('show');
});

$('.delete_account').on('click', function(e){
	e.preventDefault;
	alert('hui');
});

$('.delete_photo').on('click', function(e){
	e.preventDefault;
	$.ajax({
		type: 'POST',
		url: _MEMBER_URL + _MOD + '/delete-photo',
		dataType: 'json',
		data: '',
		cache: false,
		success:function(response) {
			if (response['status']==true) {
				window.location.href = response['url'];
			}
			else {
				alert('Photo not found');
			};
		}
	});
});


/*---------------------------------------
 * Fiter submit from keyboard.
 *---------------------------------------
*/
$('input:not(textarea)').keydown(function(event){
	var a = event.witch || event.keyCode;
	if(a == 13){
		event.preventDefault();
		return false;
	}
});

$('.select-2').select2();


/*---------------------------------------
 * Tags input.
 *---------------------------------------
*/
var tagName = new Bloodhound({
	datumTokenizer: Bloodhound.tokenizers.obj.whitespace('title'),
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	remote: {
		url: _MEMBER_URL + _MOD + '/ajax-tags',
		prepare: function (query, settings) {
			$('.tt-hint').show();
			settings.type = 'POST';
			settings.data = {
				q: query,
			};
			return settings;
		},
		filter: function (parsedResponse) {
			$('.tt-hint').hide();
			return parsedResponse;
		}
	}
});
tagName.initialize();

$('#tagsjs').tagsinput({
	typeaheadjs: {
		name: 'tagName',
		displayKey: 'title',
		valueKey: 'title',
		source: tagName.ttAdapter()
	}
});

$('.twitter-typeahead').css('display', 'inline');


/*---------------------------------------
 * DatePicker.
 *---------------------------------------
*/
$('#datepicker').datetimepicker({
	format: 'YYYY-MM-DD',
	showTodayButton: true,
	showClear: true,
	icons: {
		previous: 'fa fa-angle-left',
		next: 'fa fa-angle-right',
		today: 'fa fa-calendar-check-o',
		clear: 'fa fa-times',
	},
});


/*---------------------------------------
 * TimePicker.
 *---------------------------------------
*/
$('#timepicker').datetimepicker({
	format: 'HH:mm:ss',
	showTodayButton: true,
	showClear: true,
	icons: {
		up: 'fa fa-long-arrow-up',
		down: 'fa fa-long-arrow-down',
		today: 'fa fa-clock-o',
		clear: 'fa fa-times',
	},
});


/*---------------------------------------
 * Custom Bootsrap File Input.
 *---------------------------------------
*/
bsCustomFileInput.init();


function readImgURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#image-preview').attr('src', e.target.result);
    	}
    	reader.readAsDataURL(input.files[0]);
  }
}
$("#picture").change(function(){
    readImgURL(this);
});


/*---------------------------------------
 * tinymce.
 *---------------------------------------
*/
tinymce.init({
	selector: '#Content',
	editor_deselector: 'mceNoEditor',
	skin: 'lightgray',
	branding: false,
	content_css: _CONTENT_URL+'plugins/member/css/bootstrap.min.css,'+_CONTENT_URL+'plugins/font-awesome/css/font-awesome.min.css',
	plugins: [
		"advlist autolink link image lists charmap print preview hr anchor pagebreak",
		"searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
		"table contextmenu directionality emoticons paste textcolor",
		"code fullscreen youtube autoresize codemirror codesample"
	],
	toolbar1:'undo redo | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent table',
	toolbar2:'removeformat styleselect | fontsizeselect | link unlink image media youtube codesample code | visualblocks fullscreen',
	menubar: false,
	relative_urls: false,
	remove_script_host: true,
	resize: true,
	fontsize_formats: '8px 10px 12px 14px 18px 24px 36px',
	autoresize_min_height: 420,
    autoresize_top_margin:5,
    autoresize_bottom_margin:1,
    codemirror: {
        indentOnInit: true,
        path: _CONTENT_URL+'plugins/codemirror'
    },
	image_title: true,
	image_caption: true,
	image_advtab: true,	
});

$('.tiny-text').click(function (e) {
	e.stopPropagation();
	tinymce.EditorManager.execCommand('mceRemoveEditor', true, 'Content');
});

$('.tiny-visual').click(function (e) {
	e.stopPropagation();
	tinymce.EditorManager.execCommand('mceAddEditor', true, 'Content');
});



/* Get json lenguage */
function getLangJSON(){
	var result = $.ajax({
		dataType: 'json',
		url: _CONTENT_URL+'plugins/json/lang/'+_LANGACTIVE+'.json',
	});
	return result;
}

/* js Notif */
function cfNotif(data){
	Noty.overrideDefaults({
		theme: 'limitless',
		layout: 'topRight',
		type: 'alert',
		timeout: 4000
	});   
	new Noty({
		text: data['content'],
		type: data['type'],
		modal: true
	}).show();
}

/* Sweet Alert 2 - fitur untuk delete datatable */
function cfSwalDelete(pk,api_table,uri){
	var dataPk = pk;
	var dataUrl = uri;
	var dataTable = api_table;
	getLangJSON().done(function(lang){
		var _txtTitle = '<strong>'+lang.modal['delete_title']+'</strong>';
		var _txtContent = lang.modal['delete_content'];
		var _btnDelete = '<i class="fa fa-trash mr-2"></i>'+lang.button['delete'];
		var _btnCancel = lang.button['cancel'];
		swal.fire({
			type: 'warning',
			position: 'top',
			title: _txtTitle,
			text: _txtContent,
			showCloseButton: true,
			buttonsStyling: false,
			showCancelButton: true,
			showConfirmButton: true,
			confirmButtonClass: 'btn btn-danger',
			cancelButtonClass: 'btn btn-default',
			confirmButtonText: _btnDelete,
			cancelButtonText: _btnCancel,
			showLoaderOnConfirm: true,
			preConfirm: function() {
				return new Promise(function(resolve, reject) {
					$.ajax({
						type: 'POST',
						url: dataUrl,
						dataType: 'json',
						data: {data: dataPk},
						cache: false,
						success:function(response) {
							if (response['success']==true) {
								dataTable.row($('#DataTable tr.active')).remove().draw(false);
								resolve();
							} else {
								Swal.fire({
									position: 'top',
									type: 'error',
									title: 'Error',
									showConfirmButton: false,
									timer: 2500
								})
							};
						}
					});
				});
			},
		}).then( (result) => {
			if (result.value) {
				Swal.fire({
					position: 'top',
					type: 'success',
					title: lang.message['delete_success'],
					showConfirmButton: false,
					timer: 2500
				})
			} else { }
		})
	});
}

/* Auto close bootstrap alert */
$('.alert').delay(6000).slideUp(300, function() {
	$(this).alert('close');
});
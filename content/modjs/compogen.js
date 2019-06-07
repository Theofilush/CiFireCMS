
getLangJSON().done(function(jsonLang){
	var lang = jsonLang['compogen'];
	var errMsg = jsonLang['validation'];
	var formCompoGen = $('.steps-validation');

	/* form wizart */
	formCompoGen.steps({
		headerTag: 'h6',
		bodyTag: 'fieldset',
		titleTemplate: '<span class="number">#index#</span> #title#',
		labels: {
			previous: '<i class="icon-arrow-left13 ml-2 mr-2" /><span class="mr-2">'+ lang['button']['prev'] +'</span>',
			next:  '<span class="ml-2">'+ lang['button']['next'] + '</span><i class="icon-arrow-right14 ml-2 mr-2" />',
			finish: '<span class="ml-3 mr-3">'+ lang['button']['generate'] + '</span>'
		},
		transitionEffect: 'none',
		autoFocus: true,
		onInit: function (event, currentIndex) {
			_compGenOnInit();
		},
		onStepChanging: function (event, currentIndex, newIndex) {

			var form = $(this).show();
			// Allways allow previous action even if the current form is not valid!
			if (currentIndex > newIndex) {
				return true;
			}
			// Needed in some cases if the user went back (clean up)
			if (currentIndex < newIndex) {
				// To remove error styles
				form.find('.body:eq(' + newIndex + ') label.error').remove();
				form.find('.body:eq(' + newIndex + ') .error').removeClass('error');
			}

			form.validate().settings.ignore = ':disabled,:hidden';
			return form.valid();
		},

		onFinishing: function (event, currentIndex) {
			var form = $(this);
			form.validate().settings.ignore = ':disabled';
			return form.valid();
		},
		onFinished: function (event, currentIndex) {
			event.preventDefault();
			var form = $(this);
			var form_data = form.serialize();

			$('#loads').show();
			
			$.ajax({
				url: admin_url + a_mod +'/submit',
				type: 'POST',
				data: form_data,
				dataType: 'json',
				cache: false,
				success:function(response) {
					
					if (response['success']==true) {
						window.location.href=admin_url+a_mod+'/finish/'+response['class'];
					} else {
						$('#loads').hide();
						cfNotif(response['alert']);
					};
				}
			});
		}
	});
	
	/* validation */
	$.validator.setDefaults({
		debug: true,
	});
	formCompoGen.validate({
		ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
		errorClass: 'error',
		rules: {
			"general[component_name]": {
				required: true,
				minlength: 4,
				maxlength: 50,
			},
			"table_name": {
				required: true,
				minlength: 4,
				maxlength: 50,
			}
		}
	});
	$.validator.messages.required = errMsg['required'];
	$.validator.messages.minlength = errMsg['minlength'];
	$.validator.messages.maxlength = errMsg['maxlength'];
});

function _compGenOnInit()
{
	$('.btn-add-field').on('click',function(e){
		e.preventDefault();
		var id = $(this).attr("id");
		var newid = parseInt(id) + 1;
		var idtot = $('#totalfield').val();
		var newidtot = parseInt(idtot) + 1;
		var dataString = 'id=' + id + '&csrf_name=' + csrfToken;
		$('.btn-add-field span').html("<img src='"+site_url+"content/images/loading.gif'/>");
		$.ajax({
			type: 'POST',
			url: admin_url + a_mod + '/add-field',
			data: dataString,
			cache: false,
			success: function(data){
				$('[data-toggle="tooltip"]').tooltip();
				$('#append-add-field').append(data);
				$('.btn-add-field').attr('id', '' + newid + '');
				$('input[id^="field"]').on('input',function(){var b;b=(b=(b=$(this).val()).replace(/\s+/g,' ')).replace(/_/g,' '),$(this).val(b.toLowerCase()),$(this).val($(this).val().replace(/\W/g,' ')),$(this).val($(this).val().replace(/\s+/g,'_'))});
				$('#totalfield').val(newidtot);
				$('.btn-add-field span').html('<span><i class="fa fa-plus-circle"></i> &nbsp; Add New Field</span>');
			}
		});
		return false;
	});

	$(document).on('click','.rmfield',function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		$('#def-field-'+id).remove();
	});

	$(document).on('click','.add-more-option',function(e){
		e.preventDefault();
		var id = $(this).attr("id");
		var newid = parseInt(id) + 1;
		var idtot = $('#totaloption').val();
		var newidtot = parseInt(idtot) + 1;
		var dataString = 'id=' + id + '&csrf_name=' + csrfToken;
		$('.add-more-option span').html("<img src='"+site_url+"content/images/loading.gif'/>");
		$.ajax({
			type: 'POST',
			url: admin_url + 'compogen/add-option',
			data: dataString,
			cache: false,
			success: function(html){
				$('#append-add-options').append(html);
				$('.add-more-option').attr('id', '' + newid + '');
				$('#totaloption').val(newidtot);
				$('.add-more-option span').html('<i class="fa fa-plus-circle"></i> Add Option');
			}
		});
		return false;
	});

	$(document).on('click','.rmoption',function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		$('#def-option'+id).remove();
	});

	$(document).on('click','.btn-add-column',function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		var newid = parseInt(id) + 1;
		var idtot = $('#totalcol').val();
		var newidtot = parseInt(idtot) + 1;
		var dataString = 'id=' + id + '&csrf_name=' + csrfToken;
		$('.btn-add-column span').html("<img src='"+site_url+"content/images/loading.gif'/>");
		$.ajax({
			type: 'POST',
			url: admin_url + 'compogen/add-column',
			data: dataString,
			cache: false,
			success: function(html){
				$('#append-add-column').append(html);
				$('.btn-add-column').attr('id', '' + newid + '');
				$('#totalcol').val(newidtot);
				$('.btn-add-column span').html('<i class="fa fa-plus-circle"></i>&nbsp; Add New Column');
			}
		});
		return false;
	});

	$(document).on('click','.rmcol',function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		$('#def-column-' + id).remove();
	});

	$(document).on('click','.show-modal-terms',function(e){
		e.preventDefault();
		$('#modal-terms').modal('show');
	});

	$(document).on('input','#component_name',function(){var b;b=(b=(b=$(this).val()).replace(/\s+/g," ")).replace(/_/g," "),$('#classname').val(b.toLowerCase()),$('#classname').val($('#classname').val().replace(/\W/g," ")),$('#classname').val($('#classname').val().replace(/\s+/g,""))});
	$(document).on('input','#tablename',function(){var b;b=(b=(b=$(this).val()).replace(/\s+/g," ")).replace(/_/g," "),$(this).val(b.toLowerCase()),$(this).val($(this).val().replace(/\W/g," ")),$(this).val($(this).val().replace(/\s+/g,"_"))});
	$(document).on('input','#com_fieldname_1',function(){var b;b=(b=(b=$(this).val()).replace(/\s+/g," ")).replace(/_/g," "),$(this).val(b.toLowerCase()),$(this).val($(this).val().replace(/\W/g," ")),$(this).val($(this).val().replace(/\s+/g,"_"))});

	$(document).on('input','input[id^="field"]',function(){var b;b=(b=(b=$(this).val()).replace(/\s+/g," ")).replace(/_/g," "),$(this).val(b.toLowerCase()),$(this).val($(this).val().replace(/\W/g," ")),$(this).val($(this).val().replace(/\s+/g,"_"))});
}

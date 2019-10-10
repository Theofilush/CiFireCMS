var sFileUpload = function() {
    // Bootstrap file upload
    var _FileUpload = function() {
        if (!$().fileinput) {
            console.warn('Warning - fileinput.min.js is not loaded.');
            return;
        }

        // Modal template
        var modalTemplate = '<div class="modal-dialog modal-lg" role="document">\n' +
            '  <div class="modal-content">\n' +
            '    <div class="modal-header align-items-center">\n' +
            '      <h6 class="modal-title">{heading} <small><span class="kv-zoom-title"></span></small></h6>\n' +
            '      <div class="kv-zoom-actions btn-group">{close}</div>\n' +
            '    </div>\n' +
            '    <div class="modal-body">\n' +
            '      <div class="floating-buttons btn-group"></div>\n' +
            '      <div class="kv-zoom-body file-zoom-content"></div>\n' +
            '    </div>\n' +
            '  </div>\n' +
            '</div>\n';

        $('.file-input').fileinput({
            // browseLabel: 'Browse',
            removeIcon: '<i class="fa fa-times mr-1"></i>',
            uploadIcon: '<i class="fa fa-upload mr-1"></i>',
            browseIcon: '<i class="fa fa-folder-open mr-1"></i>',
            layoutTemplates: {
                icon: '<i class="icon-file-check"></i>',
                modal: modalTemplate
            },
            maxFilesNum: 1,
            allowedFileExtensions: ['jpg', 'jpeg', 'gif', 'png'],
            initialCaption: "No file selected",
            previewZoomButtonClasses: {
            	toggleheader: 'btn btn-light btn-icon btn-header-toggle btn-sm',
	            fullscreen: 'btn btn-light btn-icon btn-sm',
	            borderless: 'btn btn-light btn-icon btn-sm',
	            close: 'btn btn-light btn-icon btn-sm'
            },
            previewZoomButtonIcons: {
				prev: '<i class="icon-arrow-left32"></i>',
				next: '<i class="icon-arrow-right32"></i>',
				toggleheader: '<i class="icon-menu-open"></i>',
				fullscreen: '<i class="icon-screen-full"></i>',
				borderless: '<i class="icon-alignment-unalign"></i>',
				close: '<i class="icon-cross2 font-size-base"></i>'
			},
            fileActionSettings: {
				zoomClass: '',
				zoomIcon: '<i class="icon-zoomin3"></i>',
				dragClass: 'p-2',
				dragIcon: '<i class="icon-three-bars"></i>',
				removeClass: '',
				removeErrorClass: 'text-danger',
				removeIcon: '<i class="icon-bin"></i>',
				indicatorNew: '<i class="icon-file-check text-success"></i>',
				indicatorSuccess: '<i class="icon-checkmark3 file-icon-large text-success"></i>',
				indicatorError: '<i class="icon-cross2 text-danger"></i>',
				indicatorLoading: '<i class="icon-spinner2 spinner text-muted"></i>'
			}
        });
    };

    // Return objects assigned to module
    return {
        init: function() {
            _FileUpload();
        }
    }
}();

document.addEventListener('DOMContentLoaded', function() {
    sFileUpload.init();
});

$.fn.editable.defaults.mode = 'inline';

$(document).ready(function(){
	$('.select2').select2({ placeholder : '' });
});

$(document).ready(function(){
	$('#website_name').editable({
		validate: function(value) {
			if($.trim(value) == '') {
				var text = $(this).attr('data-msg');
				return text;
			}
		},
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#website_url').editable({
		validate: function(value) {
			if($.trim(value) == '') {
				var text = $(this).attr('data-msg');
				return text;
			}
		},
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#meta_description').editable({
		rows: 4,
		validate: function(value) {
			if($.trim(value) == '') {
				var text = $(this).attr('data-msg');
				return text;
			}
		},
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#meta_keyword').editable( {
		validate: function(value) {
			if($.trim(value) == '') {
				var text = $(this).attr('data-msg');
				return text;
			}
		},
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#web_email').editable({
		validate: function(value) {
			if($.trim(value) == '') {
				var text = $(this).attr('data-msg');
				return text;
			}
		},
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#tlpn').editable({
		validate: function(value) {
			if($.trim(value) == '') {
				var text = $(this).attr('data-msg');
				return text;
			}
		},
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});  

	$('#fax').editable({
		validate: function(value) {
			if($.trim(value) == '') {
				var text = $(this).attr('data-msg');
				return text;
			}
		},
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#address').editable({
		rows: 4,
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#visitors').editable({
		source: [
			{value: 'N', text: 'N'},
			{value: 'Y', text: 'Y'}
		],
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#maintenance').editable({
		source: [
			{value: 'N', text: 'N'},
			{value: 'Y', text: 'Y'}
		],
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#member_registration').editable({
		source: [
			{value: 'N', text: 'N'},
			{value: 'Y', text: 'Y'}
		],
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#cache').editable({
		source: [
			{value: 'N', text: 'N'},
			{value: 'Y', text: 'Y'}
		]
	});

	$('#cache_time').editable({
		source: [
			{value: '1', text: '1 Minutes'},
			{value: '2', text: '2 Minutes'},
			{value: '3', text: '3 Minutes'},
			{value: '4', text: '4 Minutes'},
			{value: '5', text: '5 Minutes'},
			{value: '6', text: '6 Minutes'},
			{value: '7', text: '7 Minutes'},
			{value: '8', text: '8 Minutes'},
			{value: '9', text: '9 Minutes'},
			{value: '10', text: '10 Minutes'},
		]
	});

	$('#page_item').editable({
		validate: function(value) {
			if($.trim(value) == '') {
				var text = $(this).attr('data-msg');
				return text;
			}
		},
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#captcha').editable({
		source: [
			{value: 'N', text: 'N'},
			{value: 'Y', text: 'Y'}
		],
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#recaptcha_site_key').editable({
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});
	
	$('#recaptcha_secret_key').editable({
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#imgfavicon').on('click',function(){
		$('#imgfavicon').hide();
		$('#formfavicon').show();
	});

	$('#protocol').editable({
		source: [
			{value: 'mail', text: 'mail'},
			{value: 'smtp', text: 'smtp'},
			{value: 'sendmail', text: 'sendmail'}
		],
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#hostname').editable({
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#username').editable({
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#password').editable({
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#port').editable({
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});
});

$(document).ready(function(){
	function getJsonCountry(){
		var Country = [];
		$.getJSON(content_url+"plugins/json/country.json", function(data) {
			$.each(data, function(key, val) {
				Country.push({
					id: val.name,
					text: val.name
				});
			});
		});
		return Country;
	}

	$('#country').editable({
		source: getJsonCountry(),
		select2: {
			width: 300,
			placeholder: 'Select Country',
		},
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
		 
	});
});

$(document).ready(function(){
	function getJsonTimezone(){
		var a = [];
		$.getJSON(content_url+"plugins/json/timezone.json", function(data) {
			$.each(data, function(key, val) {
				a.push({
					id: val.value,
					text: val.text
				});
			});
		});
		return a;
	}

	$('#timezone').editable({
		source: getJsonTimezone(),
		select2: {
			width: 300,
		},
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});
});

$(document).ready(function(){
	function getWeblanguage(){
		var ats = [];
		$.getJSON(admin_url+"setting/get-lang", function(data) {
			$.each(data, function(key, val) {
				ats.push({
					id: val.id,
					text: val.title
				});
			});
		});
		return ats;
	}
	$('#language').editable({
		source: getWeblanguage(),
		select2: {
			width: 300,
		}
	});
});

$(document).ready(function(){
	function getSlugUrl(){
		var SlugUrl = [];
		$.getJSON(admin_url+"setting/get_slug_url", function(data) {
			$.each(data, function(key, val) {
				SlugUrl.push({
					id: val.title,
					text: val.title
				});
			});
		});
		return SlugUrl;
	}

	$('#slug_url').editable({
		source: getSlugUrl(),
		select2: {
			width: 300,
		},
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});

	$('#slug_title').editable({
		params: function(params) {
			params.csrf_name = csrfToken;
			return params;
		}
	});
});

$(document).ready(function(){
	$('.fupload').on('input',function() {
		var f = $(this)[0].files[0];
		if (f.type == 'image/png' || f.type == 'image/jpeg') {
			$('.fav').val(f.name);
		} else {
			$(this).val('');
			$('.fav').val('');
			alert('error');
		};
	});

	$('.lupload').on('input',function() {
		var f = $(this)[0].files[0];
		if (f.type == 'image/png' || f.type == 'image/jpeg') {
			$('.logm').val(f.name);
		} else {
			$(this).val('');
			$('.logm').val('');
			alert('error');
		};
	});
});

$(document).ready(function(){
	var editor = CodeMirror.fromTextArea(document.getElementById("code_metasocial"), {
		mode: "php",
		extraKeys: {
			"Ctrl-J": "toMatchingTag",
			"F11": function(cm) {
				cm.setOption("fullScreen", !cm.getOption("fullScreen"));
			},
			"Esc": function(cm) {
				if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
			},
			"Ctrl-Space": "autocomplete"
		},
       	theme: "github",
        lineWrapping: true,
        cursorBlinkRate: 200,
        autocorrect: true,
        autofocus: true,
        lineNumbers: false,
        gutters: ["CodeMirror-linenumbers"],
        styleActiveLine: true,
        autoCloseBrackets: true,
        autoCloseTags: true
        // scrollbarStyle:"simple",
	});

	$('#submit-meta').on('click',function(){
		var contentText = $("#content").val();
		var content = editor.getValue(contentText);
		$.ajax({
			url: '',
			type: 'POST',
			data: "meta_content="+content+'&'+csrfName+'='+csrfToken,
			dataType: 'json',
			success:function(data) {
				cfNotif(data['alert']);
				$("#form-meta").fadeIn(200);
				editor.refresh();
			}
		}); 
		return false;
	}); 
});

$('.f1_edit').on('click', function(event){
	event.preventDefault();
	$('#modal_title').html('<i class="fa fa-upload mr-2"></i> Upload Favicon')
	$('#data_act').val('favicon')
	$('#modal_fedit').modal('show')
});

$('.f2_edit').on('click', function(event){
	event.preventDefault();
	$('#modal_title').html('<i class="fa fa-upload mr-2"></i> Upload Logo')
	$('#data_act').val('web_logo')
	$('#modal_fedit').modal('show')
});

$('.f3_edit').on('click', function(event){
	event.preventDefault();
	$('#modal_title').html('<i class="fa fa-upload mr-2"></i> Upload Image')
	$('#data_act').val('web_image')
	$('#modal_fedit').modal('show')
});
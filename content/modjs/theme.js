var themeFileUpload = function() {
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
            removeIcon: '<i class="fa fa-times mr-1"></i>',
            uploadIcon: '<i class="fa fa-upload mr-1"></i>',
            browseIcon: '<i class="fa fa-folder-open mr-1"></i>',
            layoutTemplates: {
                icon: '<i class="icon-file-check"></i>',
                modal: modalTemplate
            },
            maxFilesNum: 1,
            allowedFileExtensions: ['zip'],
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
    themeFileUpload.init();
});

$(".upload_theme_asets").on('click',function(e) {
    e.preventDefault();
    $('#modal_upload_theme_assets').modal('show');
}); 

$(':file').change(function() {
    var f = $(this)[0].files[0];
    if (f.type == 'application/x-zip-compressed') {
        $('.filez').val(f.name);
    } else {
        $(this).val('');
        $('.filez').val('');
        alert('error');
    };
});

$('#title').on('input', function() {
    var a;
    a = $.trim($(this).val());
    a = a.replace(/\s+/g, ' ');
    a = a.replace(/_/g, ' ');
    $('#folder').val(a.toLowerCase());
    $('#folder').val($('#folder').val().replace(/\W/g, ' '));
    $('#folder').val($.trim($('#folder').val()));
    $('#folder').val($('#folder').val().replace(/\s+/g, '-'));
});

$('#folder').on('input', function() {
    var a;
    a = $.trim($(this).val());
    a = a.replace(/\s+/g, ' ');
    a = a.replace(/_/g, ' ');
    $('#folder').val(a.toLowerCase());
    $('#folder').val($('#folder').val().replace(/\W/g, ' '));
    $('#folder').val($.trim($('#folder').val()));
    $('#folder').val($('#folder').val().replace(/\s+/g, '-'));
});

$(".modal-helper").on('click',function(e) {
    e.preventDefault();
    $('#modal-helper').modal('show');
});

$(".c_blank_theme").on('click',function(e) {
    e.preventDefault();
    $('#modal_create_blank').modal('show');
});

$('.delete_theme').on('click',function(e) {
    e.preventDefault();
    var idTeme = $(this).attr("data-id");
    var folderTheme = $(this).attr("data-folder");
    var data = {
        id:idTeme,
        folder:folderTheme
    };
    var url = admin_url + a_mod + '/delete-theme';
    themeDelete(data, url)
});

function themeDelete(data,uri){
    var dataPk = data;
    var dataUrl = uri;
    getLangJSON().done(function(lang){
        var _txtTitle = '<strong>'+lang.modal['delete_title']+'</strong>';
        var _txtContent = lang.modal['delete_content'];
        var _btnDelete = '<i class="icon-bin mr-2"></i>'+lang.button['delete'];
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
                                $('#theme-item-'+response['dataDelete']).remove()
                                resolve();                              
                            } else {
                                Swal.fire({
                                    position: 'top',
                                    type: 'error',
                                    title: 'Error',
                                    showConfirmButton: false,
                                    timer: 2500
                                })
                                setTimeout(function() {
                                    resolve();
                                }, 1000000);
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
                    timer: 2100
                })
            }
            else{}
        })
    });
}

$(".modal_active").click(function() {
    var idActive = $(this).attr("idActive");
    $('#idActive').val(idActive);
    $('#modal_active').modal('show');
});

$(".create_file").click(function(e) {
    e.preventDefault();
    $('#modal_create_file').modal('show');
});

$(".backup_theme").click(function(e) {
    e.preventDefault();
    var self = $(this); 
    var id = self.attr('data-theme-id');
    var folder = self.attr('data-theme-folder');
    var title = self.attr('data-theme-title');
    self.find('i').removeClass().addClass('icon-spinner2 spinner');
    $.ajax({
        url: window.location.href + '/backup',
        type: 'POST',
        dataType: 'JSON',
        data:{
            id: id,
            folder: folder,
            title: title,
        },
        cache: false,
        success: function(response){
            if (response['status']==true) {
                window.open(response['file'], '_blank');
            };

            self.find('i').removeClass().addClass('fa fa-download');
        }
    });
});
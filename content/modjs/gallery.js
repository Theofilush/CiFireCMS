$('.fancybox').fancybox();

$("#browse-files").fancybox({ 
	width: 880, 
	height: 570, 
	type: "iframe", 
	autoScale: false ,
}); 

$(".modal_add_album").click(function() {
	$('#modal_add_album').modal('show');
});

$(".modal_add_picture").click(function() {
	var id_album = $(this).attr("idAlbum");
	$('#id_album').val(id_album);
	$('#modal_add_picture').modal('show');
});

$('.delete_album').on('click',function(event) {
	event.preventDefault();
	var dataPk = [$(this).attr('data-id')];
	var dataUrl = admin_url + a_mod + '/delete/album';
	galleryDelete(dataPk,dataUrl)
});

$('.delete_gallery_image').on('click',function(event) {
	event.preventDefault();
	var dataPk = [$(this).attr('data-id')];
	var dataUrl = admin_url + a_mod + '/delete/image';
	galleryDelete(dataPk,dataUrl)
});

function galleryDelete(pk,uri){
	var dataPk = pk;
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
								$('#gallery-item'+response['dataDelete']).remove()
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

function responsive_filemanager_callback(field_id) {
	var url = $('#'+field_id).val();
	$('#prv').val(url);
	parent.$.fancybox.close();
	// console.log(field_id);
}
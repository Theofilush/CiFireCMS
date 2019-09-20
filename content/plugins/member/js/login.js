$('input:not(textarea)').keydown(function(event){
	var kc = event.witch || event.keyCode;
	if(kc == 13){
	event.preventDefault();
		return false;
	}
});

$('.input-email').on('input', function(e){
	e.preventDefault();
	var ref = $(this);
	var val = $(this).val();
	var maxChar = 80;

	// limit email length char
	if ( val.length >= maxChar ) {
		ref.val(function() {
			return val.substr(0, maxChar);       
		});
	}

	$.ajax({
		url: _URL + 'login/cek',
		type: 'POST',
		data: {
			'data': val
		},
		dataType: 'json',
		cache: false,
		success:function(response){
			if (response['status'] == true) {
				$('.input-password').html(response['html']);
				$("#password").focus();
			} else{
				$('.input-password').html('');
			};
			
		}
	});
});
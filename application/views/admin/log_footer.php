<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('input:not(textarea)').keydown(function(event){
		var kc = event.witch || event.keyCode;
		if(kc == 13){
			event.preventDefault();
			return false;
		}
	});

	$('.input-username').on('input', function(){
		var ref = $(this);
	    var val = $(this).val();
	    var maxChar = 20;

	    if ( val.length >= maxChar ) {
	        ref.val(function() {
	            console.log(val.substr(0, maxChar))
	            return val.substr(0, maxChar);       
	        });
	    }

		$.ajax({
			url: '<?=admin_url("login/cek-username")?>',
			type: 'POST',
			data: {
				'data': val
			},
			dataType: 'json',
			cache: false,
			success:function(response){
				if (response['status'] == '1') {
					$('.input-password').html(response['html']);
					$("#password").focus();
				} else{
					$('.input-password').html('');
				};
			}
		});
	});
</script>
</body>
</html>
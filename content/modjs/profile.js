$('#form_update').on('submit',function(e){
    e.preventDefault();
    $('.submit_update').find('i').removeClass().addClass('icon-spinner2 spinner mr-2');
    $('.noty_layout').remove();
    var formData = new FormData(this);
    var form = $('#form_update');
    $.ajax({
        url: admin_url + a_mod + '/submit-update',
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,  
        processData:false,
        cache: false,
        success:function(response){
            cfNotif(response['alert']);
            $('.submit_update').find('i').removeClass().addClass('fa fa-save mr-2');
        }
    })
    return false;
});

$('#input-datepicker').datetimepicker({
    format: 'YYYY-MM-DD',
    showTodayButton: true,
    showClear: true,
    icons: {
        previous: 'icon-arrow-left8',
        next: 'icon-arrow-right8',
        today: 'icon-calendar3',
        clear: 'icon-bin',
    },
});

$('input:not(textarea)').keydown(function(event){
    var a = event.witch || event.keyCode;
    if(a == 13){
        event.preventDefault();
        return false;
    }
});

function readImgURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#image-preview').attr('src', e.target.result);
            $(".close-preview").show();
            $(".close-preview2").show();
    }
    reader.readAsDataURL(input.files[0]);
  }
}

$("#upload-image").change(function(){
    readImgURL(this);
});
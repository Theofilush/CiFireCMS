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
        { 'targets': [3], 'width': '70px'}
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
        dataTableDrawCallback(); // standard setting

        $('.delete_single').on('click', function(i) {
            var data_pk = [];
            data_pk = [$(this).attr('data-pk')];
            $('.noty_layout').remove(); // close jsnotif
            cfSwalDelete(data_pk,api_table,admin_url+a_mod+'/delete');
        });

        $('.delete_multi').on('click', function() {
            var data_pk = [];
            $('.row_data:checked').each(function(i) {
                data_pk[i] = $(this).val();
            });
            if (data_pk != '' && data_pk != 'on') {
                $('.noty_layout').remove(); // close jsnotif
                cfSwalDelete(data_pk,api_table,admin_url+a_mod+'/delete');
            }
        });

        $('.modal_headlineon').click(function() {
            var idH = $(this).attr('Headline');
            $('#idHeadline').val(idH);
            $('#modal_headlineon').modal('show');
        });

        $('.modal_headlineoff').click(function() {
            var idOff = $(this).attr('HeadlineOff');
            $('#idOff').val(idOff);
            $('#modal_headlineoff').modal('show');
        });
    }
});

$(".modal_add").click(function() {
    $('#modal_add').modal('show');
    $('.input-tags').tagsinput();
});
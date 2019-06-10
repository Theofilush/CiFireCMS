
$(document).ready(function() {
    table = $('#DataTable').DataTable({
        'language': {
            'url': datatable_lang,
        },
        'autoWidth': false,
        'responsive': true,
        'processing': true,
        'serverSide': true,
        'order': [
            //[1, 'desc']
        ],
        'columnDefs': [
            {'targets': 'no-sort', 'width': '90px', 'orderable': false, 'searchable': false}
        ],
        'lengthMenu': [
            [10, 30, 50, 100, -1],
            [10, 30, 50, 100, 'All']
        ],
        'ajax': {
            'type': 'POST',
            'url': window.location.href
        },
        "drawCallback": function(settings) {
            var api_table = this.api();
            dataTableDrawCallback();
            
            $('.delete_single').on('click', function(i) {
                var data_pk = [];
                data_pk = [$(this).attr('data-pk')];
                var url = window.location.href + '/delete';
                cfSwalDelete(data_pk, api_table, url);
            });
        }
    });
});

$(document).ready(function() {
    $('#classname').on('input',function(){var b;b=(b=(b=$(this).val()).replace(/\s+/g,' ')).replace(/_/g,' '),$('#classname').val(b.toLowerCase()),$('#classname').val($('#classname').val().replace(/\W/g,' ')),$('#classname').val($('#classname').val().replace(/\s+/g,'_'))});
    $('#tablename').on('input',function(){var a;a=(a=(a=$(this).val()).replace(/\s+/g,' ')).replace(/_/g,' '),$('#tablename').val(a.toLowerCase()),$('#tablename').val($('#tablename').val().replace(/\W/g,' ')),$('#tablename').val($('#tablename').val().replace(/\s+/g,'_'))});
});

$('.c_structure').on('click',function() {
    $('#c_structure').modal('show');
});
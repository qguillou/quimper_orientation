import '../css/list.scss';

const $ = require('jquery');

require('datatables.net-bs4');
require('datatables.net-fixedheader-bs4');
require('datatables.net-responsive-bs4');

$(function() {
    $('.table').DataTable({
        'searching': false,
        'pageLength': 50,
        'info': false,
        'lengthChange': false,
        'language': {
            'paginate': {
              'previous': '< Précédente',
              'next': 'Suivante >'
            },
            'emptyTable': 'Aucune données disponibles'
        },
        'order': []
    });
})

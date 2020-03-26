const $ = require('jquery');

$(function() {
    $('.modal').on('show.bs.modal', function(e) {
        $(this).find('a').attr('href', $(e.relatedTarget).data('href'));
    });
})

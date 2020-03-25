import '../css/app.scss';

const $ = require('jquery');

require('bootstrap');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');


// Gestion de l'affichage du thème par defaut
if (localStorage.getItem('prefers-color-scheme') === 'dark') {
    $('.container').addClass('dark-theme');
    $('#prefers-color-scheme').prop('checked', true);
}

$(function() {
    $('#prefers-color-scheme').on('change', function() {
        if($(this).prop('checked')) {
            localStorage.setItem('prefers-color-scheme', 'dark');
            $('.container').addClass('dark-theme');
        } else {
            localStorage.setItem('prefers-color-scheme', 'default');
            $('.container').removeClass('dark-theme');
        }
    })
})

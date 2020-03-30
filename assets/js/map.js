import '../css/map.scss';

const $ = require('jquery');

require('leaflet');

$(function() {
    $('#map').each(function() {
        var lat = $(this).data('lat');
        var lon = $(this).data('lon');

        var map = L.map('map').setView([lat, lon], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
            minZoom: 1,
            maxZoom: 20
        }).addTo(map);

        L.marker([lat, lon], { icon: L.icon({iconUrl: '/images/balise.jpg'})}).addTo(map);
    });
})

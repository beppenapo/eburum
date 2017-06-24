///// parametri mappa /////
var center = ol.proj.transform([15.0549825,40.6174504], 'EPSG:4326', 'EPSG:3857');
var zoomMap = 15
////// base layer ////////
var osm = new ol.layer.Tile({
    title: 'OSM',
    type: 'base',
    visible: false,
    source: new ol.source.OSM()
});
var sat = new ol.layer.Tile({
    title: '',
    source: new ol.source.TileWMS({
        url: 'http://213.215.135.196/reflector/open/service?',
        params: {LAYERS: 'rv1', FORMAT: 'image/jpeg', TILED: true},
        attributions: [new ol.Attribution({ html: "RealVista1.0 WMS OPEN di e-GEOS SpA - CC BY SA" })]
    }),
    visible: true
});
var view = new ol.View({ center: center, zoom: zoomMap});
var map = new ol.Map({
    target: 'mappa',
    layers: [osm,sat],
    view: view,
    controls: ol.control.defaults({
                attributionOptions: ({ collapsible: false }),
                zoom: false
            })
});

/// geolocalizzazione //
var geolocation = new ol.Geolocation({ projection: view.getProjection() });
$("#geoloc").on('click', function() {
    geolocation.setTracking(true);
    var el = $(this);
    el.prop('disabled',true);
});
// update the HTML page when the position changes.
//geolocation.on('change', function() { el('info').innerText = geolocation.getAccuracy() + ' [m]'; });
// handle geolocation error.
geolocation.on('error', function(error) {
    // el('info').innerHTML = error.message;
    // el('info').style.display = '';
    console.log(error);
 });
var accuracyFeature = new ol.Feature();
geolocation.on('change:accuracyGeometry', function() {
    accuracyFeature.setGeometry(geolocation.getAccuracyGeometry());
});

var positionFeature = new ol.Feature();
positionFeature.setStyle(new ol.style.Style({
    image: new ol.style.Circle({
        radius: 6,
        fill: new ol.style.Fill({
            color: '#3399CC'
        }),
        stroke: new ol.style.Stroke({
            color: '#fff',
            width: 2
        })
    })
}));

geolocation.on('change:position', function() {
    var coordinates = geolocation.getPosition();
    positionFeature.setGeometry(coordinates ? new ol.geom.Point(coordinates) : null);
    // map.getView().setCenter(coordinates);
    // map.getView().setZoom(18);
    view.animate({
        center: coordinates,
        zoom:18,
        duration: 500
    });
});

new ol.layer.Vector({
    map: map,
    source: new ol.source.Vector({
        features: [accuracyFeature, positionFeature]
    })
});

$("#zoomin").on('click', function(){map.getView().setZoom(map.getView().getZoom()+1);});
$("#zoomout").on('click', function(){map.getView().setZoom(map.getView().getZoom()-1);});
$("#zoomHome").on('click', function(){map.getView().setCenter(center);map.getView().setZoom(zoomMap);});
$("input[name='baseLyr']").on('change', function(){
    var lyr = $("input[name='baseLyr']:checked").val();
    toggleBaseLyr(lyr);
});



function el(id) { return document.getElementById(id); }

function toggleBaseLyr(lyr){
    if(lyr=='osm'){
        sat.setVisible(false);
        osm.setVisible(true);
    }else {
        sat.setVisible(true);
        osm.setVisible(false);

    }
}

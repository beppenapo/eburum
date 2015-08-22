var map,format,extent;

function init() {
 OpenLayers.ProxyHost = "/cgi-bin/proxy.cgi?url=";
 format = 'image/png';

 map = new OpenLayers.Map('mapDiv', {
      projection: new OpenLayers.Projection("EPSG:3857"),
      displayProjection: new OpenLayers.Projection("EPSG:4326"),
      resolutions: [156543.03390625, 78271.516953125, 39135.7584765625, 19567.87923828125, 9783.939619140625, 4891.9698095703125, 2445.9849047851562, 1222.9924523925781, 611.4962261962891, 305.74811309814453, 152.87405654907226, 76.43702827453613, 38.218514137268066, 19.109257068634033, 9.554628534317017, 4.777314267158508, 2.388657133579254, 1.194328566789627, 0.5971642833948135, 0.29858214169740677, 0.14929107084870338, 0.07464553542435169, 0.037322767712175846, 0.018661383856087923, 0.009330691928043961, 0.004665345964021981, 0.0023326729820109904, 0.0011663364910054952, 5.831682455027476E-4, 2.915841227513738E-4, 1.457920613756869E-4],
      maxExtent:new OpenLayers.Bounds (-20037508.34,-20037508.34,20037508.34,20037508.34),
      units: "m",
      controls: [
       new OpenLayers.Control.Navigation(),
       new OpenLayers.Control.MousePosition(),
       new OpenLayers.Control.Attribution(),
       new OpenLayers.Control.Zoom(),
       new OpenLayers.Control.TouchNavigation({dragPanOptions: {enableKinetic: true}})
      ]
 });

 var arrayOSM = ["http://otile1.mqcdn.com/tiles/1.0.0/map/${z}/${x}/${y}.jpg",
            "http://otile2.mqcdn.com/tiles/1.0.0/map/${z}/${x}/${y}.jpg",
            "http://otile3.mqcdn.com/tiles/1.0.0/map/${z}/${x}/${y}.jpg",
            "http://otile4.mqcdn.com/tiles/1.0.0/map/${z}/${x}/${y}.jpg"];
            
 /*var osm = new OpenLayers.Layer.OSM("MapQuest-OSM Tiles", arrayOSM, {
                attribution: "Data, imagery and map information provided by <a href='http://www.mapquest.com/'  target='_blank'>MapQuest</a>, <a href='http://www.openstreetmap.org/' target='_blank'>Open Street Map</a> and contributors, <a href='http://creativecommons.org/licenses/by-sa/2.0/' target='_blank'>CC-BY-SA</a>  <img src='http://developer.mapquest.com/content/osm/mq_logo.png' border='0'>",
                transitionEffect: "resize"
 });
 map.addLayer(osm);*/
 
 var realvista = new OpenLayers.Layer.WMS("real", "http://213.215.135.196/reflector/open/service?", {
        layers: 'rv1',
        format: 'image/jpeg',
        attribution: "RealVista1.0 WMS OPEN di e-GEOS SpA - CC BY SA"
 });
 map.addLayer(realvista);
 

 
 extent = new OpenLayers.Bounds(1671751,4952887, 1680728,4958296);
 if (!map.getCenter()) {map.zoomToExtent(extent);}
}

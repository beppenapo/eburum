var map,extent,arrayOSM, osm, realvista,loadingPanel,navigate,save,del,draw,edit,divPannello,panel,newpoi;
var prj3857 = new OpenLayers.Projection("EPSG:3857");
var prj4326 = new OpenLayers.Projection("EPSG:4326");
var extDb = document.getElementsByName('ext')[0].value;
var res = [156543.03390625, 78271.516953125, 39135.7584765625, 19567.87923828125, 9783.939619140625, 4891.9698095703125, 2445.9849047851562, 1222.9924523925781, 611.4962261962891, 305.74811309814453, 152.87405654907226, 76.43702827453613, 38.218514137268066, 19.109257068634033, 9.554628534317017, 4.777314267158508, 2.388657133579254, 1.194328566789627, 0.5971642833948135, 0.29858214169740677, 0.14929107084870338, 0.07464553542435169, 0.037322767712175846, 0.018661383856087923, 0.009330691928043961, 0.004665345964021981, 0.0023326729820109904, 0.0011663364910054952, 5.831682455027476E-4, 2.915841227513738E-4, 1.457920613756869E-4];
var maxExt = new OpenLayers.Bounds (-20037508.34,-20037508.34,20037508.34,20037508.34);
var units = 'm';
var mapOpt = {projection:prj3857,displayProjection:prj4326,resolutions:res,units:units,controls:[]};
var format = 'image/png';
var osmAttr = "Data, imagery and map information provided by <a href='http://www.mapquest.com/'  target='_blank'>MapQuest</a>, <a href='http://www.openstreetmap.org/' target='_blank'>Open Street Map</a> and contributors, <a href='http://creativecommons.org/licenses/by-sa/2.0/' target='_blank'>CC-BY-SA</a> <img src='http://developer.mapquest.com/content/osm/mq_logo.png' border='0'>";

var c = 0;
var msgDel = "Geometria eliminata!\n Per rendere effettiva l'eliminazione\n utilizza il tasto 'Salva' a destra nel menù delle funzioni";
var msgUpdate = "Ok! La geometria è stata modificata";

var DeleteFeature = OpenLayers.Class(OpenLayers.Control, {
    initialize: function(layer, options) {
        OpenLayers.Control.prototype.initialize.apply(this, [options]);
        this.layer = layer;
        this.handler = new OpenLayers.Handler.Feature(this, layer, {click: this.clickFeature});
    },
    clickFeature: function(feature) {
        if(feature.fid == undefined) { this.layer.destroyFeatures([feature]);}
        else {
            feature.state = OpenLayers.State.DELETE;
            this.layer.events.triggerEvent("afterfeaturemodified",{feature: feature});
            feature.renderIntent = "select";
            this.layer.drawFeature(feature);
            $('#msg').text(msgDel);
        }
    },
    setMap: function(map) {
        this.handler.setMap(map);
        OpenLayers.Control.prototype.setMap.apply(this, arguments);
    },
    CLASS_NAME: "OpenLayers.Control.DeleteFeature"
});
var saveStrategy = new OpenLayers.Strategy.Save();
var stylePoi = new OpenLayers.StyleMap({
    "default": new OpenLayers.Style(null, {
        rules: [
            new OpenLayers.Rule({
                symbolizer: {
                    pointRadius: 8,
                    fillColor: "#427109",
                    fillOpacity: 1,
                    strokeWidth: 2,
                    strokeColor: "#72B51E"
                }
            })
        ]
    }),
    "select": new OpenLayers.Style({
        fillColor: "#0C06AF",
        strokeColor: "#00ccff",
        strokeWidth: 1
    }),
    "temporary": new OpenLayers.Style(null, {
        rules: [
            new OpenLayers.Rule({
                symbolizer: {
                    pointRadius: 8,
                    fillColor: "#0C06AF",
                    fillOpacity: 1,
                    strokeWidth: 1,
                    strokeColor: "#333333"
                }
            })
        ]
    })
});

function init() {
    OpenLayers.ProxyHost = "/cgi-bin/proxy.cgi?url=";
    map = new OpenLayers.Map('mapDiv', mapOpt);
    map.addControl(new OpenLayers.Control.Navigation());
    map.addControl(new OpenLayers.Control.MousePosition());
    map.addControl(new OpenLayers.Control.Attribution());
    map.addControl(new OpenLayers.Control.Zoom());
    map.addControl(new OpenLayers.Control.TouchNavigation({dragPanOptions: {enableKinetic: true}}));
    loadingPanel = new OpenLayers.Control.LoadingPanel();
    map.addControl(loadingPanel);
    $(".olControlLoadingPanel").load("inc/loader.php");
    loadingPanel.maximizeControl();

    realvista = new OpenLayers.Layer.WMS("real", "http://213.215.135.196/reflector/open/service?"
        , { layers: 'rv1', format: 'image/jpeg', attribution: "RealVista1.0 WMS OPEN di e-GEOS SpA - CC BY SA" }
    );
    map.addLayer(realvista);
 
    arrayOSM = ["http://otile1.mqcdn.com/tiles/1.0.0/map/${z}/${x}/${y}.jpg", "http://otile2.mqcdn.com/tiles/1.0.0/map/${z}/${x}/${y}.jpg","http://otile3.mqcdn.com/tiles/1.0.0/map/${z}/${x}/${y}.jpg", "http://otile4.mqcdn.com/tiles/1.0.0/map/${z}/${x}/${y}.jpg"];
    osm = new OpenLayers.Layer.OSM("MapQuest-OSM Tiles", arrayOSM, { attribution: osmAttr, transitionEffect: "resize"});
    map.addLayer(osm);

    newpoi = new OpenLayers.Layer.Vector("wfs", {
        styleMap: stylePoi,
        strategies: [new OpenLayers.Strategy.BBOX(), saveStrategy],
        protocol: new OpenLayers.Protocol.WFS({
            version:       "1.0.0",
            url: "http://localhost:8080/geoserver/eburum/wfs",
            featureType: "poi",
            srsName: "EPSG:3857",
            featureNS: "http://www.geoserver.org/eburum",
            geometryName: "geom",
            schema: "http://localhost:8080/geoserver/eburum/wfs?service=WFS&version=1.0.0&request=DescribeFeatureType&TypeName=eburum:poi"
        })
    });
    map.addLayer(newpoi);

// add the custom editing toolbar
    navigate = new OpenLayers.Control.DragPan({isDefault: true, title: "Naviga all'interno della mappa", displayClass: "olControlNavigation"});
    save = new OpenLayers.Control.Button({
        title: "Salva le modifiche effettuate e chiudi la sessione di lavoro",
        trigger: function() {
            if(edit.feature) {console.log(msgUpdate);}else{console.log(msgIns);}
            saveStrategy.save();
        },
        displayClass: "olControlSaveFeatures"
    });
    del = new DeleteFeature(newpoi, {title: "Elimina punto"});
    draw = new OpenLayers.Control.DrawFeature(newpoi, OpenLayers.Handler.Point,{
        title: "Inserisci punto",
        displayClass:"olControlDrawFeaturePoint",
        featureAdded: onFeatureInsert
    });
    edit = new OpenLayers.Control.ModifyFeature(newpoi, { title: "Modifica vertici geometria", displayClass: "olControlModifyFeature"});
    divPannello = document.getElementById("panel");
    panel = new OpenLayers.Control.Panel({ defaultControl: navigate, displayClass: 'olControlPanel', div: divPannello });
    panel.addControls([navigate,draw,edit,del/*,save*/]);
    map.addControl(panel);
    newpoi.events.on({"featuremodified": featureUpdate});
    $('.olControlZoom').append('<a href="#" id="max" title="torna allo zoom iniziale"><i class="fa fa-arrows-alt"></i></a>'); 
    $('.olControlZoom').append( $('#baseLayer') );
    $('.olControlZoom').append( $('#panel') );
    $('.olControlZoom').append('<span id="msg"></span>'); 
    $('.olControlZoomIn').attr("title","Ingrandisci la mappa");
    $('.olControlZoomOut').attr("title","Diminuisci la mappa");
    $("#max").click(function(){map.zoomToExtent(extent);});
    extent = new OpenLayers.Bounds(1671751,4952887, 1680728,4958296);
    if (!map.getCenter()) {map.zoomToExtent(extent);}
}
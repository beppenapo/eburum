function cercaIndirizzo(q) {
    $.getJSON('https://nominatim.openstreetmap.org/search?format=json&q=' + q, function(data) {
        if(data.length > 0){
            var trovati = [];
            $.each(data, function(key, val) {
                trovati.push("<li data-extent='"+val.boundingbox+"' data-lat='"+val.lat +"' data-lon='"+ val.lon +"'>"+ val.display_name + " ("+val.type+")</li>");
            });
            $("#resultSearchList").html(trovati.join(""));
            $("#resultSearchList > li").click(function(){
                var newExt = $(this).data('extent');
                newExt = newExt.split(',');
                var b = new OpenLayers.Bounds(newExt[2], newExt[0], newExt[3], newExt[1]);
                var p3857 = new OpenLayers.Projection("EPSG:3857");
                var p4326 = new OpenLayers.Projection("EPSG:4326");
                b.transform(p4326, p3857);
                map.zoomToExtent(b);
                $("#resultSearch").fadeOut('fast');
            });
        }else{
            $("#resultSearchList").html("<li>Nessun indirizzo trovato, riprova!</li>");
        }
        $("#resultSearch").fadeIn('fast');
        $("#hideSearch").click(function(){
            $("#resultSearch").fadeOut('fast');
            $("#resultSearchList").html('');
        });
    });
}
function close_accordion_section() {
    $('.mainMenu').removeClass('active');
    $('.subMenu').slideUp(300).removeClass('open');
}
function resizeDiv(){
    if($(".searchMain").is('.min')) { $(".searchMain").animate({height: "30%"}, 300); }else{$(".searchMain").animate({height: "77%"}, 300);}
}

function rotate(el,deg){
    var rot = deg;
    el.animate({rotation: rot},{duration: 300, step: function(now, fx) {$(this).css({"transform": "rotate("+now+"deg)"});}});
}

function onFeatureInsert(feature){
   selectedFeature = feature;
   var fid = selectedFeature.id;
   $('#fid').val(fid);
   $('#newPoi').fadeIn('fast');
} 
 
  // Passa attributi al form
function insert(fid){
    var fid = $("#fid").val();
    var nome = $("textarea[name=nomePoi]").val();
    var tipo = $("select[name=tipoPoi]").val();
    var sc = $("select[name=scPoi]").val();
    var acc = $("select[name=accPoi]").val();
    var dis = $("input[name=disPoi]").is(':checked') ? 1 : 0;
    var desc = $("textarea[name=descPoi]").val();
    if(!nome){$("textarea[name=nomePoi]").addClass('error'); c++; }else{$("textarea[name=nomePoi]").removeClass('error');}
    if(!tipo){$("select[name=tipoPoi]").addClass('error'); c++; }else{$("select[name=tipoPoi]").removeClass('error');}
    if(!sc){$("select[name=scPoi]").addClass('error'); c++; }else{$("select[name=scPoi]").removeClass('error');}
    if(!acc){$("select[name=accPoi]").addClass('error'); c++; }else{$("select[name=accPoi]").removeClass('error');}
    if(!desc){$("textarea[name=descPoi]").addClass('error'); c++; }else{$("textarea[name=descPoi]").removeClass('error');}
    
    if(c>0){$("#errori").text("I campi in rosso sono obbligatori").fadeIn('fast'); }
    else{
        $("#errori").fadeOut("fast");
        var f = newpoi.getFeatureById(fid);
        f.attributes.nome = nome;
        f.attributes.tipo = tipo;
        f.attributes.sc = sc;
        f.attributes.acc = acc;
        f.attributes.dis = dis;
        f.attributes.descrizione = desc;
        saveStrategy.save();
        $('#errori').text('geometria salvata').fadeIn('fast');
    }
 }

function featureUpdate(e){
   $("#fid").val(e.feature.id);
   $("textarea[name=nomePoi]").val(e.feature.attributes.nome);
   $("select[name=tipoPoi]").val(e.feature.attributes.tipo);
   $("select[name=scPoi]").val(e.feature.attributes.sc);
   $("select[name=accPoi]").val(e.feature.attributes.acc);
   if(e.feature.attributes.dis==1){$("input[name=disPoi]").attr('checked',true);}
   $("textarea[name=descPoi]").val(e.feature.attributes.descrizione);
   $("#newPoi").fadeIn('fast');
}
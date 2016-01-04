$(document).ready(function() {
    var sessione = $("#sessione").val();
    console.log(sessione);
    $('#closeSearch a').click(function(){
        $('#search').removeClass('aperto');
        $('#search, #map').animate({right:'-=20%'});
    });
    $('.openSearch').click(function(){
        $('#search').toggleClass('aperto');
        if($('#search').hasClass('aperto')){
            $('#search, #map').animate({right:'+=20%'});
        }else{
            $('#search, #map').animate({right:'-=20%'});
        }
    });

    $('#closeScheda a').click(function(){
        $('#scheda').removeClass('aperto');
        $('#scheda, #map').animate({left:'-=20%'});
    });
    $('.openScheda').click(function(){
        $('#scheda').toggleClass('aperto');
        if($('#scheda').hasClass('aperto')){
            $('#scheda, #map').animate({left:'+=20%'});
        }else{
            $('#scheda, #map').animate({left:'-=20%'});
        }
    });

    $('#login').hide();
    $('.openLogin').click(function(){$('#login').fadeIn("fast");});
    $('#closeLogin a').click(function(){$('#login').fadeOut("fast");});

    $("#baseLayer label").click(function(){$("#baseLayer label").removeClass('checked'); $(this).addClass('checked'); });
    
    var c = 0;
    $("button[name=annulla]").click(function(){ 
        $('#newPoi').fadeOut('fast'); 
        newpoi.refresh({force:true});
        c=0;
        $(".newPoi").removeClass('error');
        $("#errori").fadeOut("fast");
        $("#fid").val('');
        $("textarea[name=nomePoi]").val('');
        $("select[name=tipoPoi]").val('');
        $("select[name=scPoi]").val('');
        $("select[name=accPoi]").val('');
        $("input[name=disPoi]").attr('checked',false);
        $("textarea[name=descPoi]").val('');
    });
    $("button[name=salva]").click(function(){
        var fid = $("#fid").val();
        var nome = $("textarea[name=nomePoi]").val();
        var tipo = $("select[name=tipoPoi]").val();
        var sc = $("select[name=scPoi]").val();
        var acc = $("select[name=accPoi]").val();
        var dis = $("input[name=disPoi]").is(':checked');
        var desc = $("textarea[name=descPoi]").val();
        if(!nome){$("textarea[name=nomePoi]").addClass('error'); c++; }else{$("textarea[name=nomePoi]").removeClass('error');}
        if(!tipo){$("select[name=tipoPoi]").addClass('error'); c++; }else{$("select[name=tipoPoi]").removeClass('error');}
        if(!sc){$("select[name=scPoi]").addClass('error'); c++; }else{$("select[name=scPoi]").removeClass('error');}
        if(!acc){$("select[name=accPoi]").addClass('error'); c++; }else{$("select[name=accPoi]").removeClass('error');}
        if(!desc){$("textarea[name=descPoi]").addClass('error'); c++; }else{$("textarea[name=descPoi]").removeClass('error');}
        if(c>0){$("#errori").text("I campi in rosso sono obbligatori").fadeIn('fast'); }
        else{$("#errori").fadeOut("fast");}
    });
 /********* GEOCODE NOMINATIM   ********/
    $("#resultSearch").hide();
    $("#geoSearch").click(function(){var q = $("#query").val(); cercaIndirizzo(q);}); 
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
});

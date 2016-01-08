$(document).ready(function() {
    var sessione = $("#sessione").val();
    $('textarea[name=descPoi]').ckeditor();
    
    $('#closeScheda').click(function(){
        var elem = "#closeScheda";
        var arrow = $(elem+' i');
        var toggle = $('#scheda');
        toggle.toggleClass('aperto');
        if(toggle.hasClass('aperto')){
            toggle.animate({left:'+=20%'});
            $(elem).animate({width:"100%"},300).attr("title","Nascondi pannello");
            rotate(arrow,360);
        }else{
            toggle.animate({left:'-=20%'});
            $(elem).animate({width:"110%"},300).attr("title","Mostra pannello");
            rotate(arrow,180);
        }
    });

    $('#closeSearch').click(function(){
        var elem = "#closeSearch";
        var arrow = $(elem+' i');
        var toggle = $('#search');
        toggle.toggleClass('aperto');
        if(toggle.hasClass('aperto')){
            toggle.animate({right:'+=20%'}, 300);
            $(elem).animate({right:'-=10%'},300).attr("title","Nascondi pannello");
            rotate(arrow,360);
        }else{
            toggle.animate({right:'-=20%'},300);
            $(elem).animate({right:'+=10%'},300).attr("title","Mostra pannello");
            rotate(arrow,180);
        }
    });
    $('.lastPoi').click(function(){
        var id = $(this).data('id');
        var ll = $(this).data('ll').split(',');
        $.ajax({
            url: 'inc/poiSearch.php',
            type: 'POST', 
            data: {id:id}, 
            dataType: "json",
            success: function(data){
                $('#search header h1').text(data['nome']);
                $('.searchMain article #tipo').text(data['tipo']);
                $('.searchMain article #stato span').text(data['sc']);
                $('.searchMain article #acc').text(data['acc']);
                $('.searchMain article #dis').text(data['dis']);
                $('.searchMain article #descrizione').html(data['descrizione']);
            }
        });
        if(!$('#search').hasClass('aperto')){
            $('#search').addClass('aperto');
            $('#search').animate({right:'+=20%'});
        }
        var lonlat = new OpenLayers.LonLat(ll[0],ll[1]);
        map.setCenter(lonlat, 19);
    });
    
    $('#login').hide();
    $('.openLogin').click(function(){$('#login').fadeIn("fast");});
    $('#closeLogin a').click(function(){$('#login').fadeOut("fast");});

    $("#baseLayer label").click(function(){$("#baseLayer label").removeClass('checked'); $(this).addClass('checked'); });

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
    $("button[name=salva]").click(insert);
 /********* GEOCODE NOMINATIM   ********/
    $("#resultSearch").hide();
    $("#geoSearch").click(function(){var q = $("#query").val(); cercaIndirizzo(q);}); 

    $('.mainMenu').click(function() {
        var currentAttrValue = $(this).data('sub');
        if($(this).is('.active')) {
            close_accordion_section();
        }else {
            close_accordion_section();
            $(this).addClass('active');
            $('#'+currentAttrValue).slideDown(300).addClass('open'); 
        }
    });
    
    $('.commentToggle').click(function(){
        //$(".searchMain").animate({height: "50%"}, 300);
        $(".searchMain").toggleClass('min');
        $("#commentWrap").slideToggle(300);
        resizeDiv();
    });
});

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
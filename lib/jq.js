$(document).ready(function() {
    var sessione = $("#sessione").val();
    $('textarea[name=descPoi]').ckeditor();
    
    $('#closeScheda').click(function(){
        var elem = "#closeScheda";
        var arrow = $(elem+' i');
        var toggle = $('#scheda');
        var switcher = $('#switcher');
        toggle.toggleClass('aperto');
        if(toggle.hasClass('aperto')){
            toggle.animate({left:'+=20%'});
            switcher.animate({left:'+=20%'});
            $(elem).animate({width:"100%"},300).attr("title","Nascondi pannello");
            rotate(arrow,360);
        }else{
            toggle.animate({left:'-=20%'});
            switcher.animate({left:'-=20%'});
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
    
    $("#switcher ul li").on("click", function(){
        $(this).toggleClass('activeLayer');
    });
});
$(document).ready(function() {
 $('#closeSearch a').click(function(){
  $('#search').removeClass('aperto');
  $('#search, #map').animate({right:'-=16%'});
 });
 $('.openSearch').click(function(){
  $('#search').toggleClass('aperto');
  if($('#search').hasClass('aperto')){
   $('#search, #map').animate({right:'+=16%'});
  }else{
   $('#search, #map').animate({right:'-=16%'});
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

 $('#newUsr').hide();
 $('.toggle').click(function(){$('.toggled').slideToggle('fast');});

 $('input[name="signin"]').click(function(){
  var username = $('#username').val();
  var email = $('#email').val();
  var checkPwd = $('#checkPwd').val();
  var pwd = $('#pwd');
  var privacy = $("input[name='formUsrRadio']:checked").val();
  var link = $('#link').val();
  var descrUsr = $('#descrUsr').val();
  console.log(username+' '+email+' '+pwd);
  if(!username){
   $('#username').addClass('error');
   //$('.errorDiv').text('Inserisci uno username, il tuo nome vero o il nome dell\'azienda');
   return false;
  }else{
   $('#username').removeClass('error');
   //$('.errorDiv').text('');
  }
  if(!email){
   $('#email').addClass('error');
   //$('.errorDiv').text('Inserisci un indirizzo email valido');
   return false;
  }else{
   $('#email').removeClass('error');
   //$('.errorDiv').text('');
  }
  if(!pwd){
   $('#pwd').addClass('error');
   //$('.errorDiv').text('Devi digitare una password!');
   return false;
  }else{
   $('#pwd').removeClass('error');
   //$('.errorDiv').text('');
  }
  if(pwd && !checkPwd){
   $('#checkPwd').addClass('error');
   //$('.errorDiv').text('Devi ridigitare la password appena inserita!');
   return false;
  }else{
   $('#checkPwd').removeClass('error');
   //$('.errorDiv').text('');
  }
 });
 
 /********* GEOCODE NOMINATIM   ********/
$("#resultSearch").hide();
$("#geoSearch").click(function(){
 var q = $("#query").val();
 cercaIndirizzo(q);
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
    });
  }else{
   $("#resultSearchList").html("<li>Nessun indirizzo trovato!</li>");
   
  }
  $("#resultSearch").fadeIn('fast');
  $("#hideSearch").click(function(){
   $("#resultSearch").fadeOut('fast');
   $("#resultSearchList").html('');
  });
 });
}
/******************************************************/
 
 
 
});

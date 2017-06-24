var vp = viewportSize();
if(vp.w >= 1200){
    $("#toolMap .tt").data("placement","left");
    $("body>header .tt").data("placement","bottom");
    $('.tt').tooltip({
        container:'body'
        ,trigger:'hover'
    });
}

$("#loginBtn").on('click', function(){ $('#login_modal').modal(); });
$("#newUsrSubmit").on('click',function(){
    var isvalidate = $("form[name='newForm']")[0].checkValidity();
    if (isvalidate) {
        event.preventDefault();
        var email = $('input[name="newEmail"]').val();
        email=email.trim();
        $.ajax({
            type: "POST",
            url: "connector/newUsr.php",
            data: {email:email},
            success: function(data){
                $("#msgCrea").html(data);
            }
        });
    }
});


function viewportSize(){
    var viewportSize = new Object();
    var mq = window.getComputedStyle(document.querySelector('body'), ':before').getPropertyValue('content');
    var w = window.innerWidth;
    var h = window.innerHeight;
    viewportSize.mq = mq;
    viewportSize.w = w;
    viewportSize.h = h;
    return viewportSize;
}

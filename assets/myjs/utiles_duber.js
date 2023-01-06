function mostrar_alerta1(nombre_div,tipo,mensaje){
     $("#"+nombre_div).append('<div id="notify_'+nombre_div+'" class="alert alert-warning" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message_'+nombre_div+'"></div></div>');        
    $("#notify_"+nombre_div+" .message_"+nombre_div).html(mensaje);
    var tipo123="success";
    if(tipo==1){
          tipo123="success";
     }else if(tipo==2){
          tipo123="warning";
     }else if(tipo==3){
          tipo123="danger";
     } 
    $("#notify_"+nombre_div).removeClass("alert-success").removeClass("alert-warning").removeClass("alert-danger").addClass("alert-"+tipo123).fadeIn();
    $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
}
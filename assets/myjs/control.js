function selectCustomer(cid, cname, cadd1, cadd2, ph, email) {


    $('#customer_id').val(cid);
    $('#customer_name').html('<strong>'+cname+' '+cadd1+'</strong>');
    $('#customer_name').val(cname);
    $('#customer_address1').html('Abonado: <strong>'+cadd2+'</strong>');
    $('#customer_phone').html('Documento: <strong>'+ph+'</strong><br>Celular: <strong>'+email+'</strong>');
    $("#customer-box").val();

   /* $.post(baseurl+"transactions/facturas_customer",{'id_customer':cid},function(data){
        var options="<option value=''>--Sin Seleccionar Factura--</option>";
        console.log(data);
            $(data).each(function(ind,val){

                options+=val;
            });
            $("#id_facturas_asociadas").html(options);
    },'json');*/
    $("#customer").show();

    $("#customer-box-result").hide();
    $("#customer").show();
}
function selectEquipo(cid, cname, cadd1, cadd2, ph, email) {


    $('#customer_id').val(cid);
    $('#customer_name').html('<strong>'+cname+'</strong>');
    $('#customer_name').val(cname);
    $('#customer_address1').html('<strong>'+cadd1+'<br>'+cadd2+'</strong>');
    $('#customer_phone').html('Phone: <strong>'+ph+'</strong><br>Email: <strong>'+email+'</strong>');
    $("#customer-box").val();

    $("#equipo-box-result").hide();

}

function selectSupplier(cid, cname, cadd1, cadd2, ph, email) {


    $('#customer_id').val(cid);
    $('#customer_name').html('<strong>'+cname+'</strong>');
    $('#customer_name').val(cname);
    $('#customer_address1').html('<strong>'+cadd1+'<br>'+cadd2+'</strong>');
    $('#customer_phone').html('Phone: <strong>'+ph+'</strong><br>Email: <strong>'+email+'</strong>');
    $("#customer-box").val();

    $("#supplier-box-result").hide();
    $("#customer").show();
}




function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 46 || charCode > 57)) {
        return false;
    }
    return true;
}

$(document).ready(function () {


    $("#customer-box").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/csearch',
            data: 'keyword=' + $(this).val(),
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#customer-box-result").show();
                $("#customer-box-result").html(data);
                $("#customer-box").css("background", "none");

            }
        });
    });
	
	$("#equipo-box").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/bus_equipo',
            data: 'keyword=' + $(this).val(),
            beforeSend: function () {
                $("#equipo-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#equipo-box-result").show();
                $("#equipo-box-result").html(data);
                $("#equipo-box").css("background", "none");

            }
        });
    });
	
   

    $("#supplier-box").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/supplier',
            data: 'keyword=' + $(this).val(),
            beforeSend: function () {
                $("#supplier-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#supplier-box-result").show();
                $("#supplier-box-result").html(data);
                $("#supplier-box").css("background", "none");

            }
        });
    });

    $("#invoice-box").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search/invoice',
            data: 'keyword=' + $(this).val(),
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#invoice-box-result").show();
                $("#invoice-box-result").html(data);
                $("#invoice-box").css("background", "none");

            }
        });
    });

    $("#head-customerbox").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search/customer',
            data: 'keyword=' + $(this).val(),
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#head-customerbox-result").show();
                $("#head-customerbox-result").html(data);
                //$("#invoice-box").css("background", "none");

            }
        });
    });
	



});
//make payment 


//part
$(document).on('click', "#submitpayment", function (e) {
    e.preventDefault();
   var pyurl=baseurl + 'transactions/payinvoice';

        payInvoice(pyurl);


});
$(document).on('click', "#purchasepayment", function (e) {
    e.preventDefault();

    var pyurl=baseurl + 'transactions/paypurchase';

    payInvoice(pyurl);


});
$(document).on('click', "#recpayment", function (e) {
    e.preventDefault();

    var pyurl=baseurl + 'transactions/pay_recinvoice';

    payInvoice(pyurl);


});
function payInvoice(pyurl) {
    
    var errorNum = farmCheck();
    $("#part_payment").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to enter partial amount!");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({

            url: pyurl,
            type: 'POST',
            data: $('form.payment').serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                    $('#activity').append(data.activity);
                    $('#rmpay').val(data.amt);
                    $('#paymade').text(data.ttlpaid);
                    $('#paydue').text(data.amt);
                    var urlx=baseurl+'transactions/payinvoice';
                    var urly=baseurl+'transactions/payinvoicemultiple';
                    if(pyurl==urlx){
                        window.open(baseurl+"invoices/printinvoice?id="+data.tid, '_blank');
                        location.reload();
                    }else if(pyurl==urly){
                        var pa=data.pa;
                        if(pa=="si"){
                            pa="&pa=si";
                        }else{
                            pa="";
                        }
                        window.open(baseurl+"invoices/printinvoice?multiple=si&id="+data.id_fact_pagadas+'&vrm='+data.valor_restante_monto+pa,"_blank");
                        window.location.replace(baseurl+"customers/invoices?id="+id_customer+"&fac_pag="+data.id_fact_pagadas);
                        //window.location.replace(baseurl+"invoices/printinvoice?id="+data.id_fact_pagadas);
                    }else{
                        location.reload();
                    }
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);

                }

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }

}

//////////////send

function loadEmailTem (action) {

    jQuery.ajax({

        url: baseurl + 'emailinvoice/template',
        type: 'POST',
        data: action,
        dataType: 'json',
        beforeSend: function() {
            setTimeout(

                console.log('loading')
                , 5000);
        },
        success: function (data) {
            $('#request').hide();
            $('#emailbody').show();
            $('#subject').val(data.subject);
            $('.note-editable').html(data.message);




        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
            $("html, body").scrollTop($("body").offset().top);
        }
    });

}
$('.sendbill').click( function (e) {
    e.preventDefault();
    $('#emailtype').val($(this).attr('data-type'));
	$('#itype').val($(this).attr('data-itype'));

});
$('.sendsms').click( function (e) {
    e.preventDefault();
    $('#smstype').val($(this).attr('data-type'));

});
$("#sendEmail").on("show.bs.modal", function(e) {
    var action= 'ttype='+$('#emailtype').val()+'&invoiceid='+$('#invoiceid').val()+'&itype='+$('#itype').val();
       loadEmailTem(action);
});

$("#sendSMS").on("show.bs.modal", function(e) {
    var action= 'ttype='+$('#smstype').val()+'&invoiceid='+$('#invoiceid').val();
       loadSmsTem(action);
});

function loadSmsTem (action) {

    jQuery.ajax({

        url: baseurl + 'sms/template',
        type: 'POST',
        data: action,
        dataType: 'json',
        beforeSend: function() {
            setTimeout(

                console.log('loading')
                , 5000);
        },
        success: function (data) {
            $('#request_sms').hide();
            $('#smsbody').show();
            $('#sms_tem').html(data.message);
        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
            $("html, body").scrollTop($("body").offset().top);
        }
    });

}

  $('#submitSMS').on('click', function (e) {
            e.preventDefault();
			  $("#sendSMS").modal('hide');

			var action= 'mobile='+$('#smstype').val()+'&message='+$('#invoiceid').val();

            sendSms(action);

        });
		function sendSms(message) {

    var errorNum = farmCheck();
    $("#sendEmail").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to enter mobile number!");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({

            url: baseurl + 'sms/send_sms',
            type: 'POST',
            data: $('#sendsms').serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }

}
//mail
function sendBill(message) {

    var errorNum = farmCheck();
    $("#sendEmail").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to enter email!");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({

            url: baseurl + 'communication/send_invoice',
            type: 'POST',
            data: $('#sendbill').serialize()+'&message='+encodeURIComponent(message),
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }

}
////////////////////////////////////////////////////////////

//////////////cancel


$(document).on('click', "#cancel-bill", function (e) {
    e.preventDefault();

    $('#cancel_bill').modal({backdrop: 'static', keyboard: false}).one('click', '#send', function () {
        var acturl='transactions/cancelinvoice';
        cancelBill(acturl);


    });
});





function cancelBill(acturl) {
    var $btn;
    var errorNum = farmCheck();
    $("#cancel_bill").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({

            url: baseurl + acturl,
            type: 'POST',
            data: $('form.cancelbill').serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
                setTimeout(function () {// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 2000);

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }

}


/////// product add edit actions

//calcualtions


$("#calculate_income").click(function (e) {
    e.preventDefault();
    var actionurl= baseurl + 'reports/customincome';
    actionCaculate(actionurl);
});
$("#calculate_expense").click(function (e) {
    e.preventDefault();
    var actionurl= baseurl + 'reports/customexpense';
    actionCaculate(actionurl);
});
function actionCaculate(actionurl) {

    var errorNum = farmCheck();
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
    } else {

        $(".required").parent().removeClass("has-error");


        $.ajax({

            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize(),
            dataType: 'json',
            success: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();


                $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
              //  $("#product_action").remove();
                $("#param1").html(data.param1);
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);

            }

        });
    }

}




$("#mclient_add").click(function (e) {
    e.preventDefault();
    var actionurl = baseurl + 'invoices/addcustomer';
    searchCS(actionurl);
});
$("#msupplier_add").click(function (e) {
    e.preventDefault();
    var actionurl = baseurl + 'supplier/addsupplier';
    searchCS(actionurl);
});
function searchCS(actionurl) {


    var errorNum = farmCheck2();
    if (errorNum > 0) {
        $("#statusMsg").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#statusMsg").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").animate({scrollTop: $('#statusMsg').offset().top}, 1000);
    } else {

        $(".crequired").parent().removeClass("has-error");


        $.ajax({

            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize(),
            dataType: 'json',
            success: function (data) {
                $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#statusMsg").removeClass("alert-warning").addClass("alert-success").fadeIn();


                $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);



                $('#customer_id').val(data.cid);
                $('#customer_name').html('<strong>'+$('#mcustomer_name').val()+'</strong>');
                $('#customer_address1').html('<strong>'+$('#mcustomer_address1').val()+'<br>'+$('#mcustomer_city').val()+','+$('#mcustomer_country').val()+'</strong>');
                $('#customer_phone').html('Phone: <strong>'+$('#mcustomer_phone').val()+'</strong><br>Email: <strong>'+$('#mcustomer_email').val()+'</strong>');
				 $('#customer_pass').html('Login Password '+data.pass);
                $("#customer-box").val();

                $("#customer-box-result").hide();
                $("#customer").show();



                $('#addCustomer').find('input:text,input:hidden').val('');
                $("#addCustomer").modal('toggle');

            },
            error: function (data) {
                $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#statusMsg").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#statusMsg').offset().top}, 1000);

            }

        });
    }


}


//task manager

$('.checkbox').click(function (e) {


    var actionurl=  'tools/set_task';
    var id =$(this)[0].value;var stat='';


   if($(this)[0].checked){stat='Done';}else {stat='Due';}

    $.ajax({

        url: baseurl+actionurl,
        type: 'POST',
        data: {'tid':id,'stat':stat},
        dataType: 'json',
        success: function (data) {

        }

    });

});

$(document).on('click', ".check", function (e) {
    e.preventDefault();

    var actionurl=  'tools/set_task';var rval='Due';
    var id =$(this).attr('data-id');var stat=$(this).attr('data-stat');


    if(stat=='Done'){$(this).attr('data-stat','Due');
        $(this).toggleClass('text-success text-default');} else {$(this).toggleClass('text-default text-success');$(this).attr('data-stat','Done'); rval='Done';}

    $.ajax({

        url: baseurl+actionurl,
        type: 'POST',
        data: {'tid':id,'stat':rval},
        dataType: 'json',
        success: function (data) {

        }

    });

});



//universal list item delete from table

$(document).on('click', ".delete-object", function (e) {
    e.preventDefault();
    $('#object-id').val($(this).attr('data-object-id'));
    $(this).closest('tr').attr('id',$(this).attr('data-object-id'));
    $('#delete_model').modal({backdrop: 'static', keyboard: false});

});

$("#delete-confirm").on("click", function() {
    var o_data = 'deleteid=' + $('#object-id').val();
    var action_url= $('#action-url').val();
    $('#'+$('#object-id').val()).remove();
    removeObject(o_data,action_url);
});

$(document).on('click', ".asigna-object", function (e) {
    e.preventDefault();
    $('#object-id').val($(this).attr('data-object-id'));
    $(this).closest('tr').attr('id',$(this).attr('data-object-id'));
    $('#asigna_model').modal({backdrop: 'static', keyboard: false});

});
$("#asignar-confirm").on("click", function() {
    var o_data = 'deleteid=' + $('#object-id2').val()+"&"+'tecnico=' + $('#tec').val();
    //var o_datados = 'tecnico=' + $('#tec').val();
    var action_url= $('#action-urldos').val();
    $('#'+$('#object-id2').val()).remove();
    removeObject(o_data,action_url);
});

function removeObject(action,action_url) {

    jQuery.ajax({

        url: baseurl + action_url,
        type: 'POST',
        data: action,
        dataType: 'json',
        success: function (data) {
            if (data.status == "Success") {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            } else {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);

            }

        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
            $("html, body").scrollTop($("body").offset().top);

        }
    });

}

//universal create
$("#submit-data").on("click", function(e) {
    e.preventDefault();
    var o_data =  $("#data_form").serialize();
    var action_url= $('#action-url').val();
    addObject(o_data,action_url);
});
$("#submit-data_eq").on("click", function(e) {
    e.preventDefault();
    var o_data =  $("#data_form").serializeArray();
     var form_data = new FormData();
     var file_date=$("#equipofile").prop("files")[0];
     form_data.append("equipofile",file_date);
      //var indexed_array = {};

    $.map(o_data, function(n, i){console.log(n['name']);
        form_data.append(n['name'], n['value']);
    });

     
    var action_url= $('#action-url').val();
    addObject_eq(form_data,action_url);
});
$("#submit-data2").on("click", function(e) {
    e.preventDefault();
    var o_data =  $("#data_form2").serialize();
    var action_url= $('#action-url2').val();
    addObject(o_data,action_url);
});
function addObject(action,action_url) {


    var errorNum = farmCheck();
    var $btn;
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").scrollTop($("body").offset().top);
    } else {

        jQuery.ajax({

            url: baseurl + action_url,
            type: 'POST',
            data: action,
            dataType: 'json',
            success: function (data) {
				
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $("#data_form").remove();

                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);

                }

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").scrollTop($("body").offset().top);

            }
        });
    }

}
function addObject_eq(action,action_url) {


    var errorNum = farmCheck();
    var $btn;
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").scrollTop($("body").offset().top);
    } else {

        $.ajax({

            url: baseurl + action_url,
            cache: false,
            contentType: false,
            data: action,
            dataType: 'JSON',
            enctype: 'multipart/form-data',
            processData: false,
            method: "POST",
            success: function (data) {
                
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $("#data_form").remove();

                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);

                }

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").scrollTop($("body").offset().top);

            }
        });
    }

}
//
function actionProduct(actionurl) {

    var errorNum = farmCheck();
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
    } else {

        $(".required").parent().removeClass("has-error");


        $.ajax({

            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize(),
            dataType: 'json',
            success: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();


                $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
                //   $("#product_action").remove();
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);

            }

        });
    }

}

//uni sender

$('#sendMail').on('click', '#sendNow', function (e) {
    e.preventDefault();
    var o_data =  $("#sendmail_form").serialize();
    var action_url= $('#sendMail #action-url').val();


    sendMail_g(o_data,action_url);

});

$(document).on('click', "#upda", function (e) {
    e.preventDefault();
var errorNum = farmCheck();
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to details!");
        $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
    } else {

		$("#notify .message").html("<strong>Success</strong>: Thank You! License updated, please refresh the page.");
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
	}


});

function cargar_informacion_lote(dataStatus,dataMensaje){
    $("#notify_"+n_lote_actual_customers+" .message_"+n_lote_actual_customers).html("<strong>" + dataStatus + " Lote "+n_lote_actual_customers+" de "+n_lotes_customers+"</strong>: " + dataMensaje);
    if(dataStatus=="Success-sms"){
        $("#notify_"+n_lote_actual_customers).removeClass("alert-danger").removeClass("alert-warning").addClass("alert-success").fadeIn();
    }else{
        $("#notify_"+n_lote_actual_customers).removeClass("alert-success").removeClass("alert-warning").addClass("alert-danger").fadeIn();
    }
    $("html, body").animate({scrollTop: $("#notify_"+n_lote_actual_customers).offset().top}, 1000);

    if(n_lote_actual_customers<n_lotes_customers){
        n_lote_actual_customers++;
        $("#div_notify4").append('<div id="notify_'+n_lote_actual_customers+'" class="alert alert-warning" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message_'+n_lote_actual_customers+'"></div></div>');        
        $("#notify_"+n_lote_actual_customers+" .message_"+n_lote_actual_customers).html("<strong> Enviando Lote "+n_lote_actual_customers+" de "+n_lotes_customers+"</strong>: <img src='"+baseurl+"/assets/img/iconocargando.gif'>");
                    $("#notify_"+n_lote_actual_customers).fadeIn();
                    $("html, body").animate({scrollTop: $('#notify_'+n_lote_actual_customers).offset().top}, 1000);
        x=y+1;
        y=(500*n_lote_actual_customers)-1;
        if(lista_customers_sms_aux[y]==undefined){
            y=lista_customers_sms_aux.length-1;
        }
        lista_customers_sms=lista_customers_sms_aux.slice(x,y);
        var lista_cadena="";
        $(lista_customers_sms).each(function(index,value){
            value=JSON.parse(value);
            if(lista_cadena!=""){
                lista_cadena=lista_cadena+","+value.id+"-"+value.celular;    
            }else{
                lista_cadena=value.id+"-"+value.celular;    
            }
            
        });
        $("#numerosMasivo").val(lista_cadena);
        console.log($.cookie("cancelar_envio_mensajes"));
        if( $.cookie("cancelar_envio_mensajes")=="false"){
            enviar_SMS();
        }else{
            n_lote_actual_customers=n_lote_actual_customers-1;
            console.log($.cookie("cancelar_envio_mensajes"));
            $("#notify_"+n_lote_actual_customers+" .message_"+n_lote_actual_customers).html("<strong>" + dataStatus + " Lote "+n_lote_actual_customers+" de "+n_lotes_customers+"</strong>: Envio Cancelado");
            $("#notify_"+n_lote_actual_customers).removeClass("alert-danger").removeClass("alert-success").addClass("alert-warning").fadeIn();
            $("html, body").animate({scrollTop: $("#notify_"+n_lote_actual_customers).offset().top}, 1000);
            n_lote_actual_customers++;
            $("#notify_"+n_lote_actual_customers+" .message_"+n_lote_actual_customers).html("<strong>" + dataStatus + " Lote "+n_lote_actual_customers+" de "+n_lotes_customers+"</strong>: Envio Cancelado");
            $("#notify_"+n_lote_actual_customers).removeClass("alert-danger").removeClass("alert-success").addClass("alert-warning").fadeIn();
            $("html, body").animate({scrollTop: $("#notify_"+n_lote_actual_customers).offset().top}, 1000);
            
        }   


    }
    if(n_lote_actual_customers==n_lotes_customers){
        lista_customers_sms=lista_customers_sms_aux;
    }


}
function sendMail_g(o_data,action_url) {

    var errorNum = farmCheck();
    $("#sendMail").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>");
        $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
    } else {
        jQuery.ajax({

            url: baseurl + action_url,
            type: 'POST',
            data: o_data,
            dataType: 'json',
             success: function (data) {
                if(data.status=="Success-sms"){
                    /*$("#notify2 .message2").html("<strong>" + data.status + "</strong>: " + data.message);
                    /$("#notify2").removeClass("alert-danger").removeClass("alert-warning").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify2').offset().top}, 1000);*/
                    cargar_informacion_lote(data.status,data.message);
                }else if(data.status=="Error-sms"){
                        /*$("#notify2 .message2").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify2").removeClass("alert-success").removeClass("alert-warning").addClass("alert-danger").fadeIn();
                        $("html, body").animate({scrollTop: $('body').offset().top}, 1000);*/
                    cargar_informacion_lote(data.status,data.message);
                }else if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
                }

            },
            timeout: 700000,
            error: function (data, status, err) {
                if (status == "timeout") {
                    setTimeout(function(){ cargar_informacion_lote("Success-sms","Lote Enviado con Exito"); }, 7000);
                    
                }else{
                    setTimeout(function(){ cargar_informacion_lote("Success-sms","Lote Enviado con Exito"); }, 7000);
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message+" *");
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
                }
            }
        });
    }

}

function send_corte_multiple_form(o_data,action_url) {

    var errorNum = farmCheck();
    $("#sendMail").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>");
        $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
    } else {
        jQuery.ajax({

            url: baseurl + action_url,
            type: 'POST',
            data: o_data,
            dataType: 'json',
             success: function (data) {
                if(data.status=="Success"){
                    $("#div_notify5").append('<div id="notify_5" class="alert alert-warning" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message_5"></div></div>');        
                    $("#notify_5 .message_5").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify_5").removeClass("alert-danger").removeClass("alert-warning").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify2').offset().top}, 1000);
                    
                }else{

                    $("#div_notify5").append('<div id="notify_5" class="alert alert-warning" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message_5"></div></div>');        
                        $("#notify_5 .message_5").html("<strong>" + data.status + "</strong>: <ul>" + data.message+"</ul>");
                        $("#notify_5").removeClass("alert-success").removeClass("alert-warning").addClass("alert-danger").fadeIn();
                        $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
                    
                }

            },
            
            error: function (data, status, err) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
            }
        });
    }

}

//generic model

//part
$(document).on('click', "#submit_model", function (e) {
    e.preventDefault();
    var o_data =  $("#form_model").serialize();
    var action_url= $('#form_model #action-url').val();
    $("#pop_model").modal('hide');

    saveMData(o_data,action_url);


});

$(document).on('click', "#submit_model2", function (e) {
    e.preventDefault();

    var o_data =  $("#form_model2").serialize();
    var action_url= $('#form_model2 #action-url').val();
    $("#pop_model2").modal('hide');

    saveMData(o_data,action_url);


});
$(document).on('click', "#submit_model3", function (e) {
    e.preventDefault();

    var o_data =  $("#form_model3").serialize();
    var action_url= $('#form_model3 #action-url').val();
    $("#pop_model3").modal('hide');

    saveMData(o_data,action_url);


});
$(document).on('click', "#submit_model4", function (e) {
    e.preventDefault();

    var o_data =  $("#form_model4").serialize();
    var action_url= $('#form_model4 #action-url').val();
    $("#pop_model4").modal('hide');

    saveMData(o_data,action_url);


});
function saveMData(o_data,action_url) {

    var errorNum = farmCheck();
if(action_url=="tools/set_task"){
    errorNum=0;
}
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
        $("#notify .message").html("<strong>Error, Campo requerido vacio</strong>");
        $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
    } else {
        jQuery.ajax({

            url: baseurl + action_url,
            type: 'POST',
            data: o_data,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                    if(data.msg1==""){
                        window.location.href =baseurl+"invoices/view?id="+data.tid;
                    }else{
                        location.reload();
                    }


                } else {
                    if(data.status=="Error-Recibido"){
                        $("#mensaje").html('<div id="notifyx" class="alert alert-success" style="display: none;">            <a href="#" class="close" data-dismiss="alert">&times;</a>            <div class="messagex"></div></div>');
                        $("#notifyx .messagex").html("<strong>" + data.status + "</strong>: " + data.message);
                            $("#notifyx").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    
                            $('html, body').animate({scrollTop:0}, 'slow');    
                    }else{
                            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                            $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    
                            $('html, body').animate({scrollTop:0}, 'slow');    
                    }
                    
                    
                    


                }

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }

}

function miniDash() {

    var actionurl = $('#dashurl').val();


    $.ajax({

        url: baseurl + actionurl,
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            var i=0;
          //  var obj = jQuery.parseJSON(data);
            $.each(data, function (key, value) {

                for ( ind in value ) {

                  $('#dash_'+i).text(value[ind]);

                    i++;
                }
            });




        }

    });

}

//universal list item delete from table

$(document).on('click', ".delete-custom", function (e) {
    e.preventDefault();
    var did= $(this).attr('data-did');
    $('#object-id_'+did).val($(this).attr('data-object-id'));
   // $(this).closest('section').attr('id','d_'+$(this).attr('data-object-id'));
    $(this).closest("*[data-block]").attr('id','d_'+$(this).attr('data-object-id'));
    $('#delete_model_'+did).modal({backdrop: 'static', keyboard: false});

   // $("#notify .message")

    $('#delete_model_'+did+' .delete-confirm').attr('data-mid',did);


});

$(".delete-confirm").on("click", function() {
    var did= $(this).attr('data-mid');
    var o_data = $('#mform_'+did).serialize();
    var action_url= $('#action-url_'+did).val();

     $('#d_'+$('#object-id_'+did).val()).remove();


    removeObject_c(o_data,action_url);
});

function removeObject_c(action,action_url) {

    jQuery.ajax({

        url: baseurl + action_url,
        type: 'POST',
        data: action,
        dataType: 'json',
        success: function (data) {
            if (data.status == "Success") {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            } else {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);

            }

        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
            $("html, body").scrollTop($("body").offset().top);

        }
    });

}
$("#copy_address").change(function ()
{
    if($(this).prop("checked") == true){
       // alert("Checkbox is checked." );
       var name=$('#mcustomer_name').val()+$('#mcustomer_dosnombre').val()+$('#mcustomer_unoapellido').val()+$('#mcustomer_dosapellido').val();
       name=name.replace(/ /g, "");
            name=name.replace(/&/g, "y");
            name=name.replace(/ñ/g, "n");
        $('#mcustomer_name_s').val(name.toUpperCase());
        $('#mcustomer_documento_s').val($('#mcustomer_documento').val());
        $('#mcustomer_email_s').val($('#mcustomer_email').val());
        $('#mcustomer_address1_s').val($('#mcustomer_address1').val());
        $('#mcustomer_comentario_s').val($('#cmbBarrios option:selected').text());
        $('#region_s').val($('#region').val());
        $('#mcustomer_country_s').val($('#mcustomer_country').val());
        $('#postbox_s').val($('#postbox').val());
        var desabilitar=false;
        desabilitar = validar_user_name();
        if($("#mcustomer_name_s").val()=="" || $("#mcustomer_documento_s").val()=="" || $("#discountFormatPerfil").val()=="-" || $("#discountFormatPerfil").val()=="Seleccine..." || $("#discountFormatIpLocal").val()=="-" || $("#Ipremota").val()=="" || $("#mcustomer_comentario_s").val()==""){
             desabilitar=true;
        }

        if(desabilitar){
              $("#submit-data").attr("disabled", true);    
        }else{
              $("#submit-data").removeAttr("disabled");    
        }

        

    }
    else{
        $('#mcustomer_name_s').val('');
        $('#mcustomer_phone_s').val('');
        $('#mcustomer_email_s').val('');
        $('#mcustomer_address1_s').val('');
        $('#mcustomer_city_s').val('');
        $('#region_s').val('');
        $('#mcustomer_country_s').val('');
        $('#postbox_s').val('');
        $("#submit-data").removeAttr("disabled");
    }
});
$("#copy_address_edit").change(function ()
{
    if($(this).prop("checked") == true){
       // alert("Checkbox is checked." );
        if(usuario_existe){
            var name=$('#mcustomer_name').val()+$('#mcustomer_dosnombre').val()+$('#mcustomer_unoapellido').val()+$('#mcustomer_dosapellido').val();
            name=name.replace(/ /g, "");
            name=name.replace(/&/g, "y");
            name=name.replace(/ñ/g, "n");
            $('#mcustomer_name_s').val(name.toUpperCase());
        }
        $('#mcustomer_documento_s').val($('#mcustomer_documento').val());
        $('#mcustomer_email_s').val($('#mcustomer_email').val());
        $('#mcustomer_address1_s').val($('#mcustomer_address1').val());
        if($('#mcustomer_comentario_s').val()==""){
            $('#mcustomer_comentario_s').val($('#cmbBarrios option:selected').text());
        }        
        $('#region_s').val($('#region').val());
        $('#mcustomer_country_s').val($('#mcustomer_country').val());
        $('#postbox_s').val($('#postbox').val());
        var desabilitar=false;
        desabilitar = validar_user_name();
        if($("#mcustomer_name_s").val()=="" || $("#mcustomer_documento_s").val()=="" || $("#discountFormatPerfil").val()=="-" || $("#discountFormatPerfil").val()=="Seleccine..." || $("#discountFormatIpLocal").val()=="-" || $("#Ipremota").val()=="" || $("#mcustomer_comentario_s").val()==""){
             desabilitar=true;
        }

        if(desabilitar){
              $("#submit-data").attr("disabled", true);    
        }else{
              $("#submit-data").removeAttr("disabled");    
        }


    }
    else{
       // $('#mcustomer_name_s').val('');
        $('#mcustomer_phone_s').val('');
        $('#mcustomer_email_s').val('');
        $('#mcustomer_address1_s').val('');
        $('#mcustomer_city_s').val('');
        $('#region_s').val('');
        $('#mcustomer_country_s').val('');
        $('#postbox_s').val('');
        $("#submit-data").removeAttr("disabled");
    }
});

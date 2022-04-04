
var calendar=null;
var base_url=baseurl;
var currentDate; // Holds the day clicked when adding a new event
var currentEvent; // Holds the event object when editing an event

function contruccion_calendar(propiedades){
     var calendarEl = document.getElementById('calendar');
         calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      
      navLinks: true, // can click day/week names to navigate views
      
        events: base_url+'events/getEvents' ,
        selectable: true,
        
        initialDate: propiedades.initialDate,
        initialView:propiedades.initialView,
        locale: 'es',
        editable: true, // Make the event resizable true     
        selectMirror: true,
        dayMaxEvents: true, // allow "more" link when too many events
      
      
      select: function(ev) {
                
                $('#start').val(moment(ev.start).format('YYYY-MM-DD HH:mm:ss'));
                $('#end').val(moment(ev.end).format('YYYY-MM-DD HH:mm:ss'));
                 // Open modal to add event
            modal({
                // Available buttons when adding
                buttons: {
                    add: {
                        id: 'add-event', // Buttons id
                        css: 'btn-success', // Buttons class
                        label: 'Add' // Buttons label
                    }
                },
                title: 'Add Event' // Modal title
            });
        }, 
        datesSet:function(date){
            if(date.view.type!="timeGridDay"){
                    $.post(baseurl+"events/fecha_ultimo_evento_set",{'fecha':null},function(data){

                });
            }
        },
        eventDrop: function(event, delta, revertFunc,start,end) {
            start = moment(event.event._instance.range.start).format('YYYY-MM-DD HH:mm:ss');
            if(event.end){
                end = moment(event.event._instance.range.end).format('YYYY-MM-DD HH:mm:ss');
            }else{
                end = start;
            }         
                       
               $.post(base_url+'events/dragUpdateEvent',{                            
                id:event.el.fcSeg.eventRange.def.extendedProps.idevent,
                start : start,
                end :end
            }, function(result){
                $('.alert').addClass('alert-success').text('Event updated successfuly');
                hide_notify();


            });



          },         
          eventResize: function(event,dayDelta,minuteDelta,revertFunc) { 
                    
                start = event.start.format('YYYY-MM-DD HH:mm:ss');
            if(event.end){
                end = event.end.format('YYYY-MM-DD HH:mm:ss');
            }else{
                end = start;
            }         
                       //console.log(event.event._def.extendedProps.idevent);
               $.post(base_url+'events/dragUpdateEvent',{                            
                id:event.event._def.extendedProps.idevent,
                start : start,
                end :end
            }, function(result){
                $('.alert').addClass('alert-success').text('Event updated successfuly');
                hide_notify();

            });
            },
          
        // Event Mouseover
        eventMouseEnter: function(calEvent){

            var tooltip = '<div class="event-tooltip">' + calEvent.event._def.extendedProps.description + '</div>';
            
            $("body").append(tooltip);
            
            $(calEvent.el).mouseover(function(e) {
                $(this).css('z-index', 10000);
                $('.event-tooltip').fadeIn('500');
                $('.event-tooltip').fadeTo('10', 1.9);
            }).mousemove(function(e) {
                $('.event-tooltip').css('top', e.pageY + 10);
                $('.event-tooltip').css('left', e.pageX + 20);
            });
        },
        eventMouseLeave: function(calEvent) {
            $(calEvent.el).css('z-index', 8);
            $('.event-tooltip').remove();
        },
        // Handle Existing Event Click
        eventClick: function(calEvent, jsEvent, view) {
            // Set currentEvent variable according to the event clicked in the calendar
            //console.log(calEvent);
            //console.log(jsEvent);

            currentEvent = calEvent;

            // Open modal to edit or delete event
            var btns_config={
                    delete: {
                        id: 'delete-event',
                        css: 'btn-danger',
                        label: 'Borrar'
                    },
                    update: {
                        id: 'update-event',
                        css: 'btn-success',
                        label: 'Actualizar'
                    }
                };
            if(parseInt(rolid_user)<4){
                btns_config={
                    update: {
                        id: 'update-event',
                        css: 'btn-success',
                        label: 'Actualizar'
                    }
                };
            }
            var configuraciones1={
                // Available buttons when editing
                buttons: btns_config,
                title: 'Editar Evento "' + calEvent.el.fcSeg.eventRange.def.title + '"',
                event: calEvent.event,
                fecha: moment(calEvent.el.fcSeg.eventRange.range.end).format('YYYY-MM-DD')
            };


            modal(configuraciones1);
        }
           
      
    });

    calendar.render();

     function modal(data) {
        // Set modal title
        $('.modal-title').html(data.title);
        // Clear buttons except Cancel
        $('.modal-footer button:not(".btn-default")').remove();
        // Set input values
        try {
            

            if(data.event._def.extendedProps.id_tarea==null || data.event._def.extendedProps.id_tarea==0|| data.event._def.extendedProps.id_tarea=="0" || data.event._def.extendedProps.id_tarea==""){
                $("#ver_orden_id").attr("href",baseurl+"tickets/thread/?id="+data.event._def.extendedProps.idt);    
                $("#ver_orden_id").children().text("Ver Orden");
                
                $.post(baseurl+"events/fecha_ultimo_evento_set",{'fecha':data.fecha},function(data){

                });
            }else{
                $("#ver_orden_id").attr("href",baseurl+"manager/historial/?id="+data.event._def.extendedProps.id_tarea);    
                $("#ver_orden_id").children().text("Ver Tarea");
            }
            
        }
        catch (e) {
       
        }

        
        //console.log(data);
        $('#idorden').val(data.event ? data.event._def.extendedProps.idorden : '');
        $('#idtarea').val(data.event ? data.event._def.extendedProps.id_tarea : '');
        $('#title').val(data.event ? data.event._def.title : '');        
        $('#description').val(data.event ? data.event._def.extendedProps.description : '');
        $('#rol').val(data.event ? data.event._def.extendedProps.rol : '');
        $('#color').val(data.event ? data.event._def.extendedProps.colorx : '#3a87ad');     
        if(typeof data.event!="undefined"){
                if(data.event._def.extendedProps.asignacion_movil!=null && data.event._def.extendedProps.asignacion_movil!="0"){
                    $.post(baseurl+"Events/get_nombre_movil",{id:data.event._def.extendedProps.asignacion_movil},function(data){
                           $('#rol').val(data);
                    });    
                }    
        }
        
        // Create Butttons
        $.each(data.buttons, function(index, button){
            $('.modal-footer').prepend('<button type="button" id="' + button.id  + '" class="btn ' + button.css + '">' + button.label + '</button>')
        })
        //Show Modal
        $('.modal').not("#modal_sede").modal('show');

    }

    // Handle Click on Add Button
    $('.modal').on('click', '#add-event',  function(e){
        if(validator([ 'title', 'description'])) {
            $.post(base_url+'events/addEvent', {
                //idorden: $('#idorden').val(),
                title: $('#title').val(),
                description: $('#description').val(),
                color: $('#color').val(),
                rol: $('#rol').val(),
                start: $('#start').val(),
                end: $('#end').val()
            }, function(result){
                $('.alert').addClass('alert-success').text('Event added successfuly');
                $('.modal').modal('hide');
                calendar.refetchEvents();
                hide_notify();
            });
        }
    });


    // Handle click on Update Button
    $('.modal').on('click', '#update-event',  function(e){
        if(validator([ 'title', 'description', 'rol'])) {
            $.post(base_url+'events/updateEvent', {
                id: currentEvent.event._def.extendedProps.idevent,
                idorden: $('#idorden').val(),
                idtarea: $('#idtarea').val(),
                title: $('#title').val(),
                description: $('#description').val(),
                color: $('#color').val(),
                rol: $('#rol').val()
            }, function(result){
                $('.alert').addClass('alert-success').text('Event updated successfuly');
                $('.modal').modal('hide');
                //$('#calendar').fullCalendar("refetchEvents");
                calendar.refetchEvents();
                hide_notify();
                
            });
        }
    });
//hide color
    $("#link_to_cal").change(function ()
{
      
            $('#hidden_div').show();
          
        
    });


    // Handle Click on Delete Button

    $('.modal').on('click', '#delete-event',  function(e){
        $.get(base_url+'events/deleteEvent?id=' + currentEvent.el.fcSeg.eventRange.def.extendedProps.idevent, function(result){
            $('.alert').addClass('alert-success').text('Event deleted successfully !');
            $('.modal').modal('hide');
            calendar.refetchEvents();
            hide_notify();
        });
    });

    function hide_notify()
    {
        setTimeout(function() {
                    $('.alert').removeClass('alert-success').text('');
                }, 2000);
    }


    // Dead Basic Validation For Inputs
    function validator(elements) {
        var errors = 0;
        $.each(elements, function(index, element){
            if($.trim($('#' + element).val()) == '') errors++;
        });
        if(errors) {
            $('.error').html('Please insert title and description');
            return false;
        }
        return true;
    }
}
// Prepares the modal window according to data passed
   
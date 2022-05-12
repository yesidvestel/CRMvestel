<link href="<?php echo base_url(); ?>assets/portcss/custom.css" rel="stylesheet"/>
<link href='<?=base_url() ?>assets/fullcalendar/lib/main.css' rel='stylesheet' />
<script src='<?=base_url() ?>assets/fullcalendar/lib/main.js'></script>
<script>
    
var rolid_user="<?=$this->aauth->get_user()->roleid ?>";
  /*document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      initialDate: '2020-09-12',
      navLinks: true, // can click day/week names to navigate views
      selectable: true,
      selectMirror: true,
      select: function(arg) {
        var title = prompt('Event Title:');
        if (title) {
          calendar.addEvent({
            title: title,
            start: arg.start,
            end: arg.end,
            allDay: arg.allDay
          })
        }
        calendar.unselect()
      },
      eventClick: function(arg) {
        if (confirm('Are you sure you want to delete this event?')) {
          arg.event.remove()
        }
      },
      editable: true,
      dayMaxEvents: true, // allow "more" link when too many events
      events: [
        {
          title: 'All Day Event',
          start: '2020-09-01'
        },
        {
          title: 'Long Event',
          start: '2020-09-07',
          end: '2020-09-10'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2020-09-09T16:00:00'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2020-09-16T16:00:00'
        },
        {
          title: 'Conference',
          start: '2020-09-11',
          end: '2020-09-13'
        },
        {
          title: 'Meeting',
          start: '2020-09-12T10:30:00',
          end: '2020-09-12T12:30:00'
        },
        {
          title: 'Lunch',
          start: '2020-09-12T12:00:00'
        },
        {
          title: 'Meeting',
          start: '2020-09-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2020-09-12T17:30:00'
        },
        {
          title: 'Dinner',
          start: '2020-09-12T20:00:00'
        },
        {
          title: 'Birthday Party',
          start: '2020-09-13T07:00:00'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2020-09-28'
        }
      ]
    });

    calendar.render();
  });
*/
</script>
<style type="text/css">
  a{
    color: black;
  }
  a[fc-daygrid-bloc]{
    color: white;
  }
  .fc-col-header-cell > .fc-scrollgrid-sync-inner {
    padding: 10px 0px;
    vertical-align: middle;
    background: #F2F2F2;
}
.fc .fc-popover{
  z-index: 100;
}

</style>
<link href="<?php echo base_url(); ?>assets/portcss/bootstrapValidator.min.css" rel="stylesheet"/>
<link href="<?php echo base_url(); ?>assets/portcss/bootstrap-colorpicker.min.css" rel="stylesheet"/>
<script src='<?php echo base_url(); ?>assets/portjs/moment.min.js'></script>
<script src="<?php echo base_url(); ?>assets/portjs/bootstrapValidator.min.js"></script>
<script src='<?php echo base_url(); ?>assets/fullcalendar/lib/locales-all.js'></script>
<script src='<?php echo base_url(); ?>assets/fullcalendar/lib/configuraciones_fullcalendar.js'></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src='<?php echo base_url(); ?>assets/portjs/bootstrap-colorpicker.min.js'></script>


<article class="content">
    
    <div class="card card-block">

        <!-- Notification -->
        <div class="alert"></div>


        <div id='calendar'></div>
            <div class="card card-block" <?= ($this->aauth->get_user()->roleid<3) ? 'style="display:none;"':''  ?>>
                <div class="form-group row" >
                    <label class="col-sm-2 col-form-label" for="tecnicos_f">Tecnico</label>
                    <div class="col-sm-6">
                        
                        <select id="tecnicos_f" class="form-control">
                            <option value="all">Todo</option>
                            <?php foreach ($tecnicoslista as $key => $value) {
                                $username=$value['username'];
                                echo "<option value='$username'>$username</option>";
                            } ?>
                        </select>
                    </div>

                </div>
                <div class="form-group row" >
                    <label class="col-sm-2 col-form-label" for="movil_f">Movil</label>
                    <div class="col-sm-6">
                        <select id="movil_f" class="form-control">
                            <option value="all">Todo</option>
                            <?php 
                                foreach ($moviles as $key => $value) {
                                    $nombre=$value->nombre;
                                    $id_movil=$value->id_movil;
                                    echo "<option value='$id_movil'>$nombre</option>";
                                }
                             ?>
                        </select>
                    </div>

                </div>
                <div class="form-group row" >
                     <label class="col-sm-2 col-form-label" ></label>
                     <div class="col-sm-6">
                            <a href="#" class="btn btn-primary" id="btn-filtrar">Filtrar</a>
                        </div>
                </div>
            </div>
    </div>
</article>
<div class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="error"></div>
                <form class="form-horizontal" id="crud-form">
                    <input type="hidden" id="start">
                    <input type="hidden" id="end">
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="title"><?php echo $this->lang->line('Add Event')  ?></label>

                    </div>
          <input id="idorden" name="idorden" type="text" style="visibility: hidden;" class="form-control input-md"/>
          <input id="idtarea" name="idtarea" type="text" style="visibility: hidden;" class="form-control input-md"/>
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="title"><?php echo $this->lang->line('Title')  ?></label>
                        <div class="col-md-8">
                            <input id="title" name="title" type="text" class="form-control input-md"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="description"><?php echo $this->lang->line('Description')  ?></label>
                        <div class="col-md-8">
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                    </div>
          <div class="row form-group">
                        <label class="col-md-4 control-label" for="rol">Asignado</label>
                        <div class="col-md-8">
                            <input id="rol" name="rol" type="text" class="form-control input-md" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="color"><?php echo $this->lang->line('Color')  ?></label>
                        <div class="col-md-4">
                            <input id="color" name="color" type="text" class="form-control"
                                   />
                            <span class="help-block">Haga click para elegir un color</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
        <a href="<?php echo base_url('tickets/thread?id=') ?>" id="ver_orden_id"><button type="button" class="btn btn-default" style="background-color:skyblue;color: white">Ver orden</button></a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  $("#btn-filtrar").click(function(ev){
    ev.preventDefault();
    
     var tecnico=$("#tecnicos_f option:selected").val();
     var movil=$("#movil_f option:selected").val();
    
    var fecha_ultimo_evento="<?= (isset($this->aauth->get_user()->fecha_ultimo_evento))? $this->aauth->get_user()->fecha_ultimo_evento:"null" ?>";
    var propiedates={initialDate: fecha_ultimo_evento,initialView:'timeGridDay'};
        if(fecha_ultimo_evento=="null"){
            propiedates.initialDate="<?=date("Y-m-d") ?>";
            propiedates.initialView="dayGridMonth";
        }
     if(tecnico=="all"){
            $.removeCookie("tecnico");
     }else{
        $.cookie("tecnico",tecnico);   
     }
     if(calendar==null){

        contruccion_calendar(propiedates);
        
//calendar.changeView('timeGridDay',"2022-04-01");
     }else{
        calendar.refetchEvents();
     }
      
       
    });
  $(function(){
    var fecha_ultimo_evento="<?= (isset($this->aauth->get_user()->fecha_ultimo_evento))? $this->aauth->get_user()->fecha_ultimo_evento:"null" ?>";
    var propiedates={initialDate: fecha_ultimo_evento,initialView:'timeGridDay'};
        if(fecha_ultimo_evento=="null"){
            propiedates.initialDate="<?=date("Y-m-d") ?>";
            propiedates.initialView="dayGridMonth";
        }
        
    $.removeCookie('tecnico');

    $('#color').colorpicker(); // Colopicker
    // Here i define the base_url

    // Fullcalendar
   <?php if ($this->aauth->get_user()->roleid < 3) { ?>
    contruccion_calendar(propiedates);
  <?php } ?>
});
</script>
  


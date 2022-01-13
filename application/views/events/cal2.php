<link href='<?=base_url() ?>assets/fullcalendar/lib/main.css' rel='stylesheet' />
<script src='<?=base_url() ?>assets/fullcalendar/lib/main.js'></script>
<script>

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
<script src='<?php echo base_url(); ?>assets/fullcalendar/lib/configuraciones_fullcalendar.js'></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>


<article class="content">
    
    <div class="card card-block">

        <!-- Notification -->
        <div class="alert"></div>


        <div id='calendar'></div>
            <div class="card card-block" <?= ($this->aauth->get_user()->roleid<4) ? 'style="display:none;"':''  ?>>
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


  


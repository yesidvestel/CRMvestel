<link href='<?php echo base_url(); ?>assets/portcss/fullcalendar.css' rel='stylesheet'/>
<link href="<?php echo base_url(); ?>assets/portcss/bootstrapValidator.min.css" rel="stylesheet"/>
<link href="<?php echo base_url(); ?>assets/portcss/bootstrap-colorpicker.min.css" rel="stylesheet"/>
<!-- Custom css  -->
<link href="<?php echo base_url(); ?>assets/portcss/custom.css" rel="stylesheet"/>
<script src='<?php echo base_url(); ?>assets/portjs/moment.min.js'></script>
<script type="text/javascript">
    moment.locale('es', {
    months : 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
    monthsShort : 'Enero._Feb._Mar_Abr._May_Jun_Jul._Ago_Sept._Oct._Nov._Dec.'.split('_'),
    monthsParseExact : true,
    weekdays : 'Domingo_Lunes_Martes_Miercoles_Jueves_Viernes_Sabado'.split('_'),
    weekdaysShort : 'Dom._Lun._Mar._Mier._Jue._Vier._Sab.'.split('_'),
    weekdaysMin : 'Do_Lu_Ma_Mi_Ju_Vi_Sa'.split('_'),
    weekdaysParseExact : true,
    longDateFormat : {
        LT : 'HH:mm',
        LTS : 'HH:mm:ss',
        L : 'DD/MM/YYYY',
        LL : 'D MMMM YYYY',
        LLL : 'D MMMM YYYY HH:mm',
        LLLL : 'dddd D MMMM YYYY HH:mm'
    },
    calendar : {
        sameDay : '[Aujourd’hui à] LT',
        nextDay : '[Demain à] LT',
        nextWeek : 'dddd [à] LT',
        lastDay : '[Hier à] LT',
        lastWeek : 'dddd [dernier à] LT',
        sameElse : 'L'
    },
    relativeTime : {
        future : 'dans %s',
        past : 'il y a %s',
        s : 'quelques secondes',
        m : 'une minute',
        mm : '%d minutes',
        h : 'une heure',
        hh : '%d heures',
        d : 'un jour',
        dd : '%d jours',
        M : 'un mois',
        MM : '%d mois',
        y : 'un an',
        yy : '%d ans'
    },
    dayOfMonthOrdinalParse : /\d{1,2}(er|e)/,
    ordinal : function (number) {
        return number + (number === 1 ? 'er' : 'e');
    },
    meridiemParse : /PD|MD/,
    isPM : function (input) {
        return input.charAt(0) === 'M';
    },
    // In case the meridiem units are not separated around 12, then implement
    // this function (look at locale/id.js for an example).
    // meridiemHour : function (hour, meridiem) {
    //     return /* 0-23 hour, given meridiem token and hour 1-12 */ ;
    // },
    meridiem : function (hours, minutes, isLower) {
        return hours < 12 ? 'PD' : 'MD';
    },
    week : {
        dow : 1, // Monday is the first day of the week.
        doy : 4  // Used to determine first week of the year.
    }
});
    //end 
</script>
<script src="<?php echo base_url(); ?>assets/portjs/bootstrapValidator.min.js"></script>
<script src="<?php echo base_url(); ?>assets/portjs/fullcalendar.min.js"></script>
<script src='<?php echo base_url(); ?>assets/portjs/bootstrap-colorpicker.min.js'></script>



<script src='<?php echo base_url(); ?>assets/portjs/main.js'></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

<script src='<?php echo base_url(); ?>assets/portjs/locales/es.js'></script>
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
<script>

/*var calendar = new Calendar(calendarEl, {
  locale: 'es'
});

calendar.setOption('locale', 'es');*/
$("#btn-filtrar").click(function(ev){
    ev.preventDefault();
 
 var tecnico=$("#tecnicos_f option:selected").val();
 var movil=$("#movil_f option:selected").val();
 if(tecnico=="all"){
        $.removeCookie("tecnico");
 }else{
    $.cookie("tecnico",tecnico);   
 }
 
$("#calendar").fullCalendar("refetchEvents"); 
   
});

</script>



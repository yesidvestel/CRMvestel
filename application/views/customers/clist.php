<style>
.st-Activo, .st-Instalar , .st-Cortado, .st-Suspendido, .st-anulado, .st-Exonerado
{
    text-transform: uppercase;
    color: #fff;
    padding: 4px;
    border-radius: 11px;
    font-size: 15px;
}
.st-Activo
{
 background-color: #4EAA28;
}
.st-Instalar
{
 background-color: #A49F20;
}
.st-Cortado
{
 background-color: #A4282A;
}
.st-Suspendido
{
 background-color: #2224A3;
}
.st-Exonerado
{
 background-color: #24A9AB;
}
</style>
<article class="content content items-list-page">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
                               <div class="card">
                    <div class="card-body">
                        <div class="card-block">
                            <label class="col-sm-12 col-form-label"
                                       for="pay_cat"><h5>FILTRAR </h5> </label> 

                            <ul class="nav nav-tabs nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active"
                                       aria-controls="active"
                                       aria-expanded="true">Estado</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="link-tab" data-toggle="tab" href="#link"
                                       aria-controls="link"
                                       aria-expanded="false">Servicio</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="thread-tab" data-toggle="tab" href="#thread"
                                       aria-controls="thread">Direccion</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="milestones-tab" data-toggle="tab" href="#milestones"
                                       aria-controls="milestones"> Cuenta</a>
                                </li>
                               <!-- <li class="nav-item">
                                    <a class="nav-link" id="thread-tab" data-toggle="tab" href="#activities"
                                       aria-controls="activities">Otro Filtro</a>
                                </li>-->
                               
                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div role="tabpanel" class="tab-pane fade active in" id="active" aria-labelledby="active-tab" aria-expanded="true">
                                    <div class="form-group row">
                                            
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat">Estado</label>

                                        <div class="col-sm-6">
                                            <select name="tec" class="form-control" id="estado">
                                                <option value=''>Todos</option>
                                                <option value='Activo'>Activos</option>
                                                <option value='Cortado'>Cortados</option>
                                                <option value='Suspendido'>Suspendidos</option>
                                                <option value='Instalar'>Instalar</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="link" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"
                                                   for="pay_cat">Servicio</label>

                                            <div class="col-sm-6">
                                                <select name="trans_type" class="form-control" id="sel_servicios">
                                                    <option value=''>Todos</option>
                                                    <option value='Internet'>Internet</option>
                                                    <option value='TV'>TV</option>
                                                    <option value='Combo'>Combo</option>
                                                </select>
                                            </div>                              
                                        </div>
                                </div>
                                <!--thread-->
                                <div class="tab-pane fade" id="thread" role="tabpanel" aria-labelledby="thread-tab" aria-expanded="false">

                                        <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat">Direccion</label>

                                        <div class="col-sm-6">
                                            <select name="trans_type" class="form-control" id="sel_dir_personalizada" onclick="act_sel_dir_personalizada()">
                                                <option value=''>Todas</option>
                                                <option value='Personalizada'>Personalizada</option>
                                            </select>
                                        </div>                              
                                    </div>
                                    <div id="div_direccion_personalizada">
                                            <div class="form-group row">
                                        
                                        
                                        

                                            <div class="col-sm-12">
                                                <h6><label class="col-sm-2 col-form-label"
                                                   for="ciudad"><?php echo $this->lang->line('') ?>Ciudad</label></h6>
                                                <div id="ciudades">
                                                    <select id="cmbCiudades" class="selectpicker form-control" name="ciudad" onChange="cambia4()">                                
                                                        
                                                            <option value="0">-</option>
                                                        
                                                            <option value="Yopal">Yopal</option>
                                                        
                                                            <option value="Villanueva">Villanueva</option>
                                                        
                                                            <option value="Monterrey">Monterrey</option>
                                                        
                                                            <option value="Mocoa">Mocoa</option>
                                                        
                                                    </select>
                                                </div>
                                                   
                                            </div>
                                          
                                           
                                        </div>
                                            <div class="form-group row"> 
                                            
                                                <div class="col-sm-6">
                                                    <h6><label class="col-sm-2 col-form-label"
                                                       for="localidad"><?php echo $this->lang->line('') ?>Localidad</label></h6>
                                                    <div id="localidades">
                                                        <select id="cmbLocalidades"  class="selectpicker form-control" name="localidad" onChange="cambia5()">
                                                        <option value="0">-</option>
                                                        </select>
                                                    </div>
                                                       
                                                </div>
                                                
                                                <div class="col-sm-6">
                                                    <h6><label class="col-sm-2 col-form-label"
                                                       for="barrio"><?php echo $this->lang->line('') ?>Barrio</label></h6>
                                                    <div id="barrios">
                                                        <select id="cmbBarrios" class="selectpicker form-control" name="barrio" >
                                                        <option value="0">-</option>
                                                        </select>
                                                    </div>
                                                       
                                                </div>
                                                 
                                            </div>
                                            <div class="form-group row">

                                                <h6><label class="col-sm-12 col-form-label"
                                                       for="city"><?php echo $this->lang->line('') ?>Direccion</label></h6>

                                                
                                            
                                                <div class="col-sm-2">
                                                <select class="form-control"  id="nomenclatura" name="nomenclatura">
                                                                            <option value="-">-</option>
                                                                            <option value="Calle">Calle</option>
                                                                            <option value="Carrera">Carrera</option>
                                                                            <option value="Diagonal">Diagonal</option>
                                                                            <option value="Transversal">Transversal</option>
                                                                            <option value="Manzana">Manzana</option>
                                                                    </select>
                                                
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" placeholder="Numero" id="numero1" 
                                                           class="form-control margin-bottom" name="numero1">
                                                </div>
                                                <div class="col-sm-2">
                                                    <select class="form-control" id="adicionauno" name="adicionauno">
                                                                            <option value=""></option>
                                                                            <option value="bis">bis</option>
                                                                            <option value="sur">sur</option>
                                                                            <option value="a">a</option>
                                                                            <option value="a">a sur</option>
                                                                            <option value="b">b</option>
                                                                            <option value="a">b sur</option>
                                                                            <option value="c">c</option>
                                                                            <option value="d">d</option>
                                                                            <option value="e">e</option>
                                                                            <option value="f">f</option>
                                                                            <option value="g">g</option>
                                                                            <option value="h">h</option>
                                                                            <option value="a bis">a bis</option>
                                                                            <option value="b bis">b bis</option>
                                                                            <option value="c bis">c bis</option>
                                                                            <option value="d bis">d bis</option>
                                                                    </select>
                                                </div>
                                                <div class="col-sm-1" style="margin-left: -10px; width: 2%">
                                                    <label class="col-form-label" for="Nº">Nº</label>
                                                </div>
                                                <div class="col-sm-2" style="margin-left: 14px;">
                                                    <input type="text" placeholder="Numero"
                                                           class="form-control margin-bottom" id="numero2" name="numero2" style="margin-left: -20px;">
                                                </div>
                                                <div class="col-sm-2" style="margin-left: -30px;margin-right: -20px;">
                                                    <select class="col-sm-1 form-control" id="adicional2" name="adicional2">
                                                                            <option value=""></option>
                                                                            <option value="bis">bis</option>
                                                                            <option value="sur">sur</option>
                                                                            <option value="a">a</option>
                                                                            <option value="a sur">a sur</option>
                                                                            <option value="b">b</option>
                                                                            <option value="b sur">b sur</option>
                                                                            <option value="c">c</option>
                                                                            <option value="d">d</option>
                                                                            <option value="e">e</option>
                                                                            <option value="f">f</option>
                                                                            <option value="g">g</option>
                                                                            <option value="h">h</option>
                                                                            <option value="a bis">a bis</option>
                                                                            <option value="b bis">b bis</option>
                                                                            <option value="c bis">c bis</option>
                                                                            <option value="d bis">d bis</option>
                                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" placeholder="Numero"
                                                           class="form-control margin-bottom" name="numero3" id="numero3">
                                                </div>
                                            </div>
                                    </div>

                                </div>
                                <!--thread-->
                                <!--milestones-->
                                <div class="tab-pane fade" id="milestones" role="tabpanel" aria-labelledby="milestones-tab" aria-expanded="false">
                                    <div class="form-group row">
                                
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat">Estado de Cuenta</label>

                                        <div class="col-sm-6">
                                            <select name="tec" class="form-control" id="deudores">
                                                <option value=''>Todo</option>
                                                <option value='1mes'>Corriente</option>
                                                <option value='masdeunmes'>Mas del Mes</option>
                                                <option value='2meses'>Mas de 2 meses</option>
                                                <option value='3y4meses'>Mas de 3 y 4 meses</option>
                                                <option value='Todos'>Todos los Deudores</option>
                                                <option value='saldoaFavor'>Saldo a Favor</option>
                                                <option value='al Dia'>Al Dia</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <!--milestones-->
                                <!--otro filtro 
                                <div class="tab-pane fade" id="activities" role="tabpanel" aria-labelledby="activities-tab" aria-expanded="false">

                                </div>
                                activities-->
                                
                                


                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-4">
                                    <input type="button" class="btn btn-primary btn-md" value="VER" onclick="filtrar(1)">


                                </div>
                            </div>
                </div>
                                                    
            <h5><?php echo $this->lang->line('') ?>USUARIOS</h5>

            <hr>
            <div class="table-responsive">
                <table id="clientstable" class="table-striped" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
						<th>Abonado</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
						<th>Celular</th>
						<th>Cedula</th>
                        <th><?php echo $this->lang->line('Address') ?></th>
						<th id="despues_de_thead">Estado</th>
                        <th><?php echo $this->lang->line('Settings') ?></th>


                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>#</th>
						<th>Abonado</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
						<th>Celular</th>
						<th>Cedula</th>
                        <th><?php echo $this->lang->line('Address') ?></th>
						<th id="despues_de_tfoot">Estado</th>
                        <th><?php echo $this->lang->line('Settings') ?></th>


                    </tr>
                    </tfoot>
                </table>
                 <div style="float: right;">Seccionamiento ->
                    <a  id="pagination_1" data-start="<?=$array_pagination['1']['start']?>" data-end="<?=$array_pagination['1']['end']?>" onclick="filtrar(1)">1&nbsp;&nbsp;&nbsp;&nbsp;</a>
                    <a  id="pagination_2" data-start="<?=$array_pagination['2']['start']?>" data-end="<?=$array_pagination['2']['end']?>" onclick="filtrar(2)">2&nbsp;&nbsp;&nbsp;&nbsp;</a>
                    <a  id="pagination_3" data-start="<?=$array_pagination['3']['start']?>" data-end="<?=$array_pagination['3']['end']?>" onclick="filtrar(3)">3&nbsp;&nbsp;&nbsp;&nbsp;</a>
                    <a  id="pagination_4" data-start="<?=$array_pagination['4']['start']?>" data-end="<?=$array_pagination['4']['end']?>" onclick="filtrar(4)">4&nbsp;&nbsp;&nbsp;&nbsp;</a>
                    <a  id="pagination_5" data-start="<?=$array_pagination['5']['start']?>" data-end="<?=$array_pagination['5']['end']?>" onclick="filtrar(5)">5&nbsp;&nbsp;&nbsp;&nbsp;</a>
                    <a  id="pagination_6" data-start="<?=$array_pagination['6']['start']?>" data-end="<?=$array_pagination['6']['end']?>" onclick="filtrar(6)">6&nbsp;&nbsp;&nbsp;&nbsp;</a>
                    <a  id="pagination_7" data-start="<?=$array_pagination['7']['start']?>" data-end="<?=$array_pagination['7']['end']?>" onclick="filtrar(7)">7&nbsp;&nbsp;&nbsp;&nbsp;</a>

            </div>
            </div>
        </div>
    </div>
</article>

<script type="text/javascript">
    var tb;
    $(document).ready(function () {
        tb=$('#clientstable').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('customers/load_list')?>",
                'type': 'POST'
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
            "language":{
                    "processing": "Procesando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "Ningún dato disponible en esta tabla",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "search": "Buscar:",
                    "infoThousands": ",",
                    "loadingRecords": "Cargando...",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                     "info": "Mostrando de _START_ a _END_ de _TOTAL_ entradas"

                }
			
        });

    });
    var columnasAgregadas=false;
    function nuevas_columnas(){
        if(!columnasAgregadas){
              tb.destroy();
              $("#despues_de_thead").after("<th class='cols_adicionadas'>Suscripcion</th>");
              $("#despues_de_tfoot").after("<th class='cols_adicionadas'>Suscripcion</th>");
              $("#despues_de_thead").after("<th class='cols_adicionadas'>Deuda</th>");
              $("#despues_de_tfoot").after("<th class='cols_adicionadas'>Deuda</th>");
              var morosos=$("#deudores option:selected").val();

              var estado=$("#estado option:selected").val();
           
                var ciudadx= $("#cmbCiudades option:selected").val();
                var localidad= $("#cmbLocalidades option:selected").val();
                var barrio= $("#cmbBarrios option:selected").val();
                var nomenclatura= $("#nomenclatura option:selected").val();
                var numero1= $("#numero1").val();
                
                var adicionauno= $("#adicionauno option:selected").val();
                var numero2= $("#numero2").val();
                var adicional2= $("#adicional2 option:selected").val();
                var numero3= $("#numero3").val();
                var direccion = $("#sel_dir_personalizada option:selected").val();
                var sel_servicios = $("#sel_servicios option:selected").val();
              tb=$('#clientstable').DataTable({

                'processing': true,
                'serverSide': true,
                'stateSave': true,
                'order': [],

                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('customers/load_morosos') . '?id=' . $group['id']; ?>&morosos="+morosos+"&estado="+estado+"&ciudad="+ciudadx+"&localidad="+localidad+"&barrio="+barrio+"&nomenclatura="+nomenclatura+"&numero1="+numero1+"&adicionauno="+adicionauno+"&numero2="+numero2+"&adicional2="+adicional2+"&numero3="+numero3+"&direccion="+direccion+"&sel_servicios="+sel_servicios+"&pagination_start="+pagination_start+"&pagination_end="+pagination_end,
                    "type": "POST"
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                    {
                        "targets": [0], //first column / numbering column
                        "orderable": false, //set not orderable
                    },
                    
                ],  
                

            });
              columnasAgregadas=true;
      }
    }
    var pagination_start="";
    var pagination_end="";
    function filtrar($pagination_id){
          var estado=$("#estado option:selected").val();
           
            var ciudadx= $("#cmbCiudades option:selected").val();
            var localidad= $("#cmbLocalidades option:selected").val();
            var barrio= $("#cmbBarrios option:selected").val();
            var nomenclatura= $("#nomenclatura option:selected").val();
            var numero1= $("#numero1").val();
            
            var adicionauno= $("#adicionauno option:selected").val();
            var numero2= $("#numero2").val();
            var adicional2= $("#adicional2 option:selected").val();
            var numero3= $("#numero3").val();
            var direccion = $("#sel_dir_personalizada option:selected").val();
            var sel_servicios = $("#sel_servicios option:selected").val();
            var morosos=$("#deudores option:selected").val();


                pagination_start=$("#pagination_"+$pagination_id).data("start");
                pagination_end=$("#pagination_"+$pagination_id).data("end");                                              
                //color:blue;font-weight:900
            
            
                for (var i = 0; i <= 7; i++) {
                    
                    if(i!=$pagination_id){
                        $("#pagination_"+i).css("color","");
                        $("#pagination_"+i).css("font-weight","");        
                    }else{
                        $("#pagination_"+$pagination_id).css("color","blue");
                        $("#pagination_"+$pagination_id).css("font-weight","900");
                    }
                }

            //if(morosos!=""){
                if(columnasAgregadas){
                    tb.ajax.url( baseurl+'customers/load_morosos?id=<?=$_GET['id']?>&morosos='+morosos+"&estado="+estado+"&ciudad="+ciudadx+"&localidad="+localidad+"&barrio="+barrio+"&nomenclatura="+nomenclatura+"&numero1="+numero1+"&adicionauno="+adicionauno+"&numero2="+numero2+"&adicional2="+adicional2+"&numero3="+numero3+"&direccion="+direccion+"&sel_servicios="+sel_servicios+"&pagination_start="+pagination_start+"&pagination_end="+pagination_end).load();               
                }else{
                    nuevas_columnas();
                    $("option[value=100]").text("Todo");
                }
        
    }
    

     $("#div_direccion_personalizada").hide();
    function act_sel_dir_personalizada(){
        var sel_dir_personalizada= $("#sel_dir_personalizada option:selected").val();
        if(sel_dir_personalizada==""){
            $("#div_direccion_personalizada").hide();
        }else{
            $("#div_direccion_personalizada").show();
        }
    }

    var localidad_Yopal = new Array ("-","ComunaI","ComunaII","ComunaIII","ComunaIV","ComunaV","ComunaVI");
    var localidad_Monterrey = new Array ("-","Ninguno");
    var localidad_Villanueva = new Array ("-","SinLocalidad");
    var localidad_Mocoa = new Array ("-","Ninguna");
     cambia4();
                            //crear funcion que ejecute el cambio
                            function cambia4(){
                                var ciudad;
                                ciudad = $("#cmbCiudades option:selected").val();
                                //se verifica la seleccion dada
                                if(ciudad!=0 && ciudad!="-"){
                                    mis_opts=eval("localidad_"+ciudad);
                                    $("#cmbLocalidades").find('option').remove().end();
                                    for (var i = 0; i < mis_opts.length; i++) {
                                        $('#cmbLocalidades').append(new Option(mis_opts[i], mis_opts[i]));
                                    }
                                    
                                }else{
                                    $("#cmbLocalidades").find('option').remove().end();
                                    $('#cmbLocalidades').append(new Option("-", "-"));                                           
                                }
                                
                            }

                            var barrio_ComunaI = new Array ("-","Bello horizonte","Brisas del Cravo","El Batallon","El Centro","El Libertador","La Corocora","La Estrella bon Habitad","la Pradera","Luis Hernandez Vargas","San Martin","La Arboleda");
    var barrio_ComunaII = new Array ("-","El Triunfo","Comfacasanare","Conjunto Residencial Comfaboy","El Bicentenario","El Remanso","Juan Pablo","La Floresta","Los Andes","Los Helechos","Los Heroes","Maria Milena","Puerta Amarilla","Valle de los guarataros","Villa Benilda","Barcelona","Ciudad Jardín","Juan Hernando Urrego","Unión San Carlos","Laureles","Villa Natalia");
    var barrio_ComunaIII = new Array ("-","20 De Julio","Aerocivil","El Gavan","El Oasis","El Recuerdo","La Amistad","Maria Paz","Mastranto II","Provivienda");
    var barrio_ComunaIV = new Array ("-","1ro de Mayo","Araguaney","Vencedores","Casiquiare","El Bosque","La Campiña","La Esperanza","Las Palmeras","Paraíso","Villa Rocío");
    var barrio_ComunaV = new Array ("-","Ciudad del Carmen","Ciudadela San Jorge","Casimena I","Casimena II","Casimena III","El Laguito","El Nogal","El Portal","El Progreso","La Primavera","Los Almendros","Maranatha","Montecarlo","Nuevo Hábitat","Nuevo Hábitat II","Nuevo Milenio","San Mateo","Villa Nelly","Villa Vargas","Villas de Chavinave");
    var barrio_ComunaVI = new Array ("-","Villa Lucia","Villa Salomé 1","Xiruma","Llano Vargas","Bosques de Sirivana","Bosques de Guarataros","Villa David","Getsemaní","Villa Salomé 2","Las americas","Puente Raudal","Camoruco");
    var barrio_Ninguno = new Array ("-","Palmeras","Pradera","Esperanza","Villa del prado","Primavera","Nuevo milenio","San jose","Centro","Panorama","Alfonso lopez","Rivera de san andres","Rosales","Nuevo horizonte","La roca","Paomera","Floresta","Alcaravanes","Morichito","Villa santiago","15 de octubre","Glorieta","Olimpico","Brisas del tua","Guaira","Esteros","Villa del bosque","Villa mariana","Guadalupe","Leche miel","Lanceros","Paraiso","El caney","Villa daniela","Julia luz","Los esteros");
    var barrio_SinLocalidad = new Array ("-","Banquetas","Bella Vista","Bello Horizonte","Brisas del Agua Clara","Brisas del Upia I","Brisas del Upia II","Buenos Aires","Caricare","Centro","Ciudadela la Virgen","Comuneros","El Bosque","El Morichal","El Morichalito","El Portal","Fundadores","La floresta","Las Vegas","Mirador","Palmeras","Panorama","Paraiso I","Paraiso II","Progreso","Quintas del Camino Real","Villa Alejandra","Villa Campestre","Villa Estampa","Villa Luz","Villa del Palmar","Villa Mariana","Villa de los angeles");
    var barrio_Ninguna = new Array ("-","Venecia","Villa Caimaron","Villa Colombia","Villa Daniela","Villa del Norte","Villa del rio","Villa Diana","Villa Natalia","Villa Nueva","Palermo","Paraiso","Peñan","Pinos","Piñayaco","Placer","Plaza de Mercado","Prados","Progreso","Rumipamba","San Andres","San Agustin","San Fernando","San Francisco","La Loma","La union","Las Vegas","Libertador","Loma","Los Angeles","Miraflores","Modelo","Naranjito","Nueva Floresta","Obrero 1","Obrero 2","Olimpico","Pablo VI","Pablo VI bajo");
                            //crear funcion que ejecute el cambio
                            function cambia5(){
                                var localidad;
                                localidad = $("#cmbLocalidades option:selected").val();
                                //se verifica la seleccion dada
                                if(localidad!=0 && localidad!="-"){
                                    mis_opts=eval("barrio_"+localidad);
                                    //definimos cuantas obciones hay
                                    $("#cmbBarrios").find('option').remove().end();
                                    for (var i = 0; i < mis_opts.length; i++) {
                                        $('#cmbBarrios').append(new Option(mis_opts[i], mis_opts[i]));
                                    }
                                }else{
                                //resultado si no hay obciones
                                    $("#cmbBarrios").find('option').remove().end();
                                    $('#cmbBarrios').append(new Option("-", "-"));                                              
                                }
                                
                            }
</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete Customer</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this customer?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="customers/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Delete</button>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </div>
    </div>
</div>
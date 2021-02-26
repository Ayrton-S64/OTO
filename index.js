var testElement;
//modals
mdlOclusion = document.getElementsByClassName('oclusioner');

//botones
btnCerrarAlerta = document.getElementById('btnCloseAlert');

// Contenedor de tareas
taskContainer = document.getElementsByClassName('taskcontainer');

//elementos Alertas
msgAlerta = document.getElementById("mensajeAlerta");

// Inputs del form
tareasForm = document.getElementById('tareasForm');
txtnombreTarea = document.getElementById('txtNombreTarea');
dtFechaFin = document.getElementById('dtFechaFin');
timeInicio = document.getElementById('timeInicio');
timeFin = document.getElementById('timeFin');
cboCategoria = document.getElementById('cboCategoria');
tAreaDescripcion = document.getElementById('taDescripcion');

icons1 =  document.getElementsByClassName('bi-chevron-compact-right');
//constantes


//variables


//eventos
$('#taskManager').on('show.bs.collapse', (e)=>{
  e.target.parentElement.firstElementChild.firstElementChild.firstElementChild.firstElementChild.classList.replace('bi-chevron-compact-right', 'bi-chevron-compact-down');
});
$('#taskManager').on('hide.bs.collapse', (e)=>{
  e.target.parentElement.firstElementChild.firstElementChild.firstElementChild.firstElementChild.classList.replace('bi-chevron-compact-down', 'bi-chevron-compact-right');
});
$(document).on('click', '.ieliminar',function(e){
  console.log(e);
  deletedElement = e.target;
  while (!deletedElement.classList.contains('vieweritem')){
    deletedElement = deletedElement.parentElement;
  }
  testElement = deletedElement;
  eliminarTarea(deletedElement);
});


btnCerrarAlerta.addEventListener('click', cerrarAlerta);

cboCategoria.addEventListener('change', changeCbo);

//funciones
async function agregarTarea(){
  console.log("agregando...");
  nombre = txtnombreTarea.value;
  fecha = dtFechaFin.value;
  tiempoInicio = timeInicio.value;
  tiempoFin = timeFin.value;
  categoria = cboCategoria.selectedOptions[0].innerText;
  descripcion = procesarValueTextArea(tAreaDescripcion.value);
  valueAsTimeInicio = timeInicio.valueAsDate;
  valueAsTimeFin = timeFin.valueAsDate;
  horas =valueAsTimeFin.getUTCHours() - valueAsTimeInicio.getUTCHours();
  minutos = valueAsTimeFin.getUTCMinutes() - valueAsTimeInicio.getUTCMinutes();
  strHoras = (horas>9)?`${horas}`:`0${horas}`;
  strMinutos = (minutos>9)?`${minutos}`:`0${minutos}`;
  txtDuracion = strHoras + ":" + strMinutos;
  // verficaciones;


  if(verificarText(txtnombreTarea) * verificarText(dtFechaFin) * verificarText(timeInicio) * verificarText(timeFin) * verificarCbo(cboCategoria) *  verificarText(tAreaDescripcion)){
    $.ajax({
      type: "POST",
      url: "./agregarTarea.php",
      data: "nombreTarea="+nombre+
            "&fechaInicio="+fecha+
            "&horaInicio="+tiempoInicio+
            "&duracion="+txtDuracion+
            "&descripcion="+descripcion+
            "&forzar=0",
      success: function (data) {
        objeto = JSON.parse(data);
        if(objeto.success==1){
          var tmpl = '<div class="alert alert-success alert-dismissable">'+
					'<button class="close" data-dismiss="alert">&times;</button>'+
					objeto.mensaje +
					'</div>';
          crearComponente(createJSON(nombre,fecha,tiempoInicio,tiempoFin,categoria,descripcion,objeto.total));
        }else if(objeto.success==0){
          var tmpl = '<div class="alert alert-danger alert-dismissable">'+
					'<button class="close" data-dismiss="alert">&times;</button>'+
					objeto.mensaje +
					'</div>';
        }else if(objeto.response==2){
          response = await lanzarAlerta(objeto.mensaje, 2, null);
          if(response){
            $.ajax({
              type: "POST",
              url: "./agregarTarea.php",
              data: "nombreTarea="+nombre+
                    "&fechaInicio="+fecha+
                    "&horaInicio="+tiempoInicio+
                    "&duracion="+txtDuracion+
                    "&descripcion="+descripcion+
                    "&forzar=1",
              success: function (response) {
                objeto = JSON.parse(data);
                if(objeto.success==1){
                  var tmpl = '<div class="alert alert-success alert-dismissable">'+
                  '<button class="close" data-dismiss="alert">&times;</button>'+
                  objeto.mensaje +
                  '</div>';
                  crearComponente(createJSON(nombre,fecha,tiempoInicio,tiempoFin,categoria,descripcion,objeto.total));
                }else if(objeto.success==0){
                  var tmpl = '<div class="alert alert-danger alert-dismissable">'+
                  '<button class="close" data-dismiss="alert">&times;</button>'+
                  objeto.mensaje +
                  '</div>';
                }
              }
            });
          }
        }
        
        $('#tareasForm').append(tmpl);

        setTimeout(function(){
          $('.alert').addClass('on');
        },200);	

        setTimeout(function(){
          $('.alert').remove();
        },1000);
      },
      error: function (data){
        console.log("Surgió un error");
      }
      
    });
    tareasForm.reset();  
  }
}

async function eliminarTarea(tareaItem){
  response = await lanzarAlerta("seguro que quieres eliminar esta tarea!",1,tareaItem);
  console.log("respuesta");
  console.log(response);
  if(response){
    $.ajax({
      type: "POST",
      url: "./borrarTarea.php",
      data: "tareaID="+parseInt(tareaItem.id),
      success: function (data) {
        objeto = JSON.parse(data);
        if(objeto.success==1){
          var tmpl = '<div class="alert alert-success alert-dismissable">'+
					'<button class="close" data-dismiss="alert">&times;</button>'+
					objeto.mensaje +
					'</div>';
          tareaItem.remove();
        }else if(objeto.success==0){
          var tmpl = '<div class="alert alert-danger alert-dismissable">'+
					'<button class="close" data-dismiss="alert">&times;</button>'+
					objeto.mensaje +
					'</div>';
        }
        $('#taskManager').append(tmpl);

        setTimeout(function(){
          $('.alert').addClass('on');
        },200);	

        setTimeout(function(){
          $('.alert').remove();
        },1000);
      },
      error: function (data){
        console.log("Surgió un error");
      }
    });
  }
} 

function createJSON(nombre, fecha, tInicio, tFin, categoria, descripcion,idTarea){
  tf = fecha.split('-');
  obj = {
    "nombreTarea": nombre,
    "fechaFin" : `${tf[2]}/${tf[1]}/${tf[0]}`,
    "tiempoInicio" : tInicio,
    "tiempoFin" : tFin,
    "categoria" : categoria,
    "descripcion" : descripcion,
    "idTarea": idTarea
  }

  console.log(obj);

  return obj;
}

function crearComponente(tarea){
  tareasForm.reset();
  eHTML = taskContainer[0]
  let nElem = eHTML.childElementCount;
  eHTML.innerHTML += `
  <div class="vieweritem" id="${tarea.idTarea + 1}">
    <div class="taskhead">
      <div class="taskhead__first">
        <a data-toggle="collapse" href="#taskDescription${tarea.idTarea + 1}" role="button" aria-expanded="false" aria-controls="taskbody"><i class="icon-collapse bi bi-chevron-compact-right"></i></a>
        <p class="taskhead__name">${tarea.nombreTarea}</p>
      </div>
      <div class="taskhead__icons">
        <i class="bi bi-app"></i>
        <i class="ieliminar bi bi-trash-fill"></i>
      </div>
    </div>
    <div class="taskbody collapse" id="taskDescription${tarea.idTarea + 1}" data-parent="#taskManager">
      <p>${tarea.categoria}</p>
      <div>
        <p>${tarea.descripcion}</p>
      </div>
      <p>Fecha programada: <span>${tarea.fechaFin}</span></p>
      <p>De <span>${tarea.tiempoInicio}</span> a <span>${tarea.tiempoFin}</span></p>
    </div>
  </div>
  `
}

function verificarCbo(cboElement){
  if(cboElement.selectedIndex==0){
      cboElement.classList.add('bordeRojo');
      document.getElementById('advCbo').classList.remove('oculto');
      return 0
  }else{
    return 1;
  }
}

function verificarText(inputTextElement){
  if(inputTextElement.value!=""){
    if(inputTextElement.classList.contains('bordeRojo')){
      inputTextElement.classList.remove('bordeRojo');
    }
    return 1;
  }else{
    inputTextElement.classList.add('bordeRojo');
    return 0;
  }
}

function changeCbo(e){
  let htmlE = e.target;
  if(htmlE.selectedIndex!=0){
    if(htmlE.classList.contains('bordeRojo')){
      htmlE.classList.remove('bordeRojo');
      if (!document.getElementById('advCbo').classList.contains('oculto'))
      {document.getElementById('advCbo').classList.add('oculto');}
    }
  }
}

function lanzarAlerta(mensaje, tipo, objeto){
  switch(tipo){
    default:
      msgAlerta.innerText = mensaje;
      mdlOclusion[0].classList.remove('oculto');
      return new Promise((resolve,reject)=>{
        $(".buttonAlert").click(function (e) { 
          e.preventDefault();
          console.log(e);
          if(parseInt(e.target.dataset.option)){
            resolve(true);
          }else{resolve(false)}
          cerrarAlerta();
        });
      });
  }
}

function operacionAlerta(tipo,operacion,callback){

}

function procesarValueTextArea(jsText){
  let htmlText = "";
  lineas = jsText.split('\n');
  for(let i = 0; i<lineas.length;i++){
    if(i!=lineas.length-1){
      htmlText+= lineas[i]+"<br>";
    }else{
      htmlText+= lineas[i];
    }
  }
  return htmlText;
}

function cerrarAlerta(e){
  console.log('cerrando...');
  for (const oclusioner of mdlOclusion) {
    if (!oclusioner.classList.contains('oculto')){
      oclusioner.classList.add('oculto')
    }
  }
}
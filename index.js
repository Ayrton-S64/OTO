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
btnCerrarAlerta.addEventListener('click', cerrarAlerta);

cboCategoria.addEventListener('change', changeCbo);

for (const chevron of icons1) {
  chevron.addEventListener('click', function(e){
    let iconsClasses = ["bi-chevron-compact-right","bi-chevron-compact-down"]
    if(e.target.classList[1] == iconsClasses[0]){
      e.target.classList.replace(iconsClasses[0],iconsClasses[1]);
    }
    else if(e.target.classList[1] == iconsClasses[1]){
      e.target.classList.replace(iconsClasses[1],iconsClasses[0]);
    }
    console.log("Funciona!!!!")
  });
}

//funciones
function agregarTarea(){
  console.log("agregando...");
  nombre = txtnombreTarea.value;
  tf = dtFechaFin.value.split('-');
  fecha = `${tf[2]}/${tf[1]}/${tf[0]}`;
  tiempoInicio = timeInicio.value.toString();
  tiempoFin = timeFin.value.toString();
  categoria = cboCategoria.selectedOptions[0].innerText;
  descripcion = procesarValueTextArea(tAreaDescripcion.value);
  
  // verficaciones;


  if(verificarText(txtnombreTarea) * verificarText(dtFechaFin) * verificarText(timeInicio) * verificarText(timeFin) * verificarCbo(cboCategoria) *  verificarText(tAreaDescripcion)){
    crearComponente(createJSON(nombre,fecha,tiempoInicio,tiempoFin,categoria,descripcion));
    tareasForm.reset();  
  }
}

function createJSON(nombre, fecha, tInicio, tFin, categoria, descripcion){
  obj = {
    "nombreTarea": nombre,
    "fechaFin" : fecha,
    "tiempoInicio" : tInicio,
    "tiempoFin" : tFin,
    "categoria" : categoria,
    "descripcion" : descripcion
  }

  console.log(obj);

  return obj;
}

function crearComponente(tarea){
  tareasForm.reset();
  eHTML = taskContainer[0]
  let nElem = eHTML.childElementCount;
  eHTML.innerHTML += `
  <div class="vieweritem">
            <div class="taskhead">
              <div class="taskhead__first">
                <a data-toggle="collapse" href="#taskDescription${nElem+1}" role="button" aria-expanded="false" aria-controls="taskbody"><i class="bi bi-chevron-compact-right"></i></a>
                <p class="taskhead__name">${tarea.nombreTarea}</p>
              </div>
              <div class="taskhead__icons">
                <i class="bi bi-app"></i>
                <i class="ieliminar bi bi-trash-fill"></i>
              </div>
            </div>
            <div class="taskbody collapse" id="taskDescription${nElem+1}" data-parent="#taskManager">
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
  console.log(cboElement.selectedIndex)
  if(cboElement.selectedIndex==0){
      console.log("Cuidado!!!")
      cboElement.classList.add('bordeRojo');
      document.getElementById('advCbo').classList.remove('oculto');
      return 0
  }else{
    return 1;
  }
}

function verificarText(inputTextElement){
  console.log(inputTextElement);
  if(inputTextElement.value!=""){
    if(inputTextElement.classList.contains('bordeRojo')){
      inputTextElement.classList.remove('bordeRojo');
    }
    console.log("valido");
    return 1;
  }else{
    inputTextElement.classList.add('bordeRojo');
    console.log("invalido");
    return 0;
  }
}

function changeCbo(e){
  let htmlE = e.target;
  console.log(htmlE);
  if(htmlE.selectedIndex!=0){
    if(htmlE.classList.contains('bordeRojo')){
      console.log(e.target)
      htmlE.classList.remove('bordeRojo');
      if (!document.getElementById('advCbo').classList.contains('oculto'))
      {document.getElementById('advCbo').classList.add('oculto');}
    }
  }
}

function lanzarAlerta(){

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
}

function cerrarAlerta(e){
  console.log("Funciona");
  console.log(e);
  for (const oclusioner of mdlOclusion) {
    if (!oclusioner.classList.contains('oculto')){
      oclusioner.classList.add('oculto')
    }
  }
}
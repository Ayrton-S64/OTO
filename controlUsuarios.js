var prueba = 0;

function logearUsuario(){
  let param_opcion='logear';
  let param_user = $('#txtUsuario').val();
  let param_clave = $('#txtClave').val();
  $.ajax({
    type: "POST",
    url: "./logearUsuario.php",
    data: 'param_opcion='+param_opcion+
          '&param_usuario='+param_user+
          '&param_clave='+param_clave,
    success: function (data) {
      objeto = JSON.parse(data);
      prueba = data;
    },
    error: function(data){
      console.log("Surgió un error");
    }
  });
}

function registrarUsuario(){
  
}
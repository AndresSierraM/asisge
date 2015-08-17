<!DOCTYPE html>
<html>
  <head>
    <title>Asisge S.A.</title>
    {!! Html::style('css/principal.css'); !!}
    {!! Html::style('assets/guriddosuito/css/jquery-ui.css'); !!}
    {!! Html::style('assets/guriddosuito/css/trirand/ui.jqgrid.css'); !!}
    {!! Html::style('assets/guriddosuito/css/ui.multiselect.css'); !!}
    <style type="text">
        html, body {
        margin: 0;			/* Remove body margin/padding */
    	   padding: 0;
        overflow: hidden;	/* Remove scroll bars on browser window */
        font-size: 75%;
        }
		
    </style>
    {!! Html::script('assets/guriddosuito/js/jquery.min.js'); !!}
    {!! Html::script('assets/guriddosuito/js/trirand/i18n/grid.locale-en.js'); !!}
    {!! Html::script('assets/guriddosuito/js/trirand/jquery.jqGrid.min.js'); !!}
    <script>        
      $.jgrid.no_legacy_api = true;
      $.jgrid.useJSON = true;
      $.jgrid.defaults.width = "1150";
      $.jgrid.defaults.height = "300";
    </script>
     {!! Html::script('assets/guriddosuito/js/jquery-ui.min.js'); !!}
  </head>
  <body id="body">
      <nav>
        <ul>
          <li><center>Logo<center></li>
          <li><center><a href="users" >
                <img src="images/iconosmenu/usuarios.png" width="48" title="Usuarios" />
              </a></center></li>
              <li><center><a href="paquete" >
                <img src="images/iconosmenu/Opciones%20Seguridad.png" width="48" title="Paquetes del menu" />
              </a></center></li>
              <li><center><a href="opcion">
                <img src="images/iconosmenu/Opciones%20Generales.png" width="48" title="Opciones del menu" />
              </a></center></li>
              <li><center><a href="pais">
                <img src="images/iconosmenu/Paises.png" width="48" title="Paises" />
              </a></center></li>
              <li><center><a href="departamento">
                <img src="images/iconosmenu/Paises.png" width="48" title="Departamentos" />
              </a></center></li>
              <li><center><a href="ciudad">
                <img src="images/iconosmenu/Ciudades.png" width="48" title="Ciudades" />
              </a></center></li>
              <li><center><a href="tipoidentificacion">
                <img src="images/iconosmenu/Tipos%20Identificacion.png" width="48" title="Tipos de Identificacion" />
              </a></center></li>
              <li><center><a href="compania">
                <img src="images/iconosmenu/Companias.png" width="48" title="Compañías" />
              </a></center></li>
              <li><center><a href="frecuenciamedicion">
                <img src="images/iconosmenu/Frecuencia%20Medicion.png" width="48" title="Frecuencias de Medicion" />
              </a></center></li>
              <li><center><a href="proceso">
                <img src="images/iconosmenu/Procesos.png" width="48" title="Procesos" />
              </a></center></li>
              <li><center><a href="tercero">
                <img src="images/iconosmenu/Terceros.png" width="48" title="Terceros" />
              </a></center></li>
              <li><center><a href="">
                <img src="images/iconosmenu/salir-01.png" width="48" title="Salir" />
              </a></center></li>
            
            </ul>
        </nav>
      <div id="contenedor">
          @yield('titulo')
      </div>
      <div id="contenedor-fin">
          <div id="pantalla">
             @yield('content') 
          </div>
      </div>
      
      <div id="footer">
          <p>Sistema de gestion documental... Todos los derechos reservados</p>
      </div>
   </body>
</html>

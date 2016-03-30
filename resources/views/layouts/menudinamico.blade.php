<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	@yield('clases')
	{!!Html::style('CSS/menu.css'); !!}
	{!!Html::style('assets/bootstrap-v3.3.5/css/bootstrap.min.css'); !!}
	
	{!!Html::script('assets/bootstrap-v3.3.5/js/bootstrap.min.js'); !!}
	{!!Html::script('js/menu.js'); !!}


	<title>Sisoft</title>
</head>
<body id='body' onclick="cierraMenu(1);">

	<div id="header">
		<div id="container">
		<div class="barramenu">
			
		<?php

			// -------------------------------------------
			// P A Q U E T E S   S E G U N   E L   R O L 
			// D E L   U S U A R I O 
			// -------------------------------------------
			$paquetes = DB::select(
			    'SELECT P.idPaquete,
				    P.nombrePaquete,
				    P.iconoPaquete
				FROM users U
				left join rol R
				on U.Rol_idRol = R.idRol
				left join rolopcion RO
				on U.Rol_idRol = RO.Rol_idRol
				left join opcion O
				on RO.Opcion_idOpcion = O.idOpcion
				left join paquete P
				on O.Paquete_idPaquete = P.idPaquete
				where U.id = '.\Session::get("idUsuario").'
				GROUP BY P.idPaquete
				ORDER BY P.ordenPaquete, P.nombrePaquete;');
			
				
				foreach ($paquetes as $idP => $datosP) 
				{
					
					// -------------------------------------------
					// O P C I O N E S   S E G U N   E L   R O L 
					// D E L   U S U A R I O 
					// -------------------------------------------
					$opciones = DB::select(
					    'SELECT O.idOpcion,
						    P.nombrePaquete,
						    P.iconoPaquete,
						    O.nombreOpcion,
						    O.nombreCortoOpcion,
						    O.iconoOpcion,
						    O.rutaOpcion
						FROM users U
						left join rol R
						on U.Rol_idRol = R.idRol
						left join rolopcion RO
						on U.Rol_idRol = RO.Rol_idRol
						left join opcion O
						on RO.Opcion_idOpcion = O.idOpcion
						left join paquete P
						on O.Paquete_idPaquete = P.idPaquete
						where 	U.id = '.\Session::get("idUsuario").' and
						 		O.Paquete_idPaquete = '.$datosP->idPaquete.'
						order by O.ordenOpcion, O.nombreOpcion;');

					echo 
					'<div id="menu'.$datosP->idPaquete.'" class="menu">
						<img src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$datosP->iconoPaquete.'" title="'.$datosP->nombrePaquete.'" style="width:40px;" onclick="abreMenu('.$datosP->idPaquete.', '.count($opciones).');">
					</div>';

					// echo 
					// '<div id="arrow'.$datosP->idPaquete.'" class="arrow" style="margin-left: 25px; width:15px;">
					// </div>';

					echo 
					'<div id="gridbox'.$datosP->idPaquete.'" class="gridbox" style="margin-left: 15px;">
						<div id="innergrid'.$datosP->idPaquete.'" class="innergrid">
							<ul id="icons'.$datosP->idPaquete.'" class="icons">';
				
					foreach ($opciones as $idO => $datosO) 
					{
					
						echo 
						'
						<li>
							<a href="http://'.$_SERVER["HTTP_HOST"].'/'.$datosO->rutaOpcion.'"> <img src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$datosO->iconoOpcion.'" title="'.$datosO->nombreOpcion.'" style="width:48px; height:48px;"><br>
								'.$datosO->nombreCortoOpcion.'
							</a>
						</li>';
					}
					echo 
					'		</ul>
						</div>
					</div>';
				}

				echo 
				'<div id="menuuser1" class="menu" style="float: right; width: 200px;">
		            <div>
        		         '.\Session::get("nombreUsuario").'

                		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="auth/logout"> <img src="http://'.$_SERVER["HTTP_HOST"].'/images/iconosmenu/salir.png" title="Salir de SiSoft" style="width:32px; height:32px;">
						</a>
					</div>
				</div>

			</div>';
		?>



	<div id="contenedor" class="panel panel-primary">
	  <div   class="panel panel-heading">
	    @yield('titulo')
	  </div>
	  <div  id="contenedor-fin" class="panel-body">
	    @yield('content') 
	  </div>
	</div>


	<div id="footer">
	    <p>SiSoft... ASISGE S.A.S. - Todos los derechos reservados</p>
	</div>
</body>
</html>
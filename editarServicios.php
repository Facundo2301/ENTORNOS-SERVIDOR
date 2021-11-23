<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php require('utiles/conexion.php') ?>
    <?php require('utiles/vehiculos.php') ?>

	<?php
        $puerto = 1234;

        session_start();
		$idUsuario = $_SESSION['usuario']['idUsuario'];
        $vehiculos = $_SESSION['vehiculos'];
        $idVehiculo = $_POST['idVehiculo'];


    
		$entra = false;
        $reload = false;

		$conDb = connect();

		if($conDb!=null){
			
			/*
			* Query para actualizar el coche
			*
			*/

			if(isset($_POST['Matricula']) && isset($_POST['Marca']) && isset($_POST['Modelo'])){
				$matricula = $_POST['Matricula'];
				$marca = $_POST['Marca'];
				$modelo = $_POST['Modelo'];

                if(updateVeh($matricula,$marca,$modelo,$idVehiculo,$conDb)){
                    foreach ($vehiculos as $key => $value) {
                
                        if($vehiculos[$key][1]==$idVehiculo){
                           $_SESSION['vehiculos'][$key][2] = $marca;
                           $_SESSION['vehiculos'][$key][4] = $modelo;
                           $_SESSION['vehiculos'][$key][3] = $matricula;
                        }
                    }
                    $entra = true;
                }
			}


			/*
			*
			* Query para actualizar o insertar servicios
			*
			*/
			$sqlServicios = "SELECT * from listaservicios WHERE idVehiculo='$idVehiculo'";
			$queryServicios = mysqli_query($conDb,$sqlServicios);
			/*
			*
			* Actualización de servicios
			*
			*/
			if(isset($_POST['fechaAv'])){
	            $fechaAveria = $_POST['fechaAv'];
	            $sqlUpdateAv = "UPDATE listaservicios SET Averia_motor='$fechaAveria' where idVehiculo='$idVehiculo'";
	            if(!mysqli_query($conDb,$sqlUpdateAv)){
                    echo "error";
	            }
	            
        	}

        	if(isset($_POST['fechaPin'])){
	            $fechaPinchazo = $_POST['fechaPin'];
	            $sqlUpdatePin = "UPDATE listaservicios SET Pinchazo='$fechaPinchazo' where idVehiculo='$idVehiculo'";
	            if(!mysqli_query($conDb,$sqlUpdatePin)){
                    echo "error";
                }
        	}
        	if(isset($_POST['fechaAc'])){
	            $fechaAceite = $_POST['fechaAc'];
	            $sqlUpdateAc = "UPDATE listaservicios SET Cambio_aceite='$fechaAceite' where idVehiculo='$idVehiculo'";
	            if(!mysqli_query($conDb,$sqlUpdateAc)){
                    echo "error";
                }
        	}
		}
	?>

	<link rel="stylesheet" href="assets/css/stylesGen.css">
	<title>Document</title>
</head>
<body>
	<div class="header">
        <h2 class="titulo"><a href="vehIndex.php?idUsuario=" style="text-decoration: none; color: white;">CheckUrCar</a></h2>
    </div>

	<?php if($entra){ ?>

        <div class="mensaje">
            <i class="ico">&#10004; Se han producido los cambios</i>
            <button id="botonMsg">Aceptar</button>
            <script>
                document.querySelector('#botonMsg').onclick = function(){
                    document.querySelector('.mensaje').parentNode.removeChild(document.querySelector('.mensaje'));
                }
            </script>

        </div>
    <?php } ?>


    <div class="container">
        <div class="box1">
            <div class="usuario">

                <strong>Nombre: </strong><?= $_SESSION["usuario"]["nombre"]?>
                                    
            </div>
             

            <div class="datos">
                <div >
                    <h2 style="padding: 10px;">Vehículo</h2>
                </div>

                <div class="">
                    <form method="post">
                        <div>
                            <label>Matricula: </label>
                            <input type="text" name="Matricula" pattern="\d{4}[A-Z]{3}" placeholder="0000XXX"/>
                        </div>
                        <br>
                        <div>
                            <label>Marca: </label>
                            <input type="text" name="Marca" placeholder="Opel" required/>    
                        </div>
                        <br>
                        <div>
                            <label>Modelo: </label>
                            <input type="text" name="Modelo"placeholder="Corsa" required/>    
                        </div>
                        <br>
                        <button type="submit" value="Guardar" class="boton">Guardar</button>
                        <input type="hidden" name="idVehiculo" value="<?php echo $idVehiculo ?>">
                    </form>
                </div>
            </div>
        </div> <!--Fin box1-->


        <div class="box2">
                
                <div class="listaVehiculo">
                    <h2>Servicios</h2>
                </div>

                <?php if($queryServicios){ ?>

                    <?php if(mysqli_num_rows($queryServicios)>0){ ?>
                        <table class="tabla">
                            <tr>
                                <th>Servicio</th>
                                <th>Fecha</th>
                                <th style="background-color: transparent;"></th>
                            </tr>
                            <?php while($row = mysqli_fetch_assoc($queryServicios)){ ?>
                                <tr>
                                    <td>Averia de motor</td>
                                    <td><?php echo date('d/m/Y', strtotime($row["Averia_motor"])) ?></td>
                                    <td style="background-color: transparent;box-shadow: 0px 0px 0px 0px;">
                                        <form method="post">
                                            <button class="boton" id="botonAv">Editar</button>
                                        </form>
                                        <form method="post">
                                            <input type="hidden" id="fechaAv" name="fechaAv">
                                            <input type="hidden" name="idVehiculo" value="<?php echo $idVehiculo ?>">
                                            <button class="boton" type="submit" hidden id="guardarAv">Guardar</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pinchazo</td>
                                    <td><?php echo date('d/m/Y', strtotime($row["Pinchazo"])) ?></td>
                                    <td style="background-color: transparent;box-shadow: 0px 0px 0px 0px;">
                                        <form method="post">
                                            <button class="boton" id="botonPin">Editar</button>
                                        </form>
                                        <form method="post">
                                            <input type="hidden" id="fechaPin" name="fechaPin">
                                            <button class="boton" type="submit" hidden id="guardarPin" onclick="window.reload()">Guardar</button>
                                            <input type="hidden" name="idVehiculo" value="<?php echo $idVehiculo ?>">
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Cambio de aceite</td>
                                    <td><?php echo date('d/m/Y', strtotime($row["Cambio_aceite"])) ?></td>
                                    <td style="background-color: transparent;box-shadow: 0px 0px 0px 0px;">
                                        <form method="post">
                                            <button class="boton" id="botonAc">Editar</button>
                                        </form>
                                        <form method="post">
                                            <input  type="hidden" id="fechaAc" name="fechaAc">
                                            <button class="boton"  type="submit" hidden id="guardarAc" onclick="window.reload()">Guardar</button>
                                            <input type="hidden" name="idVehiculo" value="<?php echo $idVehiculo ?>">   
                                        </form>
                                        
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    <?php }else if(mysqli_num_rows($queryServicios)==0){?> <!--Cuando el coche no tiene servicios-->
                    	<h2>Servicios no asociados al vehículo</h2>
                        <br>
                        <form action="addServicios.php" method="post">
                            <button type="submit" class="boton">Añadir</button>
                            <input type="hidden" name="idVehiculo" value="<?php echo $idVehiculo ?>">
                        </form>
                    <?php } ?>

                <?php } ?>

                
            
        </div><!--Fin box2-->
    </div><!--Fin Container-->

    <script>
        var boton1 = document.querySelector('#botonAv');
        var boton2 = document.querySelector('#botonPin');
        var boton3 = document.querySelector('#botonAc');
    
        boton1.onclick = function(e){
            e.preventDefault();
            document.querySelector('#fechaAv').setAttribute('type','date');
            document.querySelector('#guardarAv').removeAttribute('hidden');
            boton1.setAttribute('hidden','hidden');

        }

        boton2.onclick = function(e){
            e.preventDefault();
            document.querySelector('#fechaPin').setAttribute('type','date');
            document.querySelector('#guardarPin').removeAttribute('hidden');
            boton2.setAttribute('hidden','hidden');
        }

        boton3.onclick = function(e){
            e.preventDefault();
            document.querySelector('#fechaAc').setAttribute('type','date');
            document.querySelector('#guardarAc').removeAttribute('hidden');
            boton3.setAttribute('hidden','hidden');
        }
    </script>
    <div class="footer"><h4>Contáctanos &copy;CheckUrCar</h4></div>

</body>
</html>
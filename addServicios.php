<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php require('utiles/conexion.php') ?>

	<?php 


		$idVehiculo = $_POST['idVehiculo'];
		$entra = false;


		$conDb = connect();

		if($conDb!=null){

			if(isset($_POST['fechaAv']) && isset($_POST['fechaPin']) && isset($_POST['fechaAc'])){
				$fechaAv = $_POST['fechaAv'];
				$fechaPin = $_POST['fechaPin'];
				$fechaAc = $_POST['fechaAc'];

				$sqlInsertSer = "INSERT INTO listaservicios VALUES ('','$idVehiculo','$fechaAv','$fechaPin','$fechaAc')";

				if(mysqli_query($conDb,$sqlInsertSer)){
					$entra = true;
				}else{
					echo 'Fallo en la consulta';
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
    		<div class="aniadir">
                <h2>Agregar servicios al coche</h2>
            </div>
		    
            
			<form method="post">
				<table class="tabla2">
					<tr>
						<td><label for="fechaAv">Fecha Averia de motor</label></td>
						<td><input type="date" name="fechaAv" required></td>	
					</tr>
					<tr>
						<td><label for="fechaPin">Fecha pinchazo</label></td>
						<td><input type="date" name="fechaPin" required></td>
					</tr>
					<tr>
						<td><label for="fechaAc">Fecha Aceite</label></td>
						<td><input type="date" name="fechaAc" required></td>
					</tr>
				</table>

				<button class="botonserv" type="submit">Enviar</button>
				<input type="hidden" name="idVehiculo" value="<?php echo $idVehiculo ?>">

			</form>
			
		</div>
	</div>

	<div class="footer"><h4>Contáctanos &copy;CheckUrCar</h4></div>
</body>
</html>
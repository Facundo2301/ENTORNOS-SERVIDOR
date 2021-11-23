<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php require('utiles/conexion.php') ?>
	<?php require('utiles/usuario.php') ?>
	<?php 

		$conDb = connect();
		$cabecera = false;

		if($conDb!=null){

			$loginRep = false;
			$passDistintas = false;
			$entra = false;

			if(!empty($_POST['enviar'])){
				$login = $_POST['login'];
				$nombre = $_POST['nombre'];
				$newPass = $_POST['newPass'];
				$repPass = $_POST['repPass'];


				/*
				*
				* Compruebo que el login no exista
				*
				*/
				$allData = allDatafromLogin($login,$conDb);
				if($allData!=null){
					$loginRep = true;
				}

				/*
				*
				* Si el login no está repetido compruebo las contraseñas
				*
				*/

				if(!$loginRep){ 

					if($newPass==$repPass){

						/*
						*
						* Ya que he comprobado todos los casos posibles, hago el insert
						*
						*/
						$fechaActual = date('Y-m-d');
						$passHasheada = password_hash($newPass, PASSWORD_DEFAULT);
						$sqlInsertUsu = "INSERT INTO datosusuario VALUES ('','$nombre','$login','$fechaActual','0','$passHasheada','0')";
						if(mysqli_query($conDb,$sqlInsertUsu)){
							$entra = true;
						}else{
							$error = true;
						}

					}else{
						$passDistintas = true;
					}

				}
			}



		}
	?>

	<link rel="stylesheet" href="assets/css/stylesLog.css">	
	<link rel="stylesheet" href="assets/css/stylesGen.css">
	
</head> 
<body>
	<div class="header">
        <h2 class="titulo"><a href="index.php" style="text-decoration: none; color: white;">CheckUrCar</a></h2>
    </div>

	

	<?php if($loginRep){ ?>
		<div class="mensajeError">
			<i class="ico" id="parr">&#9747; El login indicado ya existe</i> 
            <script>
            	console.log('Llego al login');
                window.setTimeout(function(){
                    document.querySelector('.mensajeError').removeChild(document.querySelector('#parr'));
                },3000);
            </script>
        </div>
	<?php }else if($passDistintas){ ?>
		<div class="mensajeError">
			<i class="ico" id="parr">&#9747; Las contraseñas no coinciden</i>
            <script>
                window.setTimeout(function(){
                    document.querySelector('.mensajeError').removeChild(document.querySelector('#pass'));
                },3000);
            </script>
        </div>
	<?php }else if($entra){ ?>
		<?php $cabecera = true; ?>
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
		
		<form method="post">
			<h2 style="color: white; padding-bottom: 20px;">Registro</h2>
			<div class="input-container">
				<input type="text" name="login" required >
				<label for="login">Introduzca su usuario:</label>
			</div>	
			<div class="input-container">
				<input type="text" name="nombre" required>
				<label for="nombre">Introduzca su nombre:</label>
			</div>	
			<div class="input-container">
				<input type="text" name="newPass" required>
				<label for="newPass">Introduzca una contraseña:</label>
			</div>	
			<div class="input-container">
				<input type="text" name="repPass" required>
				<label for="repPass">Repita la contraseña:</label>
			</div>
			<input type="hidden" name="enviar" value="x">
			<button type="submit" class="boton">Enviar</button>
		</form>
	</div>

    <div class="footer"><h4>Contáctanos &copy;CheckUrCar</h4></div>

</body>
</html>
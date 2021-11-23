<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php require('utiles/conexion.php') ?>
	<?php require('utiles/usuario.php') ?>

	<?php 
		session_start();
		$usuario = $_SESSION['usuario'];
		$idUsuario = $_SESSION['usuario']['idUsuario'];

		$primeraCondicion = false;
		$repetidaNueva = false;
		$nickRep = false;
		$entra = false;

		if(isset($_POST['nombreUsu'])&&isset($_POST['nuevaCon'])&&isset($_POST['rNuevaCon'])){
				
			$nuevoUsu = $_POST['nombreUsu'];
			$nuevaPass = $_POST['nuevaCon'];			
			$rNuevaPass = $_POST['rNuevaCon'];			

			if($nuevaPass!=$rNuevaPass){
				$primeraCondicion = true;
				$repetidaNueva = true;
			}else{
				$conDb = connect();

	 			if($conDb!=null){

					if(allDatafromLogin($nuevoUsu,$conDb)!=null){
						$primeraCondicion = true;
						$nickRep = true;
					}

					if(!$nickRep){
						$passHasheada = password_hash($nuevaPass, PASSWORD_DEFAULT);
						$sqlUpdate = "UPDATE datosusuario SET login='$nuevoUsu',password='$passHasheada' WHERE idUsuario = '$idUsuario'";
						if(mysqli_query($conDb,$sqlUpdate)){
							$_SESSION['usuario']['login'] = $nuevoUsu;
							$_SESSION['usuario']['password'] = $nuevaPass;
		             		$entra = true; 
				    	}
					}

	 			} //Null de db 

 			}//Las pass coinciden
 		}


	?>

	<link rel="stylesheet" href="assets/css/stylesGen.css">
	<title>Document</title>
</head>
<body>

	<div class="header">
        <h2 class="titulo"><a href="vehIndex.php?idUsuario=" style="text-decoration: none; color: white;">CheckUrCar</a></h2>
    </div>

	<?php if($primeraCondicion){ ?>
		<div class="mensajeError">
			<?php if($repetidaNueva){ ?>
				<i class="ico" id="parr">&#9747; Debe introducir las mismas contraseñas</i>
			<?php }else if($nickRep){ ?>
				<i class="ico" id="parr">&#9747; Nickname no disponible</i>
			<?php } ?>
			<script>
				console.log('he llegado');
				window.setTimeout(function(){
					document.querySelector('.mensajeError').removeChild(document.querySelector('#parr'));
				},3000);
			</script>
		</div>

	<?php }else if($entra){ ?>
        <div class="mensaje">
        	<i class="ico">&#10004; Se han producido los cambios</i>
            <button id="botonMsg">Aceptar</button>
            <script>
                document.querySelector('#botonMsg').onclick = function(){
                    document.querySelector('.mensaje').parentNode.removeChild(document.querySelector('.mensaje'));
                }
            </script>

        </div>
    <?php }?>


	<div class="container">
    	<div class="box1">
	    	<div class="usuario">
				<h2>Modifica tu usuario</h2>
			</div>
			<div class="datos2">
				<form method="post" style="margin-left: 2%;">
					<div><label><p>Nombre de usuario:</p></label>
					<input type="text" name="nombreUsu" required>
					</div>
					<div><label><p>Nueva contraseña:</p> </label>
					<input type="text" name="nuevaCon" required>
					</div>
					<div><label><p>Repita contraseña:</p></label>
					<input type="text" name="rNuevaCon" required>
					</div>
					<input type="hidden" name="enviar" value="x">
					<button type="submit" class="boton">Enviar</button>
				</form>
			</div>
		</div>
	</div>
	<div class="footer"><h4>Contáctanos &copy;CheckUrCar</h4></div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php require('utiles/header.php') ?>
	<?php require('utiles/conexion.php') ?>
	<?php require('utiles/usuario.php') ?>
	<?php 
		$entra = false;
		
		if(isset($_POST['login'])&&isset($_POST['password'])){ //Vemos que hayan introducido ambos campos

			$conDb = connect();

			if($conDb!=null){ //Si la conexion a la bd no da null empezamos con las operaciones
				session_start();

				$login = $_POST['login'];
				$pwd = $_POST['password'];
				$_SESSION['valor'] = $_POST['valor'];

				if(passCheck($login,$pwd,$conDb)){

					$allData = allDatafromLogin($login,$conDb);
					if($allData!=null){
						if($allData['admin']==0){
							header('Location:vehIndex.php?idUsuario='.$allData['idUsuario']);
						}else{
							$_SESSION['admin'] = $allData;
							header('Location:adminPanel.php');
						}
					}else{
						$entra = true;
					}

				}else{
					$entra = true;
				}

			}
		}



	?>

	<link rel="stylesheet" href="assets/css/stylesGen.css">
	<link rel="stylesheet" href="assets/css/stylesLog.css">


	<title>Document</title>
</head>
<body>
	<div class="container">
		<div class="separador">
	        <form method="post">
	            <!-- Username -->
	            <div class="input-container">
	                <input type="text" name="login" required>
	                <label>Username:</label>
	            </div>
	            <!-- Password -->
	            <div class="input-container">
	                
	                <input style="float: left; width: 90%;" type="password" name="password" id="pass" required>
	                <button class="boton2log" id="ver" onclick="verPass()"></button>
	                <label>Password:</label>
	            </div>

	            <input type="hidden" name="valor" value="100">
	            <button type="submit" class="botonlog">login</button>

	        </form>

        	<div class="l2">
        		<p style="color:white;">¿No tienes cuenta?</p>
	            <form action="registro.php" method="post">
	        		<button type="submit" class="botonlog">registro</button>
	        	</form> 
        	</div>
	          

        </div>
        
    		
        
    </div>
	

	<?php if($entra){ ?> <!--Esto es por si se produce algun error en la introducción del datos del login-->
        <div class="mensajeError">
        	<i class="ico" id="parr">&#9747; Error en la autentificación</i>
            <script>
                window.setTimeout(function(){
                    document.querySelector('.mensajeError').removeChild(document.querySelector('#parr'));
                },3000);
            </script>
        </div>
    <?php } ?>

    <script type="text/javascript">
        var hidden = false;
        const passw = document.querySelector('#pass');
        const boton = document.querySelector('#ver');
        boton.addEventListener('click',function(e){
            e.preventDefault();
            if(!hidden){
                passw.setAttribute('type','text');
                hidden = true;
            }else{
                passw.setAttribute('type','password');
                hidden = false;
            }
        
        });   
    </script>
</body>
</html>
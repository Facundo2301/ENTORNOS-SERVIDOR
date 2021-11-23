<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php require('utiles/conexion.php') ?>
	<?php require('utiles/vehiculos.php') ?>
	<?php 

		session_start();
		$idUsuario = $_SESSION['usuario']['idUsuario'];

    	$conn = connect();

    	$entra = false;

    	if($conn!=null){
    		//Vamos a hacer la query para insertar un coche con los datos que nos pasan del formulario
	    	
    		if(isset($_POST['Matricula']) && isset($_POST['Marca']) && isset($_POST['Modelo'])){

	    		$matricula = $_POST['Matricula'];
	            $marca = $_POST['Marca'];
	            $modelo = $_POST['Modelo']; 

	            $sqlInsertVeh = "INSERT INTO `listavehiculo`(`idUsuario`, `idVehiculo`, `Marca`, `Matricula`, `Modelo`) VALUES ('$idUsuario','','$marca','$matricula','$modelo') ";

	            $updateUsu = "UPDATE datosusuario SET num_vehiculos = num_vehiculos+1 WHERE idUsuario='$idUsuario'";

	            if(mysqli_query($conn,$sqlInsertVeh) && mysqli_query($conn,$updateUsu)){
	            	$_SESSION['usuario']['num_vehiculos']++;

	            	$_SESSION['vehiculos'] = allVehfromId($idUsuario,$conn);


	            	$entra = true;
	            }else{
	            	echo "se ha producido un error";
	            }

	        }

	    }
	?>
	<link rel="stylesheet" href="assets/css/stylesGen.css">	
	<style>
    	.form-veh{
    		margin: 2%;
    	}
    </style>
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
    <?php }?>

    <div class="container">
    	<div class="box1">
    		<div class="aniadir">
                <h2>Añadir vehiculo</h2>
            </div>
		    <div class="datos3">
		        <form method="post">
		            <div class="input-container">
		                <label>Matricula: </label>
		                <input type="text" name="Matricula" pattern="\d{4}[A-Z]{3}" placeholder="0000XXX" required/>
		            </div>
		            <br>
		            <div class="input-container">
		                <label>Marca: </label>
		                <input type="text" name="Marca" placeholder="Opel" required/>    
		            </div>
		            <br>
		            <div class="input-container">
		                <label>Modelo: </label>
		                <input type="text" name="Modelo" placeholder="Corsa" required/>    
		            </div>
		            <br>
		            <button class="boton" type="submit" value="Añadir">Añadir</button>
		        </form>
		    </div>
		    <div class="footer"><h4>Contáctanos &copy;CheckUrCar</h4></div>
	    </div>
    </div>

</body>
</html>
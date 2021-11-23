<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php require('utiles/header.php') ?>
	<?php require('utiles/conexion.php') ?>
    <?php require('utiles/usuario.php') ?>
    <?php require('utiles/vehiculos.php') ?>
    <?php require('utiles/cookies.php') ?>
    
	<?php 
        session_start();
    	if(isset($_SESSION['valor'])){
            $conDb = connect();

            if($conDb!=null){

                $idUsuario = $_GET['idUsuario'];
                $btVueltaAdmin = false;

                if(allDatafromId($idUsuario,$conDb)!=null){
                    $_SESSION['usuario'] = allDatafromId($idUsuario,$conDb);    
                } 
                if(allVehfromId($idUsuario,$conDb)!=null){
                    $_SESSION['vehiculos'] = allVehfromId($idUsuario,$conDb);
                }


                $usuario = $_SESSION['usuario'];

                if($usuario['num_vehiculos']>0){
                    $vehiculos =  $_SESSION['vehiculos'];
                }


                if(isset($_POST['cerrarSes'])){
                    session_destroy();
                    header('Location:index.php');
                }
                
                if(isset($_SESSION['admin'])){
                    $btVueltaAdmin = true;
                }

            }

        }else{
            header('Location:index.php');
        }
	?>


	<link rel="stylesheet" href="assets/css/stylesGen.css">
	<title>Document</title>
</head>
<body>
    <?php
        mostrarCookies();
    ?>

    <?php if($btVueltaAdmin){ ?>
        <form action="adminPanel.php">
            <button type="submit" class="boton">Volver a panel</button>
        </form>
    <?php } ?>

    <div class="container">
        <div class="box1">
	        <div class="usuario">
	            <h2>Usuario</h2>
	        </div>       
	        <div class="datos">
                <div class="ape"><strong>Login: </strong><?php echo $usuario['login'] ?></div>                
                <div class="ape"><strong>Nombre: </strong><?php echo $usuario['nombre']; ?></div>

		        <div class="box1down">
		            <div class="formEditarUsu">
                        <form action="editarUsuario.php" method="post">
                            <button type="submit" value="Editar" class="boton" >Editar</button>
                        </form>
                    </div>  
                    <div class="formCerrarSes">
                        <form method="post">
                            <button type="submit" name="cerrarSes" class="boton" value="x">Cerrar Sesión</button>
                        </form>
                    </div>
		        </div>
	        </div><!--Div de datos-->
        </div><!--Div decontenedor-->
        

        <div class="box2">
            <div class="listaVehiculo">
                <h2>Lista de vehiculos</h2>
            </div>

            <table class="tabla">
                <tr>
                    <th><strong>Marca</strong></th>
                    <th><strong>Modelo</strong></th>
                    <th><strong>Matricula</strong></th>
                    <th style="background-color: transparent;"></th>
                </tr>
            
                
                <?php if($usuario['num_vehiculos']>0){ ?>
                    
                    <?php foreach ($vehiculos as $key => $value) { ?>
                            <tr>
                                <td><?php echo $vehiculos[$key][2] ?></td>
                                <td><?php echo $vehiculos[$key][4] ?></td>
                                <td><?php echo $vehiculos[$key][3] ?></td>
                                <td style="background-color: transparent; box-shadow: 0px 0px 0px 0px;">
                                    <form action="editarServicios.php" method="post">
                                        <button class="boton" type="submit">Editar</button>
                                        <input type="hidden" name="idVehiculo" value="<?php echo $vehiculos[$key][1] ?>">
                                    </form>
                                </td>
                            </tr>
                    <?php } ?>
                <?php } ?>
            </table>

            <form action="addVh.php">
                <button type="submit" class="boton">Añadir</button>
            </form>
        </div>
        
    </div>	
</body>
</html>
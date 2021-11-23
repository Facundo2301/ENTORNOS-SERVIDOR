<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="assets/css/styleAdmin.css">

	<?php require('utiles/conexion.php') ?>

	<?php 
		session_start();
		if(isset($_SESSION['valor'])){
			$admin = $_SESSION['admin'];

			$conDb = connect();

			if($conDb!=null){

				$sqlUsuarios = "SELECT * from datosusuario WHERE admin=0";
				$queryUsuarios = mysqli_query($conDb,$sqlUsuarios);

				if(isset($_POST['cerrarSes'])){
	                session_destroy();
	                header('Location:index.php');
	            }
			}
		}else{
			header('Location:index.php');
		}

	?>


	<title>Document</title>
</head>
<body>
	<div class="admin">
		<div class="vacio"></div>
		<div class="titulo">
			<h2>Ahora eres Admin</h2>
		</div>
		<div class="cerrar">
			<form method="post">
            <button type="submit" name="cerrarSes" class="boton" value="x">Cerrar Sesión</button>
        </form>
		</div>	
		
	</div>
	
	<div class="formCerrarSes">
        
    </div>
    <div class="container">
    	<table class="tabla">
            <tr>
                <th><strong>Login</strong></th>
                <th><strong>Nombre</strong></th>
                <th><strong>Fecha de alta</strong></th>
                <th style="background-color: transparent;"></th>
            </tr>
            
                
            <?php if(mysqli_num_rows($queryUsuarios)>0){ ?>
                
                <?php while ($row = mysqli_fetch_assoc($queryUsuarios)) { ?>
                        <tr>
                            <td><?php echo $row['login'] ?></td>
                            <td><?php echo $row['nombre'] ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row["fecha_alta"])) ?></td>
                            <td style="background-color: transparent; box-shadow: 0px 0px 0px 0px;">
                                <form action="vehIndex.php" method="get">
                                    <button class="boton" type="submit">Editar</button>
                                    <input type="hidden" name="idUsuario" value="<?php echo $row['idUsuario'] ?>">
                                </form>
                            </td>
                        </tr>
                <?php } ?>
            <?php } ?>
        </table>	
    </div>
</body>
</html>
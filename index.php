<?php
use models\ProductoModel as ProductoModel;
require_once("models/ProductoModel.php");
$modelo = new ProductoModel();
$productos = $modelo->getAllProducts();
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud PHP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>

<div class="container center">
    <div class="row">
    <div class="col s12">
        <h2>Inserta tus productos Aquí</h2>
        <div class="card">
            <div class="card-content">
                <form method="POST" action="controllers/ProductoController.php" enctype="multipart/form-data">
                    <div class="input-field">
                        <input id="nombre" type="text" name="nombre">
                        <label for="nombre">Nombre</label>
                    </div>
                    <div class="input-field">
                        <input id="descripcion" type="text" name="descripcion">
                        <label for="descripcion">Descripción</label>
                    </div>
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Imagen</span>
                            <input type="file" name="imagen" accept="image/*">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Seleccione una imagen">
                        </div>
                    </div>
                    <div class="input-field">
                        <input id="fecha_creacion" type="date" name="fecha_creacion">
                        <label for="fecha_creacion">Fecha de Creación</label>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn waves-effect waves-light">Guardar</button>
                    </div>
                </form>
                <div>
                    <?php if(isset($_SESSION['error'])) { ?>
                        <p class="red-text"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
                    <?php } ?>
                    <?php if(isset($_SESSION['respuesta'])) { ?>
                        <p class="green-text"><?= $_SESSION['respuesta']; unset($_SESSION['respuesta']); ?></p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    </div>



    <div class="row">
    <?php foreach ($productos as $producto) { ?>
        <div class="col s12 m4">
            <div class="card">
                <div class="card-image" style="height: 350px; overflow: hidden;">
                    <img src="img/<?= $producto["imagen"] ?>" alt="<?= $producto['nombre'] ?>" style="object-fit: cover; height: 100%;">
                    <span class="card-title black-text" style="font-weight: bold; background-color: rgba(255, 255, 255, 0.4); "><?= $producto['nombre'] ?></span>
                </div>
                <div class="card-content">
                    <p><strong>ID:</strong> <?= $producto['id'] ?></p>
                    <p><strong>Descripción:</strong> <?= $producto['descripcion'] ?></p>
                    <p><strong>Fecha de Creación:</strong> <?= $producto['fecha_creacion'] ?></p>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>



</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
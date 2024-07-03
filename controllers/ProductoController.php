<?php

namespace controllers;

use models\ProductoModel as ProductoModel;

require_once("../models/ProductoModel.php");

class ProductoController{
   public $nombre;
   public $descripcion; 
   public $imagen; 
   public $fecha_creacion;
   
   public function __construct()
   {
        $this->nombre = $_POST['nombre'];
        $this->descripcion = $_POST['descripcion'];
        $this->imagen = ''; // Inicializar la variable imagen
        $this->fecha_creacion = $_POST['fecha_creacion'];
   }

   public function registrarProducto(){
    session_start();

    if($this->nombre == "" | $this->descripcion == "" | empty($_FILES['imagen']['name']) | $this->fecha_creacion == ""){
        $_SESSION['error'] = "Completa todos los campos";
        header("Location: ../index.php");
        return;
    }

    // Manejo de la subida de archivo
    $uploadDirectory = "../img/"; 
    $uploadFile = $uploadDirectory . basename($_FILES["imagen"]["name"]);
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    // Validar si es una imagen
    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if($check === false) {
        $_SESSION['error'] = "El archivo no es una imagen.";
        header("Location: ../index.php");
        return;
    }

    //(5MB máximo)
    if ($_FILES["imagen"]["size"] > 5000000) {
        $_SESSION['error'] = "El archivo es demasiado grande.";
        header("Location: ../index.php");
        return;
    }

    //FORMATO DE LA IMAGEN
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $_SESSION['error'] = "Solo se permiten archivos JPG, JPEG, PNG";
        header("Location: ../index.php");
        return;
    }

    //Intentar mover el archivo subido al directorio deseado
    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $uploadFile)) {
        $_SESSION['error'] = "Hubo un error al subir el archivo.";
        header("Location: ../index.php");
        return;
    }

    $this->imagen = $uploadFile;

    $model = new ProductoModel();
    $data = [
        "nombre" => $this->nombre,
        "descripcion" => $this->descripcion,
        "imagen" => $this->imagen,
        "fecha_creacion" => $this->fecha_creacion,
    ];
    $count = $model->registerProduct($data);

    if($count == 1){
        $_SESSION['respuesta'] = "Registrado";
    }else{
        $_SESSION['error'] = "Error";
    }

    header("Location: ../index.php");
   }

}

$obj = new ProductoController;
$obj->registrarProducto();

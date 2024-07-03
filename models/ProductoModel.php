<?php

namespace models;

require_once('Conexion.php');

class ProductoModel{

    public function getAllProducts(){
        $stm = Conexion::conector()->prepare("SELECT * FROM PRODUCTOS");
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function registerProduct($data) {
        $stm = Conexion::conector()->prepare("INSERT INTO PRODUCTOS VALUES(NULL, :nombre, :descripcion, :imagen, :fecha_creacion)");
        $stm->bindParam(":nombre", $data['nombre']);
        $stm->bindParam(":descripcion", $data['descripcion']);
        $stm->bindParam(":imagen", $data['imagen']);
        $stm->bindParam(":fecha_creacion", $data['fecha_creacion']);
        return $stm->execute();
    }

}

<?php

function get_conexion(){
    $server = "localhost";
    $user = "root";
    $password = "";

    try{
        $conexion = new PDO("mysql:host=$server", $user, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;

    }catch (PDOException $e){
        echo $e->getMessage();
    }
}



function ejecutar_consulta($conexion, $sql){
    try {
        $conexion->query($sql);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}



function crear_bd_gestorCitas($conexion){
    $sql = "CREATE DATABASE IF NOT EXISTS gestorCitas";
    ejecutar_consulta($conexion, $sql);
}



function seleccionar_bd_gestorCitas($conexion){
    $sql = "use gestorCitas";
    ejecutar_consulta($conexion, $sql);

}



function crear_tabla_administrador($conexion){
    $sql="CREATE TABLE IF NOT EXISTS administrador(
        id INT(6) AUTO_INCREMENT PRIMARY KEY,
        usuario VARCHAR(50) NOT NULL,
        pass VARCHAR(255) NOT NULL,
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

    ejecutar_consulta($conexion, $sql);
}



function crear_tabla_negocios($conexion){
    $sql="CREATE TABLE IF NOT EXISTS negocios(
        id_negocio INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        direccion VARCHAR(255) NOT NULL,
        telefono VARCHAR(15),
        id_administrador INT,
        FOREIGN KEY (id_administrador) REFERENCES administrador(id) ON DELETE CASCADE
        )";

        ejecutar_consulta($conexion, $sql);
}




function crear_tabla_servicios($conexion){
    $sql="CREATE TABLE IF NOT EXISTS servicios(
        id_servicio INT(6) AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(255) NOT NULL, 
        duracion INT NOT NULL,
        precio DECIMAL(10,2) NOT NULL,
        descripcion TEXT,
        id_negocio INT,
        FOREIGN KEY (id_negocio) REFERENCES negocios(id_negocio) ON DELETE CASCADE
        )";

    ejecutar_consulta($conexion, $sql);
}


function crear_tabla_citas($conexion){
    $sql="CREATE TABLE IF NOT EXISTS citas(
        id INT(6) AUTO_INCREMENT PRIMARY KEY,
        id_servicio INT,
        fecha DATETIME NOT NULL,
        nombre_cliente VARCHAR(255) NOT NULL,
        email_cliente VARCHAR(255),
        tlf_cliente INT(9),
        codigo_unico VARCHAR(10),
        estado ENUM('confirmada', 'cancelada', 'completada') DEFAULT 'confirmada',
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_servicio) REFERENCES servicios(id_servicio) ON DELETE CASCADE
        )";

    ejecutar_consulta($conexion, $sql);
}



function addServicio($conexion, $nombre_servicio, $duracion, $precio, $descripcion){

    $consulta = $conexion->prepare("INSERT INTO servicios (nombre_servicio, duracion, precio, descripcion) VALUES (:nombre_servicio, :duracion, :precio, :descripcion)");
    $consulta->bindParam(':nombre_servicio', $nombre_servicio);
    $consulta->bindParam(':duracion', $duracion);
    $consulta->bindParam(':precio', $precio);
    $consulta->bindParam(':descripcion', $descripcion);

    return $consulta->execute();

}



function deleteServicio($conexion, $id_servicio){
    $consulta = $conexion->prepare("DELETE FROM servicios WHERE id_servicio=$id_servicio");
    return $consulta->execute();
}



function addCita($conexion, $id_servicio, $fecha, $nombre_cliente, $email_cliente, $tlf_cliente, $codigo_unico){

    $consulta = $conexion->prepare("INSERT INTO citas (id_servicio, fecha, nombre_cliente, email_cliente, tlf_cliente, codigo_unico) VALUES (:id_servicio, :fecha, :nombre_cliente, :email_cliente, :tlf_cliente, :codigo_unico)");
    $consulta->bindParam(':id_servicio',$id_servicio);
    $consulta->bindParam(':fecha', $fecha);
    $consulta->bindParam(':nombre_cliente', $nombre_cliente);
    $consulta->bindParam(':email_cliente', $email_cliente);
    $consulta->bindParam(':tlf_cliente', $tlf_cliente);
    $consulta->bindParam(':codigo_unico', $codigo_unico);

    return $consulta->execute();
}



function deleteCita($conexion, $id){
    $consulta = $conexion->prepare("DELETE FROM citas WHERE id=$id");
    return $consulta->execute();
}



function alta_admin($conexion, $usuario, $password){

    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

    $consulta = $conexion->prepare("INSERT INTO administrador (usuario, pass) VALUES (:usuario, :pass)");
    $consulta->bindParam(':usuario', $usuario);
    $consulta->bindParam(':pass', $hashed_pass);
    return $consulta->execute();

    
}
//Devuelve los nombres de TODOS los negocios
function nombres_negocios($conexion){
    $consulta = $conexion->prepare("SELECT * FROM negocios");
    $consulta->execute();
    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
    return $resultados;
}

//Devuelve los datos del negocio asociado a un administrador
function datos_negocio($conexion, $id_administrador){
    $consulta = $conexion->prepare("SELECT * FROM negocios WHERE id_administrador = :id_administrador");
    $consulta->bindParam(':id_administrador', $id_administrador);
    $consulta->execute();

    if($consulta->rowCount() > 0){
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }else{
        return null;
    }
}


function cerrar_conexion($conexion){
    $conexion = null;
}

function datos_servicios($conexion, $id_administrador){
    $negocio = datos_negocio($conexion, $id_administrador);

    if($negocio){
        $id_negocio = $negocio['id_negocio'];


        $consulta_servicios = $conexion->prepare("SELECT * FROM servicios WHERE id_negocio = :id_negocio");
        $consulta_servicios->bindParam(':id_negocio', $id_negocio);
        $consulta_servicios->execute();

        return $consulta_servicios->fetchAll(PDO::FETCH_ASSOC);
    }else{
        return null;
    }
}



function login($usuario, $password){
    if(!isset($_SESSION)){
        session_start();
    }
    $conexion = get_conexion();
    seleccionar_bd_gestorCitas($conexion);

    $consulta = $conexion->prepare("SELECT * FROM administrador WHERE usuario = :usuario");
    $consulta->bindParam(':usuario', $usuario);
    $consulta->execute();

    if($consulta->rowCount() > 0){
        $fila = $consulta->fetch(PDO::FETCH_ASSOC);
        if(password_verify($password, $fila['pass'])){
            $_SESSION['usuario'] = $fila['usuario'];
            $_SESSION['id_administrador'] = $fila['id'];  
        }
    }
    cerrar_conexion($conexion);
}






?>
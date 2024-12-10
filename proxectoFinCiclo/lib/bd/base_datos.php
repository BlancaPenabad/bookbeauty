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
        foto_negocio VARCHAR(255),
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



function updateServicio($conexion, $id_servicio, $nombre_servicio, $duracion, $precio, $descripcion) {
    $consulta = $conexion->prepare("UPDATE servicios SET nombre = :nombre_servicio, descripcion = :descripcion, precio = :precio, duracion = :duracion WHERE id_servicio = :id_servicio");

    $consulta->bindParam(':nombre_servicio', $nombre_servicio);
    $consulta->bindParam(':descripcion', $descripcion);
    $consulta->bindParam(':precio', $precio); 
    $consulta->bindParam(':duracion', $duracion); 
    $consulta->bindParam(':id_servicio', $id_servicio); 

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



function updateCita($conexion, $id_cita, $id_servicio, $fecha, $nombre_cliente, $email_cliente, $tlf_cliente) {
    $consulta = $conexion->prepare("UPDATE citas SET id_servicio = :id_servicio, fecha = :fecha, nombre_cliente = :nombre_cliente, email_cliente = :email_cliente, tlf_cliente = :tlf_cliente WHERE id = :id_cita");

    $consulta->bindParam(':id_servicio', $id_servicio);
    $consulta->bindParam(':fecha', $fecha);
    $consulta->bindParam(':nombre_cliente', $nombre_cliente);
    $consulta->bindParam(':email_cliente', $email_cliente);
    $consulta->bindParam(':tlf_cliente', $tlf_cliente);
    $consulta->bindParam(':id_cita', $id_cita);

    return $consulta->execute();
}


function deleteCita($conexion, $id){
    $consulta = $conexion->prepare("DELETE FROM citas WHERE id = :id");
    $consulta->bindParam(':id', $id, PDO::PARAM_INT);
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




function datos_negocio_id($conexion, $id_negocio){
    $consulta = $conexion->prepare("SELECT * FROM negocios WHERE id_negocio = :id_negocio");
    $consulta->bindParam(':id_negocio', $id_negocio);
    $consulta->execute();

    if($consulta->rowCount() > 0){
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }else{
        return null;
    }
}



function datos_servicios_id($conexion ,$id_negocio){
    $consulta = $conexion->prepare("SELECT * FROM servicios WHERE id_negocio = :id_negocio");
    $consulta->bindParam(':id_negocio', $id_negocio);
    $consulta->execute();

    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
    if ($resultados) {
        return $resultados;
    } else {
        return []; 
    }
}


function get_id_negocio($conexion, $id_servicio){
    $consulta = $conexion->prepare("SELECT id_negocio, nombre from servicios WHERE id_servicio = :id_servicio");
    $consulta->bindParam('id_servicio', $id_servicio);
    $consulta->execute();

    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    if ($resultado) {
        return[
            'id_negocio'=>$resultado['id_negocio'],
            'nombre' => $resultado['nombre']
        ]; 
    } else {
        return null; 
    }
}



function get_citas_negocio($conexion, $id_negocio){
    

        $consulta = $conexion->prepare("SELECT citas.id, citas.fecha, citas.nombre_cliente, citas.email_cliente, citas.tlf_cliente,citas.codigo_unico, citas.estado, citas.id_servicio 
        FROM citas WHERE citas.id_servicio IN (SELECT id_servicio FROM servicios WHERE id_negocio = :id_negocio)
        ORDER BY citas.fecha ASC");

        $consulta->bindParam(':id_negocio', $id_negocio);
        $consulta->execute();

        $citas = $consulta->fetchAll(PDO::FETCH_ASSOC);

        foreach($citas as &$cita){
            $id_servicio = $cita['id_servicio'];
            $consultaII = $conexion->prepare("SELECT nombre, duracion FROM servicios WHERE id_servicio = :id_servicio");
            $consultaII->bindParam(':id_servicio', $id_servicio);
            $consultaII->execute();

            $servicio = $consultaII->fetch(PDO::FETCH_ASSOC);
            $cita['servicio_nombre'] = $servicio ? $servicio['nombre'] : null;
            $cita['duracion'] = $servicio ? $servicio['duracion'] : 0;

            if ($cita['fecha'] && $cita['duracion'] > 0) {
                $fecha_cita = new DateTime($cita['fecha']);
                $fecha_cita->modify('+' . $cita['duracion'] . ' minutes');
                $cita['fecha_final'] = $fecha_cita->format('Y-m-d H:i:s'); 
            }
        }
        unset($cita);
        return $citas;

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
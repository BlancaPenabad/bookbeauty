<?php


function insertar_administrador($conexion) {
    $usuario = "BlancaPenabad";
    $pass = password_hash("abc123", PASSWORD_DEFAULT); 

    $sql = "INSERT INTO administrador (usuario, pass) 
            SELECT '$usuario', '$pass' 
            FROM DUAL 
            WHERE NOT EXISTS (
                SELECT 1 FROM administrador WHERE usuario = '$usuario'
            )";
    ejecutar_consulta($conexion, $sql);
}

function insertar_negocio($conexion) {
    $nombre = "LeBlanc Salon";
    $direccion = "Rúa da Belleza, 123, Santiago de Compostela";
    $telefono = "981123456";
    $email = "lilblanca@hotmail.com";
    $descripcion = "Salón especializado en manicura e pedicura de alta calidade.";
    $id_administrador = 1; 
    $foto_negocio = "leblanc.jpeg";

    $sql = "INSERT INTO negocios (nombre, direccion, telefono, email, descripcion, id_administrador, foto_negocio) 
            SELECT '$nombre', '$direccion', '$telefono', '$email', '$descripcion', $id_administrador, '$foto_negocio'
            FROM DUAL
            WHERE NOT EXISTS (
                SELECT 1 FROM negocios WHERE nombre = '$nombre'
            )";
    ejecutar_consulta($conexion, $sql);
}

function insertar_servicios($conexion) {
    $servicios = [
        [
            "nombre" => "Manicura básica",
            "duracion" => 30,
            "precio" => 15.00,
            "descripcion" => "Manicura básica con limado, corte e pintado de uñas.",
            "id_negocio" => 1 
        ],
        [
            "nombre" => "Pedicura relax",
            "duracion" => 45,
            "precio" => 25.00,
            "descripcion" => "Pedicura con masaxe relaxante e tratamento hidratante.",
            "id_negocio" => 1
        ],
        [
            "nombre" => "Manicura e pedicura completa",
            "duracion" => 75,
            "precio" => 35.00,
            "descripcion" => "Manicura e pedicura completas con tratamento de cutículas e esmalte permanente.",
            "id_negocio" => 1
        ]
    ];

    foreach ($servicios as $servicio) {
        $sql = "INSERT INTO servicios (nombre, duracion, precio, descripcion, id_negocio) 
                SELECT '{$servicio['nombre']}', {$servicio['duracion']}, {$servicio['precio']}, '{$servicio['descripcion']}', {$servicio['id_negocio']}
                FROM DUAL
                WHERE NOT EXISTS (
                    SELECT 1 FROM servicios WHERE nombre = '{$servicio['nombre']}' AND id_negocio = {$servicio['id_negocio']}
                )";
        ejecutar_consulta($conexion, $sql);
    }
}

function insertar_citas($conexion) {
    $citas = [
        [
            "id_servicio" => 1, 
            "fecha" => "2024-03-20 10:00:00",
            "nombre_cliente" => "Ana López",
            "email_cliente" => "ana.lopez@example.com",
            "tlf_cliente" => 666111222,
            "codigo_unico" => "ABC123",
            "estado" => "confirmada"
        ],
        [
            "id_servicio" => 2, 
            "fecha" => "2024-03-21 11:30:00",
            "nombre_cliente" => "Carlos Martínez",
            "email_cliente" => "carlos.martinez@example.com",
            "tlf_cliente" => 666333444,
            "codigo_unico" => "DEF456",
            "estado" => "confirmada"
        ],
        [
            "id_servicio" => 3, 
            "fecha" => "2024-03-22 16:00:00",
            "nombre_cliente" => "María Fernández",
            "email_cliente" => "maria.fernandez@example.com",
            "tlf_cliente" => 666555666,
            "codigo_unico" => "GHI789",
            "estado" => "confirmada"
        ]
    ];

    foreach ($citas as $cita) {
        $sql = "INSERT INTO citas (id_servicio, fecha, nombre_cliente, email_cliente, tlf_cliente, codigo_unico, estado) 
                SELECT {$cita['id_servicio']}, '{$cita['fecha']}', '{$cita['nombre_cliente']}', '{$cita['email_cliente']}', {$cita['tlf_cliente']}, '{$cita['codigo_unico']}', '{$cita['estado']}'
                FROM DUAL
                WHERE NOT EXISTS (
                    SELECT 1 FROM citas WHERE codigo_unico = '{$cita['codigo_unico']}'
                )";
        ejecutar_consulta($conexion, $sql);
    }
}
?>
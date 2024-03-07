<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $base = $_POST['base'];
    $exponente = $_POST['exponente'];
    $resultado = $_POST['resultado'];

    //Necesitaremos esto para conectarnos a PHPMyAdmin
    $server = "localhost";
    $usuariosql = "root";
        //Por defecto, la contraseña de root es inexistente
    $contrasenia = "";


    $con1 = new mysqli($server, $usuariosql, $contrasenia);


    //Creacción de la base de datos si no existe
    $crear_base = "CREATE DATABASE IF NOT EXISTS potenciadordb"; 
    if ($con1->query($crear_base) === TRUE) {
        echo "Base de datos creada con exito<br>";
    } else {
        echo "Error en la creacion de la base datos: " . $con1->error . "<br>";
    }


    //Asignamos la db que acabamos de crear
    $db = "potenciadordb";


    $con2 = new mysqli($server, $usuariosql, $contrasenia, $db);



    $sql1 = "CREATE TABLE IF NOT EXISTS potenciadortabla (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        base VARCHAR(50) NOT NULL,
        exponente VARCHAR(50) NOT NULL,
        resultado VARCHAR(50) NOT NULL
    )";



    if ($con2->query($sql1) === TRUE) {
        if ($con2->affected_rows > 0) {
            echo "Tabla potenciadortabla creada con exito<br>";
        } else {
            echo "La tabla ya existe<br>";
        }
    } else {
        echo "Error creando la tabla: " . $con2->error;
    
    
    }

    $sql2 = "INSERT INTO potenciadortabla (base, exponente, resultado) VALUES ($base, $exponente, $resultado)";


    if ($con2->query($sql2) === TRUE) {
        echo "Valor guardado en el historial correctamente<br>";
    } else {
        echo "Error de: " . $sql2 . "<br>" . $con2->error;
    }


    $con1->close();
    $con2->close();

}



if ($_SERVER["REQUEST_METHOD"] == "GET") {

    //Necesitaremos esto para conectarnos a PHPMyAdmin
    $server = "localhost";
    $usuariosql = "root";
        //Por defecto, la contraseña de root es inexistente
    $contrasenia = "";


    //Asumimos que ya ha sido creada
    $db = "potenciadordb";


    $con3 = new mysqli($server, $usuariosql, $contrasenia, $db);

    $sql3 = "SELECT * FROM potenciadortabla";
    $retornoGet = $con3->query($sql3);

    $dataGet = array();
    while($fila = $retornoGet->fetch_assoc()) {
        $dataGet[] = $fila;
    }

    echo json_encode($dataGet);
    $con3->close();

}
?>
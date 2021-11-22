<?php
$nombre = $_POST['nombre'];
$password = $_POST['password'];
$genero = $_POST['genero'];
$mail = $_POST['mail'];
$materia = $_POST['materia'];
$telefono = $_POST['telefono'];

if(!empty($nombre) || !empty($password) || !empty($genero) || !empty($mail) 
|| !empty($materia) || !empty($telefono)){

    $host = "localhost";
    $dbusername = "server";
    $dbpassword = "root";
    $dbname = "estudiante";

    $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
    if(mysqli_connect_error()){
        die('connect error('.mysqli_connect_errno().')'.mysqli_connect_error());    
    }
    else{
        $SELECT = "SELECT telefono from usuario where telefono = ? limit 1";
        $INSERT = "INSERT INTO usuario (nombre,password,genero,mail,materia,telefono)
        values(?,?,?,?,?,?)";

        $stmt = $conn->prepare($SELECT);
        $stmt ->bind_param("i",$telefono);
        $stmt ->execute();
        $stmt ->bind_result($telefono);
        $stmt ->store_result(); #transfiere los resultados de la ultima consulta
        $rnum =$stmt->num_rows(); #regrese el numero de filas del resultado q vamos a tener en la sentencia
        if($rnum == 0){
            $stmt ->close();
            $stmt = $conn->prepare($INSERT);
            $stmt ->bind_param("sssssi",$nombre,$password,$genero,$mail,$materia,$telefono);
            $stmt ->execute();
            echo "REGISTRO COMPLETADO";
        }
        else{
            echo "alguien registro ese telefono";
        }
        $stmt->close();
        $conn->close();
    }
}
else {
    echo "todos los datos son obligatorios";
    die();
}

?>
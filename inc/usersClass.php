<?php
/**
 * usersClass
 * 
 * @package  2swap
 * @author   Álvaro Suárez
 */

include_once 'functions.php';

class users{

    public $ID = 0;
    /**
     * Crea una nueva fila en la tabla users.
     * @param type $name
     * @param type $lastname
     * @param type $email
     * @param type $password
     * @param type $create_datetime
     * @param type $local_currency
     * @return type
     */
    function create($name, $lastname, $email, $password, $create_datetime, $local_currency) {
        $connect = new Tools();
        $conexion = $connect->connectDB();
        $sql = "insert into users (name, lastname, email, password, create_datetime, local_currency) 
        values ('".$name."', '".$lastname."', '".$email."', '".md5($password)."', '".$create_datetime."', '".$local_currency."');";
        $consulta = mysqli_query($conexion, $sql);
        if ($consulta) {
        } else {
               echo "No se ha podido insertar en la base de datos<br><br>".mysqli_error($conexion);
        }
        $connect->disconnectDB($conexion);
        return $consulta;
    }

    /**
     * Modifica la tabla con los datos introducidos
     * @param type $name
     * @param type $lastname
     * @param type $local_currency
     * @return type
     */
    function update($name, $lastname, $local_currency, $email) {
        
        $connect = new Tools();
        $conexion = $connect->connectDB();
        $sql = "UPDATE users SET "
                . "name = '$name', "
                . "lastname = '$lastname', "
                . "local_currency = '$local_currency' 
        WHERE email = '$email' ;";
        $consulta = mysqli_query($conexion,$sql);
        if(!$consulta){
               echo "No se ha podido modificar la base de datos<br><br>".mysqli_error($conexion);
        }
        $connect->disconnectDB($conexion);
        return $consulta;
        
    }

    /**
     * Borra el elemento a partir de un ID dado
     * @param type $ID
     * @return type
     */ 
    function delete($email) {
        $connect = new Tools();
        $conexion = $connect->connectDB();
        $sql = "DELETE FROM users WHERE email = '".$email."';";
        $consulta = mysqli_query($conexion,$sql);
        if($consulta){
        }else{
               echo "No se ha podido borrar la fila<br><br>".mysqli_error($conexion);
        }
        $connect->disconnectDB($conexion);
        return $consulta;
    }
    
    function get_currentUser() {
        $email = $_SESSION['email'];
        //Creamos la consulta
        $sql = "SELECT * FROM users WHERE email = '".$email."';";
        //obtenemos el array
        $tool = new Tools();
        $array = $tool->GetRowSQL($sql);
        return $array[0];
    }

    /**
     * Devuelve un array con la información de una fila a partir de un ID
     * @return type
     */
    
    function getData($email) {
        //Creamos la consulta
        $sql = "SELECT * FROM users WHERE email = '".$email."';";
        //obtenemos el array
        $tool = new Tools();
        $array = $tool->getArraySQL($sql);
        return $array;
    }
    
    /**
     * Devuelve Toda la información de la tabla users
     * @return type
     */
    function getAllInfo() {
        //Creamos la consulta
        $sql = "SELECT * FROM users;";
        //obtenemos el array
        $tool = new Tools();
        $array = $tool->getArraySQL($sql);
        return $array;
    }
}
?>
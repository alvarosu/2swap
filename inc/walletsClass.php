<?php
/**
 * walletsClass
 * 
 * @package  2swap
 * @author   Álvaro Suárez
 */

include_once 'functions.php';

class wallets{

    public $ID = 0;
    /**
     * Crea una nueva fila en la tabla wallets.
     * @param type $id
     * @param type $fk_user_email
     * @param type $currency
     * @param type $amount
     * @param type $create_datetime
     * @return type
     */
    function create($id, $fk_user_email, $currency, $amount, $create_datetime) {
        $connect = new Tools();
        $conexion = $connect->connectDB();
        $sql = "insert into wallets (id, fk_user_email, currency, amount, create_datetime) 
        values ('".md5( $currency . $fk_user_email )."', '".$fk_user_email."', '".$currency."', '".$amount."', '".$create_datetime."');";
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
     * @param type $id
     * @param type $amount
     * @return type
     */
    function update($id, $amount) {
        
        $connect = new Tools();
        $conexion = $connect->connectDB();
        $sql = "UPDATE wallets SET "
                . "amount = '$amount' 
        WHERE id = '$id' ;";
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
        $sql = "DELETE FROM wallets WHERE email = '".$email."';";
        $consulta = mysqli_query($conexion,$sql);
        if($consulta){
        }else{
               echo "No se ha podido borrar la wallets<br><br>".mysqli_error($conexion);
        }
        $connect->disconnectDB($conexion);
        return $consulta;
    }

    /**
     * Devuelve un array con la información de una fila a partir de un ID
     * @return type
     */
    
    function getWallet($id) {
        //Creamos la consulta
        $sql = "SELECT * FROM wallets WHERE id = '".$id."';";
        //obtenemos el array
        $tool = new Tools();
        $array = $tool->getRowSQL($sql);
        if (!empty($array)) return $array[0];
    }
    
    /**
     * Devuelve Toda la información de la tabla wallets
     * @return type
     */
    function getWalletsByUser($fk_user_email) {
        //Creamos la consulta
        $sql = "SELECT * FROM wallets WHERE fk_user_email = '".$fk_user_email."';";
        // $sql = "SELECT * FROM wallets WHERE fk_user_email = '".$fk_user_email."' ORDER BY currency;";
        //obtenemos el array
        $tool = new Tools();
        $array = $tool->getArraySQL($sql);
        return $array;
    }
}
?>
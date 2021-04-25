<?php
/**
 * transactionsClass
 * 
 * @package  2swap
 * @author   Álvaro Suárez
 */

include_once 'functions.php';

class transactions{

    public $ID = 0;
    /**
     * Crea una nueva fila en la tabla transactions.
     * @param type $id
     * @param type $fk_user_email
     * @param type $fk_wallet_a
     * @param type $fk_wallet_b
     * @param type $amount_a
     * @param type $amount_b
     * @param type $create_datetime
     * @return type
     */
    function create($fk_user_email, $fk_wallet_a, $fk_wallet_b, $amount_a, $amount_b, $create_datetime) {
        $connect = new Tools();
        $conexion = $connect->connectDB();
        $sql = "insert into transactions (fk_user_email, fk_wallet_a, fk_wallet_b, amount_a, amount_b, create_datetime) 
        values ('".$fk_user_email."', '".$fk_wallet_a."', '".$fk_wallet_b."', '".$amount_a."', '".$amount_b."', '".$create_datetime."');";
        $consulta = mysqli_query($conexion, $sql);
        if ($consulta) {
        } else {
               echo "No se ha podido insertar en la base de datos<br><br>".mysqli_error($conexion);
        }
        $connect->disconnectDB($conexion);
        return $consulta;
    }
    
    /**
     * Devuelve Toda la información de la tabla transactions
     * @return type
     */
    function getTransactionsByUser($fk_user_email) {
        //Creamos la consulta
        $sql = "SELECT * FROM transactions WHERE fk_user_email = '".$fk_user_email."' ORDER BY create_datetime DESC;";
        //obtenemos el array
        $tool = new Tools();
        $array = $tool->getArraySQL($sql);
        return $array;
    }
}
?>
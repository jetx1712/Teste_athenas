<?php
include('conexao.php');

$id = $_POST['id'];


$sql = "DELETE FROM usuarios WHERE id_usuario = $id";

if (mysqli_query($con, $sql)) {
    echo "deletado";
} else {
    echo "erro ao deletar";
}


?>
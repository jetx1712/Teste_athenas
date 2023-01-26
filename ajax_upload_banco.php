<?php

$nome = $_POST['nome'];
$email = $_POST['email'];
$categoria = $_POST['categoria'];



    include('conexao.php');
    $sql_code = "INSERT INTO usuarios (nome, email, categoria) VALUES('$nome', '$email', '$categoria')";

    if (mysqli_query($con, $sql_code)) {
        return "enviado com sucesso";
    } else {
        return error("error");
    }







?>
<?php
include('conexao.php');


//consulta tabela categorias

$sql_category = "SELECT * FROM categorias";
$sql_code = mysqli_query($con, $sql_category);

//consulta tabela usuario

$sql_usuario = "SELECT * FROM usuarios";
$sql_code_usuario = mysqli_query($con, $sql_usuario);

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
  <link rel="stylesheet" href="css/app.css">
  <title>Teste - Athenas</title>

</head>

<body>
  <div class="container">
    <div class="row botao-top">
      <div class="col-md-3">
        <button type="button" id="modal" class="btn btn-success" data-toggle="modal" data-target="#modal">Cadastrar
          usuário</button>
      </div>
    </div>
    <div>
      <table id="Tabela" class="table table-striped">
        <thead>
          <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Categoria</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tbody>
          <?php

          while ($row_usuario = mysqli_fetch_assoc($sql_code_usuario)) {
            ?>
            <tr>
              <td>
                <?php echo $row_usuario['id_usuario'] ?>
              </td>
              <td>
                <?php echo $row_usuario['nome'] ?>
              </td>
              <td>
                <?php echo $row_usuario['email'] ?>
              </td>
              <td>
                <?php echo $row_usuario['categoria'] ?>
              </td>
              <td>
                <button  type="button" data-id="<?php echo "$row_usuario[id_usuario]" ?>" class="btn btn-danger deletar">Excluir</button>
              </td>
            </tr>
          <?php } ?>
          <!-- Final do loop de usuarios -->
        </tbody>
      </table>
    </div>
    <div>

      <!-- Modal de cadastro de usuários -->
      <form id="formulario_usuario">
        <div id="myModal" class="modal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Cadastrar usuários</h5>
              </div>
              <div class="modal-body">

                <label>Nome</label>
                <input type="text" id="nome" name="nome" class="form-control" placeholder="Insira seu nome"></input>

                <label>E-mail</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Insira seu nome"></input>

                <label>Categoria</label>
                <select id="categoria" name="categoria" class="form-control">
                  <option>Selecione uma das opções</option>
                  <?php
                  while ($row = mysqli_fetch_assoc($sql_code)) {
                    ?>
                    <option value="<?php echo $row['id'] ?>"><?php echo $row['categorias'] ?></option>
                  <?php } ?>
                </select>

              </div>
              <div class="modal-footer">
                <button type="button" id="fechar" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" id="salv" class="btn btn-primary">Cadastrar Usuário</button>
              </div>
            </div>
          </div>
        </div>
      </form>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
  integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"></script>

<script>
  $(document).ready(function () {
    $('#Tabela').DataTable({
      "pageLength": 5,
      "paging": true,
      "info": false,
      "lengthChange": false,
      "searching": false,
      "language": {
        "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
      }
    });
  });


  //funções do botão de cadastro de usuários//

  //botão que abre modal de cadastro de usuario
  $("#modal").click(function () {
    $("#myModal").modal('show');
  });

  //botao que fecha modal
  $("#fechar").click(function () {
    $("#myModal").modal('hide');
  });

  //botao que insere registro de usuario modal
  $("#salv").click(function () {
    var formData = new FormData(document.getElementById("formulario_usuario"));

    $.ajax({
      type: "POST",
      url: "ajax_upload_banco.php",
      data: formData,
      processData: false,
      contentType: false,
      success: function (data) {
        $('#myModal').modal('hide');
        Swal.fire({
          position: 'top',
          icon: 'success',
          title: 'O usuário foi criado com sucesso!',
          showConfirmButton: false,
          timer: 1500
        });
        setTimeout(function () {
          window.location.reload(true);
        }, 1000);
      },
      error: function (data) {
        $('#myModal').modal('hide');
        Swal.fire({
          position: 'top',
          icon: 'warning',
          title: 'Não foi possível criar o usuário!',
          showConfirmButton: false,
          timer: 1500
        });


      }
    });

  });

   //Deleta álbum

   $(".deletar").click(function () {
            $.ajax({
                type: 'POST',
                url: 'ajax_deleta_usuario.php',
                data: { id: $(this).attr('data-id') },
                success: function (data) {
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'O usuário foi excluido com sucesso!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function () {
                        window.location.reload(true);
                    }, 1000);
                }
            })
        })
 



</script>

</html>
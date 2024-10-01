<?php


require_once 'includes/config.php';

$mensagem_sucesso= "";
$mensagem_erro= "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);


  $sql_verifica = "SELECT * FROM usuarios WHERE email = ?";
  $stmt_verifica = $conn->prepare($sql_verifica);
  $stmt_verifica->bind_param('s', $email);
  $stmt_verifica->execute();
  $resultado = $stmt_verifica->get_result();


  if ($resultado->num_rows > 0) {
    $mensagem_erro = "Este email ja esta cadastrado.";
  } else {
    $sql = "INSERT INTO usuarios (nome, email, senha) Values (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $nome, $email, $senha);


    if ($stmt->execute()) {
      $_SESSION['mensagem_sucesso'] = "Cadastro realizado com sucesso";
      header("Location: cadastro.php");
      exit();
    } else {
      $mensagem_erro = "Erro ao cadastrar" . $conn->error;
    }
  }
  $stmt->close();
$conn->close();
}


?>


<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/cadastro.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <title>Document</title>
</head>


<body>
  <div>
    <form class="alinhar"action="" method="POST">
      <div class="login">
      <h2>Cadastro de usuarios</h2>
      </div>
      <div class="email">
      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" required><br>
      </div>
      <div class="email">
      <label for="email">Email:</label>
      <input type="text" id="email" name="email" required><br>
      </div>
     <div class="email">
     <label for="senha">Senha:</label>
     <input type="password" id="senha" name="senha" required><br>
     </div>
      


     <div class="cadastro">
     <input type="submit" value="Cadastrar">
     </div>
    </form>
  </div>
</body>


</html>
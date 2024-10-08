<?php
session_start();
 
require_once 'includes/config.php';
 
$mensagem_erro = "";
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST['email'];
  $senha = $_POST['senha'];
 
  $sql_verifica = "SELECT * FROM usuarios WHERE email = ?";
  $stmt_verifica = $conn->prepare($sql_verifica);
  $stmt_verifica->bind_param('s', $email);
  $stmt_verifica->execute();
  $resultado = $stmt_verifica->get_result();
  $usuario = $resultado->fetch_assoc();
 
  if ($usuario && password_verify($senha, $usuario['senha'])) {
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    header("Location: dashboard.php");
    exit();
  } else {
    $mensagem_erro = "Email ou senha incorretos.";
  }
 
  $stmt_verifica->close();
  $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
    
<body>
  <div class="quadrado">
    <form action="" method="POST">
    <div class="junta">
    <div class="login">
    <h2>Login</h2>
    </div>
      <div class="email">
      <label for="email">Email:</label>
      <input type="text" id="email" name="email" required><br>
      </div>
      <div class="senha">
      <label for="senha">Senha:</label>
      <input type="password" id="senha" name="senha" required><br>
      </div>
    </div>
      

      <?php if($mensagem_erro):?>
<p><?php echo $mensagem_erro; ?></p>

<?php endif; ?>
<div class="cadastro">
<input type="submit" value="Cadastrar">
     <div class="nova">
     <a href="./cadastro.php"><p>Ir para cadastro</p></a>
     </div> 
    </form>
</div>
    
  </div>

</body>
</html>
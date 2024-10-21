<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'includes/config.php';

$mensagem_sucesso = "";
$mensagem_erro = "";
$produto = null;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql_verifica = "SELECT * FROM produtos WHERE id = ?";
    $stmt_verifica = $conn->prepare($sql_verifica);
    $stmt_verifica->bind_param('i', $id); // Corrigido para 'i' e usando $id
    $stmt_verifica->execute();
    $resultado = $stmt_verifica->get_result();
    if ($resultado->num_rows > 0) {
        $produto = $resultado->fetch_assoc();
    } else {
        $mensagem_erro = "Produto não encontrado!";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $quantidade = intval($_POST['quantidade']);

    $sql_update = "UPDATE produtos SET nome=?, descricao=?, quantidade=? WHERE id=?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('ssii', $nome, $descricao, $quantidade, $id);

    if ($stmt_update->execute()) {
        $mensagem_sucesso = "Produto atualizado com sucesso.";
        header("Location: dashboard.php");
        exit();
    } else {
        $mensagem_erro = "Erro ao atualizar o produto.";
    }

    $stmt_update->close();
}

$conn->close();
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
    <title>Cadastro de Produtos</title>
</head>
<body>
    <div class="quadrado">
        <form action="" method="POST">
            <div class="login">
                <h2>Editar produtos</h2>
            </div>
            <div class="email">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo $produto['nome'] ?? '' ?>" required><br>
            </div>
            <div class="email">
                <label for="descricao">Descrição:</label>
                <input type="text" id="descricao" name="descricao" value="<?php echo $produto['descricao'] ?? '' ?>" required><br>
            </div>
            <div class="email">
                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade"  value="<?php echo $produto['quantidade'] ?? '' ?>"required><br>
            </div>

            <?php if ($mensagem_sucesso): ?>
                <p><?php echo $mensagem_sucesso; ?></p>
            <?php endif; ?>
            <?php if ($mensagem_erro): ?>
                <p><?php echo $mensagem_erro; ?></p>
            <?php endif; ?>
            <div class="login">
                <div class="cadastro">
                    <input type="submit" value="Cadastrar">
                </div>
                <a href="dashboard.php">Ir para dashboard</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
session_start();

// Desconectar
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'includes/config.php'; 

$sql = "SELECT * FROM produtos";
$resultado = $conn->query($sql);

if ($resultado === false) {
    echo "Erro na consulta: " . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Dashboard</title>
</head>

<body>
    <header>
        <div class="juntar">
            <div class="sair">
                <a href="?logout=true"><p>SAIR</p></a>
            </div>
            <div class="sair">
                <a href="cadastro-produto.php"><p>CADASTRAR PRODUTOS</p></a>
            </div>
        </div> 
    </header>
    <main>
        <?php if ($resultado->num_rows > 0): ?>
            <?php while ($produto = $resultado->fetch_assoc()): ?>
                <div class="produto">
                    <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                    <h3>Descrição: <?php echo htmlspecialchars($produto['descricao']); ?></h3>
                    <h3>Quantidade: <?php echo intval($produto['quantidade']); ?></h3>
                    <a href="excluir-produto.php?id=<?php echo $produto['id']; ?>">Excluir</a>
                    <a href="editar-produto.php?id=<?php echo $produto['id']; ?>">Editar</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nenhum produto cadastrado.</p>
        <?php endif; ?>
    </main>
    <?php $conn->close(); ?>
</body>
</html>

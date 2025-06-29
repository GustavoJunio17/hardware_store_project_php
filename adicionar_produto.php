<?php
include 'conexao.php';
include 'includes/header.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $preco = floatval($_POST['preco'] ?? 0);
    $quantidade = intval($_POST['quantidade'] ?? 0);
    $imagem_nome = '';

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'img/';
        $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $imagem_nome = uniqid('produto_', true) . '.' . $ext;
        move_uploaded_file($_FILES['imagem']['tmp_name'], $upload_dir . $imagem_nome);
    }

    $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, preco, imagem, quantidade) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsi", $nome, $descricao, $preco, $imagem_nome, $quantidade);
    if ($stmt->execute()) {
        $mensagem = "Produto adicionado com sucesso!";
    } else {
        $mensagem = "Erro ao adicionar produto.";
    }
}
?>

<div class="form-cadastro-produto">
    <h2>Adicionar Produto</h2>
    <?php if ($mensagem): ?>
        <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <label for="nome">Nome do Produto</label>
        <input type="text" name="nome" id="nome" required>

        <label for="descricao">Descrição</label>
        <textarea name="descricao" id="descricao" rows="4" required></textarea>

        <label for="preco">Preço (R$)</label>
        <input type="number" name="preco" id="preco" step="0.01" required>

        <label for="quantidade">Quantidade</label>
        <input type="number" name="quantidade" id="quantidade" min="0" step="1" required>

        <label for="imagem">Imagem</label>
        <input type="file" name="imagem" id="imagem" accept="image/*" required>

        <button type="submit" class="button">Adicionar</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
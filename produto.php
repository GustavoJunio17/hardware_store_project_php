<?php
include 'conexao.php';
include 'includes/header.php';

$id = $_GET['id'] ?? 0;
$produto = $conn->query("SELECT * FROM produtos WHERE id = $id")->fetch_assoc();

if (!$produto) {
    echo "<p>Produto não encontrado.</p>";
    include 'includes/footer.php';
    exit;
}
?>

<div class="produto-container">
  <div class="produto-imagem">
    <img src="img/<?= $produto['imagem'] ?>" alt="<?= $produto['nome'] ?>">
  </div>
  <div class="produto-detalhes">
    <h2><?= htmlspecialchars($produto['nome']) ?></h2>
    <p><?= nl2br(htmlspecialchars($produto['descricao'])) ?></p>
    <p class="preco">Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
    <p>Estoque: <?= $produto['quantidade'] ?></p>

    <?php if ($produto['quantidade'] > 0): ?>
      <a href="carrinho.php?add=<?= $produto['id'] ?>" class="button">Adicionar ao carrinho</a>
    <?php else: ?>
      <a class="button disabled" style="pointer-events: none; opacity: 0.5;">Indisponível</a>
    <?php endif; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
<?php include 'conexao.php'; ?>
<?php include 'includes/header.php'; ?>

<h2>Produtos</h2>
<div class="produtos">
<?php
$result = $conn->query("SELECT * FROM produtos");
while ($row = $result->fetch_assoc()) {
    echo "<div>";
    echo "<img src='img/{$row['imagem']}' width='100'><br>";
    echo "<div>";
    echo "<strong>{$row['nome']}</strong><br>";
    echo "R$ {$row['preco']}<br>";
    echo "</div>";
    echo "<div>";
    echo "<a href='produto.php?id={$row['id']}' class='button'>Ver Produto</a>";
    echo "</div>";
    echo "</div>";
}
?>
</div>

<?php include 'includes/footer.php'; ?>
<?php
session_start();
$_SESSION['carrinho'] = [];
?>

<?php include 'includes/header.php'; ?>

<div class="finalizar-container">
  <h2>Pedido finalizado com sucesso!</h2>
  <a href="index.php">Voltar para a loja</a>
</div>

<?php include 'includes/footer.php'; ?>
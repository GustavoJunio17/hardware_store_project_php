<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['quantidade'])) {
    $id = intval($_POST['id']);
    $novaQtd = intval($_POST['quantidade']);

    $produto = $conn->query("SELECT * FROM produtos WHERE id = $id")->fetch_assoc();
    if ($produto) {
        $qtdAtual = $_SESSION['carrinho'][$id] ?? 0;
        $estoqueDisponivel = $produto['quantidade'] + $qtdAtual;

        if ($novaQtd <= 0) {
            unset($_SESSION['carrinho'][$id]);
            $conn->query("UPDATE produtos SET quantidade = quantidade + $qtdAtual WHERE id = $id");
        } elseif ($novaQtd <= $estoqueDisponivel) {
            $dif = $novaQtd - $qtdAtual;
            $_SESSION['carrinho'][$id] = $novaQtd;
            $conn->query("UPDATE produtos SET quantidade = quantidade - $dif WHERE id = $id");
        } else {
            $_SESSION['erro'] = "Quantidade para {$produto['nome']} excede o estoque disponível.";
        }
    }
    header("Location: carrinho.php");
    exit;
}

if (isset($_GET['add'])) {
    $id = intval($_GET['add']);
    $produto = $conn->query("SELECT * FROM produtos WHERE id = $id")->fetch_assoc();
    if ($produto && $produto['quantidade'] > 0) {
        $_SESSION['carrinho'][$id] = ($_SESSION['carrinho'][$id] ?? 0) + 1;
        $conn->query("UPDATE produtos SET quantidade = quantidade - 1 WHERE id = $id");
    } else {
        $_SESSION['erro'] = "Produto esgotado.";
    }
    header("Location: carrinho.php");
    exit;
}

if (isset($_GET['remove'])) {
    $id = intval($_GET['remove']);
    if (isset($_SESSION['carrinho'][$id])) {
        $qtd = $_SESSION['carrinho'][$id];
        unset($_SESSION['carrinho'][$id]);
        $conn->query("UPDATE produtos SET quantidade = quantidade + $qtd WHERE id = $id");
    }
    header("Location: carrinho.php");
    exit;
}

include 'includes/header.php';
?>

<div class="carrinho-container">
    <h2>Carrinho de Compras</h2>

    <?php
    if (isset($_SESSION['erro'])) {
        echo "<p style='color: red; font-weight: bold; text-align: center;'>" . $_SESSION['erro'] . "</p>";
        unset($_SESSION['erro']);
    }
    ?>

    <?php if (empty($_SESSION['carrinho'])): ?>
        <p>Seu carrinho está vazio.</p>
    <?php else: ?>
        <?php
        $total = 0;
        foreach ($_SESSION['carrinho'] as $id => $qtd):
            $produto = $conn->query("SELECT * FROM produtos WHERE id = $id")->fetch_assoc();
            $subtotal = $produto['preco'] * $qtd;
            $total += $subtotal;
        ?>
        <div class="carrinho-item">
            <span class="nome-produto"><?= htmlspecialchars($produto['nome']) ?></span>

            <form method="POST" style="display: inline-block; margin: 0 10px;">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input
                    type="number"
                    name="quantidade"
                    value="<?= $qtd ?>"
                    min="0"
                    max="<?= $qtd + $produto['quantidade'] ?>"
                    style="width: 60px;"
                    onchange="this.form.submit()"
                >
            </form>

            <span class="subtotal">Subtotal: R$ <?= number_format($subtotal, 2, ',', '.') ?></span>

            <a href="carrinho.php?remove=<?= $id ?>" class="button" style="margin-left: 10px;">Remover</a>
        </div>
        <?php endforeach; ?>

        <p class="carrinho-total">Total: R$ <?= number_format($total, 2, ',', '.') ?></p>

        <a href="finalizar.php" class="carrinho-finalizar" style="margin-top: 20px;">Finalizar Pedido</a>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
<?php
session_start();

// Limpa o carrinho se o usuário decidir
if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

// Produtos disponíveis para referência
$products = [
    1 => ['name' => 'Ração para Cães', 'price' => 50.00],
    2 => ['name' => 'Ração para Gatos', 'price' => 40.00],
    3 => ['name' => 'Ração Premium para Cães', 'price' => 75.00],
    4 => ['name' => 'Ração Premium para Gatos', 'price' => 65.00],
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
</head>
<body>
    <header>
        <h1>Carrinho</h1>
    </header>
    <main>
        <h2>Itens no Carrinho</h2>
        <ul>
            <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                <?php foreach ($_SESSION['cart'] as $id => $quantity): ?>
                    <li>
                        <h3><?php echo $products[$id]['name']; ?></h3>
                        <p>Quantidade: <?php echo $quantity; ?></p>
                        <p>Preço unitário: R$ <?php echo number_format($products[$id]['price'], 2, ',', '.'); ?></p>
                        <p>Total: R$ <?php echo number_format($products[$id]['price'] * $quantity, 2, ',', '.'); ?></p>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li><p>Carrinho vazio.</p></li>
            <?php endif; ?>
        </ul>
        <form action="" method="post">
            <button type="submit" name="clear_cart">Limpar Carrinho</button>
        </form>
        <a href="checkout.php">Prosseguir para o Pagamento</a>
    </main>
</body>
</html>

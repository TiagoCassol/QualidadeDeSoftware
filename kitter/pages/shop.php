<?php
session_start();

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][$product_id] = isset($_SESSION['cart'][$product_id]) ? $_SESSION['cart'][$product_id] + $quantity : $quantity;

    header("Location: shop.php"); 
    exit;
}

$products = [
    ['id' => 1, 'name' => 'Ração para Cães', 'price' => 50.00],
    ['id' => 2, 'name' => 'Ração para Gatos', 'price' => 40.00],
    ['id' => 3, 'name' => 'Ração Premium para Cães', 'price' => 75.00],
    ['id' => 4, 'name' => 'Ração Premium para Gatos', 'price' => 65.00],
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja de Rações</title>
</head>
<body>
    <header>
        <h1>Loja de Rações para Pets</h1>
        <a href="cart.php">Carrinho (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a>
    </header>
    <main>
        <h2>Produtos</h2>
        <ul>
            <?php foreach ($products as $product): ?>
                <li>
                    <h3><?php echo $product['name']; ?></h3>
                    <p>Preço: R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></p>
                    <form action="" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="number" name="quantity" value="1" min="1">
                        <button type="submit" name="add_to_cart">Adicionar ao Carrinho</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>
</body>
</html>

<?php
   //Inicia ou retoma uma sessão
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
      
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //verifica se um produto está sendo adicionado ao carrinho
    if (isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];

        if (!in_array($productId, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $productId;
        }    //...verifica se um item está sendo removido do carrinho
    } elseif (isset($_POST['remove_item'])) {
        $removeProductId = $_POST['remove_item'];

        $_SESSION['cart'] = array_values(array_diff
        ($_SESSION['cart'], [$removeProductId]));
            //...verifica se o usuario está finalizando a compra
    } elseif (isset($_POST['checkout'])) {
        $_SESSION['success_message'] = 'Compra realizada com sucesso!';
        header('Location: index.php'); 
        exit();
    }
}

$products = [
    // Lista de produtos //
    ['id' => 1, 'name' => 'Produto 1', 'price' => 67,00, 'image' => 'produto-1.jpg'],
    ['id' => 2, 'name' => 'Produto 2', 'price' => 50,00, 'image' => 'produto-2.jpg'],
    ['id' => 3, 'name' => 'Produto 3', 'price' => 67,00, 'image' => 'produto-3.jpg'],
    ['id' => 4, 'name' => 'Produto 4', 'price' => 67,00, 'image' => 'produto-4.jpg'],
    ['id' => 5, 'name' => 'Produto 5', 'price' => 67,00, 'image' => 'produto-5.jpg'],
    ['id' => 6, 'name' => 'Produto 6', 'price' => 67,00, 'image' => 'produto-6.jpg'],
    ['id' => 7, 'name' => 'Produto 7', 'price' => 67,00, 'image' => 'produto-7.jpg'],
    ['id' => 8, 'name' => 'Produto 8', 'price' => 67,00, 'image' => 'produto-8.jpg'],
    ['id' => 9, 'name' => 'Produto 9', 'price' => 50,00, 'image' => 'produto-9.jpg'],
    ['id' => 10, 'name' => 'Produto 10', 'price' => 50,00, 'image' => 'produto-10.jpg'],
    ['id' => 11, 'name' => 'Produto 11', 'price' => 50,00, 'image' => 'produto-11.jpg'],
    ['id' => 12, 'name' => 'Produto 12', 'price' => 50,00, 'image' => 'produto-12.jpg'],
];

//Recebe um ID de produto, também retorna o preço se o produto não for encontrado
function getProductPriceById($productId, $products) {
    foreach ($products as $product) {
        if ($product['id'] == $productId) {
            return $product['price'];
        }
    }
    return 0; 
}

  //Calcula o preço total dos itens no carrinho somando seus preços individuais.
$totalPrice = 0;
foreach ($_SESSION['cart'] as $cartProductId) {
    $totalPrice += getProductPriceById($cartProductId, $products);
}

$cartCount = count($_SESSION['cart']);
$successMessage = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']);
?>
  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Minha Loja Virtual</title>
</head>
<body>
 
    <header>
        <h1>Minha Loja Virtual</h1>
    </header> 

    <section class="products">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="img/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h3><?php echo $product['name']; ?></h3>
                <p>Preço: R$<?php echo number_format($product['price'], 2); ?></p>
                <form action="index.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="submit" value="Adicionar ao Carrinho">
                </form>
            </div>
        <?php endforeach; ?>
    </section>

    <?php if (!empty($successMessage)): ?>
        <div class="success-message"><?php echo $successMessage; ?></div>
    <?php endif; ?>

    <section class="cart">
        <p>Carrinho: <?php echo $cartCount; ?> itens</p>
        <?php if ($cartCount > 0): ?>
            <p>Total: R$<?php echo number_format($totalPrice, 2); ?></p>
            <ul>
                <?php foreach ($_SESSION['cart'] as $cartProductId): ?>
                    <li>
                        Produto ID: <?php echo $cartProductId; ?> -
                        Preço: R$<?php echo number_format(getProductPriceById($cartProductId, $products), 2); ?>
                        <form action="index.php" method="post">
                            <input type="hidden" name="remove_item" value="<?php echo $cartProductId; ?>">
                            <input type="submit" value="Remover do Carrinho">
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
            <form action="index.php" method="post">
                <input type="submit" name="checkout" value="Finalizar Compra">
            </form>
        <?php else: ?>
            <p>O carrinho está vazio.</p>
        <?php endif; ?>
    </section>
    <footer>
    <div>
    <img src="img/logotipo2.png.png" alt="Shopping Online Store" width="300" height="200">
    
    </div>

    <div>
       
     <strong class="titulo">Categorias</strong> 
    <ul>
         <li>Roupas casuais</li>
         <li>Tenis</li>
         <li>Relogios</li>
         <li>Fones</li>
         <li>Roupas esportivas</li>
    
        </ul>
    </div>

     <div>
     <strong class="titulo">Encontre-nos</strong>
     <p>Whatsapp:<a href="https://wa.me/5583998776900" target="_blank">(83) 987182062</a></p>
     <p>Email: <a href="mailto: Shopping Online Store.com">Shopping Online Store</a></p>
     <p>Endereço: Av. Liberdade, 1379 - São Bento, Bayeux - PB, 58305-006</p>
     </div>
</footer>
<div id="copyright">
    Desenvolvido por <a href="https://instagram.com/gian_luca.1" target="_blank">gian_luca.1</a>
                     <a href="https://instagram.com/arthur.silva25" target="_blank">arthur.silva25</a>
                     <a href="https://instagram.com/netonascimento0" target="_blank">netonascimento0</a>
</div>


</body>
</html>
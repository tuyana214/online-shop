<!DOCTYPE html>
<html lang="ru">
<body>
<header>
    <nav>
        <a href="/catalog">Каталог</a>
        <a href="/profile">Мой профиль</a>
        <a href="/create-order">Заказать</a>
    </nav>
</header>

<main>
    <h1>Корзина</h1>

    <?php if (empty($userProducts)): ?>
        <p>Ваша корзина пуста.</p>
    <?php else: ?>
        <form action="/cart" method="POST">
            <div class="cart-items">
                <?php foreach ($userProducts as $userProduct): ?>
                    <div class="cart-item">
                        <div class="cart-item-details">
                            <img src="<?php echo $userProduct->getProduct()->getImageUrl(); ?>" alt="Изображение товара" class="cart-item-img">
                            <div class="cart-item-info">
                                <h3><?php echo $userProduct->getProduct()->getName(); ?></h3>
                                <p><?php echo $userProduct->getProduct()->getDescription(); ?></p>
                                <p><strong>Цена: </strong><?php echo number_format($userProduct->getProduct()->getPrice(), 2, ',', ' ') . ' руб.'; ?></p>
                            </div>
                        </div>

                        <div class="cart-item-actions">
                            <label for="amount_<?php echo $userProduct->getProductId(); ?>"><b>Количество:</b></label>
                            <input type="number" id="amount_<?php echo $userProduct->getProductId(); ?>" name="amount[<?php echo $userProduct->getProductId(); ?>]" value="<?php echo $userProduct->getAmount(); ?>" min="1" required>

                            <div class="amount-controls">
                                <form action="/remove-product" method="POST" style="display: inline;">
                                    <input type="hidden" name="product_id" value="<?php echo $userProduct->getProductId(); ?>">
                                    <input type="hidden" name="amount" value="1">
                                    <button type="submit">-</button>
                                </form>
                                <form action="/add-product" method="POST" style="display: inline;">
                                    <input type="hidden" name="product_id" value="<?php echo $userProduct->getProductId(); ?>">
                                    <input type="hidden" name="amount" value="1">
                                    <button type="submit">+</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

            <div class="cart-total">
                <p><strong>Общая стоимость: </strong><?php echo number_format($totalSum, 2, ',', ' ') . ' руб.'; ?></p>
            </div>
        </form>
    <?php endif; ?>
</main>
</body>
</html>

<style>
    .amount-controls button {
        background-color: #f39c12;
        color: #fff;
        border: none;
        font-size: 1.2rem;
        font-weight: bold;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        margin: 5px;
    }

    .amount-controls button:hover {
        background-color: #e67e22;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .amount-controls button:active {
        background-color: #d35400;
        transform: translateY(0);
        box-shadow: none;
    }

    .amount-controls {
        margin-top: 10px;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        color: #333;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #2c3e50;
        padding: 15px;
    }

    nav a {
        color: #ecf0f1;
        text-decoration: none;
        margin-right: 20px;
        font-weight: bold;
    }

    nav a:hover {
        color: #f39c12;
    }

    main h1 {
        font-size: 2.5rem;
        color: #e74c3c;
        text-align: center;
        margin-top: 40px;
    }

    .cart-items {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        margin: 0 20px;
    }

    .cart-item {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        width: 100%;
        max-width: 350px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .cart-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .cart-item-img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .cart-item-info {
        padding: 15px;
        text-align: center;
    }

    .cart-item-info h3 {
        font-size: 1.5rem;
        color: #2c3e50;
    }

    .cart-item-info p {
        font-size: 1rem;
        color: #7f8c8d;
    }

    .cart-item-actions {
        display: flex;
        flex-direction: column;
        padding: 15px;
        align-items: center;
        background-color: #f1c40f;
        text-align: center;
    }

    .cart-item-actions label {
        font-size: 1rem;
        font-weight: bold;
        color: #fff;
    }

    .cart-item-actions input {
        padding: 10px;
        font-size: 1rem;
        border: none;
        border-radius: 5px;
        margin-bottom: 10px;
        width: 50%;
    }

    .cart-item-actions .remove-btn {
        text-decoration: none;
        color: #e74c3c;
        font-weight: bold;
        margin-top: 10px;
    }

    .cart-item-actions .remove-btn:hover {
        color: #c0392b;
    }

    .cart-total {
        padding: 20px;
        background-color: #2c3e50;
        color: #fff;
        text-align: center;
        margin-top: 20px;
        border-radius: 10px;
    }

    .cart-total p {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .cart-total .total-price {
        font-size: 1.5rem;
        color: #f39c12;
    }

    /* Форма */
    form {
        margin-top: 20px;
    }

    form input[type="submit"] {
        background-color: #e74c3c;
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 1.2rem;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
    }

    form input[type="submit"]:hover {
        background-color: #c0392b;
    }
</style>
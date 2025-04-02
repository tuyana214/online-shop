<!DOCTYPE html>
<html lang="ru">
<body>
<header>
    <nav>
        <a href="/catalog">Каталог</a>
        <a href="/profile">Мой профиль</a>
        <a href="/order">Заказать</a>
    </nav>
</header>

<main>
    <h1>Корзина</h1>

    <?php if (empty($products)): ?>
        <p>Ваша корзина пуста.</p>
    <?php else: ?>
        <form action="/cart" method="POST">
            <div class="cart-items">
                <?php foreach ($products as $product): ?>
                    <div class="cart-item">
                        <div class="cart-item-details">
                            <img src="<?php echo $product['image_url']; ?>" alt="Изображение товара" class="cart-item-img">
                            <div class="cart-item-info">
                                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                <p><?php echo htmlspecialchars($product['description']); ?></p>
                                <p><strong>Цена: </strong><?php echo number_format($product['price'], 2, ',', ' ') . ' руб.'; ?></p>
                            </div>
                        </div>

                        <div class="cart-item-actions">
                            <label for="amount_<?php echo $product['id']; ?>"><b>Количество:</b></label>
                            <input type="number" id="amount_<?php echo $product['id']; ?>" name="amount[<?php echo $product['id']; ?>]" value="<?php echo $product['amount']; ?>" min="1" required>

                            <a href="/cart?remove=<?php echo $product['id']; ?>" class="remove-btn">Удалить</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="cart-total">
                <p><strong>Общая стоимость: </strong><?php echo number_format($totalPrice, 2, ',', ' ') . ' руб.'; ?></p>
            </div>
        </form>
    <?php endif; ?>
</main>
</body>
</html>

<style>
    /* Общие стили */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        color: #333;
        margin: 0;
        padding: 0;
    }

    /* Шапка страницы */
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

    /* Заголовок корзины */
    main h1 {
        font-size: 2.5rem;
        color: #e74c3c;
        text-align: center;
        margin-top: 40px;
    }

    /* Блок с товарами в корзине */
    .cart-items {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        margin: 0 20px;
    }

    /* Элемент товара */
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

    /* Изображение товара */
    .cart-item-img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    /* Информация о товаре */
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

    /* Действия с товаром */
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

    /* Блок с итоговой суммой */
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

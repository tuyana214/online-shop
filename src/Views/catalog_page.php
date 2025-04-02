<form action="/catalog" method="POST">
<div class="container">
    <div class="header">
        <a href="/profile">Мой профиль</a>
        <a href="/cart">Моя корзина</a>
        <h3>Catalog</h3>
    </div>

    <div class="card-deck">
        <?php foreach ($products as $product): ?>
            <div class="card text-center">
                <a href="#">
                    <div class="card-header">
                        Hit!
                    </div>
                    <img class="card-img-top" src="<?php echo $product['image_url']; ?>" alt="Card image">
                    <div class="card-body">
                        <p class="card-text text-muted"><?php echo $product['name']; ?></p>
                        <a href="#"><h5 class="card-title"><?php echo $product['description']; ?></h5></a>
                        <div class="card-footer">
                            <?php echo $product['price']; ?>
                        </div>
                    </div>
                </a>
            </div>

            <form action="/catalog" method="POST">
                <div class="container">
                    <input type="hidden" placeholder="Enter product-id" name="product_id" value="<?php echo $product['id']; ?>" id="product_id" required>

                    <label for="amount"><b>Amount</b></label>
                    <?php if (isset($errors['amount'])): ?>
                        <label style="color:red"><?php echo $errors['amount']; ?></label>
                    <?php endif; ?>
                    <input type="text" placeholder="Enter amount" name="amount" id="amount" required>

                    <button type="submit" class="registerbtn">Add product</button>
                </div>
            </form>

        <?php endforeach; ?>

<style>
    /* Общие стили */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        color: #333;
    }

    /* Заголовок страницы */
    .header h3 {
        font-size: 2.5rem;
        font-weight: bold;
        color: #e74c3c;
    }

    /* Карточки */
    .card {
        border-radius: 10px;
        transition: all 0.3s ease;
        border: 2px solid #f39c12; /* Яркая граница */
        overflow: hidden;
        background-color: #fff;
    }

    /* Эффект при наведении на карточку */
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    /* Заголовок карточки */
    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
        color: #2980b9;
    }

    /* Описание товара */
    .card-text {
        font-size: 1rem;
        color: #7f8c8d;
        margin-bottom: 1rem;
    }

    /* Цена товара */
    .price {
        font-size: 1.3rem;
        color: #f39c12; /* Яркий желтый цвет для цены */
        font-weight: bold;
    }

    /* Кнопка "Добавить в корзину" */
    .btn-danger {
        background-color: #e74c3c;
        border-color: #e74c3c;
        font-weight: bold;
        padding: 10px;
    }

    .btn-danger:hover {
        background-color: #c0392b;
        border-color: #c0392b;
    }

    /* Кнопка для навигации */
    .btn-link {
        color: #3498db;
        text-decoration: none;
        font-weight: bold;
    }

    .btn-link:hover {
        color: #2980b9;
        text-decoration: underline;
    }

    /* Стилизация формы для добавления товара */
    .form-control {
        border-radius: 5px;
        border: 1px solid #f39c12;
        margin-bottom: 10px;
    }

    .form-control:focus {
        border-color: #f1c40f;
        box-shadow: 0 0 5px rgba(241, 196, 15, 0.5);
    }

    /* Колонки */
    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    /* Отступы для карточек */
    .col-md-4 {
        margin-bottom: 20px;
    }

    /* Фоновая обертка для страницы */
    .container {
        padding-top: 40px;
    }
</style>


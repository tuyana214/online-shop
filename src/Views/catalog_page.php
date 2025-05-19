<div class="container">
    <div class="header">
        <a href="/profile">Мой профиль</a>
        <a href="/cart">Моя корзина</a>
        <a href="/orders">Мои заказы</a>
        <h3>Каталог</h3>
    </div>

    <?php foreach ($products as $product): ?>
    <div class="card text-center">
        <a href="#">
            <img class="card-img-top" src="<?php echo $product->getImageUrl(); ?>" alt="Card image">
            <div class="card-body">
                <p class="card-text text-muted"><?php echo $product->getName(); ?></p>
                <a href="#"><h5 class="card-title"><?php echo $product->getDescription(); ?></h5></a>
                <div class="price"><?php echo $product->getPrice(); ?></div>

                <?php
                $amount = 0;
                foreach ($userProducts as $userProduct) {
                    if ($userProduct->getProductId() == $product->getId()) {
                        $amount = $userProduct->getAmount();
                    }
                }
                ?>
                <span class="product-quantity" data-product-id="<?php echo $product->getId(); ?>">
                    </span>
                <p>Количество: <?php echo $amount; ?></p>
            </div>
        </a>
    </div>
</div>


    <div class="form-container">
        <form class="add-product" method="POST" onsubmit="return false">
            <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
            <input type="hidden" name="amount" value="1">
            <button type="submit" class="button">+</button>
        </form>
        <form class="remove-product" method="POST" onsubmit="return false">
                <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
                <input type="hidden" name="amount" value="1">
                <button type="submit" class="button">-</button>
        </form>
        <form action="/product" method="POST" style="display: inline;">
            <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
            <button type="submit">Подробнее</button>
        </form>
    </div>
<?php endforeach; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $("document").ready(function () {
        $('.add-product').submit(function () {
            $.ajax({
                type: "POST",
                url: "/add-product",
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    $('.product-quantity').text(response.amount)
                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при добавлении товара:', error);
                }
            });
        });
        $('.remove-product').submit(function () {
            $.ajax({
                type: "POST",
                url: "/remove-product",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    $('.product-quantity').text(response.amount)
                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при удалении товара:', error);
                }
            });
        });
    });
</script>

<style>
    .container {
        font-family: Arial, sans-serif;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e0e0e0;
    }

    .header a {
        text-decoration: none;
        color: #333;
        margin-right: 20px;
        font-size: 16px;
        transition: color 0.2s;
    }

    .header a:hover {
        color: #0066cc;
    }

    .header h3 {
        margin: 0;
        font-size: 24px;
        color: #333;
    }

    .card {
        display: inline-block;
        width: 250px;
        margin: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s;
        vertical-align: top;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .card-img-top {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .card-body {
        padding: 15px;
        text-align: center;
    }

    .card-text {
        font-size: 14px;
        color: #666;
        margin-bottom: 5px;
    }

    .card-title {
        font-size: 16px;
        color: #333;
        margin: 10px 0;
        text-decoration: none;
        display: block;
    }

    .card-title:hover {
        color: #0066cc;
    }

    .price {
        font-size: 18px;
        font-weight: bold;
        color: #d32f2f;
        margin: 10px 0;
    }

    .product-quantity {
        font-weight: bold;
        font-size: 16px;
        display: inline-block;
        margin: 0 5px;
    }

    .form-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
        padding: 10px 0;
    }

    .button {
        background-color: #2196F3;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 8px 12px;
        cursor: pointer;
        font-size: 16px;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
    }

    .button:hover {
        background-color: #0b7dda;
    }

    .form-container button[type="submit"] {
        background-color: #4CAF50;
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        color: white;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.2s;
    }

    .form-container button[type="submit"]:hover {
        background-color: #3e8e41;
    }

    .remove-product .button {
        background-color: #f44336;
    }

    .remove-product .button:hover {
        background-color: #d32f2f;
    }

    /* Для выравнивания карточек продуктов */
    .container > div:not(.header) {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
</style>

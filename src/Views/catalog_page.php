
<div class="container">
    <div class="header">
        <a href="/profile">Мой профиль</a>
        <a href="/cart">Моя корзина</a>
        <a href="/orders">Мои заказы</a>
        <h3>Catalog</h3>
    </div>

        <?php foreach ($products as $product): ?>
            <div class="card text-center">
                <a href="#">
                    <div class="card-header">
                        Hit!
                    </div>
                    <img class="card-img-top" src="<?php echo $product->getImageUrl(); ?>" alt="Card image">
                    <div class="card-body">
                        <p class="card-text text-muted"><?php echo $product->getName(); ?></p>
                        <a href="#"><h5 class="card-title"><?php echo $product->getDescription(); ?></h5></a>
                        <div class="card-footer">
                            <span class="price"><?php echo $product->getPrice(); ?></span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="amount-controls">
                <form action="/remove-product" method="POST" style="display: inline;">
                    <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
                    <input type="hidden" name="amount" value="1">
                    <button type="submit">-</button>
                </form>
                <form action="/add-product" method="POST" style="display: inline;">
                    <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
                    <input type="hidden" name="amount" value="1">
                    <button type="submit">+</button>
                </form>
            </div>
        <?php endforeach; ?>

<style>
    .amount-controls button {
        background-color: #e74c3c;
        color: #fff;
        border: none;
        font-size: 1.2rem;
        font-weight: bold;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        margin: 0 5px;
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

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        color: #333;
    }

    .header h3 {
        font-size: 2.5rem;
        font-weight: bold;
        color: #e74c3c;
    }

    .card {
        border-radius: 10px;
        transition: all 0.3s ease;
        border: 2px solid #e74c3c;
        overflow: hidden;
        background-color: #fff;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
        color: #2980b9;
    }

    .card-text {
        font-size: 1rem;
        color: black;
        margin-bottom: 1rem;
    }

    .price {
        font-size: 1.8rem;
        color: #e74c3c;
        font-weight: bold;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        padding: 5px 0;
        display: inline-block;
    }

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

    .btn-link {
        color: #3498db;
        text-decoration: none;
        font-weight: bold;
    }

    .btn-link:hover {
        color: #2980b9;
        text-decoration: underline;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #f39c12;
        margin-bottom: 10px;
    }

    .form-control:focus {
        border-color: #f1c40f;
        box-shadow: 0 0 5px rgba(241, 196, 15, 0.5);
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    .col-md-4 {
        margin-bottom: 20px;
    }

    .container {
        padding-top: 40px;
    }
</style>


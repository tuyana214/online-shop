<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заказы</title>
</head>
<body>
<a href="/catalog" class="back-btn">Перейти в каталог</a>
<h1>Мои заказы</h1>
<div class="order-container">
    <?php foreach ($userOrders as $userOrder): ?>
        <div class="order-card">
            <h2>Заказ № <?php echo $userOrder->getId(); ?></h2>
            <p><?php echo $userOrder->getContactName(); ?></p>
            <p><?php echo $userOrder->getContactPhone(); ?></p>
            <p><?php echo $userOrder->getComment(); ?></p>
            <p><?php echo $userOrder->getAddress(); ?></p>
            <table>
                <thead>
                <tr>
                    <th>Изображение</th>
                    <th>Наименование</th>
                    <th>Количество</th>
                    <th>Стоимость</th>
                    <th>Сумма</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($userOrder->getOrderProducts() as $orderProduct): ?>
                    <tr>
                        <td>
                            <img src="<?php echo $orderProduct->getProduct()->getImageUrl(); ?>" alt="Продукт" class="product-image">
                        </td>
                        <td><?php echo $orderProduct->getProduct()->getName(); ?></td>
                        <td><?php echo $orderProduct->getAmount(); ?></td>
                        <td><?php echo $orderProduct->getProduct()->getPrice(); ?> руб.</td>
                        <td><?php echo $orderProduct->getSum(); ?> руб.</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <p>Сумма заказа: <?php echo $userOrder->getSum(); ?> руб.</p>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f8ff;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .back-btn {
        display: inline-block;
        background-color: #8e44ad;
        color: #fff;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        font-size: 16px;
        border-radius: 5px;
        margin: 20px;
        transition: background-color 0.3s;
    }

    .back-btn:hover {
        background-color: #6c3483;
    }

    h1 {
        text-align: center;
        color: #2c3e50;
        font-size: 30px;
        margin-top: 40px;
    }

    .order-container {
        max-width: 1000px;
        margin: 30px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .order-card {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .order-card h2 {
        font-size: 24px;
        color: #3498db;
    }

    .order-card p {
        font-size: 16px;
        color: #7f8c8d;
        margin: 5px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 16px;
    }

    table th, table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background-color: #8e44ad;
        color: white;
    }

    table tr:hover {
        background-color: #f0f8ff;
    }

    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
    }
</style>
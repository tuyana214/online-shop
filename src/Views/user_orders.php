<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<a href="/catalog" class="back-btn">Перейти в каталог</a>
    <h1>Мои заказы</h1>
    <div class="order-container">
            <?php foreach ($newUserOrders as $newUserOrder): ?>
                <div class="order-card">
                    <h2>Заказ № <?php echo $newUserOrder['id']?></h2>
                    <p><?php echo $newUserOrder['contact_name']?></p>
                    <p><?php echo $newUserOrder['contact_phone']?></p>
                    <p><?php echo $newUserOrder['comment']?></p>
                    <p><?php echo $newUserOrder['address']?></p>
                    <table>
                        <thead>
                        <tr>
                            <th>Наименование</th>
                            <th>Количество</th>
                            <th>Стоимость</th>
                            <th>Сумма</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($newUserOrder['products'] as $newOrderProduct): ?>
                                <tr>
                                    <td><?php echo $newOrderProduct['name']?></td>
                                    <td><?php echo $newOrderProduct['amount']?></td>
                                    <td><?php echo $newOrderProduct['price']?></td>
                                    <td><?php echo $newOrderProduct['totalSum']?></td>
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                    <p>Сумма заказа <?php echo $newUserOrder['total'];?></p>
                </div>
            <? endforeach; ?>
    </div>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: skyblue;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .back-btn {
        display: inline-block;
        background-color: plum;
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
        background-color: #2980b9;
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
        background-color: plum;
        color: white;
    }

    table tr:hover {
        background-color: #f0f8ff;
    }

    .order-card p.total {
        font-size: 18px;
        color: #27ae60;
        font-weight: bold;
    }
</style>

<!DOCTYPE html>
<html lang="ru">
<body>
<div class="container">
    <h1>Ваш заказ оформлен!</h1>
    <a href="/orders" class="btn">Мои заказы</a>
    <a href="/catalog" class="btn">Перейти в каталог</a>
</div>
</body>
</html>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 28px;
        color: #2c3e50;
        text-align: center;
        margin-bottom: 20px;
    }

    h3 {
        font-size: 20px;
        color: #27ae60;
        text-align: center;
        margin-bottom: 30px;
    }

    .btn {
        display: inline-block;
        background-color: #3498db;
        color: #ffffff;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        font-size: 16px;
        border-radius: 5px;
        margin: 0 auto;
        display: block;
        width: 200px;
        transition: background-color 0.3s ease;
        margin-bottom: 20px;
    }

    .btn:hover {
        background-color: #2980b9;
    }

    p {
        text-align: center;
        font-size: 16px;
        color: #7f8c8d;
    }
</style>
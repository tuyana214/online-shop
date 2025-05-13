<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 Internal Server Error</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="error-container">
    <h1 class="error-code">500</h1>
    <p class="error-message">Внутренняя ошибка сервера. Попробуйте позже.</p>
    <a href="/catalog" class="home-link">Вернуться в каталог</a>
</div>
</body>
</html>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f7f7f7;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        color: #333;
    }

    .error-container {
        text-align: center;
        background-color: #fff;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .error-code {
        font-size: 120px;
        color: #e74c3c;
    }

    .error-message {
        font-size: 20px;
        margin-top: 20px;
        color: #555;
    }

    .home-link {
        display: inline-block;
        margin-top: 30px;
        font-size: 16px;
        color: #3498db;
        text-decoration: none;
        border: 1px solid #3498db;
        padding: 10px 20px;
        border-radius: 4px;
    }

    .home-link:hover {
        background-color: #3498db;
        color: #fff;
    }
</style>
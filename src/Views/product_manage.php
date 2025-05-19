<h1>Управление продуктами</h1>

<h2>Добавить продукт</h2>
<form method="POST" action="/add-new-product">
    <label for="name">Название:</label>
    <input type="text" id="name" name="name" required>

    <label for="price">Цена:</label>
    <input type="number" id="price" name="price" required>

    <label for="description">Описание:</label>
    <input type="text" id="description" name="description" required>

    <label for="image_url">Фото:</label>
    <input type="text" id="image_url" name="image_url" required>

    <button type="submit">Добавить</button>
</form>

<h2>Удалить продукт</h2>
<form method="POST" action="/delete-product">
    <label for="delete-product">Выберите продукт:</label>
    <select id="delete-product" name="product_id" required>
        <option value="">Выберите продукт</option>
        <?php foreach ($products as $product): ?>
            <option value="<?php echo $product->getId(); ?>"><?php echo $product->getName(); ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Удалить</button>
</form>

<a href="/admin">Вернуться</a>

<style>
    /* Общий стиль для страницы */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #ffe5e5; /* Светлый фон */
        color: #333;
        margin: 0;
        padding: 0;
    }

    /* Заголовок страницы */
    h1, h2 {
        text-align: center;
        color: #d50000; /* Красный цвет заголовка */
        font-size: 28px;
        margin-top: 30px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    /* Стили для форм */
    form {
        width: 60%;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
    }

    form label {
        font-size: 16px;
        margin-bottom: 8px;
        display: block;
        color: #333;
    }

    form input, form select {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
        box-sizing: border-box;
        background-color: #fff;
    }

    form input:focus, form select:focus {
        outline: none;
        border-color: #d50000; /* Красная рамка при фокусе */
        box-shadow: 0 0 5px rgba(213, 0, 0, 0.5); /* Легкая тень */
    }

    form button {
        background-color: #d50000; /* Ярко-красная кнопка */
        color: #fff;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        font-size: 18px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s ease;
    }

    form button:hover {
        background-color: #b30000; /* Темный красный при наведении */
    }

    /* Стилизация выпадающего списка */
    form select {
        background-color: #fff;
        border: 1px solid #ddd;
    }

    form select option {
        padding: 12px;
        font-size: 16px;
    }

    /* Легкая тень для элементов формы */
    form input, form select, form button {
        transition: box-shadow 0.3s ease;
    }

    form input:focus, form select:focus, form button:hover {
        box-shadow: 0 0 5px rgba(213, 0, 0, 0.3);
    }

    /* Плашка с сообщением об ошибке */
    .error-message {
        color: #ff0000;
        font-size: 14px;
        text-align: center;
        margin-top: 10px;
    }

    /* Стиль для кнопки "Вернуться" */
    a {
        display: inline-block;
        background-color: #ff4f4f; /* Яркий красный фон */
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 4px;
        font-size: 16px;
        text-align: center;
        transition: background-color 0.3s ease, transform 0.3s ease;
        margin-top: 20px;
    }

    a:hover {
        background-color: #b30000; /* Темный красный при наведении */
        transform: translateY(-2px); /* Легкая анимация при наведении */
    }

    a:focus {
        outline: none;
        box-shadow: 0 0 5px rgba(213, 0, 0, 0.5); /* Легкая тень при фокусе */
    }
</style>
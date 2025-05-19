<a href="/product-manage">Управление продуктами</a>
<a href="/profile">Мой профиль</a>

<h2>Список продуктов</h2>
<table>
    <thead>
    <tr>
        <th>Название</th>
        <th>Цена</th>
        <th>Описание</th>
        <th>Фото</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo $product->getName(); ?></td>
            <td><?php echo $product->getPrice(); ?></td>
            <td><?php echo $product->getDescription(); ?> </td>
            <td><img src="<?php echo $product->getImageUrl(); ?>" alt="Фото продукта" style="max-width: 100px;"></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<style>
    /* Общий стиль для страницы */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #ffe5e5; /* Светлый фон */
        color: #333;
        margin: 0;
        padding: 0;
    }

    /* Ссылки */
    a {
        text-decoration: none;
        color: #d50000; /* Яркий красный цвет */
        font-size: 18px;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 5px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    a:hover {
        background-color: #d50000; /* Красный фон при наведении */
        color: white; /* Белый текст при наведении */
    }

    /* Заголовок страницы */
    h2 {
        text-align: center;
        color: #d50000; /* Красный цвет заголовка */
        font-size: 28px;
        margin-top: 30px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Легкая тень для текста */
    }

    /* Стили для таблицы */
    table {
        width: 80%;
        margin: 30px auto;
        border-collapse: collapse;
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden; /* Убираем выступающие углы */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Легкая тень */
    }

    /* Заголовки таблицы */
    thead {
        background-color: #d50000; /* Ярко красный фон */
        color: #fff;
    }

    th, td {
        padding: 15px;
        text-align: left;
        border-bottom: 2px solid #f1f1f1; /* Светлая граница между строками */
    }

    th {
        font-weight: bold;
        font-size: 18px;
    }

    td {
        font-size: 16px;
    }

    /* Ховер для строк */
    tbody tr:hover {
        background-color: #ffebee; /* Светло-красный фон для строк при наведении */
    }

    /* Изображения */
    td img {
        max-width: 120px;
        border-radius: 8px;
        transition: transform 0.3s ease-in-out;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Легкая тень */
    }

    td img:hover {
        transform: scale(1.1); /* Увеличение при наведении */
    }
</style>
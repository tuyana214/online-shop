<form action="/create-order" method="POST">
    <div class="container">
        <a href="/catalog">Вернуться в каталог</a>
        <h1>Оформить заказ</h1>
        <p>Заполните форму для оформления заказа.</p>
        <hr>

        <label for="contact_name"><b>Имя заказчика</b></label>
        <?php if (isset($errors['contact_name'])): ?>
            <label style="color:red"><?php echo $errors['contact_name']; ?></label>
        <?php endif; ?>
        <input type="text" placeholder="Введите имя заказчика" name="contact_name" required>

        <label for="contact_phone"><b>Телефон</b></label>
        <?php if (isset($errors['contact_phone'])): ?>
            <label style="color:red"><?php echo $errors['contact_phone']; ?></label>
        <?php endif; ?>
        <input type="text" placeholder="Введите ваш телефон" name="contact_phone" required>

        <label for="address"><b>Адрес доставки</b></label>
        <?php if (isset($errors['address'])): ?>
            <label style="color:red"><?php echo $errors['address']; ?></label>
        <?php endif; ?>
        <input type="text" placeholder="Введите адрес доставки" name="address" required>

        <label for="comment"><b>Комментарий</b></label>
        <input type="text" placeholder="Введите ваш комментарий" name="comment" required>

        <button type="submit" class="registerbtn">Оформить заказ</button>
    </div>
</form>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
    }

    .container {
        background-color: #ffffff;
        padding: 30px;
        margin: 50px auto;
        max-width: 600px;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        background: linear-gradient(135deg, #ff7e5f, #feb47b);
    }

    h1 {
        font-size: 28px;
        text-align: center;
        color: #fff;
        margin-bottom: 20px;
        font-weight: 700;
    }

    a {
        text-decoration: none;
        color: #ffffff;
        display: inline-block;
        margin-top: 15px;
        text-align: center;
        font-size: 14px;
        background-color: #28a745;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    a:hover {
        background-color: #218838;
    }

    label {
        font-size: 16px;
        color: #fff;
        margin-top: 15px;
        display: block;
        font-weight: 600;
    }

    input[type="text"] {
        width: 100%;
        padding: 15px;
        margin: 10px 0;
        border: 2px solid #feb47b;
        border-radius: 5px;
        font-size: 16px;
        background-color: #fff;
        color: #333;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input[type="text"]:focus {
        border-color: #ff7e5f;
        outline: none;
        box-shadow: 0 0 8px rgba(255, 126, 95, 0.6);
    }

    button.registerbtn {
        background-color: #ff7e5f;
        color: white;
        padding: 15px 0;
        border: none;
        border-radius: 5px;
        width: 100%;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    button.registerbtn:hover {
        background-color: #feb47b;
        transform: scale(1.05);
    }

    p {
        font-size: 18px;
        color: #fff;
        margin-top: 20px;
        text-align: center;
        font-weight: 700;
    }
</style>
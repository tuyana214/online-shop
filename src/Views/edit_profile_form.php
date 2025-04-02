<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    $pdo = new PDO('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pwd');
    $stmt = $pdo->query("SELECT * FROM users WHERE id = '$userId'");
    $user = $stmt->fetch();
} else {
    header("Location: /login");
    exit;
}

?>

<div class="container">
    <div class="header">
        <a href="/profile" class="profile-link">Мой профиль</a>
        <h3>Редактировать Профиль</h3>
    </div>

    <form action="/edit-profile" method="POST">
        <div class="form-group">
            <label for="name">Введите новое имя</label>
            <?php if (isset($errors['name'])): ?>
                <label style="..."><?php echo $errors['name']; ?></label>
            <?php endif; ?>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>"/>
        </div>
        <div class="form-group">
            <label for="email">Введите новый Email</label>
            <?php if (isset($errors['email'])): ?>
                <label style="..."><?php echo $errors['email']; ?></label>
            <?php endif; ?>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"/>
        </div>
        <div class="form-group">
            <label for="password">Текущий пароль</label>
            <input type="password" id="password" name="password" placeholder="Введите текущий пароль (для подтверждения)" required>
        </div>
        <div class="form-group">
            <label for="new_password">Новый пароль</label>
            <?php if (isset($errors['new_password'])): ?>
                <label style="..."><?php echo $errors['password']; ?></label>
            <?php endif; ?>
            <input type="password" id="new_password" name="new_password" placeholder="Введите новый пароль" />
        </div>
        <div class="form-group">
            <label for="confirm_new_password">Подтверждение нового пароля</label>
            <?php if (isset($errors['confirm_new_password'])): ?>
                <label style="..."><?php echo $errors['password']; ?></label>
            <?php endif; ?>
            <input type="password" id="confirm_new_password" name="confirm_new_password" placeholder="Подтвердите новый пароль" />
        </div>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
    </form>
</div>

<style>
    .container {
        width: 80%;
        margin: 0 auto;
        text-align: center;
    }
    .profile-link {
        font-size: 18px;
        color: deeppink;
        font-weight: bold;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
    }
    .form-group input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .btn-primary {
        background-color: deeppink;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }
    .btn-primary:hover {
        background-color: darkviolet;
    }
    .error {
        color: red;
        font-size: 14px;
    }
</style>
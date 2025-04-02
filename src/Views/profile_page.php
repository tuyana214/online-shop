<div class="container">
    <div class="profile-info">
        <header class="panel-title">
            <div class="text-center">
                <strong>Профиль пользователя</strong>
            </div>
        </header>
        <p><strong>Имя:</strong> <?php echo htmlspecialchars($user['name'] ?? 'Не указано'); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email'] ?? 'Не указано'); ?></p>
    </div>
    <div class="profile-actions">
        <a href="/edit-profile" class="btn btn-primary">Редактировать профиль</a>
        <a href="/logout" class="btn btn-primary">Выйти</a>
    </div>
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
    .profile-info p {
        font-size: 18px;
        line-height: 2em;
    }
    .profile-actions a {
        font-size: 18px;
        background-color: deeppink;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
    }
    .profile-actions a:hover {
        background-color: darkviolet;
    }
</style>

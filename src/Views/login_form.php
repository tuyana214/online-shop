<form action="/login" method="POST">
    <div class="wrapper">
    <form class="form-signin" action="../login/handle_login.php" method="post">
        <h2 class="form-signin-heading">Please login</h2>
        <input type="text" class="form-control" name="username" placeholder="Email Address" required="" autofocus="" />
        <input type="password" class="form-control" name="password" placeholder="Password" required=""/>
        <label class="checkbox">
            <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
    </form>
</div>

<style>

    .wrapper {
        max-width: 400px;
        margin: 0 auto;
        padding: 40px;
        background-color: whitesmoke;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .form-signin-heading {
        text-align: center;
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
    }

    .form-control {
        width: 100%;
        height: 40px;
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .btn {
        width: 100%;
        height: 45px;
        background-color: #007bff;
        border-color: #007bff;
        color: white;
        font-size: 18px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .checkbox {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .checkbox label {
        margin-left: 8px;
        color: #333;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: skyblue;
        font-family: Arial, sans-serif;
        margin: 0;
    }
</style>

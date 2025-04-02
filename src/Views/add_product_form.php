<form action="/add-product" method="POST">
    <div class="container">
        <h1>Add product</h1>
        <p>Please fill in this form to add product.</p>
        <hr>

        <label for="product_id"><b>Product-id</b></label>
        <?php if (isset($errors['product-id'])): ?>
            <label style="color:red"><?php echo $errors['product-id']; ?></label>
        <?php endif; ?>
        <input type="text" placeholder="Enter product-id" name="product_id" id="product_id" required>

        <label for="amount"><b>Amount</b></label>
        <?php if (isset($errors['amount'])): ?>
            <label style="color:red"><?php echo $errors['amount']; ?></label>
        <?php endif; ?>
        <input type="text" placeholder="Enter amount" name="amount" id="amount" required>

        <button type="submit" class="registerbtn">Add product</button>
    </div>
</form>

<style>
    * {box-sizing: border-box}

    .container {
        padding: 16px;
    }

    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    .registerbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover {
        opacity:1;
    }

    a {
        color: dodgerblue;
    }

    .signin {
        background-color: #f1f1f1;
        text-align: center;
    }
</style>
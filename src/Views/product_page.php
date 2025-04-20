<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="product">
    <img src="<?php echo $products['image_url']; ?>" alt="<?php echo $products['name']; ?>">
    <h2><?php echo $products['name']; ?></h2>
    <p><?php echo $products['description']; ?></p>
    <p><strong>Цена: </strong><?php echo $products['price'] . " руб."; ?></p>

    <div class="average-rating">
        <strong>Средняя оценка: </strong>
        <span><?php echo $products['average_rating']; ?> / 5</span>
    </div>

    <div class="reviews">
        <h3>Reviews:</h3>
        <?php if (!empty($products['reviews'])): ?>
            <?php foreach ($products['reviews'] as $review): ?>
                <div class="review">
                    <span class="review-author"><?php echo $review->getName(); ?></span>
                    <p class="review-rating">"<?php echo $review->getRating(); ?>"</p>
                    <p class="review-comment">"<?php echo $review->getComment(); ?>"</p>
                    <p class="review-created-at">"<?php echo $review->getCreatedAt(); ?>"</p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>На данный момент отзывов нет.</p>
        <?php endif; ?>
    </div>
</div>

<div class="add-review">
    <h3>Оставить отзыв:</h3>
    <form action="/add-review" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $products['id']; ?>">
        <div>
            <label for="author">Ваше имя:</label>
            <input type="text" id="author" name="author" required>
        </div>
        <div>
            <label for="rating">Оценка:</label>
            <select id="rating" name="rating" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        <div>
            <label for="comment">Ваш комментарий:</label>
            <textarea id="comment" name="comment" rows="4" required></textarea>
        </div>
        <button type="submit">Отправить</button>
    </form>
</div>
</body>
</html>
<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f7fc;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .product {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        margin: 30px auto;
        padding: 20px;
        max-width: 850px;
        box-sizing: border-box;
    }

    .product img {
        max-width: 60%;
        height: auto;
        border-radius: 10px;
        margin-bottom: 20px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .product h2 {
        font-size: 32px;
        color: #2b2b2b;
        margin: 10px 0;
    }

    .product p {
        font-size: 18px;
        line-height: 1.6;
        color: #666;
    }

    .reviews {
        margin-top: 40px;
    }

    .reviews h3 {
        font-size: 24px;
        color: #444;
        margin-bottom: 10px;
    }

    .review {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        position: relative;
    }

    .review-author {
        font-weight: bold;
        color: #333;
        font-size: 18px;
    }

    .review-rating {
        font-size: 16px;
        color: #ff5c5c;
        margin-top: 5px;
    }

    .review-comment {
        font-size: 16px;
        color: #555;
        margin-top: 10px;
    }

    .review-created-at {
        font-size: 14px;
        color: #aaa;
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 12px;
    }

    .add-review {
        background-color: #fff;
        border-radius: 10px;
        padding: 30px;
        margin-top: 40px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .add-review h3 {
        font-size: 26px;
        color: #444;
        margin-bottom: 25px;
    }

    .add-review form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .add-review input, .add-review select, .add-review textarea {
        padding: 12px;
        font-size: 16px;
        border-radius: 8px;
        border: 1px solid #ddd;
        background-color: #f4f7fc;
        color: #333;
        width: 100%;
    }

    .add-review button {
        background-color: #ff5c5c;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
    }

    .add-review button:hover {
        background-color: #e14c4c;
    }

    .add-review button:active {
        background-color: #d43f3f;
    }
</style>

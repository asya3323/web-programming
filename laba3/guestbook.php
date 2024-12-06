<!DOCTYPE php>
<php lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Гостевая книга</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Гостевая книга</h1>
    </header>
    <nav>
        <a href="index.php">Главная</a>
        <a href="staff.php">Руководство</a>
        <a href="contacts.php">Контакты</a>
        <a href="guestbook.php">Гостевая книга</a>
    </nav>
    <div class="container guestbook-container">
        <form>
            <input type="text" placeholder="Ваше имя" required>
            <input type="email" placeholder="Ваш email" required>
            <textarea placeholder="Ваш отзыв" required></textarea>
            <button type="submit">Отправить отзыв</button>
        </form>
        <div class="reviews">
            <h3>Отзывы:</h3>
            <p>Игорь (2.02.2024): Какой прекрасный сайт!</p>
            <p>Василий (1.02.2024): Не могу найти информацию по корпусу на Биржевой...</p>
        </div>
    </div>
</body>
</php>

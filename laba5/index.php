<?php
session_start();

$file_l = 'likes.json';

if (file_exists($file_l)) {
    $current_data = json_decode(file_get_contents($file_l), true);
} else {
    $current_data = [['like1' => 0, 'like2' => 0, 'like3' => 0]]; 
}

$image_data = [
    [
        'src' => "https://tobolsktravel.ru/wp-content/uploads/2021/03/bp.jpeg",
        'description' => "Александр Абдулов"
    ],
    [
        'src' => "https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/%D0%90%D0%BD%D0%B4%D1%80%D0%B5%D0%B9_%D0%9C%D0%B8%D1%80%D0%BE%D0%BD%D0%BE%D0%B2.webp/800px-%D0%90%D0%BD%D0%B4%D0%B5%D0%B9_%D0%9C%D0%B8%D1%80%D0%BE%D0%BD%D0%BE%D0%B2.webp.png",
        'description' => "Андрей Миронов"
    ],
    [
        'src' => "https://www.mentoday.ru/upload/img_cache/521/5212f9b9c9b0bb2e30994e930f84c68a_cropped_666x447.webp",
        'description' => "Олег Янковский"
    ]
];

if (!isset($_SESSION['liked'])) {
    $_SESSION['liked'] = [];
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Проголосуйте за лучшего!</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <h1>↓Проголосуйте за лучшего по вашему мнению↓</h1>
    <div class="container">
        <?php foreach ($image_data as $i => $image): ?>
            <div class="item">
                <img src="<?= $image['src'] ?>" alt="Image <?= $i ?>">

                <div class="image-description">
                    <p><?= $image['description'] ?></p> 
                </div>

                <div class="like-section">
                    <form class="like-form" method="POST" data-id="<?= $i ?>">
                        <button type="submit" name="like" class="like-button">❤ <?= $current_data[0]['like' . ($i + 1)] ?></button>
                    </form>
                </div>
                <form method="POST" class="comment-form" data-id="<?= $i ?>">
                    <label>Имя: <input type="text" name="name" required></label><br>
                    <label>Комментарий: <textarea name="message" required></textarea></label><br>
                    <button type="submit" name="comment">Отправить</button>
                </form>
                <div class="comments">
                    <?php if (!empty($_SESSION['comments'][$i])): ?>
                        <h4>Комментарии:</h4>
                        <?php foreach ($_SESSION['comments'][$i] as $comment): ?>
                            <p><?= $comment ?></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const likeForms = document.querySelectorAll(".like-form");
            likeForms.forEach(form => {
                form.addEventListener("submit", function(event) {
                    event.preventDefault();
                    const id = this.getAttribute("data-id");
                    const formData = new FormData(this);
                    formData.append('id', id);

                    fetch("like.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.text())
                    .then(likesCount => {
                        const button = this.querySelector(".like-button");
                        button.innerHTML = `❤ ${likesCount}`;
                    });
                });
            });

            const commentForms = document.querySelectorAll(".comment-form");
            commentForms.forEach(form => {
                form.addEventListener("submit", function(event) {
                    event.preventDefault();
                    const id = this.getAttribute("data-id");
                    const formData = new FormData(this);
                    formData.append('id', id);

                    fetch(window.location.href, {
                        method: "POST",
                        body: formData
                    }).then(() => {
                        location.reload();
                    });
                });
            });
        });
    </script>
</body>
</html>

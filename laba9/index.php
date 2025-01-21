<?php
session_start();

if (isset($_GET['toggleGuestbook'])) {
    $currentState = $_SESSION['guestbookOpen'] ?? false;
    $_SESSION['guestbookOpen'] = !$currentState;
    header("Location: index.php");
    exit;
}

$db = mysqli_connect("127.0.0.1", "root", "", "mytestdb");
if (!$db) {
    die("Ошибка подключения к БД: " . mysqli_connect_error());
}

$file_l = 'likes.json';
if (file_exists($file_l)) {
    $current_data = json_decode(file_get_contents($file_l), true);
} else {
    $current_data = ['like1' => 0, 'like2' => 0, 'like3' => 0];
}

$image_data = [
    [
        'src' => "https://tobolsktravel.ru/wp-content/uploads/2021/03/bp.jpeg",
        'description' => "Александр Абдулов"
    ],
    [
        'src' => "https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/%D0%90%D0%BD%D0%B4%D1%80%D0%B5%D0%B9_%D0%9C%D0%B8%D1%80%D0%BE%D0%BD%D0%BE%D0%B2.webp/800px-%D0%90%D0%BD%D0%B4%D1%80%D0%B5%D0%B9_%D0%9C%D0%B8%D1%80%D0%BE%D0%BD%D0%BE%D0%B2.webp.png",
        'description' => "Андрей Миронов"
    ],
    [
        'src' => "https://www.mentoday.ru/upload/img_cache/521/5212f9b9c9b0bb2e30994e930f84c68a_cropped_666x447.webp",
        'description' => "Олег Янковский"
    ]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $id       = isset($_POST['id']) ? intval($_POST['id']) : -1;
    $name     = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : 'Аноним';
    $message  = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';
    $timestamp = date('Y-m-d H:i:s');

    if ($id >= 0 && $id < count($image_data)) {
        $stmt = mysqli_prepare($db, "INSERT INTO guestbook (username, message, mdate, image_id) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssi", $name, $message, $timestamp, $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Сайт: картинки + гостевая книга</title>
    <link rel="stylesheet" href="main.css">  
</head>
<body>
    

<h1>Проголосуйте за лучшего</h1>

<button class="my-button"
        onclick="location.href='?toggleGuestbook=1'">
    <?php
    echo (!empty($_SESSION['guestbookOpen']) 
            ? 'Скрыть гостевую книгу' 
            : 'Показать гостевую книгу');
    ?>
</button>

<div class="container">
    <?php foreach ($image_data as $i => $image): ?>
        <div class="item">
            <img src="<?= htmlspecialchars($image['src']) ?>" alt="Image <?= $i ?>">
            <p><?= htmlspecialchars($image['description']) ?></p>

            <form class="like-form" method="POST" data-id="<?= $i ?>" style="margin-bottom: 10px;">
                <button type="submit" name="like" class="like-button">
                    ❤ <?= intval($current_data['like' . ($i + 1)]) ?>
                </button>
            </form>

            <form method="POST" style="margin-bottom: 10px;">
                <input type="hidden" name="id" value="<?= $i ?>">
                <label>Имя: <input type="text" name="name" required></label><br>
                <label>Комментарий: <br>
                    <textarea name="message" required></textarea>
                </label><br>
                <button type="submit" name="comment">Отправить</button>
            </form>

            <?php
            $sqlLast = "SELECT username, message, mdate
                        FROM guestbook
                        WHERE image_id = $i
                        ORDER BY mdate DESC
                        LIMIT 1";
            $resLast = mysqli_query($db, $sqlLast);
            $lastRow = mysqli_fetch_assoc($resLast);
            if ($lastRow):
            ?>
                <div class="comment-last">
                    <strong>Последний комментарий:</strong><br>
                    <strong><?= htmlspecialchars($lastRow['username']) ?></strong>
                    (<?= htmlspecialchars($lastRow['mdate']) ?>):<br>
                    <?= nl2br(htmlspecialchars($lastRow['message'])) ?>
                </div>
            <?php else: ?>
                <div class="comment-last">
                    Пока нет комментариев к этому фото.
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<div id="guestbook-block"
     style="display: <?= (!empty($_SESSION['guestbookOpen']) ? 'block' : 'none'); ?>; margin-top: 40px;">
    <?php include 'guestbook.php'; ?>
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
            })
            .catch(err => console.error("Ошибка при лайке:", err));
        });
    });
});
</script>

</body>
</html>

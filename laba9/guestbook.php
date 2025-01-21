<?php
$db = mysqli_connect("127.0.0.1", "root", "", "mytestdb");
if (!$db) {
    die("Ошибка подключения к БД: " . mysqli_connect_error());
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

$allowedSort  = ['mdate', 'username', 'message'];
$sortColumn   = (isset($_GET['sort']) && in_array($_GET['sort'], $allowedSort))
                ? $_GET['sort'] : 'mdate';
$sortOrder    = (isset($_GET['order']) && $_GET['order'] === 'asc')
                ? 'ASC' : 'DESC';

$allowedLimits = [10, 20, 50, 100];
$limit  = (isset($_GET['limit']) && in_array((int)$_GET['limit'], $allowedLimits))
          ? (int)$_GET['limit'] : 10;
$page   = (isset($_GET['page']) && (int)$_GET['page'] > 0)
          ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT id, username, message, mdate, image_id
        FROM guestbook
        ORDER BY $sortColumn $sortOrder
        LIMIT $offset, $limit";
$result = mysqli_query($db, $sql);

$totalCountResult = mysqli_query($db, "SELECT COUNT(*) AS cnt FROM guestbook");
$totalCountRow    = mysqli_fetch_assoc($totalCountResult);
$totalRecords     = (int)$totalCountRow['cnt'];
$totalPages       = ceil($totalRecords / $limit);
?>
<div>
    <form method="GET" action="">
        Сортировать по:
        <select name="sort">
            <option value="mdate"    <?= ($sortColumn==='mdate')    ? 'selected' : '' ?>>Дате</option>
            <option value="username" <?= ($sortColumn==='username') ? 'selected' : '' ?>>Имени</option>
            <option value="message"  <?= ($sortColumn==='message')  ? 'selected' : '' ?>>Сообщению</option>
        </select>
        <select name="order">
            <option value="desc" <?= ($sortOrder==='DESC') ? 'selected' : '' ?>>По убыванию</option>
            <option value="asc"  <?= ($sortOrder==='ASC')  ? 'selected' : '' ?>>По возрастанию</option>
        </select>
        <select name="limit">
            <option value="10"  <?= ($limit===10)  ? 'selected' : '' ?>>10</option>
            <option value="20"  <?= ($limit===20)  ? 'selected' : '' ?>>20</option>
            <option value="50"  <?= ($limit===50)  ? 'selected' : '' ?>>50</option>
            <option value="100" <?= ($limit===100) ? 'selected' : '' ?>>100</option>
        </select>
        <button type="submit">Применить</button>
    </form>
</div>

<div>
    <h2>Все комментарии</h2>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <?php
                $username = htmlspecialchars($row['username']);
                $mdate    = htmlspecialchars($row['mdate']);
                $message  = nl2br(htmlspecialchars($row['message']));
                $imgId    = (int)$row['image_id'];
            ?>
            <div>
                <?php if ($imgId >= 0 && $imgId < count($image_data)): ?>
                    Комментарий к фото: 
                        <strong><?= htmlspecialchars($image_data[$imgId]['description']) ?></strong>
                    <br>
                <?php else: ?>
                    <small>(Сообщение без привязки к фото)</small><br>
                <?php endif; ?>

                <strong><?= $username ?></strong> (<?= $mdate ?>):
                <p><?= $message ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Нет записей.</p>
    <?php endif; ?>
</div>


<div>
    <h3>Страницы:</h3>
    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
        <a href="?page=<?= $p ?>&sort=<?= $sortColumn ?>&order=<?= strtolower($sortOrder) ?>&limit=<?= $limit ?>">
            <?= $p ?>
        </a>
        &nbsp;
    <?php endfor; ?>
</div>

<?php
mysqli_close($db);
?>

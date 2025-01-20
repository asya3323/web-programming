<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Сайт</title>
</head>
<body>
    <?php
    $page = $_GET['page'] ?? 'main';

    $pages = [
        'main' => 'Главная',
        'staff' => 'Руководство',
        'contacts' => 'Контакты',
        'guestbook' => 'Гостевая',
    ];

    if (!array_key_exists($page, $pages)) {
        $page = '404'; 
    }
    ?>

    <nav class="menu">
        <?php foreach ($pages as $key => $title): ?>
            <?php if ($page === $key): ?>
                <span class="active"><?= $title ?></span>
            <?php else: ?>
                <a href="index.php?page=<?= $key ?>"><?= $title ?></a>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>

    <div class="content">
        <?php
        switch ($page) {
            case 'main':
                echo "<h1>Добро пожаловать на главную страницу!</h1>";
                echo "<p>На нашем сайте вы найдете полезную информацию о руководстве, контактные данные и сможете оставить свои отзывы.</p>";
                echo "<img src='https://upload.wikimedia.org/wikipedia/commons/thumb/c/cc/ITMO_University%27s_main_building%2C_August_2016.jpg/1280px-ITMO_University%27s_main_building%2C_August_2016.jpg' alt='Добро пожаловать' class='welcome-image'>";
                break;

            case 'staff':
                echo "<h1>Руководство</h1>";
                echo "<section>";
                echo "<h2>Васильев Владимир Николаевич</h2>";
                echo "<ul>
                        <li>Ректор</li>
                        <li>Председатель президиума Ученого совета</li>
                        <li>Председатель приемной комиссии</li>
                      </ul>";
                echo "</section>";
                
                echo "<section>";
                echo "<h2>Баранов Игорь Владимирович</h2>";
                echo "<ul>
                        <li>Директор</li>
                        <li>Доцент образовательного центра «Энергоэффективные инженерные системы»</li>
                      </ul>";
                echo "</section>";
                
                echo "<section>";
                echo "<h2>Белов Павел Александрович</h2>";
                echo "<ul>
                        <li>Директор</li>
                        <li>Главный научный сотрудник физико-технического мегафакультета</li>
                      </ul>";
                echo "</section>";
                break;

            case 'contacts':
                echo "<h1>Контакты</h1>";
                echo "<section>";
                echo "<h2>Отдел управления делопроизводством</h2>";
                echo "<ul>
                        <li>Телефон: +7 (812) 480-00-00</li>
                        <li>Факс: +7 (812) 232-23-07</li>
                        <li>Email: od@itmo.ru</li>
                      </ul>";
                echo "</section>";
                
                echo "<section>";
                echo "<h2>Приёмная комиссия</h2>";
                echo "<ul>
                        <li>Телефон: +7 (812) 480-04-80</li>
                        <li>Email: abit@itmo.ru</li>
                      </ul>";
                echo "</section>";
                
                echo "<section>";
                echo "<h2>Пресс-служба</h2>";
                echo "<ul>
                        <li>Телефон для федеральных СМИ: +7 (900) 630-00-10</li>
                        <li>Телефон для региональных СМИ: +7 (911) 787-41-35</li>
                        <li>Телефон для международных СМИ: +7 (921) 794-38-08</li>
                        <li>Email: pressa@itmo.ru</li>
                      </ul>";
                echo "</section>";
                break;

            case 'guestbook':
                echo "<h1>Гостевая книга</h1>";
                echo "<p>Здесь вы можете оставить свои отзывы или комментарии. Нам важно ваше мнение!</p>";
                echo "<form method='post' action='' class='guestbook-form'>
                        <textarea name='message' rows='5' cols='50' placeholder='Введите ваш отзыв...'></textarea><br>
                        <button type='submit'>Отправить</button>
                      </form>";
                break;

            case '404':
                echo "<h1>Ошибка 404</h1>";
                echo "<p>Страница не найдена. Проверьте правильность ввода URL или вернитесь на <a href='index.php?page=main'>главную страницу</a>.</p>";
                break;
        }
        ?>
    </div>
</body>
</html>

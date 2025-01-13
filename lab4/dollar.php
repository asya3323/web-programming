<HTML>
<head>
    <title>Dollar</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <a href="index.php" class="back-button">Назад</a>
    <main>
        <form method="get">
            <label for="n">Введите n (количество):</label>
            <input type="number" id="n" name="n" required>
            <label for="a">Введите a (способ):</label>
            <input type="number" id="a" name="a" required>
            <button type="submit">Отправить</button>
        </form>
        <p>
            <?php
            function generateSymbol($count)
            {
                return str_repeat('$', $count);
            }
            function printDollar($n, $a)
            {
                switch ($a) {
                    case 1: // В строку
                        echo '<p class="generated_dollars">';
                        echo generateSymbol($n) . '<br/>';
                        echo '</p>';
                        break;
                    case 2: // В столбик
                        echo '<p class="generated_dollars">';
                        for ($i = 0; $i < $n; $i++) {
                            echo generateSymbol(1) . "<br/>";
                        }
                        echo '</p>';
                        break;
                    case 3: // Лесенка
                        echo '<p class="generated_dollars">';
                        for ($i = 1; $i <= $n; $i++) {
                            echo generateSymbol($i) . "<br/>";
                        }
                        echo '</p>';
                        break;
                    case 4: // Обратная лесенка
                        echo '<p class= "generated_dollars">';
                        for ($i = $n; $i >= 1; $i--) {
                            echo generateSymbol($i) . "<br/>";
                        }
                        echo '</p>';
                        break;
                    case 5: // Перевернутая кучка
                        echo '<p class = "generated_dollars center">';
                        for ($i = 0; $i < $n; $i++) {
                            $spaces = str_repeat('_', $i);
                            $dollars = generateSymbol(2 * ($n - $i) - 1);
                            echo $spaces . $dollars . "<br/>";
                        }
                        echo '</p>';
                        break;
                    case 6: // Кучка
                        echo '<p class="generated_dollars center">';
                        for ($i = 1; $i <= $n; $i++) {
                            $spaces = str_repeat('_', $n - $i);
                            $dollars = generateSymbol(2 * $i - 1);
                            echo $spaces . $dollars . '<br/>';
                        }
                        echo '</p>';
                        break;
                    default:
                         echo "<p class='error-message'>Что-то пошло не так, проверьте себя и повторите.</p>\n";
                }
            }

    if (isset($_GET['n'], $_GET['a']) && !empty($_GET['n']) && !empty($_GET['a'])) {
        $n = (int)$_GET['n'];
        $a = (int)$_GET['a'];

        if ($n > 0 && $a > 0 && $a <= 6) {
            printDollar($n, $a);
        } else {
            echo "<p class='error-message'>n и a должны быть положительными, a должно быть от 1 до 6.</p>\n";
        }
        } else {
            echo "<p class='error-message'>Привет, ты не ввёл параметры n и/или a!</p>\n";
        }
            ?>
        </p>
    </main>
</body> 

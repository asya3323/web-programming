<!DOCTYPE html>
<html>
<head>
    <title>Colors</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <a href="index.php" class="back-button">Назад</a>
    <main>
        <h1>Введите параметры для генерации таблицы цветов( в HEX)</h1>
        <form method="get">
            <label for="startColor">Начальный цвет (например 000000):</label>
            <input type="text" id="startColor" name="start" required pattern="[0-9A-Fa-f]{6}" placeholder="000000">
            <br><br>

            <label for="endColor">Конечный цвет (например FFFFFF):</label>
            <input type="text" id="endColor" name="end" required pattern="[0-9A-Fa-f]{6}" placeholder="FFFFFF">
            <br><br>

            <label for="step">Шаг (например 33):</label>
            <input type="text" id="step" name="step" required pattern="[0-9A-Fa-f]+" placeholder="33">
            <br><br>

            <label for="columns">Количество столбцов:</label>
            <input type="number" id="columns" name="columns" required min="1" placeholder="6">
            <br><br>

            <button type="submit">Сгенерировать таблицу</button>
        </form>

        <h2>Результат:</h2>
        <?php
        if (isset($_GET['start'], $_GET['end'], $_GET['step'], $_GET['columns'])) {
            $startColor = $_GET['start'];
            $endColor = $_GET['end'];
            $step = $_GET['step'];
            $columns = (int)$_GET['columns'];

            function validateInput($startColor, $endColor, $step, $columns) {
                if (!preg_match('/^[0-9A-Fa-f]{6}$/', $startColor) || !preg_match('/^[0-9A-Fa-f]{6}$/', $endColor)) {
                    return "Некорректный начальный или конечный цвет. Проверьте значения.";
                }
                if (!preg_match('/^[0-9A-Fa-f]+$/', $step)) {
                    return "Ошибочный шаг. Шаг должен быть шестнадцатеричным числом.";
                }
                if (!is_numeric($columns) || $columns <= 0) {
                    return "Количество столбцов должно быть положительным числом.";
                }
                return null;
            }

            $validationError = validateInput($startColor, $endColor, $step, $columns);
            if ($validationError) {
                echo "<p style='color:red;'>$validationError</p>";
                exit;
            }

            // преобразование числа в HEX
            function toHexColor($color) {
                return str_pad(dechex($color), 6, '0', STR_PAD_LEFT);
            }

            $startDec = hexdec($startColor);
            $endDec = hexdec($endColor);
            $stepDec = hexdec($step);

            if ($stepDec <= 0) {
                echo "<p style='color:red;'>Шаг должен быть больше нуля.</p>";
                exit;
            }

            $totalSteps = (int)(($endDec - $startDec) / $stepDec);
            if ($totalSteps <= 0) {
                echo "<p style='color:red;'>Начальный цвет должен быть меньше конечного при заданном шаге.</p>";
                exit;
            }

            echo '<table border="1" cellspacing="0" cellpadding="5">';
            $currentColor = $startDec;
            for ($i = 0; $i <= $totalSteps; $i++) {
                if ($i % $columns === 0) {
                    if ($i > 0) echo '</tr>'; 
                    echo '<tr>'; 
                }

                $hexColor = toHexColor($currentColor);
                $textColor = '#FFFFFF'; 
                echo "<td style='background-color: #$hexColor; color: $textColor;'>#$hexColor</td>";

                $currentColor += $stepDec;
            }

            echo '</tr>'; 
            echo '</table>';
        }
        ?>
    </main>
</body>
</html>

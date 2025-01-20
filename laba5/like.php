<?php
header('Content-Type: application/json');
$file_l = 'likes.json';

$current_data = file_exists($file_l) ? json_decode(file_get_contents($file_l), true) : [];

if (!isset($current_data['like1'])) $current_data['like1'] = 0;
if (!isset($current_data['like2'])) $current_data['like2'] = 0;
if (!isset($current_data['like3'])) $current_data['like3'] = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : -1;

    if ($id >= 0 && $id < 3) {
        $likeKey = 'like' . ($id + 1);

        $current_data[$likeKey]++;

        file_put_contents($file_l, json_encode($current_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo $current_data[$likeKey];
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Некорректный ID']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Метод не разрешён']);
}

exit;

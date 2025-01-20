<?php 
$file_l = 'likes.json';

if (file_exists($file_l)) {
    $current_data = json_decode(file_get_contents($file_l), true);
} else {
    $current_data = [['like1' => 0, 'like2' => 0, 'like3' => 0]]; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : -1;

    if ($id >= 0 && $id < 3) {
        $current_data[0]['like' . ($id + 1)]++;
        
        file_put_contents($file_l, json_encode($current_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        echo $current_data[0]['like' . ($id + 1)];
    }
}

exit;

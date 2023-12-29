<?php

require_once 'db.php';

$query_api = "SELECT `start_time`, `open_price`, `high_price`, `low_price`, `close_price` FROM `btc_candles`";
$stmt = $mysqli->prepare($query_api);
$stmt->execute();
$result = $stmt->get_result();

// Формирование массива данных для передачи на страницу
$getDataCandle = [];
$getDataLine   = [];
while ($row = $result->fetch_assoc()) {
    $getDataCandle[] = [
        'time'  => htmlspecialchars(gmdate('Y-m-d', $row['start_time'])),
        'open'  => (float)htmlspecialchars($row['open_price']),
        'high'  => (float)htmlspecialchars($row['high_price']),
        'low'   => (float)htmlspecialchars($row['low_price']),
        'close' => (float)htmlspecialchars($row['close_price']),
    ];

    $getDataLine[] = [
        'time'  => htmlspecialchars(gmdate('Y-m-d', $row['start_time'])),
        'value' => (float)htmlspecialchars($row['close_price']),
    ];
}

$stmt->close();

header('Content-Type: application/json');
echo json_encode(['candle' => $getDataCandle, 'line' => $getDataLine], JSON_UNESCAPED_UNICODE);

$mysqli->close();




<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

try {
    $stmt = $pdo->query("SELECT no_kamar, nama, no_hp, status FROM penghuni");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal mengambil data: ' . $e->getMessage()]);
}

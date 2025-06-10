<?php
header('Content-Type: application/json');

// Include koneksi PDO
require_once 'koneksi.php';

// Ambil data JSON dari body request
$raw  = file_get_contents("php://input");
$data = json_decode($raw, true);

// Validasi data kosong atau tidak
if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Data tidak valid']);
    exit;
}

$no_kamar = $data['no_kamar'] ?? '';
$nama     = $data['nama'] ?? '';
$no_hp    = $data['no_hp'] ?? '';
$status   = $data['status'] ?? '';

// Validasi sederhana
if (!$no_kamar || !$nama || !$no_hp || !$status) {
    echo json_encode(['success' => false, 'message' => 'Field tidak lengkap']);
    exit;
}

try {
    // Persiapkan query dan eksekusi
    $stmt = $pdo->prepare("INSERT INTO penghuni (no_kamar, nama, no_hp, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([$no_kamar, $nama, $no_hp, $status]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan ke database: ' . $e->getMessage()]);
}

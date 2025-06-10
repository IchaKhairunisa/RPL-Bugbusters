<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "igloo_kost";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Koneksi gagal: " . $conn->connect_error]));
}

if (isset($_FILES['foto'])) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

    $filename = basename($_FILES["foto"]["name"]);
    $targetFile = $targetDir . uniqid() . "_" . $filename;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed)) {
        echo json_encode(["status" => "error", "message" => "Tipe file tidak didukung"]);
        exit;
    }

    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile)) {
        $stmt = $conn->prepare("INSERT INTO kamar (foto) VALUES (?)");
        $stmt->bind_param("s", $targetFile);
        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "Kamar berhasil ditambahkan",
                "path" => $targetFile // dikembalikan ke JS
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal menyimpan ke database"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal mengunggah file"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Tidak ada file yang diunggah"]);
}

$conn->close();
?>

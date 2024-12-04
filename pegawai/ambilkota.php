<?php
session_start();

// Memeriksa apakah sesi username dan leveluser ada
$sesi_username = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
$sesi_level = isset($_SESSION['leveluser']) ? $_SESSION['leveluser'] : NULL;

// Memeriksa apakah level user valid
$valid_levels = ['1', '2', '3', '4', '5'];
if (!in_array($sesi_level, $valid_levels)) {
    header('Location: ../index.php');
    exit;
}

include "../config/koneksi.php";

// Memeriksa apakah parameter 'propinsi' ada dan disanitasi
$propinsi = isset($_GET['propinsi']) ? filter_var($_GET['propinsi'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';

if (!empty($propinsi)) {
    // Menggunakan prepared statement untuk mencegah SQL injection
    $stmt = $mysqli->prepare("SELECT id_kabkot, nama_kabkot FROM kabkot WHERE id_prov = ? ORDER BY nama_kabkot");
    if ($stmt) {
        $stmt->bind_param("s", $propinsi);
        $stmt->execute();
        $result = $stmt->get_result();

        // Debugging: jumlah baris yang dikembalikan oleh query
        echo "<!-- Jumlah baris yang dikembalikan: " . $result->num_rows . " -->\n";

        if ($result->num_rows > 0) {
            echo "<option>-- Pilih Kabupaten/Kota --</option>";

            // Array untuk melacak id_kabkot yang sudah ditampilkan
            $seen = array();
            while ($k = $result->fetch_assoc()) {
                if (!in_array($k['id_kabkot'], $seen)) {
                    echo "<option value=\"" . htmlspecialchars($k['id_kabkot']) . "\">" . htmlspecialchars($k['nama_kabkot']) . "</option>\n";
                    $seen[] = $k['id_kabkot'];
                }
            }
        } else {
            echo "<option>Tidak ada kabupaten/kota</option>";
        }

        $stmt->close();
    } else {
        echo "<option>Terjadi kesalahan pada query</option>";
    }
} else {
    echo "<option>-- Pilih Kabupaten/Kota --</option>";
}

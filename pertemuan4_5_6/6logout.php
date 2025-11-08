<?php
// 6logout.php — logout aman
session_start();

// Hapus semua data session (variabel)
$_SESSION = array();

// Jika session disimpan dalam cookie, hapus cookie session di browser
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),    // nama cookie session
        '',                // kosongkan isinya
        time() - 42000,    // set waktu kedaluwarsa di masa lalu
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Hancurkan session di server
session_destroy();

// Pastikan redirect ke halaman login setelah logout
header("Location: 3login.html");
exit();

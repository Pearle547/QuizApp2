<?php
session_start();
// HttpOnly, Secure, SameSite=Lax to protect against XSS & sniffing
$default_per_page = 2;
if (isset($_POST['per_page'])) {
    $per_page = (int)$_POST['per_page'];
    if ($per_page >= 1 && $per_page <= 10) {
        setcookie("per_page", $per_page, [
            'expires' => time() + (30*24*60*60), // 30 days
            'path' => '/',
            'secure' => isset($_SERVER['HTTPS']), // only over HTTPS
            'httponly' => true, // no JS access -> XSS protection
            'samesite' => 'Lax' // CSRF protection
        ]);
        $_COOKIE['per_page'] = $per_page; // immediate
    }
}
$per_page = isset($_COOKIE['per_page']) ? (int)$_COOKIE['per_page'] : $default_per_page;

// --- QUESTIONS ARRAY
if (!isset($_SESSION['questions_array']) || empty($_SESSION['questions_array'])) {
    $_SESSION['questions_array'] = [
        ["question" => "What is your favorite color?", "answers" => ["Blue", "Green", "Red", "Orange"], "correct" => 1],
        ["question" => "Which country are you from?", "answers" => ["Uganda", "Kenya", "Tanzania", "Rwanda"], "correct" => 0],
        ["question" => "What is your favorite food?", "answers" => ["Rice", "Matooke", "Cassava", "Potatoes"], "correct" => 0],
        ["question" => "What is your name?", "answers" => ["Michael", "Pearl", "Kelvin", "Collin"], "correct" => 2]
    ];
    $_SESSION['answered'] = [];
}
if (!isset($_SESSION['users'])) $_SESSION['users'] = []; // for auth
?>
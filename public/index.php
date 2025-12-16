<?php
declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

$config = require BASE_PATH . '/config/config.php';

try {
    $dsn = sprintf(
        '%s:host=%s;dbname=%s;charset=%s',
        $config['db']['driver'],
        $config['db']['host'],
        $config['db']['name'],
        $config['db']['charset']
    );
    $pdo = new PDO($dsn, $config['db']['username'], $config['db']['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo 'เชื่อมต่อฐานข้อมูลไม่ได้: ' . htmlspecialchars($e->getMessage());
    exit;
}

require_once BASE_PATH . '/app/controllers/MemberController.php';
$controller = new MemberController($pdo);
$controller->handle();

<?php
$config = require 'config.php';

try {
    $pdo = new PDO(
        'mysql:dbname=' . $config['dbname'] . ';charset=utf8;host=' . $config['host'],
        $config['username'],
        $config['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit('DB_CONNECTION_ERROR' . $e->getMessage());
}
?>
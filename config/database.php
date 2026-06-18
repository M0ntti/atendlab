<?php
$host = '127.0.0.1';
$port = '3306';
$dbname = 'atendlab';
$user = 'root';
$password = '';
try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $password
    );
    $pdo->setAttribute(
        PDO::ATTR_ERRMODE, 
        PDO::ERRMODE_EXCEPTION
    );
} catch (PDOException $e) {
    exit('Erro ao conectar com o banco de dados:' . $e->getMessage());
    
}
<?php
require_once '../functions/database.php';
$pdo = getPdo();
$query = $pdo->prepare('DELETE FROM posts WHERE id = :id');
$query->execute(['id' => $_GET['id']]);
header('location:index.php');
<?php

use App\Database;

$id = (int)$_GET['id'] ?? null;
$pdo = Database::getPdo();
$req = $pdo->prepare("DELETE FROM messages WHERE id=:id");
$req->execute([
    'id' => $id
]);
header('Location: /contact');
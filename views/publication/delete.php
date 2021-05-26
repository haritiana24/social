<?php

use App\Model\Post;
$id = $_GET['id'] ?? null;
Post::delete($id);
header('Location: /publication');
http_response_code(303);
<?php
// routes/owner_events.php

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

$user_id = $_SESSION['user_id'];
$my_created = get_myEvent($user_id);
renderView('owner_events', [
    'my_created' => $my_created
]);
<?php
// routes/my_events.php

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

$user_id = $_SESSION['user_id'];
$my_list = getMyRegistrations($user_id);
$stats   = getMyStats($user_id);

renderView('my_events', [
    'my_list' => $my_list,
    'stats'   => $stats
]);
?>
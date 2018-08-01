<?php
    $db->exec("DELETE FROM dictionary WHERE id = '{$_POST['id']}'");

    // Replace AUTO_INCREMENT
    $max_id = $db->query("SELECT MAX(id) FROM dictionary")->fetchColumn();
    $next_id = $max_id + 1;
    $db->exec("ALTER TABLE dictionary AUTO_INCREMENT = {$next_id}");

    header("Location: /dictionary/");

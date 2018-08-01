<?php
    $result = $db->query("SELECT name FROM `{$_GET['source']}` WHERE id = 1");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        unlink("./sources/{$_GET['source']}/{$row['name']}.srt");
    }
    $db->exec("UPDATE `{$_GET['source']}` SET name = '', words = '', page_scroll = 0, words_scroll = 0 WHERE id = 1");
    header("Location: /?source={$_GET['source']}");

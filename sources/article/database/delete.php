<?php
    $db->exec("UPDATE {$_GET['source']} SET
    url = '', text = '', words = '', page_scroll = 0, words_scroll = 0 WHERE id = 1");

    header("Location: /?source={$_GET['source']}");

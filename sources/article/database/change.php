<?php
    $text = format_text($_POST['text']);

    $words = clear_words($_POST['words']);

    $url = format_url($_POST['url']);

    $db->exec("UPDATE `{$_GET['source']}` SET
    url = '{$url}', text = '{$text}',
    words = '{$words}', page_scroll = '{$_POST['page_scroll']}',
    words_scroll = '{$_POST['words_scroll']}' WHERE id = 1");

    header("Location: /?source={$_GET['source']}");

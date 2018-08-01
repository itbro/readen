<?php
    $text = format_text($_POST['text']);

    $words = clear_words($_POST['words']);

    $_POST['author_title'] = addslashes($_POST['author_title']);

    // Remove the bookmark
    $db->exec("UPDATE `{$_GET['source']}` SET bookmark = '' WHERE id = '{$_GET['id']}'");

    $db->exec("UPDATE `{$_GET['source']}` SET
        id = '{$_POST['page']}',
        text = '{$text}',
        words = '{$words}',
        bookmark = 1,
        page_scroll = '{$_POST['page_scroll']}',
        words_scroll = '{$_POST['words_scroll']}'
        WHERE id = '{$_GET['id']}'");

    $db->query("SELECT author_title FROM `{$_GET['source']}` WHERE author_title != ''")->rowCount() > 0 ?
    $db->exec("UPDATE `{$_GET['source']}` SET author_title = '{$_POST['author_title']}' WHERE author_title != ''") :
    $db->exec("UPDATE `{$_GET['source']}` SET author_title = '{$_POST['author_title']}' WHERE id = {$_POST['id']}");

    header("Location: /?source={$_GET['source']}&id={$_POST['page']}");

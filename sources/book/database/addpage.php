<?php
    $text = format_text($_POST['text']);

    $a_th = $db->query("SELECT author_title FROM `{$_GET['source']}` WHERE author_title != ''");
    $a_th->rowCount() > 0 ? $author_title = '' : $author_title = $_POST['author_title'];
    $db->exec("INSERT INTO `{$_GET['source']}` VALUES ('{$_POST['page']}', '', '$text', 1, '', 0, 0)");

    header("Location: /?source={$_GET['source']}&id={$_POST['page']}");

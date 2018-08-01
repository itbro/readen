<?php
    require_once "../db_settings.php";

    require_once "../db_connection.php";

    $_REQUEST['q'] = trim($_REQUEST['q']);
    $word = addslashes($_REQUEST['q']);

    $word_arr = explode(">>", $word);
    if ($word_arr[1] != '')
        $db->exec("UPDATE pronunciation SET word = '{$word_arr[1]}' WHERE word = '{$word_arr[0]}'");

    $db = null;

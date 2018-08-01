<?php
    require_once "../db_settings.php";

    require_once "../db_connection.php";

    $_REQUEST['q'] = trim($_REQUEST['q']);
    $word = addslashes($_REQUEST['q']);

    $word_arr = explode(">delete>", $word);
    if ($word_arr[0] != '') {
        $result = $db->query("SELECT id, ext FROM pronunciation WHERE word = '{$word_arr[0]}'");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $dir = round($row['id'] / 500);
            unlink("../pronunciation/$dir/{$row['id']}.{$row['ext']}");
            $db->exec("DELETE FROM pronunciation WHERE id = '{$row['id']}'");
        }
    }

    $db = null;

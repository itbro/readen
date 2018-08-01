<?php
    isset($_POST['radio_descript']) ? $_POST['descript'] = 1 : $_POST['descript'] = '';
    isset($_POST['radio_unsure']) ? $_POST['unsure'] = 1 : $_POST['unsure'] = '';

    $_POST['lel'] = strip_tags($_POST['lel']);
    $_POST['meaning'] = strip_tags($_POST['meaning']);
    $_POST['comment'] = strip_tags($_POST['comment']);
    $_POST['example'] = strip_tags($_POST['example']);
    $_POST['label'] = strip_tags($_POST['label']);
    if (isset($_POST['source'])) $_POST['source'] = strip_tags($_POST['source']);

    $_POST['lel'] = preg_replace("/&#8203;|вЂ‹/", "", $_POST['lel']); // for Cambridge
    $_POST['lel'] = preg_replace('/\t/', '', $_POST['lel']);
    $_POST['lel'] = str_replace("’", "'", $_POST['lel']);
    $_POST['lel'] = str_replace("‘", "'", $_POST['lel']);
    $_POST['lel'] = str_replace("/", " / ", $_POST['lel']);
    $_POST['lel'] = str_replace("/  /  /", " /// ", $_POST['lel']);
    $_POST['lel'] = str_replace("/  /", " // ", $_POST['lel']);
    $_POST['lel'] = str_replace("|", "/", $_POST['lel']);
    $_POST['lel'] = preg_replace('/[ ]{2,}/', ' ', $_POST['lel']);
    $_POST['lel'] = trim($_POST['lel']);

    $_POST['meaning'] = str_replace("“", "\"", $_POST['meaning']);
    $_POST['meaning'] = str_replace("”", "\"", $_POST['meaning']);
    $_POST['meaning'] = str_replace("/", " / ", $_POST['meaning']);
    $_POST['meaning'] = str_replace("/  /  /", " /// ", $_POST['meaning']);
    $_POST['meaning'] = str_replace("/  /", " // ", $_POST['meaning']);
    $_POST['meaning'] = preg_replace('/\t/', '', $_POST['meaning']);
    $_POST['meaning'] = preg_replace('/[ ]{2,}/', ' ', $_POST['meaning']);
    $_POST['meaning'] = trim($_POST['meaning']);

    $_POST['comment'] = preg_replace("/&#8203;|вЂ‹/", "", $_POST['comment']); // for Cambridge
    $_POST['comment'] = preg_replace('/\t/', '', $_POST['comment']);
    $_POST['comment'] = preg_replace('/[ ]{2,}/', ' ', $_POST['comment']);
    $_POST['comment'] = trim($_POST['comment']);

    $_POST['example'] = preg_replace("/&#8203;|вЂ‹/", "", $_POST['example']); // for Cambridge
    $_POST['example'] = str_replace("’", "'", $_POST['example']);
    $_POST['example'] = str_replace("‘", "'", $_POST['example']);
    $_POST['example'] = str_replace("“", "\"", $_POST['example']);
    $_POST['example'] = str_replace("”", "\"", $_POST['example']);
    $_POST['example'] = str_replace(">", " > ", $_POST['example']);
    $_POST['example'] = preg_replace('/[ ]{2,}/', ' ', $_POST['example']);
    $_POST['example'] = preg_replace('/\t/', '', $_POST['example']);
    $_POST['example'] = trim($_POST['example']);
    $example_pure = preg_replace("/\[b\]|\[i\]|\[u\]|\[\/b\]|\[\/i\]|\[\/u\]/", "", $_POST['example']);

    if (isset($_POST['source'])) $_POST['source'] = trim($_POST['source']);

    // For a label to end with a dot
    if ($_POST['label'] != '') {
        if (substr($_POST['label'], -1) != ".") {
            $_POST['label'] = trim($_POST['label']);
            $_POST['label'] = $_POST['label'].".";
        } else $_POST['label'] = $_POST['label'];
        $_POST['label'] = str_replace('. ', '.', $_POST['label']);
        $_POST['label'] = preg_replace('/[ ]{2,}/', ' ', $_POST['label']);
    }
    $_POST['label'] = trim($_POST['label']);

    $_POST['lel'] = addslashes($_POST['lel']);
    $_POST['meaning'] = addslashes($_POST['meaning']);
    $_POST['comment'] = addslashes($_POST['comment']);
    $_POST['example'] = addslashes($_POST['example']);
    $example_pure = addslashes($example_pure);
    $_POST['label'] = addslashes($_POST['label']);
    if (isset($_POST['source'])) $_POST['source'] = addslashes($_POST['source']);


    $_POST['source_from_add'] = addslashes($_POST['source_from_add']);
    $_POST['source_from_add'] = trim($_POST['source_from_add']);

    if (($_POST['lel'] != '') && ($_POST['meaning'] != '')) {
        $db->exec("UPDATE dictionary SET lel = '{$_POST['lel']}',
            meaning = '{$_POST['meaning']}', comment = '{$_POST['comment']}',
            example = '{$_POST['example']}', example_pure = '$example_pure',
            label = '{$_POST['label']}', source = '{$_POST['source']}',
            descript = '{$_POST['descript']}', unsure = '{$_POST['unsure']}'
            WHERE id = '{$_POST['id']}'");
    }

    $_POST['search'] = trim($_POST['search'], "?");
    $_POST['search'] = "?".$_POST['search'];
    if ($_POST['search'] == "?") $_POST['search'] = "";

    header("Location: /dictionary/{$_POST['search']}");

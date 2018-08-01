<?php
    $result = $db->query("SELECT name FROM `{$_GET['source']}` WHERE id = 1");
    $file_name = $result->fetchColumn();

    $fp = fopen("./sources/{$_GET['source']}/{$file_name}.srt", "a");
    $subs = preg_replace("/&gt;/",">",$_REQUEST['subs']);
    ftruncate($fp, 0);
    fwrite($fp, $subs);
    fclose($fp);

    $words = clear_words($_POST['words']);

    $stmt = $db->prepare("UPDATE `{$_GET['source']}` SET
                words = :words,
                page_scroll = '{$_POST['page_scroll']}',
                words_scroll = '{$_POST['words_scroll']}'
                WHERE id = 1");
    $stmt->bindParam(':words', $words);
    $stmt->execute();

    header("Location: /?source={$_GET['source']}");

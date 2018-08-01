<?php
    $result = $db->query("SELECT id FROM `{$_GET['source']}`");
    $numPages = $result->rowCount();

    if ($numPages > 1) {
        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // Create an array made of the numbers of page in existence
            $pages[] = $row['id'];
            if ($row['id'] == $_POST['id'])
                // $p (a key) contains the number of page to be removed
                $p = $i;
            $i++;
        }
        if ($_POST['id'] == $pages[$numPages-1]) {
            // If the max pagehas been removed then the page before it
            // will be opend
            $author_title = $db->query("SELECT author_title FROM `{$_GET['source']}` WHERE id = '{$_POST['id']}'")->fetchColumn();
            if ($author_title != '')
                $db->exec("UPDATE `{$_GET['source']}` SET author_title = '{$author_title}' WHERE id = '{$pages[$p-1]}'");
                $db->exec("DELETE FROM `{$_GET['source']}` WHERE id = '{$_POST['id']}'");
                header("Location: /?source={$_GET['source']}&id={$pages[$p-1]}");
        } else { 
            // Otherwise, the next page will be opened
            $author_title = $db->query("SELECT author_title FROM `{$_GET['source']}` WHERE id = '{$_POST['id']}'")->fetchColumn();
            if ($author_title != '')
                $db->exec("UPDATE `{$_GET['source']}` SET author_title = '{$author_title}' WHERE id = '{$pages[$p+1]}'");
                $db->exec("DELETE FROM `{$_GET['source']}` WHERE id = '{$_POST['id']}'");
                header("Location: /?source={$_GET['source']}&id={$pages[$p+1]}");
        }
    } else {
        $db->exec("UPDATE `{$_GET['source']}` SET id = 1, text = '', words = '', page_scroll = '0', words_scroll = '0', bookmark = '1' WHERE id = '{$_POST['id']}'");
        header("Location: /?source={$_GET['source']}&id=1");
    }

<?php
    require_once "../db_settings.php";

    require_once "../db_connection.php";

    $ext = substr($_FILES['file']['name'], -3);
    if ($ext == 'mp3' || $ext == 'ogg' || $ext == 'wav') {
        $word = trim($_POST['file_name']);
        $result = $db->query("SELECT word FROM pronunciation WHERE word = '{$word}'");
        if ($result->rowCount() == 0) {
            // If there is not such a word in the database
            $word_db = addslashes($word);
            $db->exec("INSERT INTO pronunciation VALUES (null, '{$word_db}', '{$ext}')");
            $id = $db->lastInsertId();
            $dir = round($id / 500);
            // If there is not such a directory then it will be created
            if (!file_exists("../pronunciation/{$dir}"))
                mkdir("../pronunciation/{$dir}", 0700);
            // Save the file on the server
            $new_file = "../pronunciation/{$dir}/{$id}.{$ext}";
            move_uploaded_file($_FILES['file']['tmp_name'], $new_file);

            // For the file to be able to be opened via a text editor
            $data = file_get_contents($new_file);
            file_put_contents($new_file . "_copy", $data);
            unlink($new_file);
            rename($new_file . "_copy", $new_file);
        }
        $db = null;
    }

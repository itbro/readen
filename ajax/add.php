<?php
    require_once "../db_settings.php";

    require_once "../db_connection.php";

    list($link, $word) = explode("|", $_REQUEST['q']);
    if (@fopen($link, "r")) {
        // If there is not such a file on the server

        // Get the extension of the file (mp3/ogg/wav)
    	$ext = substr($link, -3);
    	if ($ext == "mp3" || $ext == "ogg" || $ext == "wav") {
    		$word = trim($word);
    		$result = $db->query("SELECT word FROM pronunciation WHERE word = '{$word}'");
            // If there is not such a file in the database
    		if ($result->rowCount() == 0) {
    			$word_db = addslashes($word);
    			$db->exec("INSERT INTO pronunciation VALUES (null, '{$word_db}', '{$ext}')");
                $id = $db->lastInsertId();
    			$dir = round($id / 500);
                // If there is not such a directory then it will be created
    			if (!file_exists("../pronunciation/{$dir}")) mkdir("../pronunciation/{$dir}", 0700);
                // Save the file onn the server
    			file_put_contents("../pronunciation/{$dir}/{$id}.{$ext}", file_get_contents($link));
    		}
            $db = null;
    	}
    }

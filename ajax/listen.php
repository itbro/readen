<?php
    require_once "../db_settings.php";

    require_once "../db_connection.php";

    $word = trim($_REQUEST['q']);
    $word = addslashes($word);
    $word_lc = strtolower($word);
    $word_uc = ucfirst($word);

    $result = $db->query("SELECT * FROM pronunciation WHERE
        word COLLATE utf8_bin = '{$word}' OR
        word COLLATE utf8_bin LIKE '{$word}=%' OR
        word COLLATE utf8_bin = '{$word_lc}' OR
        word COLLATE utf8_bin LIKE '{$word_lc}=%' OR
        word COLLATE utf8_bin = '{$word_uc}' OR
        word COLLATE utf8_bin LIKE '{$word_uc}=%'
        ORDER BY word ASC");

    $db = null;

    if ($result->rowCount() > 0) {
        // If something has been found
    	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    		$pron_arr[] = "/pronunciation/" . round($row['id'] / 500) . "/{$row['id']}.{$row['ext']}&" . str_ireplace($word, "", $row['word']) . "+";
    	}
    	$pron = implode("", $pron_arr);
    	$pron = trim($pron, "+");
    	if (strpos($pron, "+") === false) {
            // If 1 word has been found
    		if (strpos($pron, "=") === false)
                // If the word doesn't contain comments (=n/v/adj/...)
    			echo trim($pron, "&");
    		else
                // If the word contain (с =n/v/adj/...)
                echo trim($pron, "+");
    	} else
            // If several words have been found
            echo $pron;
    } else
        echo "0";

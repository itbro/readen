<?php
    $row_words = "";
    $result = $db->query("SELECT words FROM `{$_GET['source']}` WHERE id = '{$id}'");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    	if ($row['words'] == '') {
            // If there is no new word
    		for ($i = 0; $i < $words_num_rows; $i++) {
    			$row_words .= "<INPUT TYPE='TEXT' VALUE=\"\"
                class='remember_lel'><INPUT TYPE='TEXT' VALUE=\"\"
                class='remember_meaning'>\r\n";
    		}
    	} else {
    		$words_arr = explode("\r\n", $row['words']);
            $row['words'] = "";
            $to = count($words_arr);

            if ($to >= $words_num_rows) {
                // If the number of new words is more than or the same as
                // the value of the variable $words_num_rows (see:
                // settings.php)
                foreach ($words_arr as $words_row) {
                    $row_words .= "<INPUT TYPE='TEXT'
                    VALUE=\"".str_replace("|", "\" class='remember_lel'><INPUT
                    TYPE=\"TEXT\" VALUE=\"", $words_row)."\"
                    class='remember_meaning'>\r\n";
                }
            } else {
                // If the number of new words is less than
                // the value of the variable $words_num_rows (see:
                // settings.php)
                $to2 = $words_num_rows - $to;
                foreach ($words_arr as $words_row) {
                    $row_words .= "<INPUT TYPE='TEXT'
                    VALUE=\"".str_replace("|", "\" class='remember_lel'><INPUT
                    TYPE=\"TEXT\" VALUE=\"", $words_row)."\"
                    class='remember_meaning'>\r\n";
                }
                for ($i = 0; $i < $to2; $i++) {
                    $row_words .= "<INPUT TYPE='TEXT' VALUE=\"\"
                    class='remember_lel'><INPUT TYPE='TEXT'
                    VALUE=\"\" class='remember_meaning'>\r\n";
                }
            }
    	}
    }

<?php
    $new = "./sources/{$_GET['source']}/" . $_FILES['file_name']['name'];
    move_uploaded_file($_FILES['file_name']['tmp_name'], $new);
    $name = str_replace(".srt", "", $_FILES['file_name']['name']);

    $show_subs = file_get_contents($new);

    // If the subs has not been formated
    if (preg_match("<subnumber>", $show_subs) === 0) {
        $show_subs = trim($show_subs);

        // For the ureadable symbols (diamonds with question marks) not to appear
        $show_subs = iconv("cp1251", "utf-8", $show_subs);

        $rows = explode("\r\n\r\n", $show_subs);

        // Remove all of the empty elements in the array
        $rows = array_diff($rows, array(''));

        // The number of episodes
        $an = count($rows);

        // Process every episode (every element of the array)
        for ($i = 0; $i < $an; $i++) {
            // $arr[0] = the number of episode
            // an array value is the text of episode
            $arr = explode("\r\n", $rows[$i]);

            // In the case there would be unreadable symbols instead of 1
            // in the first episode
            if ($i == 0)
                $arr[0] = 1;

            preg_match_all('#^(.+?) -->#is', $arr[1], $time);

            // $time[1][0] = 00:03:17,380
            $arr[1] = "<div class='who'><timing>" .
            substr($time[1][0], 0, -4)."</timing><subnumber>" .
            str_pad($arr[0], 4, "0", STR_PAD_LEFT) .
            "</subnumber></div><div id='{$arr[0]}' class='what'>";

            $arr[1] .= "!#@G7$";

            unset($arr[0]);

            $newstr = implode("\r\n", $arr);

            // A new array:
            // $arr2[0] = timing and the number of episode
            // $arr2[1] = the text of episode
            $arr2 = explode("!#@G7$\r\n", $newstr);

            $noTags = strip_tags($arr2[1]);

            // Remove tags from the text before a direct speech check
            preg_match('/^- (.+?)\r\n- /', $noTags, $matches1, PREG_OFFSET_CAPTURE);

            if (count($matches1) != 0) {
                // If the text contents a direct speech
                // then line breaks should not be removed
                $arr2[1] .= "</div>";
            } else
                // Otherwise, replace line breaks by spaces
                $arr2[1] = str_replace("\r\n", " ", $arr2[1])."</div>";

            $arr2[1] = trim($arr2[1]);

            $rows[$i] = implode("", $arr2);
        }

        $upgrade = implode("", $rows);

        $upgrade = "<h4>{$name}</h4>".$upgrade;
    } else
        $upgrade = $show_subs;

    $fp = fopen($new, "a");
    ftruncate($fp, 0);
    fwrite($fp, $upgrade);
    fclose($fp);

    // For the file to be able to be opened via a text editor
    $data = file_get_contents($new);
    file_put_contents($new . "_copy", $data);
    unlink($new);
    rename($new . "_copy", $new);

    $stmt = $db->prepare("UPDATE `{$_GET['source']}` SET name = :name WHERE id = 1");
    $stmt->bindParam(':name', $name);
    $stmt->execute();

    header("Location: /?source={$_GET['source']}");

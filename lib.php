<?php
    const FOREIGN_PARTICLES = ["a", "an", "and", "for", "in", "no", "of", "on", "or", "over", "the", "to", "to be", "to do", "with"];


    // For the variable $transliteration
    const UNUSED = 0;
    const NATIVE_TO_FOREIGN = 1;
    const FOREIGN_TO_NATIVE = 2;
    const FOREIGN_LANGUAGE = 1;
    const NATIVE_LANGUAGE = 2;

    // For the replacements in the examples
    const REPLACE_WHAT = [
    "/\[(http(.*?))\]/",
    "/\[img\](.*?)\[\/img\]/",
    "/\[b\](.*?)\[\/b\]/",
    "/\[i\](.*?)\[\/i\]/",
    "/\[u\](.*?)\[\/u\]/",
    "/\[s\](.*?)\[\/s\]/",
    "/\[h\]/"];

    // For the replacements in the examples
    const REPLACE_BY = [
    "<a href=\"\\1\" target=\"_blank\">&#8599;</a>",
    "<img src=\"\\1\">",
    "<b>\\1</b>",
    "<i>\\1</i>",
    "<u>\\1</u>",
    "<s>\\1</s>",
    "<span class='source_headline'>[headline]</span>"];

    // The native alphabet
    const NATIVE_LETTERS = "/а|б|в|г|д|е|ё|ж|з|и|й|к|л|м|н|о|п|р|с|т|у|ф|х|ц|ч|ш|щ|ъ|ы|ь|э|ю|я/i";

    $columns = "id, lel, meaning, comment, example, label, source, descript, unsure, date";

    $dobavka1 = "[\'\"]";
    $dobavka2 = "[!?\.,]";

    function word_meaning_comment_number_example($id, $number, $example)
    {
        // For the function entries()
        // if the comment has several examples
        if ($number == 0) {
            if (strpos($example, "no example") !== false) {
                // If the example is empty
                echo "    <li>",str_replace("<for_replace>",
                "<span id='e$id' class='edit_button'>#</span> \n<div class='td_result' id='f$id' style='display:none;'>",
                str_replace("no example", "", $example)),"</li>\n";
            } else {
                // If the example is full
                echo "    <li>",str_replace("<for_replace>", "",
                str_replace("</li>\n</ol>",
                "<span id='e$id' class='edit_button'>#</span></li>\n</ol> \n<div class='td_result' id='f$id' style='display:none;'>",
                str_replace("</p >",
                "<span id='e$id' class='edit_button'>#</span></p> \n<div class='td_result' id='f$id' style='display:none;'>",
                $example))),"</li>\n";
            }
        } else {
            // If there ara 2 or more the same entries with different examples
            // then make the second example (3d, 4th.,..) red
            if (strpos($example, "no example") !== false) {
                // If the example is empty
                echo "    <li>",str_replace("<for_replace>",
                "&nbsp;<span id='e$id' class='edit_button' style='color:red;'>#</span> \n<div class='td_result' id='f$id' style='display:none;'>",
                str_replace("no example", "", $example)),"</li>\n";
            } else {
                // If the example is full
                $example = str_replace("class='word_example'",
                "class='word_example' style='color:red;'",
                str_replace("class='word_example_li'",
                "class='word_example_li' style='color:red;'",
                $example));

                echo "    <li>",str_replace("<for_replace>", "",
                str_replace("</li>\n</ol>",
                "<span id='e$id' class='edit_button'>#</span></li>\n</ol> \n<div class='td_result' id='f$id' style='display:none;'>",
                str_replace("</p >",
                "<span id='e$id' class='edit_button'>#</span></p> \n<div class='td_result' id='f$id' style='display:none;'>",
                $example))),"</li>\n";
            }
        }
    }




    function format_text($text)
    {
        // Formats the text of source
        $text = trim($text);
        $text = str_replace("‘", "'", $text);
        $text = str_replace("’", "'", $text);
        $text = str_replace("“", "\"", $text);
        $text = str_replace("”", "\"", $text);
        $text = preg_replace("/<nored>|<\/nored>/", "", $text);
        $text = preg_replace("/<TEXTAREA>|<\/TEXTAREA>/", "", $text);
        $text = preg_replace("/[ ]{2,}/", " ", $text);
        $text = addslashes($text);

        str_replace("<br>", "\r\n", $text);

        return $text;
    }


    function format_url($url)
    {
        // Formats the link to an article
        // used in sources\article\database\change.php
        $url = trim($url);
        $url = strip_tags($url);

        return $url;
    }



    function clear_words($words)
    {
        // Prepares the Words for saving to the Database.
        //
        // 1. If there is no foreign word or word at all
        //    then nothing is saved to the field Words in the Database
        // 2. If the last rows are empty they will be removed

        $nafl = "/[a-zа-яё]/i"; // Native and foreign letters

        // 1
        preg_match($nafl, $words) ? $words = $words : $words = "";

        // 2
        $words_arr = explode("\r\n", $words);
        $to = count($words_arr);
        if ($to > 0) {
            for ($i = 0; $i < $to; $i++) {
                if ($words_arr[$i] != "|")
                    $full_row = $i;
            }
            array_splice($words_arr, $full_row + 1);
            $words = implode($words_arr, "\r\n");
        }

        return $words;
    }

<?php
    define('FOREIGN_PARTICLES', ["a", "an", "and", "for", "in", "no", "of", "on", "or", "over", "the", "to", "to be", "to do", "with"]);

    // All of them are replaced by "oneself"
    // See: prepare_lel_for_db()
    define('SELFS', "/ herself | herself| himself | himself| itself | itself| ourselves | ourselves| themselves | themselves| yourself | yourself| myself | myself/i");

    // All of them are replaced by "%"
    // See: prepare_lel_for_db()
    define('MYS', "/ my | his | her | your |your | our |our | their | its | him | it | me | sb | sth | sth | sth| them | they | us | you /i");

    // For the variable $transliteration
    define('UNUSED', 0);
    define('NATIVE_TO_FOREIGN', 1);
    define('FOREIGN_TO_NATIVE', 2);
    define('FOREIGN_LANGUAGE', 1);
    define('NATIVE_LANGUAGE', 2);

    // For the replacements in the examples
    define('REPLACE_WHAT', [
    "/\[(http(.*?))\]/",
    "/\[img\](.*?)\[\/img\]/",
    "/\[b\](.*?)\[\/b\]/",
    "/\[i\](.*?)\[\/i\]/",
    "/\[u\](.*?)\[\/u\]/",
    "/\[s\](.*?)\[\/s\]/",
    "/\[h\]/"]);

    // For the replacements in the examples
    define('REPLACE_BY', [
    "<a href=\"\\1\" target=\"_blank\">&#8599;</a>",
    "<img src=\"\\1\">",
    "<b>\\1</b>",
    "<i>\\1</i>",
    "<u>\\1</u>",
    "<s>\\1</s>",
    "<span class='source_headline'>[headline]</span>"]);

    // The native alphabet
    define('NATIVE_LETTERS', "/а|б|в|г|д|е|ё|ж|з|и|й|к|л|м|н|о|п|р|с|т|у|ф|х|ц|ч|ш|щ|ъ|ы|ь|э|ю|я/i");

    // For the function translit()
    define('LETTERS', array(
        "q" => "й",
        "w" => "ц",
        "e" => "у",
        "r" => "к",
        "t" => "е",
        "y" => "н",
        "u" => "г",
        "i" => "ш",
        "o" => "щ",
        "p" => "з",
        "[" => "х",
        "]" => "ъ",
        "a" => "ф",
        "s" => "ы",
        "d" => "в",
        "f" => "а",
        "g" => "п",
        "h" => "р",
        "j" => "о",
        "k" => "л",
        "l" => "д",
        ";" => "ж",
        "'" => "э",
        "z" => "я",
        "x" => "ч",
        "c" => "с",
        "v" => "м",
        "b" => "и",
        "n" => "т",
        "m" => "ь",
        "," => "б",
        "." => "ю",
        "Q" => "Й",
        "W" => "Ц",
        "E" => "У",
        "R" => "К",
        "T" => "Е",
        "Y" => "Н",
        "U" => "Г",
        "I" => "Ш",
        "O" => "Щ",
        "P" => "З",
        "{" => "Х",
        "}" => "Ъ",
        "A" => "Ф",
        "S" => "Ы",
        "D" => "В",
        "F" => "А",
        "G" => "П",
        "H" => "Р",
        "J" => "О",
        "K" => "Л",
        "L" => "Д",
        ":" => "Ж",
        "\"" => "Э",
        "Z" => "Я",
        "X" => "Ч",
        "C" => "С",
        "V" => "М",
        "B" => "И",
        "N" => "Т",
        "M" => "Ь",
        "<" => "Б",
        ">" => "Ю",
        "`" => "ё",
        "~" => "Ё",
        "!" => "!",
        "@" => "\"",
        "#" => "№",
        "$" => ";",
        "^" => ":",
        "&" => "?",
        "|" => "/",
        "?" => ",",
        "/" => "."));

    $columns = "id, lel, meaning, comment, example, label, source, descript, unsure, date";

    $dobavka1 = "[\'\"]";
    $dobavka2 = "[!?\.,]";

    function prepare_lel_for_db($foreign)
    {
        // Used in dictionary\database\search_request.php
        $foreign = str_replace("sb\'s", "%", $foreign);
        $foreign = str_replace("sth\'s", "%", $foreign);
        $foreign = preg_replace(SELFS, " oneself ", $foreign);
        $foreign = preg_replace(MYS, " % ", $foreign);
        $foreign = preg_replace("/sb /i", "% ", $foreign);
        $foreign = preg_replace("/ sb/i", " %", $foreign);
        $foreign = addslashes($foreign);
        $foreign = trim($foreign);

        return $foreign;
    }

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

    function entries($arr, $i, $id, $word, $meaning, $comment)
    {
        global $id;
        $comment_num = count($arr[$i][$word][$meaning]);
        if ($comment_num == 1) {
            // If the translation has only 1 comment
            foreach ($arr[$i][$word][$meaning] as $comment => $example) {
                if ($comment == "") {
                    // If the comment is empty
                    $example_num = count($arr[$i][$word][$meaning][$comment]);
                    if ($example_num == 1) {
                        // If the comment has only 1 example
                        if (strpos($arr[$i][$word][$meaning][$comment][0], "no example") !== false) {
                            // If the example is empty
                            echo "\n <div class='word_ru'>\n  $meaning",str_replace("<for_replace>",
                            "<span id='e$id' class='edit_button'>#</span> \n<div class='td_result' id='f$id' style='display:none;'>",
                            str_replace("no example", "", $arr[$i][$word][$meaning][$comment][0])),"</div>\n";
                        } else {
                            // If the example is full
                            echo "\n <div class='word_ru'>\n  $meaning<span id='r$id' class='rest_button_closed'></span>
      <div id='shr$id' class='rest' style='display:none;'>\n   ",
      str_replace("<for_replace>", "", str_replace("</li>\n</ol>",
      "<span id='e$id' class='edit_button'>#</span></li>\n</ol> \n<div class='td_result' id='f$id' style='display:none;'>",
      str_replace("</p >",
      "<span id='e$id' class='edit_button'>#</span></p> \n<div class='td_result' id='f$id' style='display:none;'>",
      $arr[$i][$word][$meaning][$comment][0]))),"\n  </div>\n </div>\n";
                        }
                    } else {
                        // If the comment has several examples
                        echo "\n <div class='word_ru'>\n  $meaning<span id='r$id' class='rest_button_closed'></span>
      <div id='shr$id' class='rest' style='display:none;'>\n";
                        echo "   <ol class='list_example_sub'>\n";
                        foreach ($arr[$i][$word][$meaning][$comment] as $number => $example) {
                            word_meaning_comment_number_example($id,$number,$example);
                            $id++;
                        }
                        echo "   </ol>\n";
                        echo "  </div>\n </div>\n";
                    }
                } else {
                    // If the comment is full
                    $example_num = count($arr[$i][$word][$meaning][$comment]);
                    if ($example_num == 1) {
                        // If the comment has only 1 example
                        if (strpos($arr[$i][$word][$meaning][$comment][0], "no example") !== false) {
                            // If the example is empty
                            echo "\n <div class='word_ru'>\n  $meaning\n  <p class='word_comment'>$comment<span id='e$id' class='edit_button'>#</span></p>",
                            str_replace("<for_replace>", "\n<div class='td_result' id='f$id' style='display:none;'>",
                            str_replace("no example", "", $arr[$i][$word][$meaning][$comment][0])),"</div>\n";
                        } else {
                            // If the example is full
                            echo "\n <div class='word_ru'>\n  $meaning\n  <p class='word_comment'>$comment<span id='r$id' class='rest_button_closed correct'></span></p>
      <div id='shr$id' class='rest' style='display:none;'>\n   ",
      str_replace("<for_replace>", "",
      str_replace("</li>\n</ol>", "<span id='e$id' class='edit_button'>#</span></li>\n</ol> \n<div class='td_result' id='f$id' style='display:none;'>",
      str_replace("</p >", "<span id='e$id' class='edit_button'>#</span></p> \n<div class='td_result' id='f$id' style='display:none;'>",
      $arr[$i][$word][$meaning][$comment][0]))),"\n  </div>\n </div>\n";
                        }
                    } else {
                        // If the comment has several examples
                        echo "\n <div class='word_ru'>\n  $meaning\n  <p class='word_comment'>$comment<span id='r$id' class='rest_button_closed'></span></p>
      <div id='shr$id' class='rest' style='display:none;'>\n";
                        echo "   <ol class='list_example_sub'>\n";
                        foreach ($arr[$i][$word][$meaning][$comment] as $number => $example) {
                            word_meaning_comment_number_example($id,$number,$example);
                            $id++;
                        }
                        echo "   </ol>\n";
                        echo "  </div>\n </div>\n";
                    }
                }
            }
        } else {
            // If the translation has several comments
            echo "\n <div class='word_ru'>\n  $meaning";
            echo "\n  <ol class='comment_list'>\n";
            foreach ($arr[$i][$word][$meaning] as $comment => $example) {
                echo "   <li>";
                if ($comment == "") {
                    // If the comment is empty
                    $example_num = count($arr[$i][$word][$meaning][$comment]);
                    if ($example_num == 1) {
                        // If the comment has only 1 example
                        if (strpos($arr[$i][$word][$meaning][$comment][0], "no example") !== false) {
                            // If the example is empty
                            echo str_replace("<for_replace>",
                            "<span id='e$id' class='edit_button' style='margin-left:0;'>#</span> \n<div class='td_result' id='f$id' style='display:none;'>",
                            str_replace("no example", "", $arr[$i][$word][$meaning][$comment][0]));
                        } else {
                            // If the example is full
                            echo "<span id='r$id' class='rest_button_closed correct'></span>
      <div id='shr$id' class='rest' style='display:none;'>\n   ",str_replace("<for_replace>", "",
      str_replace("</li>\n</ol>",
      "<span id='e$id' class='edit_button'>#</span></li>\n</ol> \n<div class='td_result' id='f$id' style='display:none;'>",
      str_replace("</p >",
      "<span id='e$id' class='edit_button'>#</span></p> \n<div class='td_result' id='f$id' style='display:none;'>",
      $arr[$i][$word][$meaning][$comment][0]))),"\n  </div>\n";
                        }
                    } else {
                        // If the comment has several examples
                        echo "<span id='r$id' class='rest_button_closed correct'></span>
        <div id='shr$id' class='rest' style='display:none;'>\n";
                        echo "     <ol class='list_example_sub'>\n";
                        foreach ($arr[$i][$word][$meaning][$comment] as $number => $example) {
                            word_meaning_comment_number_example($id,$number,$example);
                            $id++;
                        }
                        echo "     </ol>\n";
                        echo "    </div>\n";
                    }
                } else {
                    // If the comment is full
                    $example_num = count($arr[$i][$word][$meaning][$comment]);
                    if ($example_num == 1) {
                        // If the comment has only 1 example
                        if (strpos($arr[$i][$word][$meaning][$comment][0], "no example") !== false) {
                            // If the example is empty
                            echo "\n    <p class='word_comment'>$comment<span id='e$id' class='edit_button'>#</span></p>",
                            str_replace("<for_replace>", "\n<div class='td_result' id='f$id' style='display:none;'>",
                            str_replace("no example", "", $arr[$i][$word][$meaning][$comment][0])),"\n";
                        } else {
                            // If the example is full
                            echo "\n    <p class='word_comment'>$comment<span id='r$id' class='rest_button_closed correct'></span></p>
      <div id='shr$id' class='rest' style='display:none;'>\n   ",
      str_replace("<for_replace>", "", str_replace("</li>\n</ol>",
      "<span id='e$id' class='edit_button'>#</span></li>\n</ol> \n<div class='td_result' id='f$id' style='display:none;'>",
      str_replace("</p >",
      "<span id='e$id' class='edit_button'>#</span></p> \n<div class='td_result' id='f$id' style='display:none;'>",
      $arr[$i][$word][$meaning][$comment][0]))),"\n  </div>\n";
                        }
                    } else {
                        // If the comment has several examples
                        echo "\n    <p class='word_comment'>$comment<span id='r$id' class='rest_button_closed'></span></p>
        <div id='shr$id' class='rest' style='display:none;'>\n";
                        echo "     <ol class='list_example_sub'>\n";
                        foreach ($arr[$i][$word][$meaning][$comment] as $number => $example) {
                            word_meaning_comment_number_example($id,$number,$example);
                            $id++;
                        }
                        echo "     </ol>\n";
                        echo "    </div>\n";
                    }
                }
                echo "   </li>\n";
                $id++;
            }
            echo "  </ol>";

            // the translation close tag
            echo "\n </div>\n";
        }
    }


    function words_found($num_rows, $num_rows2)
    {
        // Outputs the number of words found
        // and defines the endings for the words "word" and "translation"

        $num_rows2 == 1 ? $wORws = 'word ' : $wORws = 'words ';

        if ($_SERVER['QUERY_STRING'] == "") {
            $num_rows == 1 ? $mORms = 'translation' : $mORms = 'translations';
            return "<span id='stat' title='$num_rows2 $wORws $num_rows $mORms for today'>$num_rows</span>";
        } else {
            $num_rows == 1 ? $mORms = 'translation' : $mORms = 'translations';
            return "<span id='stat' title='$num_rows2 $wORws $num_rows $mORms found'>$num_rows</span>";
        }
    }


    function translit($word, $lang)
    {
        // The transliteration:
        // if $lang == NATIVE_LANGUAGE then the transliteration
        // from the native language to the foreign one
        // otherwise from the foreign language to the native one

        $word_as_array = [];
        $word_length = mb_strlen($word);
        for ($i = 0; $i < $word_length; $i++) {
            $word_as_array[$i] = mb_substr($word, $i, 1);
        }

        $letters = LETTERS;

        if ($lang != NATIVE_LANGUAGE)
            $letters = array_flip(LETTERS);

        $word_translated = "";
        foreach ($word_as_array as $its_letter) {
            if (isset($letters[$its_letter])) {
                $word_translated .= $letters[$its_letter];
            } else $word_translated .= $its_letter;
        }
        return $word_translated;
    }


    function pager($num_rows2, $how_many_pages, $this_page)
    {
        // The list of pages for the Dictionary
        // It only outputs if the number of pages are more than 1
        if ($how_many_pages > 1) {

            // the previous page
            if ($this_page == 1)
                $pagePrevious = "<span class='noPage'>&#9664;</span>";
            else {
                $rest_part = preg_replace(
                    "/scrolling=([0-9]+)/",
                    "scrolling=0",
                    $_SERVER['QUERY_STRING']);

                $pagePrevious = preg_replace(
                    "/page=([0-9]+)/",
                    "page=" . ($this_page - 1),
                    $rest_part);

                $pagePrevious = "<a href=\"?" . $pagePrevious . "\">&#9664;</a>";
            }
            $arr['back_page'] = $pagePrevious;

            // the list of pages
            $arr['page_list'] = "";
            for ($i = 1; $i <= $how_many_pages; $i++) {
                $nbsp = "";
                if (strlen($how_many_pages) == 1)
                    $nbsp .= "&nbsp;";
                else {
                    if (strlen($how_many_pages) != strlen($i)) {
                        $k = strlen($how_many_pages) - strlen($i);
                        for ($ik = 0; $ik < $k; $ik++) {
                            $nbsp .= "&nbsp;";
                        }
                    } else $nbsp = "";
                }
                $arr['page_list'] .=  "<OPTION VALUE='{$i}'>{$nbsp}{$i}</OPTION>";
            }

            // the next page
            if ($this_page == $how_many_pages)
                $pageNext = "<span class='noPage'>&#9654;</span>";
            else {
                $rest_part = preg_replace(
                    "/scrolling=([0-9]+)/",
                    "scrolling=0",
                    $_SERVER['QUERY_STRING']);

                $pageNext = preg_replace(
                    "/page=([0-9]+)/",
                    "page=" . ($this_page + 1),
                    $rest_part);

                $pageNext = "<a href=\"?" . $pageNext . "\">&#9654;</a>";
            }
            $arr['next_page'] = $pageNext;

            return <<<LOL
            <div id='pages'><div id='pCenter'>
            <div class='pagePrevious'>{$arr['back_page']}</div>
            <SELECT NAME='' id='pageList'>{$arr['page_list']}</SELECT>
            <div class='pageNext'>{$arr['next_page']}</div>
            </div></div>

            <script>
            <!-- В выпадающем списке страниц (id='pageList') выбрать текущую страницу -->
            var optionsA = document.getElementById('pageList').getElementsByTagName('option');
            for (o=0; o<optionsA.length; o++) {
                if (optionsA[o].value == {$this_page}) {
                    optionsA[o].selected=true;
                }
            }
            </script>
LOL;
        } else return;
    }


    function edit_form(
        // The Edit entry form
        // used in dictionary\views\vyvod_strok.php

        $row_id,
        $row_lel,
        $row_meaning,
        $row_comment,
        $row_example,
        $row_label,
        $row_source,
        $textarea_meaning,
        $this_page,
        $source_from_sources,
        $checkbox_decript,
        $checkbox_unsure
    )
    {
        $row_lel = htmlspecialchars(stripslashes($row_lel), ENT_QUOTES);
        $row_meaning = htmlspecialchars(stripslashes($row_meaning), ENT_QUOTES);
        $row_comment = htmlspecialchars(stripslashes($row_comment),ENT_QUOTES);
        $row_example = htmlspecialchars(stripslashes($row_example), ENT_QUOTES);
        $row_source = htmlspecialchars(stripslashes($row_source), ENT_QUOTES);
        $source_from_sources = htmlspecialchars(stripslashes($source_from_sources), ENT_QUOTES);
        $server_query_string = htmlspecialchars(stripslashes($_SERVER['QUERY_STRING']), ENT_QUOTES);

        return <<<LOL
        <for_replace>
            <div class="closeEdit">×</div>
            <FORM NAME="form{$row_id}" METHOD="POST" ACTION="/dictionary/">
                <legend>Edit entry form</legend>
                <INPUT TYPE="TEXT" NAME="lel" MAXLENGTH="500" VALUE="{$row_lel}"
                PLACEHOLDER="foreign" AUTOCOMPLETE="off" class="result_lel">
                <INPUT TYPE="TEXT" NAME="meaning" MAXLENGTH="500" VALUE="{$row_meaning}"
                PLACEHOLDER="native" AUTOCOMPLETE="off" $textarea_meaning id="meaning{$row_id}">
                <TEXTAREA NAME="comment" MAXLENGTH="1000" PLACEHOLDER="comment"
                class="result_comment">{$row_comment}</TEXTAREA>
                <div class="bbcodes"><span id="b{$row_id}" class="bbc_b">b</span><span
                id="i{$row_id}" class="bbc_i">i</span><span id="u{$row_id}"
                class="bbc_u">u</span><span id="s{$row_id}" class="bbc_s">s</span><span
                id="x{$row_id}" class="bbc_x">Clear</span></div>
                <TEXTAREA NAME="example" MAXLENGTH="2000" PLACEHOLDER="example"
                class="result_example" id="example{$row_id}">{$row_example}</TEXTAREA>
                <INPUT TYPE="TEXT" NAME="label" MAXLENGTH="500" VALUE="{$row_label}"
                PLACEHOLDER="label" AUTOCOMPLETE="off" class="result_label">
                <INPUT TYPE="TEXT" NAME="source" MAXLENGTH="1000" VALUE="{$row_source}"
                PLACEHOLDER="source" AUTOCOMPLETE="off" class="result_source"
                id="source{$row_id}">
                <div class="descript_unsure"><label><INPUT TYPE="CHECKBOX"
                NAME="radio_descript" class="checkbox" VALUE="1"{$checkbox_decript}
                id="descript{$row_id}"><p class="checkbox_description">Description</p></label><label><INPUT
                TYPE="CHECKBOX" NAME="radio_unsure" class="checkbox"
                VALUE="1"{$checkbox_unsure} id="unsure{$row_id}"><p
                class="checkbox_unsure">Unsure</p></label></div>
                <INPUT TYPE="SUBMIT" NAME="action" VALUE="change" id="bs{$row_id}" class="button_save">
                <div class="button_del" id="dD{$row_id}">Delete</div>
                <INPUT TYPE="SUBMIT" NAME="action" VALUE="delete" id="sD{$row_id}" style="display:none;">
                <INPUT TYPE="HIDDEN" NAME="id" VALUE="{$row_id}">
                <INPUT TYPE="HIDDEN" NAME="search" VALUE="{$server_query_string}" id="acds{$row_id}">
                <INPUT TYPE="HIDDEN" NAME="page" VALUE="$this_page" class="this_page_from_label">
                <INPUT TYPE="HIDDEN" NAME="source_from_add" VALUE="{$source_from_sources}">
            </FORM>
        </div>

LOL;
    }

    // For the function clear_words()
    define('NATIVE_AND_FOREIGN_LETTERS', "/[a-zа-яё]/i");

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
        // Prepares the Words for the database.
        // If there is no word then nothing is saved
        preg_match(NATIVE_AND_FOREIGN_LETTERS, $words) ? $words = $words : $words = "";

        // The last empty rows are removed
        $words_arr = explode("\r\n", $words);
        $to = count($words_arr);
        if ($to > 0) {
            for ($i = 0; $i < $to; $i++) {
                if ($words_arr[$i] != "|") $full_row = $i;
            }
            array_splice($words_arr, $full_row + 1);
            $words = implode($words_arr, "\r\n");
        }
        return $words;
    }

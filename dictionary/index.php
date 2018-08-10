<?php
    require_once "../db_settings.php";

    require_once "../db_connection.php";

    require_once "../settings.php";

    require_once "../lib.php";

    spl_autoload_register();

    // When a new entry added or the existing entry edited or deleted
    if (isset($_POST['action'])) {
    	require_once "database/{$_POST['action']}.php";
        exit;
    }

    isset($_GET['page']) ? $page = $_GET['page'] : $page = 1;

    require_once "database/search_request.php";

    require_once "views/result_output.php";

    $num_rows2 = count($arr);

    // The number of pages
    $how_many_pages = ceil($num_rows2 / $how_many_rows_dic);

    if (!isset($_GET['search_lel']) && $how_many_pages > 1 && !isset($_GET['page']))
        header("Location: /dictionary/?page=1");

    $words_found = lib\ResultNumber::words_found($num_rows, $num_rows2);

    // If the Dictionary has been open from the Sources
    if ($search_source != "")
        $sSource = $search_source;
    else if ($source_from_sources != "")
        $sSource = $source_from_sources;
    else if (isset($_COOKIE["source_from_add"]))
        $sSource = $_COOKIE["source_from_add"];
    else
        $sSource = "";
    preg_match("/^(http:\/\/)|^(https:\/\/)/", $sSource, $matches69, PREG_OFFSET_CAPTURE);
    if ($matches69 == 1) $sSource = str_replace(" ", "+", $sSource);
    $sSource = htmlentities(stripslashes($sSource), ENT_QUOTES, "UTF-8", false);

    $page_list_output = lib\Pager::pages($num_rows2, $how_many_pages, $page);


    // The number of next entry for the Add new word form
    $new_word_number = $db->query("SELECT count(*) FROM dictionary")->fetchColumn() + 1;


    $db = null;


    if ($_SERVER['REQUEST_URI'] != "/dictionary/") {
        $toTitle == '' ?
        $toTitle = "Dictionary ($num_rows)" :
        $toTitle .= " ($num_rows)";
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= $toTitle ?></title>
        <meta charset='utf-8'>
        <link rel='SHORTCUT ICON' href='/favicon.ico' type='image/x-icon'>
        <link rel='stylesheet' type='text/css' href='/dictionary/views/css.css'>

        <script src="/jquery.js"></script>
        <script src='/settings.js'></script>
        <script src='/lib.js'></script>
        <script src='/dictionary/views/js.js'></script>
    </head>
    <body>
        <div id='dictionary'>

            <!-- the Add new word form -->
            <div id='add_new_word' style='display:none;'>
<?php require_once "views/add_new_word_form.php"; ?>
            </div>

            <!-- the Search form -->
            <div id='td_search'>
<?php require_once "views/search_fields.php"; ?>
            </div>

            <!-- The entries -->
<?php
    if ($num_rows2 > 0) {
        // Form what page
        $from = $page * $how_many_rows_dic - $how_many_rows_dic;
        // To what page
        $to = $page * $how_many_rows_dic;
        $to <= $num_rows2 ? $to = $to : $to = $num_rows2;

        // The counter to show/hide the examples
        $id = 0;
        for ($i = $from; $i < $to; $i++) {
            foreach ($arr[$i] as $word => $meaning) {
                echo "<div class='word_meaning'>\n <div class='word_en'>$word</div>";
                // How many the word has translations
                $meaning_num = count($arr[$i][$word]);
                // If there is only 1 word
                if ($meaning_num == 1) {
                    foreach ($arr[$i][$word] as $meaning => $comment) {
                        lib\EntriesOutput::entries($arr,$i,$id,$word,$meaning,$comment);
                    }
                } else {
                // If several
                    echo "\n <ol class='meaning_list'>\n";
                    foreach ($arr[$i][$word] as $meaning => $comment) {
                        echo "  <li>";
                        lib\EntriesOutput::entries($arr,$i,$id,$word,$meaning,$comment);
                        echo "  </li>\n\n";
                        $id++;
                    }
                    echo " </ol>\n";
                }
                echo "</div>\n\n";
            }
            $id++;
        }
    }
?>

        </div>

        <!-- The list of pages -->
<?= $page_list_output ?>

        <div id='deleteWarning' style='display:none;'>Are you sure?<br>
            <div id='deleteYes'>Yes</div><div id='deleteNo'>No</div>
            <div id='YesNo'></div>
        </div>

        <audio id='audio' style='display:none;' controls></audio>
        <button id='sound' style='display:none;'>♫</button>
        <INPUT TYPE='TEXT' NAME='add_change_del[word]' VALUE=''
        autocomplete='off' id='pron_word' style='display:none;'>
        <INPUT TYPE='TEXT' NAME='add_change_del[pron_link]' VALUE=''
        autocomplete='off' id='pron_link' style='display:none;'>

        <INPUT TYPE='TEXT' VALUE='' id='falseForm'>

        <script type="text/javascript">
            document.getElementById("td_search").style.left =
            document.getElementById("dictionary").getBoundingClientRect().left;

            document.getElementById("dictionary").style.minHeight =
            document.documentElement.clientHeight -
            document.getElementById("td_search").offsetHeight - dicMinHeightMinus + "px";

            var dicMarginTop = document.getElementById("dictionary").getBoundingClientRect().top;

            if (document.getElementById("extra_fields_button").classList.item(0) == "extra_fields_button_open")
                document.getElementById("dictionary").style.marginTop =
                document.getElementById("dictionary").getBoundingClientRect().top +
                document.getElementById("extra_fields").offsetHeight +
                document.getElementById("content").offsetHeight - extra_fields_indent + "px";
        </script>

        <form action="/ajax/add_manually.php" method="post" id="add_manually" enctype="multipart/form-data" style="display:none;">
            <input type="text" name="file_name" value="" id="file_name">
            <input type="file" name="file" id="file">
          <input type="submit" value="" id="submit">
        </form>
    </body>
</html>

<?php
    require_once "db_settings.php";

    require_once "db_connection.php";

    require_once "settings.php";

    require_once "lib.php";

    if (isset($_POST['action'])) {
        require_once "./sources/{$_GET['source']}/database/{$_POST['action']}.php";
    	exit;
    }

    // If index.php opend
    if ($_SERVER['REQUEST_URI'] == "/" || $_SERVER['REQUEST_URI'] == "/index.php")
        header("Location: /?source=article");

    isset($_GET['id']) ? $id = intval($_GET['id']) : $id = 1;

    // For the Book, if an unacceptable page has been requested
    if ($_GET['source'] == "book" && ($id == 0 || $id < -99 || $id > 999))
        header("Location: /?source={$_GET['source']}&id=1");

    $delete_whole_book = '';

    require_once "./sources/words/words.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" type="text/css" href="sources/css.css">
        <link rel="stylesheet" type="text/css" href="sources/<?= $_GET['source'] ?>/views/css.css">

        <script src="/jquery.js"></script>
        <script src="/settings.js"></script>
        <script src="/lib.js"></script>
        <script src="sources/<?= $_GET['source'] ?>/views/js.js"></script>

        <link rel="search" type="application/opensearchdescription+xml"
        href="search_plugin.xml" title="Readen">
        <title><?= ucfirst($_GET['source']) ?></title>
    </head>
    <body>
        <div id='top'>
            <div id='topMenuSubMenu'>
                <!-- Top Right -->
                <div id='subMenu'>
<?php
                    require_once "./sources/{$_GET['source']}/views/TopRight.php";
?>
                </div>
                <div id='openDic'>
                    <INPUT TYPE='TEXT' VALUE='' id='searchInDic'>
                </div>
                <!-- Top Left -->
                <div id='menu'>
<?php
                    require_once "./sources/{$_GET['source']}/views/TopLeft.php";
?>
                </div>
            </div>
        </div>

        <div id='bottom'>
            <div id='bottomLeftRight'>

                <!-- Bottom Right (the Words) -->
                <div id='bottomRight'>

                    <div id='occ_num'></div>
                    <div id='words_to_remember'>
                        <div id='fields'><?= $row_words ?></div>
                    </div>
                    <iframe src='sources/words/' frameborder='0' id='frame_words' name="frame_words"></iframe>
                    <div id='new_red_words'>
                        <div id='new_words_num'></div>
                        <div id='red_words_num'></div>
                        <div id='add_field'></div>
                        <div id='toolCode'><span title="Add the row under the current one: --
Add the row below the current one: ==
Remove the current row: -=
Remove all of the empty rows: =-">?</span></div>
                    </div>

                </div>

                <!-- Bottom Left (the Text) -->
                <div id='bottomLeft'>
<?php
                    require_once "./sources/{$_GET['source']}/views/text.php";

                    $db = null;
?>
                    <iframe NAME='text_editable_frame'
                        src='sources/text.html?<?= $_GET['source'] ?>'
                        frameborder='0' spellcheck='false' scrolling='no'
                        id='editor_frame'></iframe>
                    <div id='scroll_a' style='display:none;'></div>

                    <div id='to_add_new_word' style='display:none;'><?= $sourceForDic ?></div>

                    <div id='deleteWarning' style='display:none;'><?= $delete_whole_book ?>
                        <p id='delete_the'>Delete the <?= $delete_what ?>?</p>
                        <div id='deleteYes'>Yes</div><div id='deleteNo'>No</div>
                    </div>

                    <div id='meanpron' style='display:none;'><button
                        id='word_meaning'>&nbsp;</button><button
                        id='word_highlight'>H</button><button
                        id='word_clear'>C</button><button
                        id='sound'>♫</button><INPUT TYPE='TEXT'
                        NAME='add_change_del[word]' VALUE=''
                        autocomplete='off' id='pron_link'
                        style='display:none;'><INPUT TYPE='TEXT'
                        NAME='add_change_del[pron_link]' VALUE=''
                        autocomplete='off' id='pron_word' style='display:none;'>
                    </div>

                    <audio id='audio' style='display:none;'></audio>

                </div>
            </div>
        </div>

        <form action="ajax/add_manually.php" method="post" id="add_manually" enctype="multipart/form-data" style="display:none;">
            <input type="text" name="file_name" value="" id="file_name">
            <input type="file" name="file" id="file">
          <input type="submit" value="" id="submit">
        </form>
    </body>
</html>

<?php
    $result = $db->query("SELECT * FROM {$_GET['source']} WHERE id = {$id}");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        if ($row['name'] != "") {
            $subName = str_replace("%20", " ", $row['name']) . ".srt";
            $content = file_get_contents("sources/{$_GET['source']}/{$subName}");
        } else {
            $subName = $content = "";
        }

        echo <<<LOL
                        <FORM METHOD='POST' ACTION='/?source={$_GET['source']}'
                        enctype='multipart/form-data' id='load_subs_form'>
                            <INPUT type='file' name='file_name' id='load_file'>
                            <INPUT TYPE='SUBMIT' NAME='action' VALUE='Add' id='buttonSubmit'>
                        </FORM>

                        <div id='text' style='display:;'>{$content}</div>

                        <div id='edit_page' style='display:none'>
                            <div class='form_header'></div>
                            <FORM METHOD='POST' ACTION='/?source={$_GET['source']}' style='display:none;'>
                                <TEXTAREA NAME='subs' id='enter_text'></TEXTAREA>
                                <INPUT TYPE='HIDDEN' NAME='page_scroll' id='page_scroll' VALUE='{$row['page_scroll']}'>
                                <INPUT TYPE='HIDDEN' NAME='words' id='add_words' VALUE=''>
                                <INPUT TYPE='HIDDEN' NAME='words_scroll' id='words_scroll' VALUE='{$row['words_scroll']}'>
                                <INPUT TYPE='HIDDEN' NAME='source' VALUE='{$_GET['source']}'>
                                <INPUT TYPE='SUBMIT' NAME='action' VALUE='Change' id='buttonSave'>
                                <INPUT TYPE='SUBMIT' NAME='action' VALUE='Delete' id='buttonDelete'>
                            </FORM>
                        </div>
LOL;
    }

    $sourceForDic = "";
    $delete_what = $_GET['source'];

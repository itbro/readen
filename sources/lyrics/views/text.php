<?php
    $result = $db->query("SELECT * FROM {$_GET['source']} WHERE id = {$id}");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

        $row_text = str_replace("\r\n", "<br>", $row["text"]);

    	echo <<<LOL
    <div id='edit_page' style='display:none;'>
     <div class='form_header'></div>
     <FORM METHOD='POST' ACTION='/?source={$_GET['source']}'>
      <TEXTAREA NAME='text' id='enter_text'></TEXTAREA>
      <INPUT TYPE='HIDDEN' NAME='page_scroll' id='page_scroll' VALUE='{$row['page_scroll']}'>
      <INPUT TYPE='HIDDEN' NAME='words' id='add_words' VALUE=''>
      <INPUT TYPE='HIDDEN' NAME='words_scroll' id='words_scroll' VALUE='{$row['words_scroll']}'>
      <INPUT TYPE='HIDDEN' NAME='source' VALUE='{$_GET['source']}'>
      <INPUT TYPE='SUBMIT' NAME='action' VALUE='Change' id='buttonSave'>
      <INPUT TYPE='SUBMIT' NAME='action' VALUE='Delete' id='buttonDelete'>
     </FORM>
    </div>

      <div id='text' style='display:;'>{$row_text}</div>
LOL;
        $all_lines = explode("\r\n", $row['text'])[0];

    	$sourceForDic = trim($all_lines);
    	$sourceForDic = strip_tags($sourceForDic);
    	$sourceForDic = htmlentities($sourceForDic, ENT_QUOTES, "UTF-8", false) . " (lyrics)";
    }
    $delete_what = $_GET['source'];

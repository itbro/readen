<?php
    $a_th = $db->query("SELECT author_title FROM book WHERE author_title != ''");
    $a_th->rowCount() > 0 ? $author_title = $a_th->fetchColumn() : $author_title = '';

    // The page list for the Edit page form
    for ($p = 99; $p > 0; $p--) {
        // -99...-1
    	$negativeArray[] = -1*$p;
    }
    for ($p = 1; $p <= 999; $p++) {
        // 1...999
    	$positiveArray[] = $p;
    }

    // -99...-1,1...999
    $allPagesPossible = array_merge($negativeArray, $positiveArray);

    // Remove the current page from the array
    $pagesWithoutThisPage = array_diff($pages, array($thisBookPage));

    // Only unused numbers of pages are left in the array
    $allPagesLeft = array_diff($allPagesPossible, $pagesWithoutThisPage);
    $allPageList = "";
    foreach($allPagesLeft as $allPageL)
    {
    	$allPageList .=  "<OPTION VALUE='$allPageL'>$allPageL</OPTION>\n";
    }
    $allPageList = "<SELECT NAME='page' id='select_page_edit'>".$allPageList."</SELECT>";

    $result = $db->query("SELECT * FROM {$_GET['source']} WHERE id = {$id}");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $author_title_0 = htmlentities($author_title, ENT_QUOTES, "UTF-8", false);

        $row_text = str_replace("\r\n", "<br>", $row["text"]);

        echo <<<LOL
            <div id='text' style='display:;'>{$row_text}</div>

            <div id='edit_page' style='display:none;'>
             <div class='form_header'></div>
             <FORM METHOD='POST' ACTION='/?source={$_GET['source']}&id={$id}'>
              <TEXTAREA NAME='text' id='enter_text'></TEXTAREA>
              <div class='under_textarea'><div class='pages'
              title='This Page'>{$allPageList}</div><div
              id='author_title'><input type='text' name='author_title'
              value='{$author_title_0}'
              autocomplete='off' title="Book's Title and Author"></div></div>
              <INPUT TYPE='SUBMIT' NAME='action' VALUE='ChangePage' id='buttonSave'>
              <INPUT TYPE='SUBMIT' NAME='action' VALUE='DeletePage' id='buttonDeletePage'>
              <INPUT TYPE='HIDDEN' NAME='page_scroll' id='page_scroll' VALUE='{$row['page_scroll']}'>
              <INPUT TYPE='HIDDEN' NAME='words' id='add_words' VALUE=''>
              <INPUT TYPE='HIDDEN' NAME='words_scroll' id='words_scroll' VALUE='{$row['words_scroll']}'>
              <INPUT TYPE='HIDDEN' NAME='id' VALUE='{$id}'>
              <INPUT TYPE='HIDDEN' NAME='source' VALUE='{$_GET['source']}'>
             </FORM>
            </div>

        	<script>
        	// выберем текущую страницу из списка
            	var options2 = document.getElementById('select_page_edit').getElementsByTagName('option');
            	for (o=0; o<options2.length; o++) {
            		if (options2[o].innerHTML == document.getElementById('thisBookPage').innerHTML) {
            			options2[o].selected=true;
            		}
            	}
        	</script>
LOL;
    	   $sourceForDic = trim(htmlentities($author_title, ENT_QUOTES, "UTF-8", false)) . " (book: {$id})";
    }

    // -1...-99,1...999
    $allPagesPossible2 = array_merge($negativeArray, $positiveArray);

    // Only unused numbers of pages are left in the array
    $allPagesLeft2 = array_diff($allPagesPossible2, $pages);
    $allPageList2 = "";
    foreach($allPagesLeft2 as $allPageL)
    {
    	$allPageList2 .=  "<OPTION VALUE='$allPageL'>{$allPageL}</OPTION>\n";
    }
    $allPageList2 = "<SELECT NAME='page' id='select_page_add'>{$allPageList2}</SELECT>";

    $max_id = $db->query("SELECT MAX(id) FROM book")->fetchColumn();
    $newword_id = $max_id + 1;

    // If the next page must be -99
    if ($newword_id == 0) $newword_id = 1;
    if ($newword_id > 999) $newword_id = 999;

    echo <<<LOL
    <div id='addPage' style='display:none'>
     <div class='form_header'></div>
     <FORM METHOD='POST' ACTION='/?source={$_GET['source']}'>
      <TEXTAREA NAME='text' id='enter_text2'></TEXTAREA>
      <div class='under_textarea'><div class='pages' title='Page to be'>{$allPageList2}</div></div>
      <INPUT TYPE='SUBMIT' NAME='action' VALUE='AddPage' id='buttonAddPage'>
     </FORM>
    </div>

    <script>
    // Select the next page in the page list
    var options3 = document.getElementById('select_page_add').getElementsByTagName('option');

    // If the max page (999) has now been used
    var position = -999;
    for (o=0; o<options3.length; o++) {
    	if (options3[o].innerHTML == {$newword_id}) {
    		var position = o;
    		break;
    	}
    }
    </script>
LOL;

    $delete_what = 'page';
    $delete_whole_book = "<div id='delete_whole_book'>The whole book</div>";

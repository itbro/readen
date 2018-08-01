<?php
    $result = $db->query("SELECT author_title FROM {$_GET['source']} WHERE author_title != ''");
    $result->rowCount() > 0 ?
    $bookTitle = htmlentities($result->fetchColumn(), ENT_QUOTES, "UTF-8", false) :
    $bookTitle = "";

    $bBookNumber = $id;

    // Set the bookmark on the current page
    $db->exec("UPDATE {$_GET['source']} SET bookmark = '' WHERE id != ''");
    $db->exec("UPDATE {$_GET['source']} SET bookmark = '1' WHERE id = '{$id}'");

    $result2 = $db->query("SELECT id FROM {$_GET['source']} ORDER BY id");
    $p = 0;
    while ($row2 = $result2->fetch(PDO::FETCH_ASSOC))
    {
    	$pages[$p] = $row2['id'];
    	$p++;
    }

    $pageList = "";
    strlen(max($pages)) >= strlen(min($pages)) ?
    $space_num = strlen(max($pages)) : $space_num = strlen(min($pages));
    foreach($pages as $pageL)
    {
    	$pageList .=  "<OPTION VALUE='$pageL'>".str_replace(" ", "&nbsp;", str_pad($pageL, $space_num, " ", STR_PAD_LEFT))."</OPTION>\n";
    }

    $pageList = "<SELECT NAME='pageList[]' id='pageL'>\n".$pageList."</SELECT>";

    $thisBookPage = $id;

    foreach($pages as $num => $page) {
    	if ($page == $thisBookPage) {
    		$navPage = $num;
    	}
    	$lastKey = $num;
    }
    if ($navPage == 0) {
    	$pageBefore = "<div class='beforePage'><span class='noBefore'>&#9668;</span></div>";
    } else $pageBefore = "<div class='beforePage'><a href=\"/?source={$_GET['source']}&id={$pages[$navPage-1]}\">&#9668;</a></div>";

    if ($navPage == $lastKey) {
    	$pageAfter = "<div class='nextPage'><span class='noNext'>&#9658;</span></div>";
    } else $pageAfter = "<div class='nextPage'><a href=\"/?source={$_GET['source']}&id={$pages[$navPage+1]}\">&#9658;</a></div>";

    echo "     <a href='/?source=article'><div id='article'>Article</div></a>
     <a href='/?source=lyrics'><div id='lyrics'>Lyrics</div></a>
     <a href='/?source=subtitles'><div id='subtitles'>Subtitles</div></a>
     <div id='book'><div id='level1' title=\"{$bookTitle}\">Book</div><div class='this_label'>{$pageBefore}{$pageList}{$pageAfter}</div></div>

    <div id='thisBookPage' style='display:none;'>{$thisBookPage}</div>

         <script>
      var options1 = document.getElementById('pageL').getElementsByTagName('option');
      for (o=0; o<options1.length; o++) {
    	if (document.getElementById('thisBookPage').innerHTML == options1[o].value) {
    		options1[o].selected=true;
    	}
      }
     </script>\n";

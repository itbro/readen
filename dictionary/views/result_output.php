<?php
    // $result from dictionary\database\search_request.php
    // is processed to create the $arr which is used in dictionary\index.php

    $i = 0;
    $arr = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

    	$row['descript'] == 1 ? $checkbox_decript = " checked" : $checkbox_decript = "";
    	$row['unsure'] == 1 ? $checkbox_unsure = " checked" : $checkbox_unsure = "";

    	if (($checkbox_decript != ' checked') && ($checkbox_unsure != ' checked')) {
    		$textarea_meaning = "class='result_meaning'";
    		$checkbox = " class='meaning_normal'";
    	} elseif (($checkbox_decript == ' checked') && ($checkbox_unsure == ' checked')) {
    		$textarea_meaning = "class='result_meaning_checkbox_both'";
    		$checkbox = " class='checkbox_1_2'";
    	} elseif ($checkbox_decript == ' checked') {
    		$textarea_meaning = "class='result_meaning_checkbox_descript'";
    		$checkbox = " class='checkbox_2'";
    	} else {
    		$textarea_meaning = "class='result_meaning_checkbox_unsure'";
    		$checkbox = " class='checkbox_1'";
    	}

    	$rowLel = stripslashes($row['lel']);
    	$rowMeaning = stripslashes($row['meaning']);

    	if ($lang == NATIVE_LANGUAGE) {
    		$mediator = $rowLel;
    		$rowLel = $rowMeaning;
    		$rowMeaning = $mediator;
    		$mediator = '';
    	}

    	$rowComment = stripslashes($row['comment']);
    	$rowExample = stripslashes($row['example']);
    	$rowSource =  stripslashes($row['source']);

    	$rowMeaning = str_replace("/", "<span class='separator'>/</span>", $rowMeaning);

    	// if ($row['label'] != '') {
        //     // Show the label(s) of the translation
    	// 	$label_block = trim($row['label'], ".");
    	// 	$how_many_tags = strpos($label_block, ".");
    	// 	if ($how_many_tags === false) {
        //         // If there is only 1 label
    	// 		$tags = $label_block;
    	// 	} else {
        //         // If there are several labels
    	// 		$tagsarr = explode(".", $label_block);
    	// 		$tags = '';
    	// 		foreach ($tagsarr as $tag) {
    	// 			$tags .= "$tag, ";
    	// 		}
    	// 		$tags = trim($tags, ", ");
    	// 	}
    	// } else $tags = '';

    	$rowMeaning = "<span$checkbox>$rowMeaning</span>";

        // In the examples
        // replace a URL by the link
    	if ($rowSource != "") {
    		$vs_result_1 = preg_match("/^http:\/\/|^https:\/\/|^www./", $rowSource, $matches);
            // есть ли в источнике ссылка
    		if ($vs_result_1 == 0)
    			$rowSource = "&nbsp;<span class='source'>$rowSource</span>";
    		else
                $rowSource = "&nbsp;<span class='source'><a href=\"$rowSource\" target=\"_blank\">&#8599;</a></span>";
    	}

    	$arr_e = array();
    	$rowExample_num = substr_count($rowExample, ">");
    	if ($rowExample != "" and $rowExample_num > 0) {
    		$examples = explode(">", $rowExample);
    		foreach($examples as $key => $v_example) {
    			$v_example = trim($v_example, " ");
    			$key == 0 ?
                $v_example = "<li><span class='word_example_li'>".$v_example."</span>".$rowSource."</li>" :
                $v_example = "<li><span class='word_example_li'>".$v_example."</span></li>";
    			$arr_e[] = $v_example;
    		}
    		$rowExample = "<ol class='list_example'>\n".implode("\n", $arr_e)."\n</ol>\n";
    	} elseif ($rowExample != "")
    		$rowExample = "<p class='word_example'>$rowExample$rowSource</p >";
    	else
            $rowExample = "no example";

        // !!! IF THERE ARE LINE BREAKS IT DOESN'T WORK !!!
    	$rowExample = preg_replace(REPLACE_WHAT, REPLACE_BY, $rowExample);

    	$rowComment = str_replace("\r\n", "<br>", $rowComment);

    	$rowExample = str_replace("\r\n", "<br>", $rowExample);


    	$rowExample .= lib\EditingForm::form(
                            $row['id'],
                            $row['lel'],
                            $row['meaning'],
                            $row['comment'],
                            $row['example'],
                            $row['label'],
                            $row['source'],
                            $textarea_meaning,
                            $page,
                            $source_from_sources,
                            $checkbox_decript,
                            $checkbox_unsure
                        );

    	$arr[$i] = array($rowLel => array($rowMeaning => array($rowComment => array($rowExample))));
    	$i++;
    }

    $to = count($arr);
    if ($to > 0) {
        for ($i = 0; $i < $to; $i++) {
            // If the array contains such a key
        	if (array_key_exists($i, $arr) == 1) {
            	foreach($arr[$i] as $word => $value) {
                    // If the word in the current array and
                    // the word in the previous array are identical
            		if ($i != 0 && array_key_exists($word, $arr[$i-1])) {
            			foreach($arr[$i][$word] as $meaning => $value) {
                            // If the translation in the current array and
                            // the translation in the previous array are identical
            				if (array_key_exists($meaning, $arr[$i-1][$word])) {
            					foreach($arr[$i][$word][$meaning] as $comment => $value) {
                                    // If the comment in the current array and
                                    // the comment in the previous array are identical
            						if (array_key_exists($comment, $arr[$i-1][$word][$meaning])) {
            							array_push($arr[$i-1][$word][$meaning][$comment], $arr[$i][$word][$meaning][$comment][0]);
            							unset($arr[$i]);
            						} else {
            							$arr[$i-1][$word][$meaning] += $arr[$i][$word][$meaning];
            							unset($arr[$i]);
            						}
            					}
            				} else {
            					$arr[$i-1][$word] += $arr[$i][$word];
            					unset($arr[$i]);
            				}
            			}
            			$arr = array_values($arr);
            			$i--;
            		}
            	}
            }
        }
    }

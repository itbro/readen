<?php
    Namespace lib;

    class EntriesOutput
    {
        public static function entries(
            $arr,
            $i,
            $id,
            $word,
            $meaning,
            $comment
        )
        {
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
    }

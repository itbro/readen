<?php
    /** Returns all the matches */

     // For the Search fields form
     $lel_for_search_fields = "";
     $meaning_for_search_fields = "";
     $comment_for_search_fields = "";
     $example_for_search_fields = "";
     $label_for_search_fields = "";
     $source_for_search_fields = "";

     // For the Add new word fields
     $lel_for_add_new_word_form = "";
     $meaning_for_add_new_word_form = "";
     $comment_for_add_new_word_form = "";
     $example_for_add_new_word_form = "";
     $label_for_add_new_word_form = "";
     $source_for_add_new_word_form = "";

    if (isset($_GET['search_lel']) && (
        trim($_GET['search_lel']) != "" ||
        trim($_GET['search_meaning']) != "" ||
        trim($_GET['search_comment']) != "" ||
        trim($_GET['search_example']) != "" ||
        trim($_GET['search_label']) != "" ||
        trim($_GET['search_source']) != "")
    ) {
        // When FOREIGN_LANGUAGE foreign words are on the left-hand side
        // and native words are on the right-hand side
        // when NATIVE_LANGUAGE vice versa
        $lang = FOREIGN_LANGUAGE;

        $onlyRu = 0;
        $transliteration = UNUSED;

        // Remove unreadable symbols from Cambridge dictionary
        $foreign = urldecode($_GET['search_lel']);
        $foreign = preg_replace("/&#8203;|вЂ‹/", "", $foreign);
        $foreign = preg_replace('/[ ]{2,}/', ' ', $foreign);
        $foreign = trim($foreign);
        $native = trim($_GET['search_meaning']);
        $native = str_replace("*", ",", $native);
        $search_comment = trim($_GET['search_comment']);
        $search_comment = preg_replace("/вЂ‹/", "", $search_comment);
        $search_example = trim($_GET['search_example']);
        $search_example = preg_replace("/вЂ‹/", "", $search_example);
        $search_label = trim($_GET['search_label']);
        $search_source = trim($_GET['search_source']);
        $page = $_GET['page'];
        $source_from_sources = $_GET['source'];
        $scrolling = $_GET['scrolling'];

        // If the fields in the request are empty they are replaced by "%"
        // for querying the database
    	$foreign == '' ? $request_lel = "%" : $request_lel = prepare_lel_for_db($foreign);
    	$native == '' ? $request_meaning = "%" : $request_meaning = prepare_lel_for_db($native);
    	$search_comment == '' ? $request_comment = "%" : $request_comment = prepare_lel_for_db($search_comment);
    	$search_example == '' ? $request_example = "%" : $request_example = prepare_lel_for_db($search_example);
    	$search_label == '' ? $request_label = "%" : $request_label = prepare_lel_for_db($search_label);
    	$search_source == '' ? $request_source = "%" : $request_source = prepare_lel_for_db($search_source);

        // The search is whether through several columns or the only one column
        $foreign != '' ? $sle = 1 : $sle = 0;
        $native != '' ? $sm = 1 : $sm = 0;
        $search_comment != '' ? $sc = 1 : $sc = 0;
        $search_example != '' ? $se = 1 : $se = 0;
        $search_label != '' ? $sla = 1 : $sla = 0;
        $search_source != '' ? $ss = 1 : $ss = 0;
        $pluralSearch = $sle + $sm + $sc + $se + $sla + $ss;

    	if ($pluralSearch == 1) {
            // The search through the only one column
            if ($foreign != '') {
                // If words was only typed in the toppest field ("foreign")
        		if (preg_match(NATIVE_LETTERS, $foreign, $matches)) {
                    // If the word contains native letters
                    // then the search is through the column Meaning

                    search_in_meaning:

        			$request_meaning = prepare_lel_for_db($foreign);
        			require "database/queries/only_meaning.php";
        			$num_rows = $db->query($query)->rowCount();

        			if ($num_rows > 0) {
                        $result = $db->query($query);

            			$lang = NATIVE_LANGUAGE;
            			$toTitle = $foreign;
                        $lel_for_search_fields = htmlentities($foreign, ENT_QUOTES, "UTF-8", false);
                        $meaning_for_add_new_word_form = htmlentities($foreign, ENT_QUOTES, "UTF-8", false);
        			} else {
                        // If nothing has been found then check
                        // whether or not the transliteration has been used
                        // (from the foreign language to native one):
                        if ($transliteration != FOREIGN_TO_NATIVE) {
                            // if not used then use it in the case
                            // the foreign word has been spelt with native letters
                            $foreign = translit($foreign, FOREIGN_LANGUAGE);
                            $transliteration = NATIVE_TO_FOREIGN;

                            // and send it to search through the foreign words
                            goto search_in_lel;

                        } else {
                            // Otherwise (the transliteration has not been used),
                            // it means that the foreign word was searched for
                            // in the first place but nothing has been found, so
                            // translate the word back from the native language
                            // to the foreign one
                            $foreign = translit($foreign, FOREIGN_LANGUAGE);
                            // и выдать резльтат: 0 найденных строк
                            $result = $db->query($query);
                            $num_rows = 0;

                            $lang = FOREIGN_LANGUAGE;
        					$toTitle = $foreign;
                            $lel_for_search_fields = htmlentities($foreign, ENT_QUOTES, "UTF-8", false);
                            $lel_for_add_new_word_form = htmlentities($foreign, ENT_QUOTES, "UTF-8", false);
                        }
                    }
        		} else {
                    // The search through the foreign words

                    search_in_lel:

                    if (in_array(strtolower($foreign), FOREIGN_PARTICLES)) {
                        $request_lel = prepare_lel_for_db($foreign);
                        require_once "database/queries/only_particle.php";
                        $result = $db->query($query);
                        $num_rows = $result->rowCount();

                        $lang = FOREIGN_LANGUAGE;
                        $toTitle = $foreign;
                        $lel_for_search_fields = htmlentities($foreign, ENT_QUOTES, "UTF-8", false);
                        $lel_for_add_new_word_form = htmlentities($foreign, ENT_QUOTES, "UTF-8", false);
                     } else {
                        $request_lel = prepare_lel_for_db($foreign);
        				require_once "database/queries/only_lel.php";
        				$num_rows = $db->query($query)->rowCount();

                        if ($num_rows > 0) {
                            $result = $db->query($query);

                			$lang = FOREIGN_LANGUAGE;
                			$toTitle = $foreign;
                            $lel_for_search_fields = htmlentities($foreign, ENT_QUOTES, "UTF-8", false);
                            $lel_for_add_new_word_form = htmlentities($foreign, ENT_QUOTES, "UTF-8", false);
                        } else {
                            // If nothing has been found then check
                            // whether or not the transliteration has been used
                            // (from the native language to foreign one):
                            if ($transliteration != NATIVE_TO_FOREIGN) {
                                // if not used then use it in the case
                                // the native word has been spelt with foreign letters
                                $foreign = translit($foreign, NATIVE_LANGUAGE);
                                $transliteration = FOREIGN_TO_NATIVE;

                                goto search_in_meaning;

                            } else {
                                // Otherwise (the transliteration has not been used),
                                // it means that the native word was searched for
                                // in the first place but nothing has been found, so
                                // translate the word back from the foreign language
                                // to the native one
                                $foreign = $_GET['search_lel'];

                                $request_meaning = prepare_lel_for_db($foreign);
                                require "database/queries/only_meaning.php";
                                $result = $db->query($query);
                                $num_rows = $result->rowCount();

                                $lang = NATIVE_LANGUAGE;
            					$toTitle = $foreign;
                                $lel_for_search_fields = htmlentities($foreign, ENT_QUOTES, "UTF-8", false);
                                $meaning_for_add_new_word_form = htmlentities($foreign, ENT_QUOTES, "UTF-8", false);
        					}
        				}
        			}
        		}
        	}
            else {
                // The search through:
                // translations (native words)
                // comments
                // examples
                // labels
                // sources
                if ($native != "") {
                	// Through translations
            		require "database/queries/only_meaning.php";
            		$lang = NATIVE_LANGUAGE;
            		$onlyRu = 1;
            		$toTitle = $native;
                    $meaning_for_search_fields = htmlentities($native, ENT_QUOTES, "UTF-8", false);
                    $meaning_for_add_new_word_form = htmlentities($native, ENT_QUOTES, "UTF-8", false);
            	} elseif ($search_comment != "") {
            	    // Through comments
            		require_once "database/queries/only_comment.php";
            		$toTitle = $search_comment;
                    $comment_for_search_fields = htmlentities($search_comment, ENT_QUOTES, "UTF-8", false);
                    $comment_for_add_new_word_form = htmlentities($search_comment, ENT_QUOTES, "UTF-8", false);
            	} elseif ($search_example != "") {
            	    // Through examples
            		require_once "database/queries/only_example.php";
            		$toTitle = $search_example;
                    $example_for_search_fields = htmlentities($search_example, ENT_QUOTES, "UTF-8", false);
                    $example_for_add_new_word_form = htmlentities($search_example, ENT_QUOTES, "UTF-8", false);
            	} elseif ($search_label != "") {
            	    // Through labels
            		require_once "database/queries/only_label.php";
            		$toTitle = $search_label;
                    $label_for_search_fields = htmlentities($search_label, ENT_QUOTES, "UTF-8", false);
                    $label_for_add_new_word_form = htmlentities($search_label, ENT_QUOTES, "UTF-8", false);
            	} elseif ($search_source != "") {
            	    // Through sources
            		require_once "database/queries/only_source.php";
            		$toTitle = $search_source;
                    $source_for_search_fields = htmlentities($search_source, ENT_QUOTES, "UTF-8", false);
                    $source_for_add_new_word_form = htmlentities($search_source, ENT_QUOTES, "UTF-8", false);
                }
                $result = $db->query($query);
                $num_rows = $result->rowCount();
    	    }
        }
        elseif ($pluralSearch > 1) {
    	    // the search through the several fields (columns)

            if (in_array(strtolower($foreign), FOREIGN_PARTICLES))
                require "database/queries/plural_search_particle.php";
            else
                require "database/queries/plural_search.php";

            $num_rows = $db->query($query)->rowCount();
            $result = $db->query($query);
            $toTitle = $native;

            // For the Search fields form
            $lel_for_search_fields = $foreign;
            $meaning_for_search_fields = $native;
            $comment_for_search_fields = $search_comment;
            $example_for_search_fields = $search_example;
            $label_for_search_fields = $search_label;
            $source_for_search_fields = $search_source;

            // For the Add new word fields
            $lel_for_add_new_word_form = $foreign;
            $meaning_for_add_new_word_form = $native;
            $comment_for_add_new_word_form = $search_comment;
            $example_for_add_new_word_form = $search_example;
            $label_for_add_new_word_form = $search_label;
            $source_for_add_new_word_form = $search_source;
    	}

        // If the search has been through the several columns
        // or through the one of the extra fields
        // the open the extra search fields
        if ($pluralSearch > 1 or ($sle == 0 && $pluralSearch > 0)) {
            $otherFields = "block";
            $extra_fields = "extra_fields_button_open";
        } else {
            $otherFields = "none";
            $extra_fields = "extra_fields_button_closed";
        }
    } else {
        // If there has been no search at all
        $result = $db->query("SELECT *
                    FROM dictionary
                    WHERE date = CURDATE()
                    ORDER BY id DESC");
        $num_rows = $result->rowCount();

        $num_rows == 0 ?
        $toTitle = "Dictionary" :
        $toTitle = "Dictionary ($num_rows)";

        $pluralSearch = 0;

        $sle = 0;

        $otherFields = "none";

        $extra_fields = "extra_fields_button_closed";

        $lang = FOREIGN_LANGUAGE;

        $foreign = "";
        $native = "";
        $search_comment = "";
        $search_example = "";
        $search_label = "";
        $search_source = "";
        $source_from_sources = "";
        $scrolling = 0;
    }

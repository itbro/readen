$( window ).on( "beforeunload", function() {
    delete_cookie("source_from_add");
});

$( window ).on( "load", function() {

	$( window ).scrollTop() > 4 ?
    $( "#www" ).css( "boxShadow", "0 7px 12px -10px #777" ) :
    $( "#www" ).css( "box-shadow", "none" );

	if ($( "#search_lel" ).val() == "") {
		$( "#search_lel" ).focus();
	} else {
		$( "#search_lel" ).css( "padding-right", "28px" );
		$( "#search_lel" ).focus();
        $( "#search_lel" )[0].selectionStart = $( "#search_lel" ).val().length;
	}


    edit_example_buttons();


	if ($( ".button_del")[0]) {
		$( ".button_del").each(function() {
			$( this ).click(function() {
				$( "#YesNo" ).html( this.id.replace("d", "s") );
				$( "#deleteWarning" ).show();
			});
		});

		$( "#deleteWarning" ).css({
            top: window.innerHeight / 4 + "px",
            left: document.getElementById("dictionary").getBoundingClientRect().left + 135 + "px"
        });
	}

	$( "#deleteYes" ).click(function() {
		$( "#" + $( "#YesNo" ).html() ).click();
		$( "#deleteWarning" ).show();
	});

	$( "#deleteNo" ).click(function() {
		$( "#deleteWarning" ).hide();
	});


	if ($( "#pageList" )[0])
		$( "#pageList" ).change( link_for_pageList );


    scrolling_back();


	show_clear_button();


	$( "#search_lel" ).on( "dragover", if_search_lel_ondragover );


	$( "#clear_search" )
        .click( if_clear_search_onclick )
        .on( "dragover", if_clear_search_ondragover );


	$( window ).resize( if_window_resize );


	$( window ).scroll( if_window_onscroll );


	$( "#add_new_word_button" )
        .click(function() {
    		if ($( "#add_new_word" ).css( "display" ) == "none") {
    			$( "#add_new_word" ).show( "slow" );
    			$( "#add_new_word" ).css( "left", add_new_word_left() );
    		} else
                $( "#add_new_word" ).hide( "slow" );

            // Remove the selection from a word when Add button is clicked on
    		$( "#falseForm" ).position().top = $( this ).css( "top" ) + "px";
    		$( "#falseForm" ).position().left = $( this ).css( "left" ) + "px";
    		$( "#falseForm" ).select();
    	})
        .on( "dragover", function() {
    		$( "#add_new_word" ).css( "left", add_new_word_left() );
    		$( "#add_new_word" ).show( "slow" );
    	});

	$( "#closeAdd" )
        .click(function() {
    		$( "#add_new_word" ).hide( "slow" );
    	})
        .on( "dragover", function() {
    		$( "#add_new_word" ).hide( "slow" );
    	});


	$( "#extra_fields_button" )
        .click(function() {
            // Show/Hide the extra search fields [+]
    		if ($( "#extra_fields" ).css( "display" ) == "none") {
                $( this ).removeClass( "extra_fields_button_closed" ).addClass( "extra_fields_button_open" );
    			$( "#extra_fields" ).show();
    			$( "#dictionary" ).css( "margin-top",
                dicMarginTop + $( "#extra_fields" ).outerHeight() +
                $( "#content" ).outerHeight() - extra_fields_indent + "px" );

    			$( "#dictionary" ).css( "min-height", document.documentElement.clientHeight -
                $( "#td_search" ).outerHeight() - dicMinHeightMinus + "px" );
    		} else {
                $( this ).removeClass( "extra_fields_button_open" ).addClass( "extra_fields_button_closed" );
    			$( "#extra_fields" ).hide();
    			$( "#dictionary" ).css( "margin-top", dicMarginTop + "px" );

    			$( "#dictionary" ).css( "min-height", document.documentElement.clientHeight -
                $( "#td_search" ).outerHeight() - dicMinHeightMinus + "px" );
    		}
    	})
        .on( "dragover", function() {
            $( this ).removeClass( "extra_fields_button_closed" ).addClass( "extra_fields_button_open" );
    		$( "#extra_fields" ).show();
    		$( "#dictionary" ).css( "margin-top", dicMarginTop +
            $( "#extra_fields" ).outerHeight() +
            $( "#content" ).outerHeight() - extra_fields_indent + "px" );

    		$( "#dictionary" ).css( "min-height", document.documentElement.clientHeight -
            $( "#td_search" ).outerHeight() - dicMinHeightMinus + "px" );
    	});


    var td_results = $('.td_result');
	var edit_buttons = $('.edit_button');
	var closeEdits = $('.closeEdit');

	td_results.each(function(index) {
        // For the Edit entry form close buttons
		$( this ).attr( "data-bred", "b" + index );
		closeEdits.eq(index).attr("id", "cl" + index );
	});

	edit_buttons.each(function() {
        // Remove the selection from a word when the Edit button is clicked on
        $( this).click(function() {
            $( "#falseForm" ).position().top = $( this ).css( "top" ) + "px";
    		$( "#falseForm" ).position().left = $( this ).css( "left" ) + "px";
    		$( "#falseForm" ).select();
    		word_to_listen2 = '';
    		editIfAbove(this.id, "1");
        });
	});

    closeEdits.each(function() {
        $( this ).click(function() {
            // For the Edit entry form close buttons
            var form_id2 = $( this ).attr( "id" ).replace("cl", "b");
            td_results.each(function() {
                if ($( this ).attr( "data-bred" ) == form_id2)
                    $( this ).hide( "slow" );
            });
        });
    });

	edit_buttons.each(function() {
		$( this ).on( "dragover", function() {
			editIfAbove(this.id, "2");
		});
	});


    selection_remover();


    // Change style of text in translation fields
    // when Description and Unsure checkboxes are clicked on
    if ($( ".checkbox" )[0]) {
		$( ".checkbox" ).each(function() {
			$( this ).click(function() {
				if ($( this ).attr( "id" ).search("descript") == 0) {
					var var1 = $( this ).attr( "id" ).replace("descript", "meaning");
					$( "#" + $( this ).attr( "id" ) ).prop( "checked" ) === true ?
                    $( "#" + var1 ).css( "font-style", "italic" ) :
                    $( "#" + var1 ).css( "font-style", "normal" );
				} else {
					var var2 = $( this ).attr( "id" ).replace("unsure", "meaning");
					$( "#" + $( this ).attr( "id" ) ).prop( "checked" ) === true ?
                    $( "#" + var2 ).css( "color", "#CA4026" ) :
                    $( "#" + var2 ).css( "color", "#555" );
				}
			});
		});
	}


	// [the Add new word form]
	$( "#newword_lel" ).each(trnslt);
	$( "#meaning0" ).each(trnslt);
	$( "#newword_example" ).each(trnslt);
	$( "#newword_label" ).each(trnslt);
	$( "#source_from_new_add" ).each(trnslt);
	document.getElementById("source_from_new_add").ondragover = function() {
		if (clearSource == 1) this.value = '';
	}


	// [the Edit entry form]
	$( ".result_lel" ).each(trnslt);
	$( ".result_meaning" ).each(trnslt);
    $( ".result_meaning_checkbox_unsure" ).each(trnslt);
    $( ".result_meaning_checkbox_descript" ).each(trnslt);
    $( ".result_meaning_checkbox_both" ).each(trnslt);
    $( ".result_label" ).each(trnslt);
    var element_result_sources = $( ".result_source" );
    element_result_sources.each(trnslt);
    $( ".result_example" ).each(function(index) {
        $( this )
            .on( "input", function() {
                var pos = carPos(this);
                this.value = nativeToForeign(this.value, pos);
    			this.selectionStart = this.selectionEnd = pos;

                if (add_source_when_typing_option == 1) {
                    if (test_1 != this.id) {
                        // When typing in the Example field
                        // the source from the Add new word form
                        // will automatically be added into the source field
                        // of the current Edit entry form
                        if (element_result_sources.eq( index ).val() == "" &&
                        $( "#source_from_new_add" ).val() != "") {
                            element_result_sources.eq( index ).val( $( "#source_from_new_add" ).val() );
                            test_1 = this.id;
                        }
                    }
                }

                // If typing "==" it will automatically be replaced
                // by the source from the Add new word form
                var example_source = " [" + $( "#source_from_new_add" ).val() + "]";
                if ($( this ).val().search("==") != -1) {
                    $( this ).val( $( this ).val().replace("==", example_source) );
                    cursorPos = this.value.length - $( "#source_from_new_add" ).val().length - 3;
                    // Put the cursor before [
                    this.selectionStart = this.selectionEnd = cursorPos;
                }
            })
            .keydown(function(event) {
                if (event.keyCode == 16) shift_key = "Shift";
            })
            .click( add_source_if_clicked );
    });


	// the Search form
	$( "#prefix" ).change(function() {
		searches();
		prefixChange = 1;
		$( "#free_search" ).click();
	});

	$( "#search_lel" )
        .on({
            input: function() {
                if ($( "#search_meaning" ).val() != '') {
                   var pos = carPos(this);
                   this.value = nativeToForeign(this.value, pos);
                   this.selectionStart = this.selectionEnd = pos;
                }

                setTimeout(searches, 1);

                hide_show_fields_clearing_button();
            },
            drop: function() {
                setTimeout('$( "#free_search" ).click()', 4);
            }
        })
        .keydown(function(event) {
    		if (event.keyCode == 16) shift_key = "Shift";
    	});

	$( "#search_meaning" )
        .on( "input", function() {
    		var pos = carPos(this);
    		this.value = foreignToNative(this.value, pos);
    		this.selectionStart = this.selectionEnd = pos;

    		setTimeout(searches, 1);

    		hide_show_fields_clearing_button();
    	})
        .keydown(function(event) {
    		if (event.keyCode == 16) shift_key = "Shift";
    	});

	$( "#search_comment" ).on( "input", function () {
		setTimeout(searches, 1);
		hide_show_fields_clearing_button();
	});

	$( "#search_example" )
        .on( "input", function() {
    		var pos = carPos(this);
    		this.value = nativeToForeign(this.value, pos);
    		this.selectionStart = this.selectionEnd = pos;

    		setTimeout(searches, 1);

    		hide_show_fields_clearing_button();
    	})
    	.keydown(function(event) {
    		if (event.keyCode == 16) shift_key = "Shift";
    	});

	$( "#search_label" )
        .on( "input", function() {
    		var pos = carPos(this);
    		this.value = nativeToForeign(this.value, pos);
    		this.selectionStart = this.selectionEnd = pos;

    		setTimeout(searches, 1);

    		hide_show_fields_clearing_button();
    	})
    	.keydown(function(event) {
    		if (event.keyCode == 16) shift_key = "Shift";
    	});

	$( "#search_source" )
        .on( "input", function() {
    		var pos = carPos(this);
    		this.value = nativeToForeign(this.value, pos);
    		this.selectionStart = this.selectionEnd = pos;

    		setTimeout(searches, 1);

    		hide_show_fields_clearing_button();
    	})
    	.keydown(function(event) {
    		if (event.keyCode == 16) shift_key = "Shift";
    	});


	// Make a search link for the search button
	$( "#free_search" ).mouseover(searches);
	$( "#free_search" ).click(when_click_on_search);


    $( "#sound" ).click(sound_dictionary);

	$( "#pron_link" )
    .on( "input", function() {
		pron_add($( "#pron_link" ).val() + "|" + $( "#pron_word" ).val());
		$( "#pron_link" ).val( "" );
		$( "#pron_link" ).hide();
	})
    .click(function() {
        // Open a window to add a pronunciation manually
        $( "#file_name" ).val( $("#pron_word").val() );
        $( "#file" ).click();

		$( "#pron_link" ).hide();
		$( "#pron_link" ).val( "" );
		$( "#Cambridge" ).attr( "href", pron_link_dic_by_default );
	});

    $( "#add_manually" ).on( "submit", { e: "event" }, pron_add_manually );

    $( "#file" ).on( "change", function() {
        $( "#submit" ).click();
    });


	$( "#dictionary" ).mousedown(function() {
		$( "#sound" ).hide();
		$( "#pron_link" ).hide();
		if ($( "#n_v_a" )) $( "#n_v_a" ).remove();
	})



    // If nothing has been found
	if (!document.getElementsByClassName('word_meaning')[0] &&
    document.getElementById("search_lel").value != '')
        if_no_word_found();


    where_listen();


	$( "#Academic" ).click(if_Academic_clicked);
	$( "#Multitran" ).click(if_Multitran_clicked);
	$( "#Cambridge" ).click(if_Cambridge_clicked);
	$( "#Urban" ).click(if_Urban_clicked);
	$( "#Google" ).click(if_Google_clicked);
	$( "#Yandex" ).click(if_Yandex_clicked);
	$( "#Oxford" ).click(if_Oxford_clicked);
	$( "#Macmillan" ).click(if_Macmillan_clicked);
});

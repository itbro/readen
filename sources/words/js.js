$( window ).on( "load", function() {

	$( "#fields" ).mouseover(function() {
        all_lels = $( ".remember_lel" );
        all_meanings = $( ".remember_meaning" );
		all_lels.each(function() {
			$( this )
                .on( "input", function() {
    				if ($( this ).val().search(del_this) != -1) {
                        // Remove the current row
    					asd = "";
    					all_lels.each(function(index) {
    						$( this ).css( "color" ) == color_6 ?
                            color_red = color_red_value :
                            color_red = "";

                            $( this ).val().search(del_this) != -1 ?
    					    asd = asd :
                            asd = asd + "<INPUT TYPE=\"TEXT\" VALUE=\"" +
                            $( this ).val().trim() + "\" class=\"remember_lel\"" +
                            color_red + "><INPUT TYPE=\"TEXT\" VALUE=\"" +
                            all_meanings.eq( index ).val().trim() + "\" class=\"remember_meaning\">\n";
                        });

    					all_lels.length - 1 < words_num_rows ?
    					newFileds = "<INPUT TYPE=\"TEXT\" VALUE=\"\" class=\"remember_lel\">" +
                        "<INPUT TYPE=\"TEXT\" VALUE=\"\" class=\"remember_meaning\">\n" :
    					newFileds = "";

    					$( "#fields" ).html( asd.replace(/\n+$/, "") + newFileds );
    				} else if (this.value.search(del_empty) != -1) {
                        // Remove all of the empty rows
                        // (if the cell on the left is empty)
    					asd = "";
    					var count = 0;
                        all_lels = $( ".remember_lel" );
                        all_meanings = $( ".remember_meaning" );
    					all_lels.each(function(index) {
    						if ($( this ).val() != "" && $( this ).val() != del_empty)
                                count++;

    						$( this ).css( "color" ) == color_6 ?
                            color_red = color_red_value :
                            color_red = "";

    						$( this ).val() == "" || $( this ).val() == del_empty ?
    						asd = asd :
    						asd = asd + "<INPUT TYPE=\"TEXT\" VALUE=\"" +
                            $( this ).val().replace(del_empty, "").trim() +
                            "\" class=\"remember_lel\"" + color_red + "><INPUT TYPE=\"TEXT\" VALUE=\"" +
                            all_meanings.eq( index ).val().trim() + "\" class=\"remember_meaning\">\n";
    					});

                        // The number of full rows
    					var lost = count;

    					newFileds = "";
    					if (lost < words_num_rows) {
    					    all_lels = $( ".remember_lel" );

                            // The number of empty rows that will be added
    						var nfn = words_num_rows-lost;

    						for (var n = 0; n < nfn; n++) {
    							newFileds += "<INPUT TYPE=\"TEXT\" VALUE=\"\" class=\"remember_lel\">" +
                                "<INPUT TYPE=\"TEXT\" VALUE=\"\" class=\"remember_meaning\">\n";
    						}
    					} else
                            newFileds = "";

    					$( "#fields" ).html( asd.replace(/\n+$/, "") + newFileds );
    				} else if ($( this ).val().search(add_above) != -1 || $( this ).val().search(add_below) != -1) {

    					asd = "";

    					// If the last row is empty it is removed
    					if (all_lels.eq( all_lels.length - 1 ).val() == "" &&
                        all_meanings.eq( all_meanings.length - 1).val() == "") {
    						all_lels.eq( all_lels.length - 1 ).remove();
    						all_meanings.eq( all_meanings.length - 1 ).remove();
    					}

                        all_lels = $( ".remember_lel" );
                        all_meanings = $( ".remember_meaning" );
    					all_lels.each(function(index) {
    						$( this ).css( "color" ) == color_6 ?
                            color_red = color_red_value :
                            color_red = "";

                            if ($( this ).val().search(add_above) != -1) {
                                // Add a row above the current row
                                if ($( this ).val().search(add_above) != -1) {
                                    asd = asd + "<INPUT TYPE=\"TEXT\" VALUE=\"\" class=\"remember_lel\">" +
                                    "<INPUT TYPE=\"TEXT\" VALUE=\"\" class=\"remember_meaning\">\n";
                                    asd = asd + "<INPUT TYPE=\"TEXT\" VALUE=\"" +
                                    $( this ).val().trim().replace(add_above, "") +
                                    "\" class=\"remember_lel\"" + color_red + "><INPUT TYPE=\"TEXT\" VALUE=\"" +
                                    all_meanings.eq( index ).val().trim()+"\" class=\"remember_meaning\">\n";
                                } else
                                    asd = asd + "<INPUT TYPE=\"TEXT\" VALUE=\"" +
                                    $( this ).val().trim() +
                                    "\" class=\"remember_lel\"" + color_red + "><INPUT TYPE=\"TEXT\" VALUE=\"" +
                                    all_meanings.eq( index ).val().trim() +
                                    "\" class=\"remember_meaning\">\n";
                            } else {
                                // Add a row below the current row
                                if ($( this ).val().search(add_below) != -1) {
                                    asd = asd + "<INPUT TYPE=\"TEXT\" VALUE=\"" +
                                    $( this ).val().trim().replace(add_below, "") +
                                    "\" class=\"remember_lel\"" + color_red + "><INPUT TYPE=\"TEXT\" VALUE=\"" +
                                    all_meanings.eq( index ).val().trim() +
                                    "\" class=\"remember_meaning\">\n";
                                    asd = asd + "<INPUT TYPE=\"TEXT\" VALUE=\"\" class=\"remember_lel\">" +
                                    "<INPUT TYPE=\"TEXT\" VALUE=\"\" class=\"remember_meaning\">\n";
                                } else
                                    asd = asd + "<INPUT TYPE=\"TEXT\" VALUE=\"" +
                                    $( this ).val().trim() +
                                    "\" class=\"remember_lel\"" + color_red + "><INPUT TYPE=\"TEXT\" VALUE=\"" +
                                    all_meanings.eq( index ).val().trim() +
                                    "\" class=\"remember_meaning\">\n";
                            }
    					});

    					$( "#fields" ).html( asd.replace(/\n+$/, "") );

    					$( "#new_word_field" ).html( $( window ).scrollTop() );
    				}
    				how_many_words_words();
    				show_red_num_words(red_num);

    				var pos = carPos(this);
    				this.value = nativeToForeign(this.value, pos);
    				this.selectionStart = this.selectionEnd = pos;
    			})
    			.keydown(function(event) {
    				if (event.keyCode == 16) shift_key = "Shift";
    			})
                .click(function() {
                    all_lels.each(function() {
                        if ($( this ).css( "color" ) != color_6) {
                            $( this ).css( "font-weight", "normal" );
                        }
                    });
                    $( "#occ_num", parent.document ).html( "" );
                })
                .mouseup(function(event) {

                    $( "#sound" ).html( "♫" );
                    $( "#sound" ).attr( "title", "" );

                    if (thSS != "q") {
                        thSS = this.selectionStart;
                        thSE = this.selectionEnd;
                        if (thSS != thSE) {
                            if ($( "#n_v_a" )[0])
                                $( "#n_v_a" ).remove();

                            word_to_listen = this.value.substring(this.selectionStart, this.selectionEnd);
                            listen_words(word_to_listen, event);
                            thSS = thSE = "q";
                        } else {
                            $( "#sound" ).hide();
                            $( "#pron_link" ).hide();
                            if ($( "#n_v_a" )[0])
                                $( "#n_v_a" ).remove();
                        }
                    } else {
                        $( "#sound" ).hide();
                        $( "#pron_link" ).hide();
                        if ($( "#n_v_a" )[0])
                            $( "#n_v_a" ).remove();
                        thSS = thSE = 0;
                    }
                });

		});

		all_meanings.each(function() {
            $( this )
                .on( "input", function() {
                    var pos = carPos(this);
                    this.value = foreignToNative(this.value, pos);
                    this.selectionStart = this.selectionEnd = pos;

                    how_many_words_words();
                    show_red_num_words(red_num);
                })
                .keydown(function(event) {
                    if (event.keyCode == 16) shift_key = "Shift";
                })
                .click(function() {
                    $( "#sound" ).html( "♫" );
                    $( "#sound" ).attr( "title", "" );
                    $( "#sound" ).hide();
                    $( "#pron_link" ).hide();
                    if ($( "#n_v_a" )[0])
                        $( "#n_v_a" ).remove();
                    word_to_listen = "";
                });
        });
	});

	$( "#red_words_num", parent.document ).click(function() {
		if ($( "#red_words_num", parent.document ).html() != 0) {
			$( this ).css( "color" ) != color_6 ?
            make_them_red() :
            make_them_black();
		}
	});

	$( "#sound" ).click(function() {
		if ($( "#sound" ).html() == "#") {
			if ($( "#sound" ).attr( "title" ) == "Change the word!")
				pron_change(word_to_listen);
            else if ($( "#sound" ).attr( "title" ) == "Delete the word!")
				pron_delete(word_to_listen);
			else
                pron_add_manual(word_to_listen);

			$( "#sound" ).html( "♫" );
			$( "#sound" ).hide();
		} else {
			$( this ).hide();
			$( "#pron_link" ).css( "top", $( "#sound" ).css( "top" ) );
			$( "#pron_link" ).css( "left", $( "#sound" ).css( "left" ) );
			$( "#pron_link" ).show();

			// If #pron_link happens to be beyond the Dictionary boundaries
			if (document.getElementById('pron_link').getBoundingClientRect().left +
            $( "#pron_link" ).outerWidth() >
            document.getElementById('fields').getBoundingClientRect().left +
            $( "#fields" ).outerWidth()) {
				$( "#pron_link" ).css( "left",
                document.getElementById('fields').getBoundingClientRect().left +
                $( "#fields" ).outerWidth() - $( "#pron_link" ).outerWidth() - 10 + "px" );
			}

			$( "#pron_link" ).focus();

			$( "#pron_word" ).val( word_to_listen );
			window.open("http://dictionary.cambridge.org/dictionary/english/" +
            word_to_listen, "_blank", param(parent.document.getElementById("topMenuSubMenu").getBoundingClientRect().left));
		}
	});

	$( "#pron_link" )
    .on( "input", function() {
		pron_add($( "#pron_link" ).val() + "|" + $( "#pron_word" ).val());
        $( "#pron_link" ).hide();
		$( "#pron_link" ).val( "" );
	})
	.click(function() {
		$( "#pron_link" ).hide();
		$( "#pron_link" ).val( "" );
	});
});

$(window).on( "load", function() {

    func1();

    offsetWidth_947();

    four_buttons();

    func3();

    openDic_width();

    $( "#add_manually" ).on( "submit", { e: "event" }, pron_add_manually );

    $( "#file" ).on( "change", function() {
        $( "#submit" ).click();
        $( "#meanpron" ).hide();
        $( "#pron_link" ).hide();
        $( "#pron_word" ).val( "" );
    });

	$( "#searchInDic" )
        .on({
            input: function() {
            searchInDic_oninput(
                $( "#searchInDic" ).val().trim(),
                $( "#to_add_new_word" ).html(),
                newWinPos());
            },
            click: function() {
                if_searchInDic_clicked_on();
            }
        });

	$( "#SaveLink" ).on( "click", function() { SaveLink_onclick(); });

	$( "#CleanLink" ).on( "click", function() { CleanLink(); });

	$( "#EditLink" )
        .mousedown(function() {
    		if ($( "#edit_page" ).css( "display" ) != "block") {
    			$( "#scroll_a" ).html( self.pageYOffset );
    		}
    	})
        .on( "click", function() {
            $( ".form_header" ).eq( 0 ).html( "edit article" );
            EditLink_onclick();
        });

    if ($( "#DeleteLink" )[0]) {
        $( "#DeleteLink" ).on( "click", function() {
            DeleteLink_onclick();
        });

        $( "#deleteYes" ).on( "click", function() {
            $( "#buttonDelete" ).click();
        });

        $( "#deleteNo" ).on( "click", function() {
            $( "#deleteWarning" ).hide();
            $( "#DeleteLink" ).css( "background", dark_color );
            $( "#DeleteLink" ).css( "color", color_2);
        });
    }


	$( "#editor_frame" ).contents()
        .click(function(event) {
            editor_frame_onclick(event);
        })
        .mousedown(function() {
            editor_frame_onmousedown();
        });

    $( "#editor_frame" ).contents().find( "#meanpron2" ).mouseover(function() {
        meanpron2_onmouseover();
    });

    $( "#pron_link" )
        .on( "input", function() {
            pron_link_oninput();
        })
        .click(function() {
            pron_link_onclick();
        });

    make_iframe_editable();

	$( "#add_field" ).click(function() { addFields(newFieldsNum); });

	window.onresize = function() { if_window_resized(); }
	window.onscroll = function() { if_window_scrolled(); }




    all_meanings = $( "#frame_words").contents().find( ".remember_meaning" );
    all_meanings.each(function() {
        $( this )
            .on( "input", function() {
                var pos = carPos(this);
                this.value = foreignToNative(this.value, pos);
                this.selectionStart = this.selectionEnd = pos;

                how_many_words_words_temprary();
                show_red_num_words_temprary(red_num);
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

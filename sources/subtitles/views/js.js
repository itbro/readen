$(window).on( "load", function() {

    func1();

	offsetWidth_947();

	four_buttons();

    func3();

    openDic_width();

    $( "#sound" ).contextmenu(function(event) {
        $( "#file_name" ).val( document.getElementById("editor_frame").contentWindow.document.getSelection() );
        $( "#file" ).click();
        event.preventDefault();
    });

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


    if ($( "#AddLink" )[0]) {
        $( "#AddLink" ).click(function()
        {
            $( "#load_file" ).click();
        });

        $( "#load_file" ).change(function()
        {
            $( "#buttonSubmit" ).click();
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

    // For the title of the Subtitles to be sent to the Dictionary
    $( "#editor_frame").contents().find( ".what" ).each(function() {
        $( this ).click(function() {
            $( "#to_add_new_word" ).html( $( "h4" ).eq( 0 ).html() +
            " (subtitles: " + this.id + ")" );
        });
    });

	window.onresize = function() { if_window_resized(); }
	window.onscroll = function() { if_window_scrolled(); }


    // The Words
    trnslt_words();
    if_words_sound_click_on();
    if_words_pron_link_click_on();
    if_words_red_words_click_on();
});

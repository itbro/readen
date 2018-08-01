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
});

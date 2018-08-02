var iniPosLeft = 0;
var iniPosLeft2 = 0;
var newFileds = "";
var new_words_num = 0;
var asd = "";
var all_lels = "";
var all_meanings = "";
var red_num = 0;
var whenScrollOpen = 0;
var whenScrollClosed = 0;
var whenResizeOpen = 0;
var whenResizeClosed = 0;
var plus = 0;
var edF = 0; // books
var word = "";
var words_to_listen = "";
var words_to_listen_arr = [];
var wordsHeightMinus = 0;
var color_red = "";
var word_to_listen = "";
var thSS = 0;
var thSE = 0;
var shift_key = "";
var urlAsArr = likePHPGet(document.location.search.replace("%20", " "));
var prefixChange = 0;
var form_id1 = "";
var word_to_listen2 = "";
var iniSleft = 0;
var bId = "";
var coord = 0;

// The size of gap between the result (the entries) and the list of pages
var dicMinHeightMinus = 53;

var cursorPos = 0;
var test_1 = "";
var test_2 = "";

// The size of gap between the Search form and the result (the entries)
var extra_fields_indent = 16;

// For pronunciation: listen()
var n_v_a = "<div id='n_v_a'></div>";

function words_scroll_pos()
{
    // Sets scrolling position in the Words
	if (navigator.userAgent.search("Edge") != -1)
        return document.getElementById("frame_words").contentWindow.document.body;
    else
        return document.getElementById("frame_words").contentWindow.document.documentElement;
}

function newWinPos()
{
    // The coordinates of the Dictionary window when it is opened
	return 'width=600,height=' + heightDic + ',scrollbars=1,top=' + topDic +
    ',left=' + (Math.round(document.getElementById("bottomLeft").getBoundingClientRect().left) - 6);
}

function editor_frame_onclick(e)
{
	word = document.getElementById("editor_frame").contentWindow.document.getSelection();
	word = (word + "").trim();

	if (word != '') {
		$( "#pron_link" ).val( "" );
		$( "#pron_word" ).val( "" );

		listen(word, e);
		find_word_right(word);
	}
}

function addFields(nfn)
{
    // Adds new words from the Sources to the Words
	asd = "";
	newFileds = "";
	all_lels = $( "#frame_words" ).contents().find( ".remember_lel" );
	all_meanings = $( "#frame_words" ).contents().find( ".remember_meaning" );
	all_lels.each(function( index ) {
		$( this ).css( "color" ) == color_6 ? color_red = " style='color:red;font-weight:bold;'" : color_red = "";
		asd += "<INPUT TYPE='TEXT' VALUE=\"" +
        $( this ).val() + "\" class='remember_lel'" +
        color_red + "><INPUT TYPE='TEXT' VALUE=\"" +
        all_meanings.eq( index ).val() + "\" class='remember_meaning'>\n";
	});

    for (var n = 0; n < nfn; n++) {
        newFileds += "<INPUT TYPE=\"TEXT\" VALUE=\"\" class=\"remember_lel\"><INPUT TYPE=\"TEXT\" VALUE=\"\" class=\"remember_meaning\">\n";
    }
	$( "#frame_words" ).contents().find( "#fields" ).html( asd + newFileds );

	words_scroll_pos().scrollTop = words_scroll_pos().scrollHeight;
}

function show_red_num(red_num)
{
    // Counts how many words in the Words have no translations
    // when a word puts into the Words from the Sources
	all_lels_red = $( "#frame_words" ).contents().find( ".remember_lel" );
	all_meanings_red = $( "#frame_words" ).contents().find( ".remember_meaning" );
    all_lels_red.each(function(index) {
		if ($ ( this ).val() != "" && all_meanings_red.eq( index ).val() == "")
			red_num++;
		else
            red_num = red_num;
	});

	red_num == 0 ?
    $( "#red_words_num" ).css( "cursor", "text" ) :
    $( "#red_words_num" ).css( "cursor", "pointer" );

	$( "#red_words_num" ).html( red_num );
}

function show_red_num_words(red_num)
{
    // For the Words
    // Counts how many words in the Words have no translations
    // when a word is typed in the Words themselves
	all_lels_red = $( ".remember_lel" );
	all_meanings_red = $( ".remember_meaning" );
	all_lels_red.each(function(index) {
		if ($ ( this ).val() != "" && all_meanings_red.eq( index ).val() == "")
			red_num++;
		else
            red_num = red_num;
	});
	if (red_num == 0) {
        // Sets the color of word when the word is typed in the field
		$( "#red_words_num", parent.document ).css ( "color",
        $( "#new_red_words", parent.document ).css( "color" ));
		$( "#red_words_num", parent.document ).css( "cursor", "text" );
	} else
		$( "#red_words_num", parent.document ).css( "cursor", "pointer" );

	$( "#red_words_num", parent.document ).html( red_num );
}

function AddPage_onclick()
{
    if (position != -999) {
        options3[position].selected = true;
        $( ".form_header" ).eq( 1 ).html( "add page" );
        if ($( "#addPage" ).css( "display" ) == "block") {
            $( "#addPage" ).hide();
            $( "#add_form" ).css( "background-color", dark_color );
            $( "#add_form" ).css( "color", color_2 );

            meanPronPos();
        } else {
            $( "#edit_page" ).hide();
            $( "#EditLink" ).css( "background-color", dark_color );
            $( "#EditLink" ).css( "color", color_2 );

            $( "#addPage" ).show();
            $( "#add_form" ).css( "background-color", color_1 );
            $( "#add_form" ).css( "color", color_3 );

            meanPronPos();

            $( "#addPage" ).css( "top", $( "#top" ).outerHeight() + 14 + "px" );
            add_edit_form_height();
        }
    } else {
        alert("Sorry, but the maximum page (999) is used now.");
        return false;
    }
}

function EditLink_onclick()
{
	if ($( "#edit_page" ).css( "display" ) == "none") {
		$( window ).scrollTop( 0 );

		$( "#edit_page" ).show();
		$( "#EditLink" ).css( "background-color", color_1 );
		$( "#EditLink" ).css( "color", color_3 );

		meanPronPos();

		add_edit_form_height();

        // For the Book
		if ($( "#addPage" )[0]) {
			$( "#addPage" ).hide();
			$( "#add_form" ).css( "background-color", dark_color );
			$( "#add_form" ).css( "color", color_2 );
		}
	} else {
		$( window ).scrollTop( $( "#scroll_a" ).html() );
		$( "#scroll_a" ).html( "" );

		$( "#edit_page" ).hide();
		$( "#EditLink" ).css( "background-color", dark_color );
		$( "#EditLink" ).css( "color", color_2 );

		meanPronPos();
	}
}

function add_edit_form_height()
{
    // Sets the height of form to add/edit text
    var under_textarea = 0;

    $( ".under_textarea" )[0] ?
    under_textarea = $( ".under_textarea" ).eq( 0 ).outerHeight() :
    under_textarea = 0;

    $( "#edit_page" ).css( "height", window.innerHeight - 127 + "px" );

    $( "#enter_text" ).css( "height", $( "#edit_page" ).outerHeight() - under_textarea -
    $( ".form_header" ).eq( 0 ).outerHeight() - 8 + "px" );

    if ($( "#addPage" )[0]) {
        under_textarea = $( ".under_textarea" ).eq( 1 ).outerHeight();
        $( "#addPage" ).css( "height", $( window ).innerHeight() - 127 + "px" );
        $( "#enter_text2" ).css( "height", $( "#addPage" ).outerHeight() - under_textarea -
        $( ".form_header" ).eq( 1 ).outerHeight() - 8 + "px" );
    }
}

function CleanLink()
{
    // Removes highlighting in words
	$( window ).scrollTop( self.pageYOffset );
	$( "#enter_text" ).val( $( "#editor_frame" ).contents().find( "#text" ).html().replace(/<red>|<\/red>/g, "") );
	$( "#editor_frame" ).contents().find( "#text" ).html( $( "#enter_text" ).val() );
}

function SaveLink_onclick()
{
    // Make words in the Words like this:
    // foreign word|translation
    if ($( "#addPage" )[0] && $( "#addPage" ).css( "display" ) == "block") {
        // For Book when adding a new page
        $( "#buttonAddPage" ).click();
    } else {
        asd = "";
        all_lels = $( "#frame_words" ).contents().find( ".remember_lel" );
        all_meanings = $( "#frame_words" ).contents().find( ".remember_meaning" );
        all_lels.each(function(index) {
            asd = asd + $( this ).val().replace(/\s+/g," ").replace(/\|/g,"").trim() + "|" +
            all_meanings.eq( index ).val().replace(/\s+/g," ").replace(/\|/g,"").trim() + "\r\n";
        });
        $( "#add_words" ).val( asd.trim() );

        $( "#scroll_a" ).html() != "" ?
        $( "#page_scroll" ).val( $( "#scroll_a" ).html() ) :
        $( "#page_scroll" ).val( self.pageYOffset );

        $( "#words_scroll" ).val( words_scroll_pos().scrollTop );

        $( "#buttonSave" ).click();
    }
}

function DeleteLink_onclick()
{
	if ($( "#deleteWarning" ).css( "display" ) == "none") {
		$( "#DeleteLink" ).css( "background-color", color_4 );
		$( "#DeleteLink" ).css( "color", color_5 );

		$( "#deleteWarning" ).css({
            top: $( window ).innerHeight() / 4 + "px",
            left:  document.getElementById("bottomLeft").getBoundingClientRect().left +
            $( "#bottomLeft" ).outerWidth() / 4 + "px" });

		$( "#deleteWarning" ).show();
	} else {
		$( "#deleteWarning" ).hide();
        $( "#DeleteLink" ).css( "background-color", dark_color );
		$( "#DeleteLink" ).css( "color", color_2 );
	}
}

function func1()
{
    // If scrolling below 10px the shadow appears
    $( window ).scrollTop() > 10 ?
    $( "#top" ).css( "box-shadow", "0 0 7px #999" ) :
    $( "#top" ).css( "box-shadow", "none" );
}

function make_iframe_editable()
{
    // Makes the iframe editable
	$( "#editor_frame" ).contents().prop( "designMode", "on");
	$( "#editor_frame" ).contents().find( "#text" ).html( $( "#text" ).html() );
	$( "#enter_text" ).val( $( "#editor_frame" ).contents().find( "#text" ).html().replace(/<br>/g, "\n") );

	$( "#editor_frame" ).css({
        width: $( "#editor_frame" ).contents().find( "#text" ).outerWidth() + "px",
        height: $( "#text" ).outerHeight() + "px"
    });
	$( "#text" ).hide();

	$( window ).scrollTop( $( "#page_scroll" ).val() );
}

function func3()
{
	// For the Words
	$( "#frame_words" ).contents().find( "#fields" ).html( $( "#fields" ).html() );

	$( "#words_scroll" ).val() == "" ?
    words_scroll_pos().scrollTop = 0 :
    words_scroll_pos().scrollTop = $( "#words_scroll" ).val();

	$( "#frame_words" ).css( "left",
    document.getElementById("bottomRight").getBoundingClientRect().left + "px" );

	how_many_words();
	show_red_num(red_num);

	$( "#frame_words" ).css( "height", document.documentElement.clientHeight - 84 + "px" );

	$( "#new_red_words" ).css({
        top: $( "#frame_words" ).outerHeight() + 60 + "px",
        left: document.getElementById("bottomRight").getBoundingClientRect().left + "px"
    });
	$( "#occ_num" ).css( "left", document.getElementById("bottomRight").getBoundingClientRect().left + "px" );
}

function meanpron2_onmouseover()
{
	$( "#meanpron" ).css( "top", document.getElementById("editor_frame").getBoundingClientRect().top +
    frames["text_editable_frame"].document.getElementById("meanpron2").getBoundingClientRect().top + "px" );
	$( "#editor_frame" ).contents().find( "#meanpron2" ).hide();
	$( "#meanpron" ).show();
}

function searchInDic_oninput(lel, source)
{
    // Interaction with the Dictionary
	window.open("/dictionary/?" +
    "search_lel=" + escape(lel.trim()) +
    "&search_meaning=" +
    "&search_comment=" +
    "&search_example=" +
    "&search_label=" +
    "&search_source=" +
    "&page=" + 1 +
    "&source=" + escape(source) +
    "&scrolling=" + 0,
    '_blank', newWinPos());

	$( "#searchInDic" ).val( "" );
}

function if_searchInDic_clicked_on()
{
    // Open the Dictionary
	window.open("/dictionary/", '_blank', newWinPos());
	$( "#searchInDic" ).val( "" );
}

function if_window_scrolled()
{
    func1();

	if ($( window ).outerWidth() < 948) {
		$( "#topMenuSubMenu" ).css( "position", "fixed" );
		$( "#topMenuSubMenu" ).css({
            top: 0,
            left: $( "#bottomLeft" ).getBoundingClientRect().left - 20 + "px"
        });
		$( "#topMenuSubMenu" ).css( "paddingLeft", 10 + "px" );
	} else {
		$( "#topMenuSubMenu" ).css( "position", "static" );
		$( "#topMenuSubMenu" ).css( "paddingLeft", 0 );
	}

    meanPronPos();

    $( "#meanpron" ).css( "left",
    Number($( "#editor_frame").contents().find( "#meanpron2" ).css( "left" ).replace("px", "")) +
    document.getElementById("bottomLeft").getBoundingClientRect().left + "px" );

    $( "#frame_words" ).css( "height", document.documentElement.clientHeight - 84 + "px" );

    $( "#new_red_words" ).css({
        top: $( "#frame_words" ).outerHeight() + 60 + "px",
        left: document.getElementById("bottomRight").getBoundingClientRect().left + "px"
    });
    $( "#occ_num" ).css( "left",
    document.getElementById("bottomRight").getBoundingClientRect().left + "px" );

    $( "#frame_words" ).css( "left",
    document.getElementById("bottomRight").getBoundingClientRect().left + "px" );

    if ($( "#addPage" )[0]) $( "#addPage" ).css( "left",
    document.getElementById("bottomLeft").getBoundingClientRect().left + "px" );

	if ($( "#deleteWarning" )[0]) {
		$( "#deleteWarning" ).css( "left",
        document.getElementById("bottomLeft").getBoundingClientRect().left +
        $( "#bottomLeft" ).outerWidth() / 4 + "px" );
	}
}

function if_window_resized()
{
	if (document.documentElement.offsetWidth < 948) {
		$( "#topMenuSubMenu" ).css( "position", "fixed" );
		$( "#topMenuSubMenu" ).css({
            top: 0,
		    left: document.getElementById("bottomLeft").getBoundingClientRect().left - 20 + "px" });
		$( "#topMenuSubMenu" ).css( "padding-left", 10 + "px" );
	} else {
		$( "#topMenuSubMenu" ).css( "position", "static" );
		$( "#topMenuSubMenu" ).css( "padding-left", 0 );
	}

    meanPronPos();
    $( "#meanpron" ).css( "left",
    Number($( "#editor_frame" ).contents().find( "#meanpron2" ).css( "left" ).replace("px", "")) +
    document.getElementById("bottomLeft").getBoundingClientRect().left + "px" );

    $( "#frame_words" ).css({
        left: document.getElementById("bottomRight").getBoundingClientRect().left + "px",
        height: document.documentElement.clientHeight - 84 + "px"
     });

    $( "#new_red_words" ).css({
        top: $( "#frame_words" ).outerHeight() + 60 + "px",
        left: document.getElementById("bottomRight").getBoundingClientRect().left + "px"
    });
    $( "#occ_num" ).css( "left",
    document.getElementById("bottomRight").getBoundingClientRect().left + "px" );

    add_edit_form_height();

    if ($( "#addPage" )[0]) {
        add_edit_form_height();

        $( "#addPage" ).css( "left",
        document.getElementById("bottomLeft").getBoundingClientRect().left + "px" );
    }

	if ($( "#deleteWarning" )[0]) {
		$( "#deleteWarning" ).css( "left",
        document.getElementById("bottomLeft").getBoundingClientRect().left +
        $( "#bottomLeft" ).outerWidth() / 4 + "px" );
	}
}

function offsetWidth_947()
{
	if (document.documentElement.offsetWidth < 948) {
		$( "#topMenuSubMenu" ).css( "position", "fixed" );
		$( "#topMenuSubMenu" ).css({
            top: 0,
            left: document.getElementById("bottomLeft").getBoundingClientRect().left - 20 + "px"
        });
		$( "#topMenuSubMenu" ).css( "padding-left", 10 + "px" );
	}
}

function editor_frame_onmousedown()
{
	$( "#meanpron" ).hide();
	$( "#word_meaning" ).show();
	$( "#word_highlight" ).show();
	$( "#word_clear" ).show();
	$( "#sound" ).html( "♫" );
	$( "#sound" ).show();
	$( "#pron_link" ).hide();
	$( "#pron_link" ).val( "" );
	$( "#pron_word" ).val( "" );
	$( "#editor_frame" ).contents().find( "#meanpron2" ).hide();
	if ($( "#n_v_a" )[0])
        $( "#n_v_a" ).remove();
}

function pron_link_oninput()
{
	pron_add($( "#pron_link" ).val() + "|" + $( "#pron_word" ).val());
	$( "#meanpron" ).hide();
	$( "#pron_link" ).hide();
	$( "#pron_link" ).val( "" );
	$( "#pron_word" ).val( "" );
}

function pron_link_onclick()
{
	$( "#sound" ).hide();
	$( "#pron_link" ).hide();
	$( "#pron_link" ).val( "" );
	$( "#pron_word" ).val( "" );

	// Sets the coordinate for the Text interaction buttons
    // if the pron link is opend on the one conditions
    // but closed on the other ones
	$( "#meanpron" ).css( "left", iniPosLeft + "px" );
	$( "#editor_frame" ).contents().find( "#meanpron2" ).css( "left", iniPosLeft2 + "px" );

	whenScrollClosed = document.documentElement.scrollLeft;
	whenResizeClosed = window.innerWidth;

	// If the horizontal scrolling has been used
	if (whenScrollClosed > whenScrollOpen) {
		$( "#meanpron" ).css( "left",
        Number($( "#editor_frame" ).contents().find( "#meanpron2" ).css( "left" ).replace("px", "")) -
        whenScrollClosed-whenScrollOpen + 10 );
	} else if (whenScrollClosed < whenScrollOpen) {
		$( "#meanpron" ).css( "left",
        Number($( "#editor_frame" ).contents().find( "#meanpron2" ).css( "left" ).replace("px", "")) + 10 );
	}

	// If the size of window has been changed
	if (whenResizeClosed < whenResizeOpen) {
		$( "#meanpron" ).css( "left",
        Number($( "#editor_frame" ).contents().find( "#meanpron2" ).css( "left" ).replace("px", "")) +
        document.getElementById("bottomLeft").getBoundingClientRect().left + "px" );
	} else if (whenResizeClosed > whenResizeOpen) {
		$( "#meanpron" ).css( "left",
        Number($( "#editor_frame" ).contents().find( "#meanpron2" ).css( "left" ).replace("px", "")) +
        document.getElementById("bottomLeft").getBoundingClientRect().left + "px" );
	}

	$( "#editor_frame" ).contents().find( "#meanpron2" ).html( $( "#meanpron" ).html() );
	$( "#editor_frame" ).contents().find( "#meanpron2" ).css( "width", $( "#meanpron" ).outerWidth() + "px" );
	$( "#editor_frame" ).contents().find( "#meanpron2" ).css( "height", $( "#meanpron" ).outerHeight() + "px" );
}

// [the Text interaction buttons]

function four_buttons()
{
    $( "button" ).on( "click", function() {
        if (this.id == "word_meaning") word_meaning();
        else if (this.id == "word_highlight") word_highlight();
        else if (this.id == "word_clear") word_clear();
        else if (this.id == "sound") sound();
    });
}


function word_meaning()
{
    // Searches for a word selected
	$( "#word_meaning" ).hide();
	$( "#word_highlight" ).hide();
	$( "#word_clear" ).hide();
	$( "#sound" ).hide();
	if ($( "#n_v_a" )[0])
        $( "#n_v_a" ).remove();

	if (redAtOnce == 1) {
        document.getElementById("editor_frame").contentWindow.document.execCommand(
            "insertHTML",
            false,
            "<red>" +
            document.getElementById("editor_frame").contentWindow.document.getSelection() +
            "</red>"
        );
    }
	$( "#enter_text" ).val( $( "#editor_frame" ).contents().find( "#text" ).html().replace(/<br>/g, "\n") );

	add_empty_field_if_needed(word);
	how_many_words();
	show_red_num(red_num);

    searchInDic_oninput(
        word,
        $( "#to_add_new_word" ).html(),
        newWinPos()
    );

    $( "#editor_frame" ).contents().find( "#meanpron2" ).html( $( "#meanpron" ).html() );
	$( "#editor_frame" ).contents().find( "#meanpron2" ).css( "width", $( "#meanpron" ).outerWidth() + "px" );
	$( "#editor_frame" ).contents().find( "#meanpron2" ).css( "height", $( "#meanpron" ).outerHeight() + "px" );
}

function word_highlight()
{
    // Highlight a word selected
	document.getElementById("editor_frame").contentWindow.document.execCommand(
        "insertHTML",
        false,
        "<red>" + document.getElementById("editor_frame").contentWindow.document.getSelection() + "</red>"
    );
	$( "#enter_text" ).val( $( "#editor_frame" ).contents().find( "#text" ).html().replace(/<br>/g, "\n").replace(/&nbsp;/g, " ") );
	$( "#meanpron" ).hide();
}

function word_clear()
{
    // Remove highlighting from the word selected
	document.getElementById("editor_frame").contentWindow.document.execCommand(
        "insertHTML",
        false,
        document.getElementById("editor_frame").contentWindow.document.getSelection()
    );
	$( "#enter_text" ).val( $( "#editor_frame" ).contents().find( "#text" ).html().replace(/<br>/g, "\n").replace(/&nbsp;/g, " ") );
	$( "#meanpron" ).hide();
}

function sound()
{
	if ($( "#sound" ).html() == "#") {
        if ($( "#sound" ).prop( "title" ) == "Change the word!")
            pron_change(word);
        else if ($( "#sound" ).prop( "title" ) == "Delete the word!")
            pron_delete(word);
        else
            pron_add_manual(word);

		$( "#meanpron" ).hide();
		$( "#sound" ).html( "♫" );
	} else {
		$( "#pron_link" ).show();
		$( "#pron_word" ).val( word );

		$( "#pron_link" ).css( "width", $( "#word_meaning" ).outerWidth() +
        $( "#word_highlight" ).outerWidth() + $( "#word_clear" ).outerWidth() +
        $( "#sound" ).outerWidth() + "px" );

		$( "#pron_link" ).css( "height", $( "#meanpron" ).height() + "px" );

		$( "#pron_link" ).focus();

		$( "#sound" ).hide();
		$( "#word_meaning" ).hide();
		$( "#word_highlight" ).hide();
		$( "#word_clear" ).hide();
		$( "#editor_frame" ).contents().find( "#meanpron2" ).css({
            top: Number($( "#meanpron" ).css( "top" ).replace("px", "")) -
            document.getElementById("bottomLeft").getBoundingClientRect().top + "px",
            left: Number($( "#meanpron" ).css( "left" ).replace("px", "")) -
            document.getElementById("bottomLeft").getBoundingClientRect().left + "px"
        });

        $( "#editor_frame" ).contents().find( "#meanpron2" ).html( $( "#meanpron" ).html() );
    	$( "#editor_frame" ).contents().find( "#meanpron2" ).css( "width", $( "#meanpron" ).outerWidth() + "px" );
    	$( "#editor_frame" ).contents().find( "#meanpron2" ).css( "height", $( "#meanpron" ).outerHeight() + "px" );

        // The coordinates of #meanpron before the click on "♫"
		iniPosLeft = $( "#meanpron" ).css( "left" );
        // The coordinates of #meanpron2 before the click on "♫"
		iniPosLeft2 = $( "#editor_frame" ).contents().find( "#meanpron" ).css( "left" );

		// If the Text interaction buttons is beyond editor_frame
		if (document.getElementById("meanpron").getBoundingClientRect().left -
        document.getElementById("bottomLeft").getBoundingClientRect().left +
        $( "#meanpron" ).outerWidth() > $( "#editor_frame" ).outerWidth()) {
			$( "#meanpron" ).css( "left",
            document.getElementById("bottomLeft").getBoundingClientRect().left +
            $( "#editor_frame" ).outerWidth() - $( "#meanpron" ).outerWidth() - 5 + "px" );

			$( "#editor_frame" ).contents().find( "#meanpron2" ).css( "left",
            document.getElementById("meanpron").getBoundingClientRect().left -
            document.getElementById("bottomLeft").getBoundingClientRect().left + "px" );
		}
		whenScrollOpen = document.documentElement.scrollLeft;
		whenResizeOpen = window.innerWidth;

        // Open (or not) a dictionary
        // to find out the pronunciation of word selected
        // (see settings.js: var dicPron)
        var word_request = word.split("=")[0];
		if (dicPron == 0)
            return false;
		else if (dicPron == 1) setTimeout(function() {
            window.open('http://dictionary.cambridge.org/dictionary/english/' +
            word_request, "_blank", newWinPos());}, 1);
		else if (dicPron == 2) setTimeout(function() {
            window.open('http://www.oxfordlearnersdictionaries.com/definition/english/' +
            word_request, "_blank", newWinPos());}, 1);
		else if (dicPron == 3) setTimeout(function() {
            window.open('http://www.macmillandictionary.com/pronunciation/british/' +
            word_request, "_blank", newWinPos());}, 1);
		else
            return false;
	}
}

function meanPronPos()
{
	if ($( "#meanpron" ).css( "display" ) == "block") {
		$( "#editor_frame" ).contents().find( "#meanpron2" ).html( $( "#meanpron" ).html() );
		if ($( "#editor_frame" ).contents().find( "#meanpron2" ).css( "display" ) == "none") {
			$( "#editor_frame" ).contents().find( "#meanpron2" ).show();
			$( "#meanpron" ).hide();
		}
	}
}

function pron_change(str)
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", "/ajax/change.php?q=" + str, true);
	xmlhttp.send();
}

function pron_delete(str)
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", "/ajax/delete.php?q=" + str, true);
	xmlhttp.send();
}

function pron_add(str)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "/ajax/add.php?q=" + str, true);
    xmlhttp.send();
}

function pron_add_manual(str)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "/ajax/add_manually.php?q=" + str, true);
    xmlhttp.send();
}

function pron_add_manually(e)
{
    // Adds the pronunciation file to the database manually
    e.preventDefault();
    var that = $( this ),
    formData = new FormData(that.get(0));
    $.ajax({
        url: that.attr( "action" ),
        type: that.attr( "method" ),
        contentType: false,
        processData: false,
        data: formData,
        dataType: "json",
        success: function(json) {
            if (json) {
                that.replaceWith(json);
            }
        }
    });
}

function find_word_right(word)
{
    // Searches for the word selected among the Words
	var word_test = word.replace(/\.|\|/g, "");
	if (word_test != '' &&
        word_test != ' ' &&
        word_test != 'ing' &&
        word_test != 'ed' &&
        word_test.length != 1) {
		word = word.toLowerCase();
        var occurrences = [];
        var oc = 0;

        // How many occurances are there in the Words
        var all_lels_s = $( "#frame_words" ).contents().find( ".remember_lel" );
		all_lels_s.each(function(index) {
			if ($( this ).val().toLowerCase().search(word) != -1) {
				occurrences[oc] = index;
				oc++;
				$( this ).css( "font-weight", "bold" );
			} else if ($( this ).css( "color" ) != color_6) {
				$( this ).css( "font-weight", "normal" );
			}
		});

        // Moves scrolling infront of the toppest word found in the Words
		if (occurrences.length > 0) {
			var min = Math.min.apply(null, occurrences);
			words_scroll_pos().scrollTop = all_lels_s.eq( min ).offset().top;
			$( "#occ_num" ).css( "font-weight", "bold" );
			$( "#occ_num" ).html( occurrences.length );
		} else
            $( "#occ_num" ).html( "" );
	}
}

function how_many_words()
{
    // For the Words
    // Counts the number of words overall added to the Words
    // when they added from a source
	new_words_num = 0;
	$( "#frame_words" ).contents().find( ".remember_lel" ).each(function() {
		$( this ).val() != "" ? new_words_num++ : "";
    });
	$( "#new_words_num" ).html( "Overall: " + new_words_num + "/" );
}

function how_many_words_words() {
    // For the Words
    // Counts the number of words overall in the Words
    // when they added by typing them in the Words itself or
    // when they removed
	new_words_num = 0;
	$(".remember_lel").each(function() {
        $( this ).val() != "" ? new_words_num++ : "";
    });
	$( "#new_words_num", parent.document ).html( "Overall: " + new_words_num + "/" );
}

function add_empty_field_if_needed(slovo)
{
    // For the Words
    // Are there empty rows (empty_field_num)?
	var empty_field_num = 0;
	var all_lels_q = $( "#frame_words" ).contents().find( ".remember_lel" );
    all_lels_q.each(function() {
        if ($( this ).val() == "") empty_field_num++;
    });

	if (empty_field_num == 0) addFields(1);

	all_lels_q = $( "#frame_words" ).contents().find( ".remember_lel" );
    all_lels_q.each(function() {

		if ($( this ).val() == "") {
			$( this ).val( slovo );
			// Moves the slider of scrolling in fromt of the word added
			if ($( "#frame_words" ).contents().find( "#new_word_field" ).html() == "")
				words_scroll_pos().scrollTop = $( this ).offset().top -
                $( "#frame_words" ).outerHeight() / 1.5;
			else {
                // If the new row added happens to be below
				// the first empty row
				if ($( "#frame_words" ).contents().find( "#new_word_field" ).html() >
                $( this ).offset().top) {
					words_scroll_pos().scrollTop = $( this ).offset().top -
                    $( "#frame_words" ).outerHeight() / 1.5;
				} else {
					words_scroll_pos().scrollTop =
                    $( "#frame_words" ).contents().find( "#new_word_field" ).html();
					$( "#frame_words" ).contents().find( "#new_word_field" ).html( "" );
				}
			}
			return false;
		}
    });
}

function param(topMenuSubMenu_from_left)
{
    // Sets the coordinates of the Dictionary window
    // when it is opened in the Sources
    var winScr = 0;
    Number(window.screenX) < 0 ? winScr = 0 : winScr = Number(window.screenX);
    coord = winScr + Number(topMenuSubMenu_from_left);
    return 'width=600,height=' +
            heightDic +
            ',scrollbars=1,top=' +
            topDic +
            ',left=' +
            (coord-5);
}

function make_them_red() {
	all_meanings_red = $( ".remember_meaning" );
	$( ".remember_lel" ).each(function(index) {
        if ($( this ).val() != "" && all_meanings_red.eq( index ).val() == "") {
			$( this ).css({
                "color": color_6,
                "font-weight": "bold"
            });
			$( "#red_words_num", parent.document ).css( "color", color_6 );
		}
    });
}

function make_them_black() {
    // In the Words, makes rew words back black
	all_meanings_red = $( ".remember_meaning" );
	$( ".remember_lel" ).each(function(index) {
        $( this ).css({
            "color": "#555",
            "font-weight": "normal"
        });
		$( "#red_words_num", parent.document ).css( "color",
        $( "#new_red_words", parent.document ).css( "color" ) );
	});
}

function delete_cookie(cookie_name)
{
    // Remove the source from the Add new word form when the tab is closed
    var cookie_date = new Date();
    cookie_date.setTime(cookie_date.getTime() - 1);
    document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
}

function if_window_onscroll() {
    // When the window is scrolled
    $( "#td_search" ).css( "left",
    document.getElementById("dictionary").getBoundingClientRect().left + "px" );
    $( "#add_new_word" ).css( "left", add_new_word_left() );

    $( window ).scrollTop() > 4 ?
    $( "#www" ).css( "box-shadow", "0 7px 12px -10px #777" ) :
    $( "#www" ).css( "box-shadow", "none" );
}

function if_search_lel_ondragover() {
    if ($( "#search_meaning" ).val() == "" &&
    $( "#search_comment" ).val() == "" &&
    $( "#search_example" ).val() == "" &&
    $( "#search_label" ).val() == "" &&
    $( "#search_source" ).val() == "") {
        $( "#free_search" ).attr( "data-href", "/dictionary/" );
        $( "#search_lel" ).val( "" );
    }
}

function if_clear_search_onclick() {
    $( "#free_search" ).attr( "data-href", "/dictionary/" );
    $( "#search_lel" ).val( "" );
    $( "#search_lel" ).focus();
    $( "#search_meaning" ).val( "" );
    $( "#search_comment" ).val( "" );
    $( "#search_example" ).val( "" );
    $( "#search_label" ).val( "" );
    $( "#search_source" ).val( "" );
    $( this ).hide();
}

function if_clear_search_ondragover() {
    $( "#free_search" ).attr( "data-href", "/dictionary/" );
    $( "#search_lel" ).val( "" );
    $( "#search_meaning" ).val( "" );
    $( "#search_comment" ).val( "" );
    $( "#search_example" ).val( "" );
    $( "#search_label" ).val( "" );
    $( "#search_source" ).val( "" );
    $( this ).hide();
}

function extra_dic_param()
{
    // Sets the coordinates of the extra dictionaries windows
    // when it is opened in the Dictionary
    if (window.screenX <= 0)
        return param(document.getElementById("dictionary").getBoundingClientRect().left);
    else
        return "width=600,height=" + heightDic + ",scrollbars=1,top=" +
        window.screenY + ",left=" + window.screenX;
}

function if_window_resize()
{
    $( "#td_search" ).css( "left",
    document.getElementById("dictionary").getBoundingClientRect().left + "px" );

    $( "#add_new_word" ).css( "left", add_new_word_left() );

    $( "#dictionary" ).css( "min-height", document.documentElement.clientHeight -
    $( "#td_search" ).outerHeight() - dicMinHeightMinus + "px" );

    if ($( ".button_del" )[0])
        $( "#deleteWarning" ).css( "left",
        document.getElementById("dictionary").getBoundingClientRect().left + 135 + "px" );

    $( "#sound" ).css( "left", document.getElementById("dictionary").getBoundingClientRect().left +
    iniSleft + "px" );
    $( "#pron_link" ).css( "left", $( "#sound" ).css( "left" ) );

    if ($( "#n_v_a" )[0])
        $( "#n_v_a" ).css( "left",
        document.getElementById("dictionary").getBoundingClientRect().left +
        iniSleft + "px" );
}

function link_for_pageList()
{
    // For the Dictionary
    // Prepares the links for the list of pages
    window.location = document.location.search
    .replace(/page=([0-9]+)/, "page=" + this.value)
    .replace(/scrolling=[0-9]+/, "scrolling=0");
}

function selection_remover()
{
    // Removes the highlighting from the word
    $( ".rest_button_closed" ).each(function() {
        $( this ).click(function() {
            $( "#falseForm" ).position().top = $( this ).css( "top" ) + "px";
            $( "#falseForm" ).position().left = $( this ).css( "left" ) + "px";
            $( "#falseForm" ).select();

            restIfAbove(this.id, "1");
        });

        $( this ).on( "dragover", function() {
            restIfAbove(this.id, "2");
        });
    });
}

function search_request(
    search_lel,
    search_meaning,
    search_comment,
    search_example,
    search_label,
    search_source,
    page,
    source,
    scrolling
)
{
    // Prepares the query string for the GET request
    return "search_lel=" + search_lel.trim() +
    "&search_meaning=" + search_meaning.trim() +
    "&search_comment=" + search_comment.trim() +
    "&search_example=" + search_example.trim() +
    "&search_label=" + search_label.trim() +
    "&search_source=" + search_source.trim() +
    "&page=" + page +
    "&source=" + source.trim() +
    "&scrolling=" + Math.round(scrolling);
}

function scrolling_back()
{
    // When an entry is edited and the button Change is pressed
    // the scrolling is back to the initial place

    $( window ).scrollTop( urlAsArr["scrolling"] );

    $( ".button_save" ).each(function() {
        $( this ).click(function() {
           var acds = this.id.replace("bs", "acds");
           $( "#" + acds ).val( search_request(
               urlAsArr['search_lel'],
               urlAsArr['search_meaning'],
               urlAsArr['search_comment'],
               urlAsArr['search_example'],
               urlAsArr['search_label'],
               urlAsArr['search_source'],
               urlAsArr['page'],
               urlAsArr['source'],
               $( window ).scrollTop()
           ));
       });
    });
}

function when_click_on_search() {
    if ($( "#prefix" ).val() == "" &&
        $( "#search_lel" ).val() == "" &&
        $( "#search_meaning" ).val() == "" &&
        $( "#search_comment" ).val() == "" &&
        $( "#search_example" ).val() == "" &&
        $( "#search_label" ).val() == "" &&
        $( "#search_source" ).val() == "") {
            window.location = "/dictionary/";
            return false;
    } else {
        window.location = this.dataset.href;
        return false;
    }
}

function searches()
{
    var prefixValue = "";
    $.trim( $( "#search_lel" ).val() ) == "" ?
    prefixValue = $.trim( $( "#prefix" ).val() ) :
    prefixValue = $( "#prefix" ).val();

    $( "#free_search" ).attr( "data-href", "/dictionary/?" +
    search_request(
        prefixValue + $( "#search_lel" ).val(),
        $( "#search_meaning" ).val(),
        $( "#search_comment" ).val(),
        $( "#search_example" ).val(),
        $( "#search_label" ).val(),
        $( "#search_source" ).val(),
        1,
        $( "#source_from_new_add" ).val(),
        0
    ));
}

function listen(str, event)
{
    // For the Sources
    if (str != '') {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

				if (str.search(">>") != -1) {
					$( "#sound" ).html( "#" );
					$( "#sound" ).attr( "title", "Change the word!" );
				} else if (str.search(">delete>") != -1) {
					$( "#sound" ).html( "#" );
					$( "#sound" ).attr( "title", "Delete the word!" );
				} else $( "#sound" ).attr( "title", "" );

				if (xmlhttp.responseText != 0) {
					$( "#sound" ).hide();

					$( "#meanpron" ).append( n_v_a );
					if (xmlhttp.responseText.search("[+]") == -1) {
                        // If there is 1 word
						if (xmlhttp.responseText.search("[=]") == -1) {
                            // If it has no comment (=n/=adj/../=v)
							words_to_listen = "<div class='nvadj' onclick=\"listen_word('" +
                            xmlhttp.responseText + "');\">♫</div>";
						} else {
                            // If it has a comment
							words_to_listen = "<div class='nvadj' style='padding: 0 3px 0 4px;' onclick=\"listen_word('" +
                            xmlhttp.responseText.split('&=')[0] + "');\">♫ (" +
                            xmlhttp.responseText.split('&=')[1] + ")</div>";
						}
					} else {
                        // If there are several words
						var result = xmlhttp.responseText.replace(/=/g,"");
						words_to_listen_arr = result.split('+');
						$.each(words_to_listen_arr, function( index, value ) {
							if (index == 0) {
                                // For the first word of the list of words
								var sim = value.split('&')[1];
								if (sim == '') {
									sim = '♫';
									var extra_style = "";
								} else {
									sim = '♫ (' + value.split('&')[1] + ')';
									var extra_style = " style='padding: 0 3px 0 5px;'";
								}
								words_to_listen += "<div class='nvadj'" + extra_style +
                                " onclick=\"listen_word('" +
                                value.split('&')[0] + "');\">" + sim + "</div>";
							} else {
								sim = value.split('&')[1];
								var extra_style = " style='font-weight: bold;'";
								words_to_listen += "<div class='nvadj'" + extra_style +
                                " onclick=\"listen_word('" +
                                value.split('&')[0] + "');\">" + sim + "</div>";
							}
						});
					}
					$( "#n_v_a" ).html( words_to_listen );
					words_to_listen = "";
				} else
                    $( "#sound" ).show();

				$( "#meanpron" ).show();
				$( "#pron_link" ).hide();
				$( "#pron_word" ).val( "" );

				event.pageY < 55 ? plus = event.pageY + top_down : plus = event.pageY;

                $( "#meanpron" ).offset({ top: $( "#editor_frame" ).offset().top +
                plus - top_down });

                if (event.clientX + 16 + $( "#meanpron" ).outerWidth() >
                $( "#editor_frame" ).outerWidth()) {
                    $( "#meanpron" ).css( "left",
                    document.getElementById("bottomLeft").getBoundingClientRect().left +
                    $( "#editor_frame" ).outerWidth() -
                    $( "#meanpron" ).outerWidth() - 10 + "px" );

                } else $( "#meanpron" ).css( "left", event.clientX + 16 +
                document.getElementById("bottomLeft").getBoundingClientRect().left + "px" );

                // The coordinates of #meanpron before the click on "♫"
				iniPosLeft = $( "#meanpron" ).css( "left" );

				$( "#editor_frame" ).contents().find( "#meanpron2" ).html( $( "#meanpron" ).html() );
				$( "#editor_frame" ).contents().find( "#meanpron2" ).outerWidth( $( "#meanpron" ).outerWidth() + "px" );
				$( "#editor_frame" ).contents().find( "#meanpron2" ).outerHeight( $( "#meanpron" ).outerHeight() + "px" );
				$( "#editor_frame" ).contents().find( "#meanpron2" ).css( "top", plus - top_down + "px" );
				$( "#editor_frame" ).contents().find( "#meanpron2" ).css( "left",
                document.getElementById("meanpron").getBoundingClientRect().left -
                document.getElementById("bottomLeft").getBoundingClientRect().left + "px" );

                // The coordinates of #meanpron2 before the click on "♫"
				iniPosLeft2 = $( "#editor_frame" ).contents().find( "#meanpron2" ).css( "left" );
            }
        }
        xmlhttp.open("GET", "/ajax/listen.php?q=" + str, true);
        xmlhttp.send();
	}
}

function listen_words(str, event)
{
    if (str != '') {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

				if (str.search(">>") != -1) {
					$( "#sound" ).html( "#" );
					$( "#sound" ).attr( "title", "Change the word!" );
				} else if (str.search(">delete>") != -1) {
					$( "#sound" ).html( "#" );
					$( "#sound" ).attr( "title", "Delete the word!" );
				} else $( "#sound" ).attr( "title", "" );

				$( "#pron_word" ).val( str );
				$( "#sound" ).show();
				$( "#sound" ).css( "top", event.pageY - 25 + "px" );
				$( "#sound" ).css( "left", event.clientX + 5 + "px" );

				// If the Pronunciation button is beyond #fields
                // then back it within #fields
				if (document.getElementById("sound").getBoundingClientRect().top <
                document.getElementById("fields").getBoundingClientRect().top) {
					$( "#sound" ).css( "top",
                    document.getElementById("fields").getBoundingClientRect().top + "px" );
				}

				if (document.getElementById("sound").getBoundingClientRect().top +
                $( "#sound" ).outerHeight() > $( "#frame_words", parent.document ).outerHeight()) {
					$( "#sound" ).css( "top", $( "#fields" ).prop( "scrollHeight" ) -
                    $( "#sound" ).outerHeight() - 5 + "px" );
				}
				if (document.getElementById("sound").getBoundingClientRect().left <
                document.getElementById("fields").getBoundingClientRect().left) {
					$( "#sound" ).css( "left",
                    document.getElementById("fields").getBoundingClientRect().left + 5 + "px" );
				}
                if (document.getElementById("sound").getBoundingClientRect().left >
                $( "#fields" ).outerWidth()) {
                    $( "#sound" ).css( "left", $( "#fields" ).outerWidth() -
                    $( "#sound" ).outerWidth() - 5 + "px" );
                }

				if (xmlhttp.responseText != 0) {
                    if ($( "#n_v_a" )[0])
                        $( "#n_v_a" ).remove();
                    $( "body" ).append( n_v_a );
					$( "#n_v_a" ).css( "top", $( "#sound" ).css( "top" ) );
					$( "#n_v_a" ).css( "left", $( "#sound" ).css( "left" ) );
					$( "#sound" ).hide();
					if (xmlhttp.responseText.search("[+]") == -1) {
                        // If there is 1 word
						if (xmlhttp.responseText.search("[=]") == -1) {
                            // If it has no comment (=n/=adj/../=v)
							words_to_listen = "<div class='nvadj' onclick=\"listen_word('" + xmlhttp.responseText + "');\">♫</div>";
						} else {
                            // If it has a comment
							words_to_listen = "<div class='nvadj' style='padding: 1px 2px 0 4px;' onclick=\"listen_word('" +
                            xmlhttp.responseText.split('&=')[0] + "');\">♫ (" + xmlhttp.responseText.split('&=')[1] + ")</div>";
						}
                    } else {
                        // If there are several words
                        var result = xmlhttp.responseText.replace(/=/g,"");
                        words_to_listen_arr = result.split('+');
                        $.each(words_to_listen_arr, function( index, value ) {
                            if (index == 0) {
                                // For the first word of the list of words
                                var sim = value.split('&')[1];
                                if (sim == "") {
                                    sim = "♫";
                                    var extra_style = " style='padding: 1px 2px 0 4px;'";
                                } else {
                                    sim = '♫ (' + value.split('&')[1] + ')';
                                    var extra_style = " style='padding: 1px 2px 0 4px;'";
                                }
                                words_to_listen += "<div class='nvadj'" + extra_style +
                                " onclick=\"listen_word('" + value.split('&')[0] + "');\">" +
                                sim + "</div>";
                            } else {
                                sim = value.split('&')[1];
                                // For the other words (n, adj,.. v)
                                var extra_style = " style='padding: 0 3px 0 3px;font-weight: bold;'";
                                words_to_listen += "<div class='nvadj'" + extra_style +
                                " onclick=\"listen_word('" + value.split('&')[0] + "');\">" +
                                sim + "</div>";
                            }
                        });
                    }
					$( "#n_v_a" ).html( words_to_listen );
					words_to_listen = '';
				}
            }
        }
		xmlhttp.open("GET", "/ajax/listen.php?q=" + str, true);
		xmlhttp.send();
	}
}

function listen_dictionary(str, event)
{
    if (str != '') {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				$( "#pron_word" ).val( str );
				$( "#sound" ).show();
				$( "#sound" ).css( "top", event.pageY - 15 + "px" );
				$( "#sound" ).css( "left", event.clientX + 5 + "px" );

                // If the Pronunciation button is beyond #dictionary
                // then back it within #dictionary
				if (document.getElementById("sound").getBoundingClientRect().left +
                $( "#sound" ).outerWidth() > $( "#dictionary" ).outerWidth() +
                document.getElementById("dictionary").getBoundingClientRect().left) {
					iniSleft = $( "#dictionary" ).outerWidth() - $( "#sound" ).outerWidth() - 10;
					$( "#sound" ).css( "left", iniSleft +
                    document.getElementById("dictionary").getBoundingClientRect().left + "px" );
				} else iniSleft = event.clientX + 5 -
                document.getElementById("dictionary").getBoundingClientRect().left;

				if (document.getElementById("sound").getBoundingClientRect().top <
                document.getElementById("dictionary").getBoundingClientRect().top) {
					$( "#sound" ).css( "top",
                    document.getElementById("dictionary").getBoundingClientRect().top - 5 + "px" );
				}

				if (xmlhttp.responseText != 0) {
                    $( "body" ).append( n_v_a );
					$( "#n_v_a" ).css( "top", $( "#sound" ).css( "top" ) );
					$( "#n_v_a" ).css( "left", $( "#sound" ).css( "left" ) );
					$( "#sound" ).hide();
					if (xmlhttp.responseText.search("[+]") == -1) {
                        // If there is 1 word
						if (xmlhttp.responseText.search("[=]") == -1) {
                            // If it has no comment (=n/=adj/../=v)
							words_to_listen = "<div class='nvadj' onclick=\"listen_word('" + xmlhttp.responseText + "');\">♫</div>";
						} else {
                            // If it has a comment
							words_to_listen = "<div class='nvadj' style='padding: 2px 3px 0 4px;' onclick=\"listen_word('" +
                            xmlhttp.responseText.split('&=')[0] + "');\">♫ (" +
                            xmlhttp.responseText.split('&=')[1] + ")</div>";
						}
                    } else {
                        // If there are several words
                        var result = xmlhttp.responseText.replace(/=/g,"");
                        words_to_listen_arr = result.split('+');
                        $.each(words_to_listen_arr, function( index, value ) {
                            if (index == 0) {
                                // For the first word of the list of words
                                var sim = value.split('&')[1];
                                if (sim == "") {
                                    sim = "♫";
                                    var extra_style = " style='padding: 1px 2px 0 4px;'";
                                } else {
                                    sim = '♫ (' + value.split('&')[1] + ')';
                                    var extra_style = " style='padding: 1px 2px 0 4px;'";
                                }
                                words_to_listen += "<div class='nvadj'" + extra_style +
                                " onclick=\"listen_word('" + value.split('&')[0] + "');\">" +
                                sim + "</div>";
                            } else {
                                sim = value.split('&')[1];
                                // For the other words (n, adj,.. v)
                                var extra_style = " style='padding: 0 3px 0 3px;font-weight: bold;'";
                                words_to_listen += "<div class='nvadj'" + extra_style +
                                " onclick=\"listen_word('" + value.split('&')[0] + "');\">" +
                                sim + "</div>";
                            }
                        });
                    }
					$( "#n_v_a" ).html( words_to_listen );
					words_to_listen = "";
				}
            }
        }
		if (str.search(symbols_for_pron) != -1) {
            // For the Add prnunciation button to appear
            // only for foreign words selected
			xmlhttp.open("GET", "/ajax/listen.php?q=" + str, true);
			xmlhttp.send();
		} else word_to_listen2 = "";
	}
}

function listen_word(lw)
{
	$( "#sound" ).hide();
	$( "#audio" ).attr( "src", lw );
	document.getElementById("audio").play();
}

function where_listen()
{
    if ($( ".word_en" )[0]) {
        $( ".word_en, .meaning_normal, .word_example, result_meaning_checkbox_both, checkbox_1, checkbox_2, checkbox_1_2, list_example" ).mouseup(function(event) {
            if (word_to_listen2 == '') {
                word_to_listen2 = document.getSelection() + "";
                word_to_listen2 = word_to_listen2.trim();
                if (word_to_listen2 != "" && $( "#sound" ).css( "display" ) == "none")
                    listen_dictionary(word_to_listen2, event);
                else if ($( "#sound" ).css( "display" ) == "block")
                    $("#sound").hide();
                else if ($( "#sound" ).css( "display" ) == "none" && $( "#sound" ).css( "pron_link" ) == "")
                    $("#sound").hide();
            } else
                word_to_listen2 = "";
        });
    }
}

function if_Academic_clicked() {
    if ($("#search_lel").val() != "") {
        window.open("http://translate.academic.ru/" +
        searchRequest("Academic") + "/en/ru/", "_blank", extra_dic_param());
        return false;
    } else {
        window.open("http://translate.academic.ru/", "_blank", extra_dic_param());
        return false;
    }
}

function if_Multitran_clicked() {
    if ($("#search_lel").val() != "") {
        window.open("http://www.multitran.ru/c/m.exe?CL=1&s=" +
        searchRequest("Multitran") + "&l1=1", "_blank", extra_dic_param());
        return false;
    } else {
        window.open("http://www.multitran.ru/", "_blank", extra_dic_param());
        return false;
    }
}

function if_Cambridge_clicked() {
    if ($("#search_lel").val() != "") {
        window.open("http://dictionary.cambridge.org/dictionary/english/" +
        searchRequest("Cambridge"), "_blank", extra_dic_param());
        return false;
    } else {
        window.open("http://dictionary.cambridge.org/dictionary/english/", "_blank", extra_dic_param());
        return false;
    }
}

function if_Urban_clicked() {
    if ($("#search_lel").val() != "") {
        window.open("http://www.urbandictionary.com/define.php?term=" +
        searchRequest("Urban"), "_blank", extra_dic_param());
        return false;
    } else {
        window.open("http://www.urbandictionary.com/", "_blank", extra_dic_param());
        return false;
    }
}

function if_Google_clicked() {
    if ($("#search_lel").val() != "") {
        window.open("https://www.google.co.uk/search?q=\"" +
        searchRequest("Google") + "\"", "_blank", extra_dic_param());
        return false;
    } else {
        window.open("https://www.google.co.uk/", "_blank", extra_dic_param());
        return false;
    }
}

function if_Yandex_clicked() {
    if ($("#search_lel").val() != "") {
        window.open("http://yandex.ru/yandsearch?text=" +
        searchRequest("Yandex"), "_blank", extra_dic_param());
        return false;
    } else {
        window.open("http://yandex.ru/yandsearch?text=", "_blank", extra_dic_param());
        return false;
    }
}

function if_Oxford_clicked() {
    if ($("#search_lel").val() != "") {
        window.open("http://www.oxfordlearnersdictionaries.com/definition/english/" +
        searchRequest("Oxford"), "_blank", extra_dic_param());
        return false;
    } else {
        window.open("http://www.oxfordlearnersdictionaries.com/", "_blank", extra_dic_param());
        return false;
    }
}

function if_Macmillan_clicked() {
    if ($("#search_lel").val() != "") {
        window.open("http://www.macmillandictionary.com/pronunciation/british/" +
        searchRequest("Macmillan"), "_blank", extra_dic_param());
        return false;
    } else {
        window.open("http://www.macmillandictionary.com/", "_blank", extra_dic_param());
        return false;
    }
}

function search_pron2()
{
    $( this ).hide();
    $("#pron_link").css( "top", $("#sound").css( "top" ) );
    $("#pron_link").css( "left", $("#sound").css( "left" ) );
    $("#pron_link").show();

    // на тот случай, если pron_link выходит за границы словаря
    if (document.getElementById("pron_link").getBoundingClientRect().left +
    $("#pron_link").outerWidth() >
    document.getElementById("dictionary").getBoundingClientRect().left +
    $("#dictionary").outerWidth()) {
        $("#pron_link").css( "left",
        document.getElementById("dictionary").getBoundingClientRect().left +
        $("#dictionary").outerWidth() - $("#pron_link").outerWidth() - 10 + "px" );
    }

    $("#pron_word").val( document.getSelection() );
    window.open("http://dictionary.cambridge.org/dictionary/english/" +
    document.getSelection(), "_blank", extra_dic_param());
}

function if_no_word_found()
{
    // If no word has been found
    // See settings.js -> var searchEngine

    $("#add_new_word_button").click();

    $( "#search_lel" ).focus();
    $( "#search_lel" )[0].selectionStart = $( "#search_lel" ).val().length;

    if ($("#search_lel").val().search(/[a-zA-z]/) != -1 && $("#search_meaning").val() == "") {
        var search_arr2 = $("#search_lel").val().split(" ");
        if (search_arr2[0] == "to" ||
        search_arr2[0] == "To" ||
        search_arr2[0] == "a" ||
        search_arr2[0] == "A" ||
        search_arr2[0] == "an" ||
        search_arr2[0] == "An" ||
        search_arr2[0] == "the" ||
        search_arr2[0] == "The") {
        search_arr2.splice(0,1);
            var search_request = search_arr2.join(" ");
            search_request = search_request.replace(" %","");
        } else
            search_request = $("#search_lel").val();

        if (searchEngine == 1)
            window.open("http://translate.academic.ru/" +
            search_request + "/en/ru/", "_blank", extra_dic_param());
        else if (searchEngine == 2)
            window.open("http://www.multitran.ru/c/m.exe?CL=1&s=" +
            search_request + "&l1=1", "_blank", extra_dic_param());
        else if (searchEngine == 3)
            window.open("http://dictionary.cambridge.org/dictionary/english/" +
            search_request.toLowerCase(), "_blank", extra_dic_param());
        else if (searchEngine == 4)
            window.open("http://www.urbandictionary.com/define.php?term=" +
            search_request, "_blank", extra_dic_param());
        else if (searchEngine == 5)
            window.open("https://www.google.co.uk/search?q=\"" +
            search_request+"\"", "_blank", extra_dic_param());
        else if (searchEngine == 6)
            window.open("http://yandex.ru/yandsearch?text=" +
            search_request, "_blank", extra_dic_param());
        else if (searchEngine == 7)
            window.open("http://www.oxfordlearnersdictionaries.com/definition/english/" +
            search_request, "_blank", extra_dic_param());
        else if (searchEngine == 8)
            window.open("http://www.macmillandictionary.com/pronunciation/british/" +
            search_request, "_blank", extra_dic_param());
    }
}

function add_new_word_left()
{
    // Set the horizontal coordinates for the Add new word form
	return document.getElementById("dictionary").getBoundingClientRect().left +
    parseInt($("#dictionary").outerWidth() / 6.5) + "px";
}

function searchRequest(dicName)
{
	var rough_search = $("#search_lel").val().replace(/^\s+/, "").replace(/\s+$/, "");
	var search_arr = rough_search.split(" ");

	if (search_arr[0] == "to" ||
        search_arr[0] == "To" ||
        search_arr[0] == "a" ||
        search_arr[0] == "A" ||
        search_arr[0] == "an" ||
        search_arr[0] == "An" ||
        search_arr[0] == "the" ||
        search_arr[0] == "The") {
		search_arr.splice(0,1);
		var search = search_arr.join(" ");
		search = search.replace(" %", "");
	} else {
		var search = rough_search.replace(" %", "").trim();
	}

	if (dicName == "Google")
        return rough_search;
	else if (dicName == "Cambridge")
        return search.toLowerCase().replace(/\s/g, "-");
	else
        return search;
}

function tag_framing(what, opentag, closetag)
{
	var AB = what.value.substring(0, what.selectionStart);
	var BC = what.value.substring(what.selectionStart, what.selectionEnd);
	var CD = what.value.substring(what.selectionEnd, what.value.length);
	what.value = AB + opentag + BC + closetag + CD;
}

function remove_tags(what)
{
	var AB = what.value.substring(0, what.selectionStart);
	var BC = what.value.substring(what.selectionStart, what.selectionEnd);
	var CD = what.value.substring(what.selectionEnd, what.value.length);
	what.value = AB + BC.replace(/\[[^\]]+\]/g, "") + CD;
}

function carPos(t)
{
    // For the transliteration
    // Pinpoints the position of symbol typed in
	if (document.selection) {
        // for Internet Explorer
		t.focus();
		var s = document.selection.createRange();
		s.moveStart("character", -t.value.length);
		return s.text.length;
	} else if (t.selectionStart || t.selectionStart == '0')
        // for Firefox
        return t.selectionStart;
}

function nativeToForeign(text, pos)
{
    // The transliteration from the native language to the foreign one
	if (typeof native_foreign[text.substring(pos-1, pos)] === "undefined") {
		shift_key = "";
	} else {
		if (text.substring(pos-1, pos) == ",") {
            // если введён этот знак, а перед этим
			if (shift_key == "Shift") {
                // была нажата клавиша Shift
				shift_key = "";
				text = text.substring(0, pos-1) + "?" + text.substring(pos, text.length);
			} else
				text = text.substring(0, pos-1) +
                native_foreign[text.substring(pos-1, pos)] + text.substring(pos, text.length);
		}
		else {
			shift_key = "";
			text = text.substring(0, pos-1) +
            native_foreign[text.substring(pos-1, pos)] + text.substring(pos, text.length);
		}
	}
    // In the fields: "foreign", "example", "label" and "source"
    // if typing in Native language
    return text.replace(
        nativeToForeign_Shift_from_1, nativeToForeign_Shift_to_1
        ).replace(
        nativeToForeign_Shift_from_2, nativeToForeign_Shift_to_2
        ).replace(
        nativeToForeign_Shift_from_3, nativeToForeign_Shift_to_3
        ).replace(
        nativeToForeign_Shift_from_4, nativeToForeign_Shift_to_4
        ).replace(
        nativeToForeign_Shift_from_5, nativeToForeign_Shift_to_5
        ).replace(
        nativeToForeign_Shift_from_6, nativeToForeign_Shift_to_6
        );
}

function foreignToNative(text, pos)
{
    // The transliteration from the foreign language to the native one
	if (typeof foreign_native[text.substring(pos-1, pos)] === "undefined") {
		shift_key = "";
	} else {
		if (text.substring(pos-1, pos) == "?") {
			if (shift_key == "Shift") {
                // If the key Shift has been pressed
				shift_key = "";
				text = text.substring(0, pos-1) + "," +
                text.substring(pos, text.length);
			} else
				text = text.substring(0, pos-1) +
                foreign_native[text.substring(pos-1, pos)] +
                text.substring(pos, text.length);
		}
		else if (text.substring(pos-1, pos) == "&") {
			if (shift_key == "Shift") {
				shift_key = "";
				text = text.substring(0, pos-1) + "?" +
                text.substring(pos, text.length);
			} else
				text = text.substring(0, pos-1) +
                foreign_native[text.substring(pos-1, pos)] +
                text.substring(pos, text.length);
		}
		else if (text.substring(pos-1, pos) == "\"") {
			if (shift_key == "Shift") {
				shift_key = "";
				text = text.substring(0, pos-1) + "Э" +
                text.substring(pos, text.length);
			} else
				text = text.substring(0, pos-1) +
                foreign_native[text.substring(pos-1, pos)] +
                text.substring(pos, text.length);
		}
		else {
			shift_key = "";
			text = text.substring(0, pos-1) +
            foreign_native[text.substring(pos-1, pos)] +
            text.substring(pos, text.length);
		}
	}
    // In the field "native" if typing in Foreign language
    return text.replace(
        foreignToNative_Shift_from_1, foreignToNative_Shift_to_1
        ).replace(
        foreignToNative_Shift_from_2, foreignToNative_Shift_to_2
        ).replace(
        foreignToNative_Shift_from_3, foreignToNative_Shift_to_3
        ).replace(
        foreignToNative_Shift_from_4, foreignToNative_Shift_to_4
        ).replace(
        foreignToNative_Shift_from_5, foreignToNative_Shift_to_5
        ).replace(
        foreignToNative_Shift_from_6, foreignToNative_Shift_to_6
        );
}

function restIfAbove(thisId, youFrom)
{
    // Shows the contents of entries
	form_id1 = thisId.replace('r', 'shr');
	if (youFrom == 1) {
		if ($( "#" + form_id1 ).css( "display" ) == 'none') {
			$( "#" + form_id1 ).slideDown();
			$( "#" + thisId ).removeClass( "rest_button_closed" ).addClass( "rest_button_open" );
		} else {
			$( "#" + form_id1 ).slideUp();
			$( "#" + thisId ).removeClass("rest_button_open").addClass("rest_button_closed");
			word_to_listen2 = "";
		}
	} else {
		$( "#" + form_id1 ).slideDown();
        $( "#" + thisId ).removeClass("rest_button_closed").addClass("rest_button_open");
	}
}

function editIfAbove(thisId, youFrom)
{
    // To edit entries
	form_id1 = thisId.replace('e', 'f');
	if (youFrom == 1) {
		$( "#" + form_id1 ).css( "display" ) == 'none' ?
        $( "#" + form_id1 ).show( "slow" ) :
        $( "#" + form_id1 ).hide( "slow" );
	} else
        $( "#" + form_id1 ).show( "slow" );
}

function edit_example_buttons()
{
    // BB-codes

    $( ".bbc_b" ).each(function() {
        $( this ).click(function() {
            bId = this.id.replace("bNew", "newword_example");
            bId = bId.replace(/^b/, "example");
            var start = "[b]";
            var end = "[/b]";
            tag_framing(document.getElementById(bId), start, end); return false;
        });
    });

    $( ".bbc_i" ).each(function() {
        $( this ).click(function() {
            bId = this.id.replace("iNew", "newword_example");
            bId = bId.replace(/^i/, "example");
            var start = "[i]";
            var end = "[/i]";
            tag_framing(document.getElementById(bId), start, end); return false;
        });
    });

    $( ".bbc_u" ).each(function() {
        $( this ).click(function() {
            bId = this.id.replace("uNew", "newword_example");
            bId = bId.replace(/^u/, "example");
            var start = "[u]";
            var end = "[/u]";
            tag_framing(document.getElementById(bId), start, end); return false;
        });
    });

    $( ".bbc_s" ).each(function() {
        $( this ).click(function() {
            bId = this.id.replace("sNew", "newword_example");
            bId = bId.replace(/^s/, "example");
            var start = "[s]";
            var end = "[/s]";
            tag_framing(document.getElementById(bId), start, end); return false;
        });
    });

    $( ".bbc_x" ).each(function() {
        $( this ).click(function() {
            bId = this.id.replace("xNew", "newword_example");
            bId = bId.replace(/^x/, "example");
            remove_tags(document.getElementById(bId)); return false;
        });
    });
}

function trnslt() {
    // Translates from foregn language to native language and vice versa
    $( this )
        .on( "input", function() {
            var pos = carPos(this);

            if (
                $( this ).is( "#newword_lel") ||
                $( this ).is( "#newword_example") ||
                $( this ).is( "#newword_label") ||
                $( this ).is( "#source_from_new_add") ||
                $( this ).is( ".result_lel") ||
                $( this ).is( ".result_label" ) ||
                $( this ).is( ".result_source" )
            )
                this.value = nativeToForeign(this.value, pos);
            else
                this.value = foreignToNative(this.value, pos);

            this.selectionStart = this.selectionEnd = pos;
        })
        .keydown(function(event) {
            if (event.keyCode == 16) shift_key = "Shift";
        });
}

function add_source_if_clicked() {
    if (add_source_if_clicked_option == 1) {
        // Automatically puts a source in the source field of Edit entry form
        // from the Add new word form
        var chM1 = $( this ).val().indexOf($( "#source_from_new_add" ).val());
        var chM2 = $( "#" + this.id.replace('example', 'source')).val().indexOf($( "#source_from_new_add" ).val());
        if (chM1 == -1 && chM2 == -1) {
            if (test_2 != this.id) {
                $( this ).val( $( this ).val() + ' >  [' + $( "#source_from_new_add" ).val() + ']' );
                cursorPos = this.value.length - $( "#source_from_new_add" ).val().length - 3;
                // Set the cursor between > and [
                this.selectionStart = this.selectionEnd = cursorPos;
                test_2 = this.id;
            }
        }
    } else
        return false;
}

function openDic_width() {
    // Sets the with for #searchInDic field
    // which is doubleclickd on to open the Dictionary
    $( "#openDic" ).css( "width", $( "#topMenuSubMenu" ).outerWidth() -
    $( "#menu" ).outerWidth() - $( "#subMenu" ).outerWidth() - 30 + "px" );
}

function hide_show_fields_clearing_button() {
    // Hide or not Clear fields button (X)
    if ($( "#search_lel" ).val() == "" &&
    $( "#search_meaning" ).val() == "" &&
    $( "#search_comment" ).val() == "" &&
    $( "#search_example" ).val() == "" &&
    $( "#search_label" ).val() == "" &&
    $( "#search_source" ).val() == "")
        $( "#clear_search" ).hide();
    else
        $( "#clear_search" ).show();
}

function show_clear_button()
{
    // Shows the clear search fields button
    // if at least one field is filled
    if ($( "#search_lel" ).val() != "" ||
    $( "#search_meaning" ).val() != "" ||
    $( "#search_comment" ).val() != "" ||
    $( "#search_example" ).val() != "" ||
    $( "#search_label" ).val() != "" ||
    $( "#search_source" ).val() != "")
        $( "#clear_search" ).show();
}

function likePHPGet(query_string) {
    // The analogous to the PHP array $_GET
    // to get parameters from URL
    // the result is an array: parameter => value
    var vars = {};
    var parts = query_string.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(a, key, value) {
        vars[key] = value;
    });
    return vars;
}

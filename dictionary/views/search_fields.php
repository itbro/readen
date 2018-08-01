                <div id="www">
                    <FORM METHOD="POST" ACTION="/dictionary/" NAME="f">

                        <div id="num_rows"><?= $words_found ?></div>

                        <SELECT NAME="Prefix[]" id="prefix">
                            <OPTION VALUE=""></OPTION>
                            <OPTION VALUE="to ">to</OPTION>
                            <OPTION VALUE="a ">a</OPTION>
                            <OPTION VALUE="an ">an</OPTION>
                            <OPTION VALUE="the ">the</OPTION>
                            <OPTION VALUE="to be ">to be</OPTION>
                        </SELECT>

                        <div id="search_fileds">
                            <INPUT TYPE="TEXT" NAME="search_lel" autocomplete="off"
                            VALUE="<?= $lel_for_search_fields ?>" id="search_lel">

                            <div id="extra_fields" style="display:<?= $otherFields ?>;">
                                <INPUT TYPE="TEXT" NAME="search_meaning"
                                PLACEHOLDER="native" autocomplete="off"
                                VALUE="<?= $meaning_for_search_fields ?>" id="search_meaning">

                                <INPUT TYPE="TEXT" NAME="search_comment"
                                PLACEHOLDER="comment" autocomplete="off"
                                VALUE="<?= $comment_for_search_fields ?>" id="search_comment">

                                <INPUT TYPE="TEXT" NAME="search_example"
                                PLACEHOLDER="example" autocomplete="off"
                                VALUE="<?= $example_for_search_fields ?>" id="search_example">

                                <INPUT TYPE="TEXT" NAME="search_label"
                                PLACEHOLDER="label" autocomplete="off"
                                VALUE="<?= $label_for_search_fields ?>" id="search_label">

                                <INPUT TYPE="TEXT" NAME="search_source"
                                PLACEHOLDER="source" autocomplete="off"
                                VALUE="<?= $source_for_search_fields ?>" id="search_source">
                            </div>

                            <div id="content"><a href=""
                            id="Academic">A&nbsp;</a>|<a href=""
                            id="Multitran">&nbsp;M&nbsp;</a>|<a href=""
                            id="Cambridge">&nbsp;C&nbsp;</a>|<a href=""
                            id="Urban">&nbsp;U&nbsp;&nbsp;</a>/<a href=""
                            id="Google">&nbsp;&nbsp;G&nbsp;</a>|<a href=""
                            id="Yandex">&nbsp;Y&nbsp;</a>|<a href=""
                            id="Oxford">&nbsp;O&nbsp;</a>|<a href=""
                            id="Macmillan">&nbsp;M</a>
                            </div>
                        </div>

                        <INPUT TYPE="SUBMIT" VALUE="" data-href="" id="free_search">

                        <div id="add_new_word_button">Add</div>

                        <INPUT TYPE="HIDDEN" NAME="source_from_add" VALUE="<?= $source_from_sources ?>" id="badbad">

                        <div id="extra_fields_button" class="<?= $extra_fields ?>"></div>

                        <div id="clear_search" style="display:none;">×</div>
                    </FORM>
                </div>

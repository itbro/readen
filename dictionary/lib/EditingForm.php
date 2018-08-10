<?php
    Namespace lib;

    class EditingForm
    {
        public static function form(
            $row_id,
            $row_lel,
            $row_meaning,
            $row_comment,
            $row_example,
            $row_label,
            $row_source,
            $textarea_meaning,
            $this_page,
            $source_from_sources,
            $checkbox_decript,
            $checkbox_unsure
        )
        {
            // The Edit entry form
            // used in dictionary\views\vyvod_strok.php

            $row_lel = htmlspecialchars(stripslashes($row_lel), ENT_QUOTES);
            $row_meaning = htmlspecialchars(stripslashes($row_meaning), ENT_QUOTES);
            $row_comment = htmlspecialchars(stripslashes($row_comment),ENT_QUOTES);
            $row_example = htmlspecialchars(stripslashes($row_example), ENT_QUOTES);
            $row_source = htmlspecialchars(stripslashes($row_source), ENT_QUOTES);
            $source_from_sources = htmlspecialchars(stripslashes($source_from_sources), ENT_QUOTES);
            $server_query_string = htmlspecialchars(stripslashes($_SERVER['QUERY_STRING']), ENT_QUOTES);

            return <<<LOL
            <for_replace>
                <div class="closeEdit">×</div>
                <FORM NAME="form{$row_id}" METHOD="POST" ACTION="/dictionary/">
                    <legend>Edit entry form</legend>
                    <INPUT TYPE="TEXT" NAME="lel" MAXLENGTH="500" VALUE="{$row_lel}"
                    PLACEHOLDER="foreign" AUTOCOMPLETE="off" class="result_lel">
                    <INPUT TYPE="TEXT" NAME="meaning" MAXLENGTH="500" VALUE="{$row_meaning}"
                    PLACEHOLDER="native" AUTOCOMPLETE="off" $textarea_meaning id="meaning{$row_id}">
                    <TEXTAREA NAME="comment" MAXLENGTH="1000" PLACEHOLDER="comment"
                    class="result_comment">{$row_comment}</TEXTAREA>
                    <div class="bbcodes"><span id="b{$row_id}" class="bbc_b">b</span><span
                    id="i{$row_id}" class="bbc_i">i</span><span id="u{$row_id}"
                    class="bbc_u">u</span><span id="s{$row_id}" class="bbc_s">s</span><span
                    id="x{$row_id}" class="bbc_x">Clear</span></div>
                    <TEXTAREA NAME="example" MAXLENGTH="2000" PLACEHOLDER="example"
                    class="result_example" id="example{$row_id}">{$row_example}</TEXTAREA>
                    <INPUT TYPE="TEXT" NAME="label" MAXLENGTH="500" VALUE="{$row_label}"
                    PLACEHOLDER="label" AUTOCOMPLETE="off" class="result_label">
                    <INPUT TYPE="TEXT" NAME="source" MAXLENGTH="1000" VALUE="{$row_source}"
                    PLACEHOLDER="source" AUTOCOMPLETE="off" class="result_source"
                    id="source{$row_id}">
                    <div class="descript_unsure"><label><INPUT TYPE="CHECKBOX"
                    NAME="radio_descript" class="checkbox" VALUE="1"{$checkbox_decript}
                    id="descript{$row_id}"><p class="checkbox_description">Description</p></label><label><INPUT
                    TYPE="CHECKBOX" NAME="radio_unsure" class="checkbox"
                    VALUE="1"{$checkbox_unsure} id="unsure{$row_id}"><p
                    class="checkbox_unsure">Unsure</p></label></div>
                    <INPUT TYPE="SUBMIT" NAME="action" VALUE="change" id="bs{$row_id}" class="button_save">
                    <div class="button_del" id="dD{$row_id}">Delete</div>
                    <INPUT TYPE="SUBMIT" NAME="action" VALUE="delete" id="sD{$row_id}" style="display:none;">
                    <INPUT TYPE="HIDDEN" NAME="id" VALUE="{$row_id}">
                    <INPUT TYPE="HIDDEN" NAME="search" VALUE="{$server_query_string}" id="acds{$row_id}">
                    <INPUT TYPE="HIDDEN" NAME="page" VALUE="$this_page" class="this_page_from_label">
                    <INPUT TYPE="HIDDEN" NAME="source_from_add" VALUE="{$source_from_sources}">
                </FORM>
            </div>

LOL;
        }
    }

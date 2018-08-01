    <div id='closeAdd'>×</div>

    <FORM NAME="form_add" METHOD="POST" ACTION="/dictionary/">
         <legend>New entry <?= $new_word_number ?></legend>

         <INPUT TYPE="TEXT" NAME="lel" MAXLENGTH="500" PLACEHOLDER="foreign"
         AUTOCOMPLETE="off" id="newword_lel" VALUE="<?= $lel_for_add_new_word_form ?>">

         <INPUT TYPE="TEXT" NAME="meaning" MAXLENGTH="500" PLACEHOLDER="native"
         AUTOCOMPLETE="off" class="newword_meaning" id="meaning0" VALUE="<?= $meaning_for_add_new_word_form ?>">

         <TEXTAREA NAME="comment" MAXLENGTH="1000" PLACEHOLDER="comment"
         id="newword_comment"><?= $comment_for_add_new_word_form ?></TEXTAREA>

         <div class="bbcodes"><span id="bNew" class="bbc_b">b</span><span
         id="iNew" class="bbc_i">i</span><span id="uNew" class="bbc_u">u</span><span
         id="sNew" class="bbc_s">s</span><span id="xNew" class="bbc_x">Clear</span></div>

         <TEXTAREA NAME="example" MAXLENGTH="2000" PLACEHOLDER="example"
         id="newword_example"><?= $example_for_add_new_word_form ?></TEXTAREA>

         <INPUT TYPE="TEXT" NAME="label" MAXLENGTH="500" PLACEHOLDER="label"
         AUTOCOMPLETE="off" id="newword_label" VALUE="<?= $label_for_add_new_word_form ?>">

         <INPUT TYPE="TEXT" NAME="source_from_add" MAXLENGTH="1000"
         PLACEHOLDER="source" AUTOCOMPLETE="off" id="source_from_new_add"
         VALUE="<?= $sSource ?>">

         <div class="descript_unsure"><label><INPUT TYPE="CHECKBOX"
         NAME="radio_descript" class="checkbox" VALUE="1" id="descript0"><p
         class="checkbox_description">Description</p></label><label><INPUT
         TYPE="CHECKBOX" NAME="radio_unsure" class="checkbox" VALUE="1"
         id="unsure0"><p class="checkbox_unsure">Unsure</p></label></div>

         <INPUT TYPE="SUBMIT" NAME="action" VALUE="add" class="button_save">

         <INPUT TYPE="HIDDEN" NAME="link" VALUE="" id="link">

         <INPUT TYPE="HIDDEN" NAME="after_add" VALUE="1">

         <INPUT TYPE="HIDDEN" NAME="search" VALUE="">
    </FORM>

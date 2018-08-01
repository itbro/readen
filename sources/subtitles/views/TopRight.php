<?php
    $add_or_delete = $db->query("SELECT id FROM {$_GET['source']} WHERE name != ''");
    $add_or_delete->rowCount() == 0 ?
    $but_name = "<div id='AddLink'>Add</div>" :
    $but_name = "<div id='DeleteLink'>Delete</div>";
?>
                    <?= $but_name . "\n" ?>
                    <div id='CleanLink'>Clear</div>
                    <div id='SaveLink'>Save</div>

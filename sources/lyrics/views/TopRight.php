<?php
    $num = $db->query("SELECT id
                        FROM {$_GET['source']}
                        WHERE text != ''")->rowCount();

    if ($num == 0) {
        $EditLink = 'Add';
        $DeleteLink = "";
    } else {
        $EditLink = 'Edit';
        $DeleteLink = "<div id='DeleteLink'>Delete</div>";
    }
?>
                    <?= $DeleteLink ?>
                    <div id='EditLink'><?= $EditLink ?></div>
                    <div id='CleanLink'>Clear</div>
                    <div id='SaveLink'>Save</div>

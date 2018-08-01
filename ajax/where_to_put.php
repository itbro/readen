<?php
    require_once "../db_settings.php";

    require_once "../db_connection.php";

    $max_id = $db->query("SELECT MAX(id) FROM pronunciation")->fetchColumn();

    $db = null;

    // The number that is given to a new file added
    $file_number = $max_id + 1;

    // The number of folder that the file is put in
    $folder_number = round($file_number / 500);

    echo "Put file $file_number into folder $folder_number";

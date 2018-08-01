<?php
    $query = "SELECT $columns FROM dictionary WHERE

    label LIKE '$request_label.' OR
    label LIKE '$request_label.%' OR
    label LIKE '%.$request_label.' OR
    label LIKE '%.$request_label.%'

    ORDER by lel, meaning, comment, example, label, source, id ASC";

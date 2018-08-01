<?php
    $query = "SELECT $columns FROM dictionary WHERE

    lel 			LIKE '{$request_lel}' AND
    meaning 		LIKE '%{$request_meaning}%' AND
    comment			LIKE '%{$request_comment}%' AND
    example_pure	LIKE '%{$request_example}%' AND
    label			LIKE '%{$request_label}%' AND
    source			LIKE '%{$request_source}%'

    ORDER by lel, meaning, comment, id ASC";

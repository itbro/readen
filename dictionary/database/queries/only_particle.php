<?php
    $query = "(SELECT $columns FROM dictionary WHERE

    lel 		LIKE '{$request_lel}' AND
    meaning 	LIKE '%' AND
    comment		LIKE '%' AND
    example		LIKE '%' AND
    label		LIKE '%' AND
    source		LIKE '%'

    GROUP by CAST(lel AS CHAR) ASC, BINARY lel DESC, meaning, comment, example, label, source, id ASC)";

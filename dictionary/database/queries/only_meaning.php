<?php
    $query = "(SELECT $columns FROM dictionary WHERE

    meaning 	LIKE '{$request_meaning}'

    GROUP by CAST(meaning AS CHAR) ASC, BINARY meaning DESC, lel, comment, id ASC)
    UNION (SELECT $columns FROM dictionary WHERE

    meaning 	LIKE '{$request_meaning} /%' OR
    meaning 	LIKE '%/ {$request_meaning}' OR
    meaning 	LIKE '%/ {$request_meaning} /%' OR
    LOWER(meaning)		RLIKE '{$request_meaning}{$dobavka2}$' OR
    LOWER(meaning)		RLIKE '^{$dobavka1}{$request_meaning}{$dobavka1}$' OR
    LOWER(meaning)		RLIKE '{$request_meaning}{$dobavka2}[ .]+'

    GROUP by CAST(meaning AS CHAR) ASC, BINARY meaning DESC, lel, comment, id ASC)
    UNION (SELECT $columns FROM dictionary WHERE

    meaning 	LIKE '{$request_meaning} %'

    GROUP by CAST(meaning AS CHAR) ASC, BINARY meaning DESC, lel, comment, id ASC)
    UNION (SELECT $columns FROM dictionary WHERE

    meaning 	LIKE '% {$request_meaning}'

    GROUP by CAST(meaning AS CHAR) ASC, BINARY meaning DESC, lel, comment, id ASC)
    UNION (SELECT $columns FROM dictionary WHERE

    meaning 	LIKE '% {$request_meaning} /%'

    GROUP by CAST(meaning AS CHAR) ASC, BINARY meaning DESC, lel, comment, id ASC)";

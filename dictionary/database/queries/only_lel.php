<?php
    $query = "(SELECT $columns FROM dictionary WHERE

    lel 		LIKE '{$request_lel}'

    GROUP by CAST(lel AS CHAR) ASC, BINARY lel DESC, meaning, comment, id ASC)
    UNION (SELECT $columns FROM dictionary WHERE

    lel 		LIKE '%/ {$request_lel}' OR
    lel 		LIKE '{$request_lel} /%' OR
    lel 		LIKE '%/ {$request_lel} /%' OR
    LOWER(lel) 		RLIKE '{$request_lel}{$dobavka2}$' OR
    LOWER(lel) 		RLIKE '^{$dobavka1}{$request_lel}{$dobavka1}$' OR
    LOWER(lel) 		RLIKE '^{$dobavka1}{$request_lel}{$dobavka1}[.*]$' OR
    LOWER(lel) 		RLIKE '{$request_lel}{$dobavka2} /%' OR
    LOWER(lel) 		RLIKE '%/ {$request_lel}{$dobavka2}'

    GROUP by CAST(lel AS CHAR) ASC, BINARY lel DESC, meaning, comment, id ASC)
    UNION (SELECT $columns FROM dictionary WHERE

    lel 		LIKE '%/ pl. {$request_lel}'

    GROUP by CAST(lel AS CHAR) ASC, BINARY lel DESC, meaning, comment, id ASC)
    UNION (SELECT $columns FROM dictionary WHERE

    lel 		LIKE 'a {$request_lel}' OR
    lel 		LIKE 'an {$request_lel}' OR
    lel 		LIKE 'the {$request_lel}' OR
    lel 		LIKE 'to {$request_lel}' OR
    lel 		LIKE 'to {$request_lel} /%'

    GROUP by CAST(lel AS CHAR) ASC, BINARY lel DESC, meaning, comment, id ASC)
    UNION (SELECT $columns FROM dictionary WHERE

    lel 		LIKE 'to be {$request_lel}'

    GROUP by CAST(lel AS CHAR) ASC, BINARY lel DESC, meaning, comment, id ASC)
    UNION (SELECT $columns FROM dictionary WHERE

    lel 		LIKE '{$request_lel}s'

    GROUP by CAST(lel AS CHAR) ASC, BINARY lel DESC, meaning, comment, id ASC)
    UNION (SELECT $columns FROM dictionary WHERE

    lel 		LIKE '{$request_lel} %'

    GROUP by CAST(lel AS CHAR) ASC, BINARY lel DESC, meaning, comment, id ASC)
    UNION (SELECT $columns FROM dictionary WHERE

    lel 		LIKE '% {$request_lel}'

    GROUP by CAST(lel AS CHAR) ASC, BINARY lel DESC, meaning, comment, id ASC)
    UNION (SELECT $columns FROM dictionary WHERE

    lel 		LIKE '% {$request_lel} %'

    GROUP by CAST(lel AS CHAR) ASC, BINARY lel DESC, meaning, comment, id ASC)
    UNION (SELECT $columns FROM dictionary WHERE

    lel 		LIKE '{$request_lel}s' OR
    lel 		LIKE '{$request_lel}es' OR
    lel 		LIKE '% {$request_lel}s' OR
    lel 		LIKE '% {$request_lel}es' OR
    lel 		LIKE '% {$request_lel}s %' OR
    lel 		LIKE '% {$request_lel}es %'

    GROUP by CAST(lel AS CHAR) ASC, BINARY lel DESC, meaning, comment, id ASC)";

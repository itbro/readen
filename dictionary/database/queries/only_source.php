<?php
    $query = "SELECT $columns
                FROM dictionary
                WHERE source LIKE '$request_source'
                ORDER by source, lel, meaning, comment, example, label, id ASC";

<?php
    $query = "SELECT $columns
                FROM dictionary
                WHERE comment
                LIKE '%{$request_comment}%'
                ORDER by lel, meaning, comment, example, label, source, id ASC";

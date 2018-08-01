<?php
    $query = "SELECT $columns
                FROM dictionary
                WHERE example_pure
                LIKE '%$request_example%'
                ORDER by lel, meaning, id ASC";

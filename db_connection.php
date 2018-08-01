<?php
    mb_internal_encoding("UTF-8");

    $db = new PDO(
                    "mysql:host={$host};dbname={$dbname}",
                    $user,
                    $pass,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $db->exec("SET CHARSET utf8");

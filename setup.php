<?php
    require "db_settings.php";

    // #1

    try {
        $connection = new PDO("mysql:host={$host}",
                                $user,
                                $pass,
                                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (Exception $error) {
        echo "<center>
            Can't connect to MySQL :(
            <br /><br />
            <kbd>{$error->getMessage()}</kbd>
        </center>";
        exit;
    }

    // #2

    try {
        $connection->exec("CREATE DATABASE `{$dbname}`
                            CHARACTER SET utf8
                            COLLATE utf8_general_ci");
    } catch (PDOException $error) {
        echo "<center>
            Can't create the database :(
            <br /><br />
            <kbd>{$error->getMessage()}</kbd>
        </center>";
        exit;
    }

    // #3

    try {
        $connection->exec("USE `{$dbname}`");
    } catch (PDOException $error) {
        echo "<center>
            Can't connect to the database :(
            <br /><br />
            <kbd>{$error->getMessage()}</kbd>
        </center>";
        exit;
    }

    // #4

    try {
        $connection->exec("CREATE TABLE `article` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `url` varchar(999) NOT NULL,
          `text` text NOT NULL,
          `words` text NOT NULL,
          `page_scroll` int(11) NOT NULL,
          `words_scroll` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    } catch (PDOException $error) {
        echo "<center>
            Can't create the first table :(
            <br /><br />
            <kbd>{$error->getMessage()}</kbd>
        </center>";
        exit;
    }

    $connection->exec("CREATE TABLE `book` (
      `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `author_title` varchar(1000) NOT NULL,
      `text` text NOT NULL,
      `bookmark` enum('','1') NOT NULL,
      `words` text NOT NULL,
      `page_scroll` int(11) NOT NULL,
      `words_scroll` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

    $connection->exec("CREATE TABLE `dictionary` (
      `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `lel` varchar(500) NOT NULL,
      `meaning` varchar(500) NOT NULL,
      `comment` varchar(1000) NOT NULL,
      `example` varchar(2000) NOT NULL,
      `example_pure` varchar(2000) NOT NULL,
      `label` varchar(100) NOT NULL,
      `source` varchar(500) NOT NULL,
      `descript` enum('','1') NOT NULL,
      `unsure` enum('','1') NOT NULL,
      `date` date NOT NULL,
      INDEX (lel),
      INDEX (meaning),
      INDEX (label),
      INDEX (source)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

    $connection->exec("CREATE TABLE `lyrics` (
      `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `text` text NOT NULL,
      `words` text NOT NULL,
      `page_scroll` int(11) NOT NULL,
      `words_scroll` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

    $connection->exec("CREATE TABLE `pronunciation` (
      `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `word` varchar(999) NOT NULL,
      `ext` varchar(9) NOT NULL,
      INDEX (word)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

    $connection->exec("CREATE TABLE `subtitles` (
      `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `name` varchar(999) NOT NULL,
      `words` text NOT NULL,
      `page_scroll` int(11) NOT NULL,
      `words_scroll` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

    // #5

    $connection->exec("INSERT INTO `article` VALUES (null, '', '', '', 0, 0)");

    $connection->exec("INSERT INTO `lyrics` VALUES (null, '', '', '', 0, 0)");

    $connection->exec("INSERT INTO `book` VALUES (null, '', '', '1', '', 0, 0)");

    $connection->exec("INSERT INTO `subtitles` VALUES (null, '', '', 0, 0)");

    $connection = null;

    echo "<center>Well done! :)</center>";

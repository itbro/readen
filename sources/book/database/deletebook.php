<?php
    $db->exec("DELETE FROM `{$_GET['source']}`");
    $db->exec("INSERT INTO `{$_GET['source']}` VALUES (1, '', '', 1, '', 0, 0)");
    header("Location: /?source={$_GET['source']}&id=1");

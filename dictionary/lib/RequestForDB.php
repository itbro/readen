<?php
    Namespace lib;

    class RequestForDB
    {
        // All of them are replaced by "oneself"
        // See: prepare_lel_for_db()
        const SELFS = "/ herself | herself| himself | himself| itself | itself| ourselves | ourselves| themselves | themselves| yourself | yourself| myself | myself/i";

        // All of them are replaced by "%"
        // See: prepare_lel_for_db()
        const MYS = "/ my | his | her | your |your | our |our | their | its | him | it | me | sb | sth | sth | sth| them | they | us | you /i";

        public static function foreign($foreign)
        {
            // Used in dictionary\database\search_request.php
            $foreign = str_replace("sb\'s", "%", $foreign);
            $foreign = str_replace("sth\'s", "%", $foreign);
            $foreign = preg_replace(self::SELFS, " oneself ", $foreign);
            $foreign = preg_replace(self::MYS, " % ", $foreign);
            $foreign = preg_replace("/sb /i", "% ", $foreign);
            $foreign = preg_replace("/ sb/i", " %", $foreign);
            $foreign = addslashes($foreign);
            $foreign = trim($foreign);

            return $foreign;
        }
    }

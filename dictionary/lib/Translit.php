<?php
    Namespace lib;

    class Translit
    {
        const LETTERS = array(
            "q" => "й",
            "w" => "ц",
            "e" => "у",
            "r" => "к",
            "t" => "е",
            "y" => "н",
            "u" => "г",
            "i" => "ш",
            "o" => "щ",
            "p" => "з",
            "[" => "х",
            "]" => "ъ",
            "a" => "ф",
            "s" => "ы",
            "d" => "в",
            "f" => "а",
            "g" => "п",
            "h" => "р",
            "j" => "о",
            "k" => "л",
            "l" => "д",
            ";" => "ж",
            "'" => "э",
            "z" => "я",
            "x" => "ч",
            "c" => "с",
            "v" => "м",
            "b" => "и",
            "n" => "т",
            "m" => "ь",
            "," => "б",
            "." => "ю",
            "Q" => "Й",
            "W" => "Ц",
            "E" => "У",
            "R" => "К",
            "T" => "Е",
            "Y" => "Н",
            "U" => "Г",
            "I" => "Ш",
            "O" => "Щ",
            "P" => "З",
            "{" => "Х",
            "}" => "Ъ",
            "A" => "Ф",
            "S" => "Ы",
            "D" => "В",
            "F" => "А",
            "G" => "П",
            "H" => "Р",
            "J" => "О",
            "K" => "Л",
            "L" => "Д",
            ":" => "Ж",
            "\"" => "Э",
            "Z" => "Я",
            "X" => "Ч",
            "C" => "С",
            "V" => "М",
            "B" => "И",
            "N" => "Т",
            "M" => "Ь",
            "<" => "Б",
            ">" => "Ю",
            "`" => "ё",
            "~" => "Ё",
            "!" => "!",
            "@" => "\"",
            "#" => "№",
            "$" => ";",
            "^" => ":",
            "&" => "?",
            "|" => "/",
            "?" => ",",
            "/" => ".");

        public static function transliteration(
            $word,
            $lang
        )
        {
            // The transliteration:
            // if $lang == NATIVE_LANGUAGE then the transliteration
            // from the native language to the foreign one
            // otherwise from the foreign language to the native one

            $word_as_array = [];
            $word_length = mb_strlen($word);
            for ($i = 0; $i < $word_length; $i++) {
                $word_as_array[$i] = mb_substr($word, $i, 1);
            }

            $letters = self::LETTERS;

            if ($lang != NATIVE_LANGUAGE)
                $letters = array_flip(self::LETTERS);

            $word_translated = "";
            foreach ($word_as_array as $its_letter) {
                if (isset($letters[$its_letter])) {
                    $word_translated .= $letters[$its_letter];
                } else $word_translated .= $its_letter;
            }
            return $word_translated;
        }
    }

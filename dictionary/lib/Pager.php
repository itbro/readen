<?php
    Namespace lib;

    class Pager
    {
        public static function pages(
            $num_rows2,
            $how_many_pages,
            $this_page
        )
        {
            // The list of pages for the Dictionary
            // It only outputs if the number of pages are more than 1
            if ($how_many_pages > 1) {

                // the previous page
                if ($this_page == 1)
                    $pagePrevious = "<span class='noPage'>&#9664;</span>";
                else {
                    $rest_part = preg_replace(
                        "/scrolling=([0-9]+)/",
                        "scrolling=0",
                        $_SERVER['QUERY_STRING']);

                    $pagePrevious = preg_replace(
                        "/page=([0-9]+)/",
                        "page=" . ($this_page - 1),
                        $rest_part);

                    $pagePrevious = "<a href=\"?" . $pagePrevious . "\">&#9664;</a>";
                }
                $arr['back_page'] = $pagePrevious;

                // the list of pages
                $arr['page_list'] = "";
                for ($i = 1; $i <= $how_many_pages; $i++) {
                    $nbsp = "";
                    if (strlen($how_many_pages) == 1)
                        $nbsp .= "&nbsp;";
                    else {
                        if (strlen($how_many_pages) != strlen($i)) {
                            $k = strlen($how_many_pages) - strlen($i);
                            for ($ik = 0; $ik < $k; $ik++) {
                                $nbsp .= "&nbsp;";
                            }
                        } else $nbsp = "";
                    }
                    $arr['page_list'] .=  "<OPTION VALUE='{$i}'>{$nbsp}{$i}</OPTION>";
                }

                // the next page
                if ($this_page == $how_many_pages)
                    $pageNext = "<span class='noPage'>&#9654;</span>";
                else {
                    $rest_part = preg_replace(
                        "/scrolling=([0-9]+)/",
                        "scrolling=0",
                        $_SERVER['QUERY_STRING']);

                    $pageNext = preg_replace(
                        "/page=([0-9]+)/",
                        "page=" . ($this_page + 1),
                        $rest_part);

                    $pageNext = "<a href=\"?" . $pageNext . "\">&#9654;</a>";
                }
                $arr['next_page'] = $pageNext;

                return <<<LOL
                <div id='pages'><div id='pCenter'>
                <div class='pagePrevious'>{$arr['back_page']}</div>
                <SELECT NAME='' id='pageList'>{$arr['page_list']}</SELECT>
                <div class='pageNext'>{$arr['next_page']}</div>
                </div></div>

                <script>
                <!-- В выпадающем списке страниц (id='pageList') выбрать текущую страницу -->
                var optionsA = document.getElementById('pageList').getElementsByTagName('option');
                for (o=0; o<optionsA.length; o++) {
                    if (optionsA[o].value == {$this_page}) {
                        optionsA[o].selected=true;
                    }
                }
                </script>
LOL;
            } else return;
        }
    }

<?php
    $bm = $db->query("SELECT id FROM book WHERE bookmark != ''")->fetchColumn();
?>
                    <a href='/?source=article'><div id='article'>Article</div></a>
                    <div id='lyrics'>Lyrics</div>
                    <a href='/?source=subtitles'><div id='subtitles'>Subtitles</div></a>
                    <a href='/?source=book&id=<?= $bm ?>'><div id='book'>Book</div></a>

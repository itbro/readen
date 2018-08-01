<?php
    $bm = $db->query("SELECT id FROM book WHERE bookmark != ''")->fetchColumn();
?>
                    <div id='article'>Article</div>
                    <a href='/?source=lyrics'><div id='lyrics'>Lyrics</div></a>
                    <a href='/?source=subtitles'><div id='subtitles'>Subtitles</div></a>
                    <a href='/?source=book&id=<?= $bm ?>'><div id='book'>Book</div></a>

<?php
    $bm = $db->query("SELECT id FROM book WHERE bookmark != ''")->fetchColumn();
?>
                    <a href='/?source=article'><div id='article'>Article</div></a>
                    <a href='/?source=lyrics'><div id='lyrics'>Lyrics</div></a>
                    <div id='subtitles'>Subtitles</div>
                    <a href='/?source=book&id=<?= $bm ?>'><div id='book'>Book</div></a>

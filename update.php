<pre>
<?php

include "sites.php";

foreach($sites as $silename => $site) {
    echo sprintf("Loading %s... \n", $silename); 
    file_put_contents("/home/jehna/thejunkland.com/itala/tmp_recent/" . $silename, file_get_contents($site));
}
?>
</pre>
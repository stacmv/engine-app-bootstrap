<?php
define("DONT_START_ENGINE", true);

include "index.php";


// ============================

?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/bs2/css/bootstrap-combined.min.css">
</head>
<body>
<div class="container">
<?php

$dbs = glob(DATA_DIR . "*.db");


foreach(db_get_tables_list() as $db_table){
    echo "<b>Checking '".$db_table."' ...</b><br>";
    db_check_schema($db_table);
    echo "<b>Done.<br>";
};
echo "Done all.";

?>
</div>
</body>
</html>

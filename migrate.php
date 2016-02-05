<?php
define("DONT_START_ENGINE", true);

include "index.php";


// ============================

?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <base href="../../">
    <link rel="stylesheet" href="assets/css/bootstrap-combined.min.css">
</head>
<body>
<div class="container">
<?php

$dbs = glob(DATA_DIR . "*.db");

foreach($dbs as $db_file){
    $db_name = pathinfo($db_file,PATHINFO_FILENAME);
    
    echo "<b>Checking '".$db_name."' ...</b><br>";
    db_check_schema($db_name);
    echo "<b>Done.<br>";
};
echo "Done all.";

?>
</div>
</body>
</html>

<?php

header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=SQL_Graph.sql");
print $_POST['sql'];
?>
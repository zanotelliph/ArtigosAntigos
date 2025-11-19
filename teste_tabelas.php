<?php
require_once 'site/database/db.class.php';

$db = (new Database())->getConnection();

$tables = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

echo "<pre>";
print_r($tables);
echo "</pre>";

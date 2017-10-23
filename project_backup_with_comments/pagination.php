<?php
$mongodb = new Mongo();
$database = $mongodb->sandesh;
$collection = $database->info;
 
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 5;
$skip = ($page - 1) * $limit;
$next = ($page + 1);
$prev = ($page - 1);
//$sort = array('createdAt' => -1);
//$total=26;
$cursor = $collection->find()->skip($skip)->limit($limit);

$total=$cursor->count();
foreach ($cursor as $r) {
echo sprintf('<p>Name:%s. Gender:%s. Weight:%d. </p>', $r['name'], $r['gender'], $r['weight']);
}

if($page > 1){
echo '<a href="?page=' . $prev . '">Previous</a>';
if($page * $limit < $total) {
echo ' <a href="?page=' . $next . '">Next</a>';
}
} else {
if($page * $limit < $total) {
echo ' <a href="?page=' . $next . '">Next</a>';
}
}
 
$mongodb->close();
?>

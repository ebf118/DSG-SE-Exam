<?php 

$m = new MongoClient();

$db = $m->logs_db;
$collection = $m->logs;

$success = $collection->aggregate([
    { $match: { status: "success" } },
    { $group: { _id: "$created_at", counter: { $sum: 1} } }
]);

$error = $collection->aggregate([
    { $match: { status: "error" } },
    { $group: { _id: "$created_at", counter: { $sum: 1} } }
]);

$created_at = $collection->distinct("created_at");

$new_array = array('series' => $created_at, 'success' => $success, 'error' => $error);

$json = json_encode($new_array);

return $json;
?>
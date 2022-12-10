<?php 

header("Content-Type: application/json; charset=UTF-8");

include_once "../handler.php";
include("../../model/score.php");
include("../../model/db.php");

$data = handle_request();

$usr = new score();
$usr->set($data);
$result = $usr->delete(get_connection(include("../config.php")));

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

?>
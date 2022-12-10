<?php 

header("Content-Type: application/json; charset=UTF-8");
include_once "../handler.php";
include("../../model/game.php");
include("../../model/db.php");

$data = handle_request();

$usr = new game();
$usr->set($data);
$result = $usr->update(get_connection(include("../config.php")));

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

?>
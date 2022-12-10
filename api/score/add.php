<?php 

header("Content-Type: application/json; charset=UTF-8");

include_once "../handler.php";
include("../../model/score.php");
include("../../model/db.php");

$data = handle_request();

$usr = new score();
$usr->set($data);

$check = $usr->one_by_player_id(get_connection(include("../config.php")));
if ($check->data != null){
    $check->data->score = $usr->score;
    $usr->set($check->data);
    $result = $usr->update(get_connection(include("../config.php")));

    echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

$result = $usr->add(get_connection(include("../config.php")));

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

?>
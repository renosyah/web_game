<?php

include_once("model/game.php");
include_once("model/db.php");

$game = new game();

$offset = 0;
if (isset($_GET['offset']) && !empty($_GET['offset'])) {
    $offset = $_GET['offset'];
}


$game_query = (object) ['search_by' => 'game_name','search_value' => '','order_by' => 'id','order_dir'=> 'asc','offset' => $offset,'limit' => 10];
$result_game = $game->all(get_connection(include("api/config.php")),$game_query);

?>
<div class="row" style="min-height:600px">
    <?php if (count($result_game->data) == 0){ ?>
        <div class="col s12">
            <div style="height:150px"></div>
            <p class="center">No data</p>
        </div>
    <?php } ?>

    <?php foreach ($result_game->data as $value) { ?>
        <div class="col s12 m6 l3">
            <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="<?php echo $value->game_url . "/index.icon.png" ?>" style="height:250px">
                </div>
                <div class="card-content">
                    <p>Game id : <?php echo $value->id ?></p>
                    <h4><?php echo $value->game_name ?></h4>
                    <p><?php echo $value->game_description ?></p>
                </div>
                <div class="card-action">
                    <a class="black-text" href="<?php echo $value->game_url ?>?game_id=<?php echo $value->id ?>&player_id=admin001&player_name=admin" target="_blank">Play</a>
                    <a class="black-text" href="<?php echo "?menu=scoreboard&offset=0&game_id=". $value->id ?>">Scoreboard</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<div class="container">
    <ul class="center pagination">
        <li class="waves-effect"><a href="<?php echo "?menu=games" . ("&offset=". ($offset - 10 < 0 ? 0 : $offset - 10) ) ?>"><i class="material-icons">chevron_left</i></a></li>
        <li class="waves-effect"><a href="<?php echo "?menu=games" . ("&offset=". ($offset + 10) ) ?>"><i class="material-icons">chevron_right</i></a></li>
    </ul>
</div>

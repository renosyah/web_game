<?php

include_once("model/game.php");
include_once("model/db.php");

$game = new game();
$game_query = (object) ['search_by' => 'game_name','search_value' => '','order_by' => 'id','order_dir'=> 'asc','offset' => 0,'limit' => 100];
$result_game = $game->all(get_connection(include("api/config.php")),$game_query);

?>
<div class="row">
    <?php if ($result_game->error != ""){ ?>
    <div class="col s12">
        <p class="center" style="height:300px">Kosong</p>
    </div>
    <?php return; } ?>

    <?php foreach ($result_game->data as $value) { ?>
        <div class="col s12 m6 l3">
            <div class="card">
                <div class="card-content">
                    <h4><?php echo $value->game_name ?></h4>
                    <p><?php echo $value->game_description ?></p>
                </div>
                <div class="card-action">
                    <a class="black-text" href="<?php echo $value->game_url ?>?&player_id=admin001&player_name=admin">Play</a>
                    <!-- <a class="red-text" href="#">Delete</a> -->
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php

include_once("model/score.php");
include_once("model/db.php");

$score= new score();
$offset = 0;

if (isset($_GET['offset']) && !empty($_GET['offset'])) {
    $offset = $_GET['offset'];
}

$game_id = null;
if (isset($_GET['game_id']) && !empty($_GET['game_id'])) {
    $game_id = $_GET['game_id'];
}

$score_query = (object) ['search_by' => 'player_name','search_value' => '','order_by' => 'score','order_dir'=> 'desc','offset' => $offset,'limit' => 10];

if ($game_id != null){
    $score_query = (object) ['search_by' => 'game_id','search_value' => $game_id,'order_by' => 'score','order_dir'=> 'desc','offset' => $offset,'limit' => 10];
}


$result_score = $score->all(get_connection(include("api/config.php")), $score_query);

?>
<div class="row">
    <?php if ($result_score->error != ""){ ?>
    <div class="col s12">
        <p class="center" style="height:300px">Kosong</p>
    </div>
    <?php return; } ?>

    <?php foreach ($result_score->data as $value) { ?>
        <div class="col s12 m6 l3">
            <div class="card">
                <div class="card-content">
                    <p>Game id : <?php echo $value->game_id ?></p>
                    <h4><?php echo $value->player_name ?></h4>
                    <p>Score : <?php echo $value->score ?></p>
                </div>
                <div class="card-action">
                    <!-- <a class="black-text">Play</a> -->
                    <!-- <a class="red-text" href="#">Delete</a> -->
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<div class="container">
    <ul class="center pagination">
        <li class="waves-effect"><a href="<?php echo "?menu=scoreboard&offset=". $offset - 10 . $game_id != null ? "&game_id=". $game_id : "" ?>"><i class="material-icons">chevron_left</i></a></li>
        <li class="waves-effect"><a href="<?php echo "?menu=scoreboard&offset=". $offset + 10 . $game_id != null ? "&game_id=". $game_id : "" ?>"><i class="material-icons">chevron_right</i></a></li>
    </ul>
</div>

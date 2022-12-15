<?php
    include_once("model/score.php");
    include_once("model/db.php");

    $score= new score();

    $offset = 0;
    $limit = 8;

    if (isset($_GET['offset']) && !empty($_GET['offset'])) {
        $offset = $_GET['offset'];
    }

    $game_id = null;
    if (isset($_GET['game_id']) && !empty($_GET['game_id'])) {
        $game_id = $_GET['game_id'];
    }

    $score_query = [
        'search_by' => 'scoreboard.player_name',
        'search_value' => '',
        'order_by' => 'scoreboard.score',
        'order_dir'=> 'DESC',
        'offset' => $offset,
        'limit' => $limit
    ];
    
    if ($game_id != null){
        $score_query['search_by'] = 'scoreboard.game_id';
        $score_query['search_value'] = $game_id;
    }

    $result_score = $score->all_with_games(
        get_connection(include("api/config.php")),
        (object) $score_query
    );

?>
<div class="row" style="min-height:600px">
    <?php if (count($result_score->data) == 0){ ?>
        <div class="col s12">
            <div style="height:150px"></div>
            <p class="center">No data</p>
        </div>
    <?php } ?>

    <?php foreach ($result_score->data as $value) { ?>
        <div class="col s12 m6 l3">
            <div class="card">
            <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="<?php echo "$value->game_url/index.icon.png" ?>" style="height:250px">
                </div>
                <div class="card-content">
                    <p><?php echo "Game : $value->game_name" ?></p>
                    <h4><?php echo $value->player_name ?></h4>
                    <p>Score : <?php echo $value->score ?></p>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php
    $menu = "?menu=scoreboard";
    $byGameId = $game_id != null ? "game_id=$game_id" : "";
    $prevPage = "offset=". ($offset - $limit < 0 ? 0 : $offset - $limit);
    $nextPage = "offset=". ($offset + $limit);
?>

<div class="container">
    <ul class="center pagination">
        <li class="waves-effect"><a href="<?php echo "$menu&$prevPage&$byGameId" ?>"><i class="material-icons">chevron_left</i></a></li>
        <li class="waves-effect"><a href="<?php echo "$menu&$nextPage&$byGameId" ?>"><i class="material-icons">chevron_right</i></a></li>
    </ul>
</div>

<?php

include_once("result_query.php");

class score {
    public $id;
    public $game_id;
    public $player_id;
    public $player_name;
    public $score;

    public function __construct(){
    }

    public function set($data){
        $this->id = (int) $data->id;
        $this->game_id = $data->game_id;
        $this->player_id = $data->player_id;
        $this->player_name = $data->player_name;
        $this->score = $data->score;
    }

    public function add($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "INSERT INTO scoreboard (game_id, player_id, player_name, score) VALUES ($this->game_id, $this->player_id, $this->player_name, $this->score)";
        $stmt = $db->query($query);
        if (!$stmt){
            $result_query->error = "error at add new score : ".$stmt->error;
            $result_query->data = "not ok";
            $db->close();
        }

        $db->close();
        return $result_query;
    }
    
    public function one($db) {
        $result_query = new result_query();
        $one = new score();
        $query = "SELECT id, game_id, player_id, player_name, score FROM scoreboard WHERE id=$this->id LIMIT 1";
        $stmt = $db->query($query);
        if (!$stmt){
            $result_query->error = "error at query one game : ".$stmt->error;
            $db->close();
            return $result_query;
        }

        $result = mysqli_fetch_assoc($stmt);
        $one->id = (int) $result['id'];
        $one->game_id = (int) $result['game_id'];
        $one->player_id = $result['player_id'];
        $one->player_name = $result['player_name'];
        $one->score = (int) $result['score'];
        $result_query->data = $one;
        $db->close();
        return $result_query;
    }

    public function one_by_player_id($db) {
        $result_query = new result_query();
        $one = new score();
        $query = "SELECT id, game_id, player_id, player_name, score FROM scoreboard WHERE player_id = ? and game_id = ? LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('si', $this->player_id, $this->game_id);
        $stmt->execute();      
        if ($stmt->error != ""){
            $result_query-> error = "error at query one score : ".$stmt->error;
            $stmt->close();
            return $result_query;
        }
        $rows = $stmt->get_result();
        if($rows->num_rows == 0){
            $stmt->close();
            return $result_query;
        }
        $result = $rows->fetch_assoc();
        $one->id = (int) $result['id'];
        $one->game_id = (int) $result['game_id'];
        $one->player_id = $result['player_id'];
        $one->player_name = $result['player_name'];
        $one->score = (int) $result['score'];
        $result_query->data = $one;
        $stmt->close();
        return $result_query;
    }

    public function all($db,$list_query) {
        $result_query = new result_query();
        $all = array();
        $query = "SELECT 
                    id, game_id, player_id, player_name, score
                FROM 
                    scoreboard
                WHERE
                    ".$list_query->search_by." LIKE '%".$list_query->search_value."%'
                ORDER BY
                    ".$list_query->order_by." ".$list_query->order_dir." 
                LIMIT $list_query->limit OFFSET $list_query->offset";

        $stmt = $db->query($query);
        if (!$stmt){
            $result_query->error = "error at query one score : ".$stmt->error;
            $db->close();
            return $result_query;
        }

        if($stmt->num_rows == 0){
            $db->close();
            $result_query->data = $all;
            return $result_query;
        }

        while ($result = $stmt->fetch_array()){
            $one = new score();
            $one->id = (int) $result['id'];
            $one->game_id = (int) $result['game_id'];
            $one->player_id = $result['player_id'];
            $one->player_name = $result['player_name'];
            $one->score = (int) $result['score'];
            array_push($all,$one);
        }
        $result_query->data = $all;

        $db->close();
        return $result_query;
    }

    public function update($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "UPDATE scoreboard SET game_id = $this->game_id, player_id = $this->player_id, player_name = $this->player_name, score = $this->score WHERE id = $this->id";
        $stmt = $db->query($query);
        if (!$stmt){
            $result_query->error = "error at add new score : ".$stmt->error;
            $result_query->data = "not ok";
            $db->close();
        }

        $db->close();
        return $result_query;
    }
    
    public function delete($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "DELETE FROM scoreboard WHERE id = $this->id";
        $stmt = $db->query($query);
        if (!$stmt){
            $result_query->error = "error at add new score : ".$stmt->error;
            $result_query->data = "not ok";
            $db->close();
        }

        $db->close();
        return $result_query;
    }
}


?>
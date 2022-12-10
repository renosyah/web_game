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
        $query = "INSERT INTO scoreboard (game_id, player_id, player_name, score) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('issi', $this->game_id, $this->player_id, $this->player_name, $this->score);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error =  "error at add new score : ".$stmt->error;
            $result_query->data = "not ok";
        }
        $stmt->close();
        return $result_query;
    }
    
    public function one($db) {
        $result_query = new result_query();
        $one = new score();
        $query = "SELECT id, game_id, player_id, player_name, score FROM scoreboard WHERE id=? LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $this->id);
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
        $one->id = $result['id'];
        $one->game_id = $result['game_id'];
        $one->player_id = $result['player_id'];
        $one->player_name = $result['player_name'];
        $one->score = $result['score'];
        $result_query->data = $one;
        $stmt->close();
        return $result_query;
    }

    public function one_by_player_id($db) {
        $result_query = new result_query();
        $one = new score();
        $query = "SELECT id, game_id, player_id, player_name, score FROM scoreboard WHERE player_id = ? LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $this->player_id);
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
        $one->id = $result['id'];
        $one->game_id = $result['game_id'];
        $one->player_id = $result['player_id'];
        $one->player_name = $result['player_name'];
        $one->score = $result['score'];
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
                    ".$list_query->search_by." LIKE ?
                ORDER BY
                    ".$list_query->order_by." ".$list_query->order_dir." 
                LIMIT ? 
                OFFSET ?";
        $stmt = $db->prepare($query);
        $search = "%".$list_query->search_value."%";
        $offset = $list_query->offset;
        $limit =  $list_query->limit;
        $stmt->bind_param('sii',$search ,$limit, $offset);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query-> error = "error at query all score : ".$stmt->error;
            $stmt->close();
            return $result_query;
        }
        $rows = $stmt->get_result();
        if($rows->num_rows == 0){
            $stmt->close();
            $result_query->data = $all;
            return $result_query;
        }

        while ($result = $rows->fetch_assoc()){
            $one = new score();
            $one->id = $result['id'];
            $one->game_id = $result['game_id'];
            $one->player_id = $result['player_id'];
            $one->player_name = $result['player_name'];
            $one->score = $result['score'];
            array_push($all,$one);
        }
        $result_query->data = $all;
        $stmt->close();
        return $result_query;
    }

    public function update($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "UPDATE scoreboard SET game_id = ?, player_id = ?, player_name = ?, score = ? WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('issii', $this->game_id, $this->player_id, $this->player_name, $this->score, $this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at update one score : ".$stmt->error;
            $result_query->data = "not ok";
            $stmt->close();
            return $result_query;
        }
        $stmt->close();
        return $result_query;
    }
    
    public function delete($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "DELETE FROM scoreboard WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at delete one score : ".$stmt->error;
            $result_query->data = "not ok";
            $stmt->close();
            return $result_query;
        }
        $stmt->close();
        return $result_query;
    }
}


?>
<?php

include_once("result_query.php");

class game {
    public $id;
    public $game_name;
    public $game_description;
    public $game_url;

    public function __construct(){
    }

    public function set($data){
        $this->id = (int) $data->id;
        $this->game_name = $data->game_name;
        $this->game_description = $data->game_description;
        $this->game_url = $data->game_url;
    }

    public function add($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "INSERT INTO game (game_name, game_description, game_url) VALUES ($this->game_name, $this->game_description, $this->game_url)";
        $stmt = $db->query($query);
        if (!$stmt){
            $result_query->error = "error at add new game : ".$stmt->error;
            $result_query->data = "not ok";
            $db->close();
        }

        $db->close();
        return $result_query;
    }
    
    public function one($db) {
        $result_query = new result_query();
        $one = new game();
        $query = "SELECT id, game_name, game_description, game_url FROM game WHERE id=$this->id LIMIT 1";
        $stmt = $db->query($query);
        if (!$stmt){
            $result_query->error = "error at query one game : ".$stmt->error;
            $db->close();
            return $result_query;
        }

        $result = mysqli_fetch_assoc($stmt);
        $one->id = $result['id'];
        $one->game_name = $result['game_name'];
        $one->game_description = $result['game_description'];
        $one->game_url = $result['game_url'];
        $result_query->data = $one;

        $db->close();
        return $result_query;
    }

    public function all($db,$list_query) {
        $result_query = new result_query();
        $all = array();
        $query = "SELECT 
                    id, game_name, game_description, game_url
                FROM 
                    game
                WHERE
                    ".$list_query->search_by." LIKE '%".$list_query->search_value."%'
                ORDER BY
                    ".$list_query->order_by." ".$list_query->order_dir." 
                LIMIT $list_query->limit OFFSET $list_query->offset";

        $stmt = $db->query($query);
        if (!$stmt){
            $result_query->error = "error at query one game : ".$stmt->error;
            $db->close();
            return $result_query;
        }

        if($stmt->num_rows == 0){
            $db->close();
            $result_query->data = $all;
            return $result_query;
        }

        while ($result = $stmt->fetch_array()){
            $one = new game();
            $one->id = $result['id'];
            $one->game_name = $result['game_name'];
            $one->game_description = $result['game_description'];
            $one->game_url = $result['game_url'];
            array_push($all,$one);
        }

        $result_query->data = $all;

        $db->close();
        return $result_query;
    }

    public function update($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "UPDATE game SET game_name = $this->game_name, game_description = $this->game_description, game_url = $this->game_url WHERE id = $this->id";
        $stmt = $db->query($query);
        if (!$stmt){
            $result_query->error = "error at update game : ".$stmt->error;
            $result_query->data = "not ok";
            $db->close();
        }

        $db->close();
        return $result_query;
    }
    
    public function delete($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "DELETE FROM game WHERE id = $this->id";
        $stmt = $db->query($query);
        if (!$stmt){
            $result_query->error = "error at update game : ".$stmt->error;
            $result_query->data = "not ok";
            $db->close();
        }

        $db->close();
        return $result_query;
    }
}


?>
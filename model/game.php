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
        $query = "INSERT INTO game (game_name, game_description, game_url) VALUES (?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sss', $this->game_name, $this->game_description, $this->game_url);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error =  "error at add new game : ".$stmt->error;
            $result_query->data = "not ok";
        }
        $stmt->close();
        return $result_query;
    }
    
    public function one($db) {
        $result_query = new result_query();
        $one = new game();
        $query = "SELECT id, game_name, game_description, game_url FROM game WHERE id=? LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();      
        if ($stmt->error != ""){
            $result_query-> error = "error at query one game : ".$stmt->error;
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
        $one->game_name = $result['game_name'];
        $one->game_description = $result['game_description'];
        $one->game_url = $result['game_url'];
        $result_query->data = $one;
        $stmt->close();
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
            $result_query-> error = "error at query all game : ".$stmt->error;
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
            $one = new game();
            $one->id = $result['id'];
            $one->game_name = $result['game_name'];
            $one->game_description = $result['game_description'];
            $one->game_url = $result['game_url'];
            array_push($all,$one);
        }
        $result_query->data = $all;
        $stmt->close();
        return $result_query;
    }

    public function update($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "UPDATE game SET game_name = ?, game_description = ?, game_url = ? WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sssi', $this->game_name, $this->game_description, $this->game_url, $this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at update one game : ".$stmt->error;
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
        $query = "DELETE FROM game WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at delete one game : ".$stmt->error;
            $result_query->data = "not ok";
            $stmt->close();
            return $result_query;
        }
        $stmt->close();
        return $result_query;
    }
}


?>
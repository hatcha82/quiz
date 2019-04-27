<?php
error_reporting(0);
    include_once("db_config.php");
    function getConnection(){
        $conn = new mysqli(DBCONNECTIP, DBUSER, DBPASSWD, DBNAME);
        

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $conn->set_charset("utf8");

        return $conn;
    }
    function transaction($sqlArray){
        $conn = getConnection();
        
        $all_query_ok=true; // our control variable 

        //we make 4 inserts, the last one generates an error 
        //if at least one query returns an error we change our control variable 
        foreach ($sqlArray as $sql) {
            $conn->query($sql) ? null : $all_query_ok=false; 
        }
        
        //now let's test our control variable 
        $result = '';
        
        if($all_query_ok){
            $result = "true";
            $conn->commit();
        }else{
            $result = "false";
            $conn->rollback(); 
        }
        $conn->close(); 
        return $result;
    
    }
    

    function delete($sql){
        $conn = getConnection();
        if ($conn->query($sql) === TRUE) {
            return $conn->affected_rows;
        } else {
            return null;
        }
        $conn->close();
    }
    function update($sql){
        $conn = getConnection();
        if ($conn->query($sql) === TRUE) {
            return $conn->affected_rows;
        } else {
            return null;
        }
        $conn->close();
    }
    function insert($sql){
        $conn = getConnection();
        if ($conn->query($sql) === TRUE) {
            return $conn->insert_id;
        } else {
            return null;
        }
        $conn->close();
    }
    function getList($sql){
          
        $conn = getConnection();
       
        $result = $conn->query($sql);
        
        $list = array();
        if ($result->num_rows > 0) {
            
            //output data of each row
            while($obj=mysqli_fetch_object($result)){
            //     echo "id: " . $row["id"]. " - Name: " . $row["userid"]. " " . $row["userid"]. "<br>";
                $list.array_push($list, $obj);
            }
        }
        $conn->close();
        return $list;
        
    }
    function getListWithJSON($sql){
          
        $conn = getConnection();
       
        $result = $conn->query($sql);
        $conn->close();
        $list = array();
        if ($result->num_rows > 0) {
            
            //output data of each row
            while($obj=mysqli_fetch_object($result)){
            //     echo "id: " . $row["id"]. " - Name: " . $row["userid"]. " " . $row["userid"]. "<br>";
                @$list.array_push($list, $obj);
            }
        }

        return json_encode($list,JSON_UNESCAPED_UNICODE);
        
    }

?>
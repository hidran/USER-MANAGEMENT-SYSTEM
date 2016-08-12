<?php
require_once 'connection.php';

function getFromGet($param,  $default= null, $type ='string'){
    
    if($type === 'int'){
      $param = filter_input(INPUT_GET, $param, FILTER_SANITIZE_NUMBER_INT)  ;
    } else {
        $param = filter_input(INPUT_GET, $param, FILTER_SANITIZE_STRING)  ;
    }
    
    $ret = $param? $param : $default;
   
  
    
    return $ret;
}
function getRandName() {

    $names = ['ROBERTO', 'GIOVANNI', 'GIULIA', 'TED', 'JOHN'];
    $lastnames = ['SMITH', 'RE', 'ROSSI', 'ARIAS', 'MENDOZA', 'CRUZ', 'WILDE'];
    return $names[mt_rand(0, count($names) - 1)] . ' ' . $lastnames[mt_rand(0, count($names) - 1)];
}

function getRandEmail( $name) {
     $domains = ['google.com', 'yahoo.com', 'hotmail.it','libero.it'];
  

    $str = strtolower(str_replace(' ','.',$name)).'.'.mt_rand(11, 99).'@'.$domains[mt_rand(0, count($domains) - 1)] ;
    return $str;
}
function getRandFiscalcode() {
    $i = 16;
    $res = '';
    while ($i > 0) {
        $res .=chr(mt_rand(97, 122));
        $i--;
    }
    return strtoupper($res);
}
function insertRandUsers($tot, mysqli $mysqli) {
    $fiscalcodes = [];
     $emails = [];
     $fiscalcode = $email = '';
    for ($i = 0; $i < $tot; $i++) {
        
        do{
            $fiscalcode = getRandFiscalcode();
        } while (in_array($fiscalcode, $fiscalcodes));
        
        $fiscalcodes[] = $fiscalcode;
        
        $name = getRandName();
        
        $age = mt_rand(18, 99);
        
        do{
            $email = getRandEmail( $name);
        } while (in_array($email, $emails));
       
        $emails[] = $email;
        $query = "INSERT INTO users (id, username,age,fiscalcode,email) VALUES (NULL, '$name', $age,'" . $fiscalcode . "','$email')";
        $res = $mysqli->query($query);
        if (!$res) {
            echo('<br>Error' . $mysqli->error);
        } else {
            echo $mysqli->affected_rows . ' created';
        }
    }
  
}

  function getUsers(array $params){
      
       $mysqli = $GLOBALS['mysqli'];
         $records = [];
         
         $orderBy = $params['orderBy'];
         $orderBy =  $mysqli->escape_string($orderBy);
         $orderDir = $params['orderDir'];
         $orderDir =  $mysqli->escape_string($orderDir);
         $start = (int)$params['start'];
         $limit = (int)$params['limit'];
       
          
          $where = '';
         $whereParam = !empty($params['search'])? $params['search'] : '';
          
         if($whereParam){
             
             $whereParam = $mysqli->escape_string($whereParam);
             
             $where = " WHERE username like '%$whereParam%' OR ";
             $where .= " fiscalcode like '%$whereParam%' OR ";
             $where  .= "email like '$whereParam%' OR ";
             $where  .= "age =".((int)$whereParam);
             $where  .= " OR id =".((int)$whereParam);
         }
        
        $sql ="SELECT * FROM users $where ORDER BY $orderBy $orderDir LIMIT $start,$limit";
        echo $sql;
        $result = $mysqli->query($sql);
        if($result && $result->num_rows){
            $records =  $result->fetch_all(MYSQLI_ASSOC);
           
        }
        return $records;
        
    }
    
    
  function getTotalUsers(array $params){
      
       $mysqli = $GLOBALS['mysqli'];
       
        $totalRecords =0;
         
        
          
          $where = '';
         $whereParam = !empty($params['search'])? $params['search'] : '';
          
         if($whereParam){
             
             $whereParam = $mysqli->escape_string($whereParam);
             
             $where = " WHERE username like '%$whereParam%' OR ";
             $where .= " fiscalcode like '%$whereParam%' OR ";
             $where  .= "email like '$whereParam%' OR ";
             $where  .= "age =".((int)$whereParam);
             $where  .= " OR id =".((int)$whereParam);
         }
        
        $sql ="SELECT COUNT(*) AS total FROM users $where";
        //echo $sql;
        $result = $mysqli->query($sql);
        if($result && $result->num_rows){
           $row  = $result->fetch_assoc();
              $totalRecords = $row['total'];
           
        }
        return $totalRecords;
    }
    function deleteRecord($id){
         $id = (int) $id;
         if(!$id){
             return false;
         }
         
        $sql = 'DELETE FROM users where id='.($id);
       // echo $sql;
       
        $ret = $GLOBALS['mysqli']->query($sql);
        return  $GLOBALS['mysqli']->affected_rows;
    }
    function getUser($id){
          $result = [];
         $id = (int) $id;
         $sql = 'SELECT * FROM users where id='.$id;
          $res = $GLOBALS['mysqli']->query($sql);
           if($res && $res->num_rows){
               $result = $res->fetch_assoc();
           }
           return $result;
    }
    function updateuser(array $array){
        var_dump($array);
        $mysqli = $GLOBALS['mysqli'];
         $id = (int)$array['id'];
         $username = $mysqli->escape_string($array['username']);
         $fiscalcode = $mysqli->escape_string($array['fiscalcode']);
         $email = $mysqli->escape_string($array['email']);
          $age = (int)$array['age'];
          
        
         $sql = "UPDATE users set username='$username', fiscalcode='$fiscalcode'";
         $sql .=" , age=$age, email ='$email' WHERE ID=$id";
          $mysqli->query($sql);
            echo $sql;
          return $mysqli->affected_rows;
       
    }
    
      function insertUser(array $array){
        var_dump($array);
        $mysqli = $GLOBALS['mysqli'];
        
         $username = $mysqli->escape_string($array['username']);
         $fiscalcode = $mysqli->escape_string($array['fiscalcode']);
         $email = $mysqli->escape_string($array['email']);
          $age = (int)$array['age'];
          
        
         $sql = "INSERT INTO users (username,email,age, fiscalcode)";
         $sql .=" values('$username','$email' ,$age ,'$fiscalcode')";
       
          $mysqli->query($sql);
            echo $sql;
          return $mysqli->affected_rows;
       
    }
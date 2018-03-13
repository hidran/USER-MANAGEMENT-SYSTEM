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
         
         $orderBy = $params['orderBy']? $params['orderBy'] : 'ID';
         $orderBy =  $mysqli->escape_string($orderBy);
         $orderDir = $params['orderDir']?$params['orderDir'] :'DESC';
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
      //  echo $sql;
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
         $user = getUser($id);
        $ret = $GLOBALS['mysqli']->query($sql);
        $result =  $GLOBALS['mysqli']->affected_rows;
        if($result && file_exists(AVATAR_DIR.$user['avatar'])){
            unlink(AVATAR_DIR.$user['avatar']);
        }
        return  $result;
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
        //var_dump($array);
        $mysqli = $GLOBALS['mysqli'];
         $id = (int)$array['id'];
         $username = $mysqli->escape_string($array['username']);
         
         $fiscalcode = $mysqli->escape_string($array['fiscalcode']);
         
         $email = $mysqli->escape_string($array['email']);
         
          $age = (int)$array['age'];
        $passwordhash = '';
          if($array['password']){
              $passwordhash = password_hash($array['password'], PASSWORD_DEFAULT);
          }
      
         
        $roletype  =  in_array($array['roletype'], getRoles()) ? $array['roletype'] : 'user'; 
         $sql = "UPDATE users set username='$username', fiscalcode='$fiscalcode'";
         $sql .=" , age=$age, email ='$email'";
          if($passwordhash){
              $sql .=", password='$passwordhash'";
          }
    
        $sql .= ",roletype='$roletype'  WHERE ID=$id";
       // die($sql);
          $mysqli->query($sql);
           // echo $sql;
          return $mysqli->affected_rows;
       
    }
     function copyAvatar($userid){
        set_time_limit(0);
        $res = [
            'success' => false,
            'message' => 'Problemi salvando immagine'
        ];
         if(empty($_FILES)){
             $res['message'] = 'Nessun file caricato';
             return $res;
         }
         if($_FILES['avatar']['error']){
            return $res;
         }
         if($_FILES['avatar']['size']> MAX_FILE_SIZE){
             $res['message'] = 'Il file supera '.MAX_FILE_SIZE . ' bytes';
             return $res;
         }
         if($_FILES['avatar']['type'] !='image/jpeg'){
             $res['message'] = 'Il file non è jpeg';
             return $res;
         }
         $imgResource = imagecreatefromjpeg($_FILES['avatar']['tmp_name']);
       list($orig_w, $orig_h) =   getimagesize($_FILES['avatar']['tmp_name']);
       $rationOrg = $orig_w/$orig_h;
         $rationThumb = THUMB_MAX_FILE_WIDTH/THUMB_MAX_FILE_HEIGHT;
          $calcWith = THUMB_MAX_FILE_WIDTH;
          $calcHeight = THUMB_MAX_FILE_HEIGHT;
         if($rationThumb > $rationOrg){
             $calcWith = $calcWith*$rationOrg;  
         } else {
             $calcHeight =  $calcWith/ $rationOrg;
         }
         $scaleImg = imagescale($imgResource, $calcWith, $calcHeight);
         $avatarname =  $userid.'.jpg';
        $result =  imagejpeg($scaleImg, AVATAR_DIR.$avatarname);
         $scaleImg = imagescale($imgResource, BIG_MAX_FILE_WIDTH, BIG_MAX_FILE_HEIGHT);
         $avatarnameBIG =  $userid.'_BIG.jpg';
         $result =  imagejpeg($scaleImg, AVATAR_DIR.$avatarnameBIG);
        if(!$result){
            $res['message'] ='Impossibile salvare miniatura';
            return $res;
        }
        $res['success'] = true;
        $res['message'] ='Immagine caricata';
        $sql = "UPDATE users set avatar='$avatarname' where id=$userid";
        $GLOBALS['mysqli']->query($sql);
        return $res;
     }
      function insertUser(array $array){
        //var_dump($array);
        $mysqli = $GLOBALS['mysqli'];
        
         $username = $mysqli->escape_string($array['username']);
         $fiscalcode = $mysqli->escape_string($array['fiscalcode']);
         $email = $mysqli->escape_string($array['email']);
          $age = (int)$array['age'];
          $password = $array['password'] ?? 'testpassword';
        
           $passwordhash = password_hash($password, PASSWORD_DEFAULT);
       


          $roletype  =  in_array($array['roletype'], getRoles()) ? $array['roletype'] : 'user';

          $sql = "INSERT INTO users (username,email,age, fiscalcode, password, roletype)";
         $sql .=" values('$username','$email' ,$age ,'$fiscalcode','$passwordhash','$roletype')";
        
          $res = $mysqli->query($sql);
        if(!$res){
            die($mysqli->error);
        }
          return $mysqli->affected_rows;
       
    }

function verifyUserData($email, $password, $token){
    $result = [
        'message' => 'User logged in',
        'success' => true
    ];
    //echo $token .'='.$_SESSION['token'];
    if($token !== $_SESSION['token']){
        $result['message'] = 'Token mismacth';
        $result['success'] = false;
        return $result;
    }

    $correctEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    // var_dump($correctEmail);
    if(!$correctEmail){
        $result['message'] = '1 Wrong email or password ';
        $result['success'] = false;
        return $result;
    }

    //var_dump($password);
    if(strlen($password) < 6){
        $result['message'] = '2 Wrong email or password ';
        $result['success'] = false;
        return $result;
    }
    return $result;
}

function getUserByEmail(string $email){
    $result = [];
    $email = mysqli_escape_string( $GLOBALS['mysqli'], $email);
    
    $sql = "SELECT * FROM users where email = '$email'";
  //  echo $sql;
    $res = $GLOBALS['mysqli']->query($sql);
    if($res && $res->num_rows){
        $result = $res->fetch_assoc();
    }
    return $result;
}

function isUserLoggedin(){
    
    return !empty($_SESSION['userData']);
}
function getUserRole(){
    return $_SESSION['userData']['roletype'];
}
function isAdmin(){
    return $_SESSION['userData']['roletype'] == 'admin';
}
function isEditor(){
    return $_SESSION['userData']['roletype'] == 'editor';
}
function userCanModify(){
    return in_array($_SESSION['userData']['roletype'] ,['editor','admin']);
}
function userCanDelete(){
    return isAdmin();
}
function getUserFullName(){
    if(isUserLoggedin()){
        return $_SESSION['userData']['username'];
    }
}
function logoutUser(){
   
    session_destroy();
}
function verifyLogin(){
    if(empty($_SESSION['userData'])){
        header('Location: login.php');
        exit;
    }
}
function getRoles(){
    
     return ['user','editor', 'admin'];
}
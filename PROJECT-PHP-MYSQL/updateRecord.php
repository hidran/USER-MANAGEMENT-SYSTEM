<?php
session_start();
require_once 'functions.php';
verifyLogin();
$action = $_REQUEST['action'];

$id = !empty($_REQUEST['id'])?$_REQUEST['id'] : 0;


$arrParams = $_GET;
unset($arrParams['action']);
unset($arrParams['id']);
$qString = http_build_query($arrParams, '', '&amp;');




switch ($action) {
    case 'delete':
        $result = deleteRecord($id);
        $qString = str_replace('&amp;', '&', $qString);
        $message = $result ? 'RECORD CANCELLATO CORRETTAMENTE' : 'PROBLEMI CANCELLANDO RECORD';
        $url = "index.php?success=$result&message=" . urlencode($message) . '&' . $qString;
         header("Location:$url");
        break;
    case 'update':
        $row = getUser($id);
        if ($row) {
            require_once 'header.php';
            $search = getFromGet('search', '');
            require_once 'navbar.php';
            require_once 'formUpdate.php';
            require_once 'footer.php';
        }
        break;
         case 'insert':
             $row = [
                 'id' =>'',
                 'fiscalcode' =>'',
                 'email' =>'',
                 'age'=>'',
                 'username' => '',
                 'avatar'=> ''
             ];
        
            require_once 'header.php';
            $search = getFromGet('search', '');
            require_once 'navbar.php';
            require_once 'formUpdate.php';
            require_once 'footer.php';
       
        break;
    
    case 'updateRecord':


        $result = updateuser($_POST);
     
        $res =  copyAvatar($_POST['id']);
       
        $qString = str_replace('&amp;', '&', $qString);
       
        $message = ($result || $res['success'] )? 'RECORD AGGIORNATO CORRETTAMENTE' : 'PROBLEMI AGGIORNANDO RECORD';
        $url = "index.php?success=".($result || $res['success'])." &message=" . urlencode($message) . '&' . $qString;

        header("Location:$url");

        break;
    case 'insertRecord':


        $result = insertUser($_POST);
        if($result){
           $res =  copyAvatar($mysqli->insert_id);
           if($res['success']){
               
           }
        } else {
            die($mysqli->error);
        }
        $qString = str_replace('&amp;', '&', $qString);
        $message = $result ? 'RECORD INSERITO CORRETTAMENTE' : 'PROBLEMI INSERENDO RECORD';
        $url = "index.php?success=$result&message=" . urlencode($message) . '&' . $qString;

        header("Location:$url");

        break;
}


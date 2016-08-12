<?php

require_once 'functions.php';

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
        $url = "index.php?sucess=$result&message=" . urlencode($message) . '&' . $qString;
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
                 'username' => ''
             ];
        
            require_once 'header.php';
            $search = getFromGet('search', '');
            require_once 'navbar.php';
            require_once 'formUpdate.php';
            require_once 'footer.php';
       
        break;
    
    case 'updateRecord':


        $result = updateuser($_POST);
        $qString = str_replace('&amp;', '&', $qString);
        $message = $result ? 'RECORD AGGIORNATO CORRETTAMENTE' : 'PROBLEMI AGGIORNANDO RECORD';
        $url = "index.php?sucess=$result&message=" . urlencode($message) . '&' . $qString;

        header("Location:$url");

        break;
    case 'insertRecord':


        $result = insertUser($_POST);
        $qString = str_replace('&amp;', '&', $qString);
        $message = $result ? 'RECORD INSERITO CORRETTAMENTE' : 'PROBLEMI INSERENDO RECORD';
        $url = "index.php?sucess=$result&message=" . urlencode($message) . '&' . $qString;

        header("Location:$url");

        break;
}


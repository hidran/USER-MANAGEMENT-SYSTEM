<?php
session_start();
require_once 'functions.php';
verifyLogin();

if(!empty($_GET['logout'])){
    logoutUser();
    header('Location: login.php');
}
$userRole = getUserRole();
if($userRole == 'user'){
    header('Location: login.php');
    exit;
}
$recordPerPage = $search = '';


$search = getFromGet('search', '');

require_once 'header.php';
require_once 'navbar.php';
//$_GET

$orderBy = getFromGet('orderBy', 'id');

$orderBy = in_array($orderBy, $orderByColumns) ? $orderBy : 'id';

$orderDir = getFromGet('orderDir', 'ASC');

$recordPerPage = getFromGet('recordPerPage', 10, 'int');

 $page = getFromGet('page', 0,'int');

$start = ($page-1)*$recordPerPage;
 if($start <0 ){
     $start = 0;
 }
$params = [
    'orderBy' => $orderBy,
    'orderDir' => $orderDir,
    'start' => $start,
    'limit' => $recordPerPage,
    'search' => $search
];

$totalRecords =  getTotalUsers(['search' => $search]);

$users = getUsers($params);

$numPages = ceil($totalRecords/$recordPerPage);

$paginatorParams = http_build_query($params, '', '&amp;').'&amp;recordPerPage='.$recordPerPage;



$orderParam = $orderDir === 'ASC' ? 'DESC' : 'ASC';

$sorterArray = [
  
    'orderDir' => $orderParam,
    'start' => $start,
    'limit' => $recordPerPage,
    'search' => $search,
    'recordPerPage' => $recordPerPage
];

$sorterParams = http_build_query($sorterArray, '', '&amp;');
$message = getFromGet('message');
 if($message) :

    $success = getFromGet('success');
    $class = $success ? 'alert-success' : 'alert-danger';
    ?>
    <div class="alert <?= $class ?> alert-dismissible" role="alert">
        <h2><?= strip_tags($message) ?></h2>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
   

     <?php
     
 endif;
require_once 'users-list.php';
require_once 'footer.php';


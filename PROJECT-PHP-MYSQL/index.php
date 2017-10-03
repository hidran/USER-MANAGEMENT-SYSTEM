<?php
//error_reporting(0);
$recordPerPage = $search = '';
require_once 'functions.php';

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
?>

<table class="table table-striped" id="table-users">
    <thead>
       
        <tr>
            <th<?=$orderBy ==='id'? " class=\"$orderDir\"":''?>>
                <a href="index.php?orderBy=id&amp;<?= $sorterParams ?>">ID</a>
            </th>
            <th<?=$orderBy ==='username'? " class=\"$orderDir\"":''?>>
                <a href="index.php?orderBy=username&amp;<?= $sorterParams ?>">USER NAME</a>
            </th>
            <th>Avatar</th>
            <th<?=$orderBy ==='fiscalcode'? " class=\"$orderDir\"":''?>>
                <a href="index.php?orderBy=fiscalcode&amp;<?= $sorterParams ?>">FISCAL CODE</a>
            </th>
            <th<?=$orderBy ==='email'? " class=\"$orderDir\"":''?>>
                <a href="index.php?orderBy=email&amp;<?= $sorterParams ?>">EMAIL</a>
            </th>
            <th<?=$orderBy ==='age'? " class=\"$orderDir\"":''?>>
                <a href="index.php?orderBy=age&amp;<?= $sorterParams ?>">AGE</a>
            </th>
            <th>AZIONE</th>
        </tr>
         <tr> <td class="text-success text-muted text-xs-center" colspan="6">
                Record trovati <?=$totalRecords?>
                Num pages = <?=$numPages?>
            </td>
        </tr>
    </thead>  

    <?php if ($users) : ?>
        <tbody>
            <?php foreach ($users as $user) : ?>

                <tr>
                    <td>
                        <?= $user['id'] ?> 
                    </td>
                    <td>
                        <?= $user['username'] ?>   
                    </td>
                    <td>
                        <?php
                        if($user['avatar'] && file_exists(AVATAR_DIR.$user['avatar'])){ ?>
                            <img class="avatar" src="<?=AVATAR_DIR.$user['avatar']?>" alt="<?=$user['avatar']?>">
                      <?php 
                        }
                        ?>
                    </td>
                    <td>
                        <?= $user['fiscalcode'] ?>      
                    </td>
                    <td>
                        <a href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a>  
                    </td>
                    <td>
                        <?= $user['age'] ?>   
                    </td>
                    <td class="p-a-0 text-sm-left">
                        <a class="btn btn-success btn-sm" href="updateRecord.php?action=update&amp;id=<?=$user['id']?>&amp;<?=$paginatorParams?>&amp;page=<?=$page?>">
                            <i class="fa fa-pencil-square"></i>&nbsp;MODIFICA
                        </a>
                        <a onclick="return confirm('Vuoi eliminare il recod?')" class="btn btn-danger btn-sm" href="updateRecord.php?action=delete&amp;id=<?=$user['id']?>&amp;<?=$paginatorParams?>&amp;page=<?=$page?>">
                            <i class="fa fa-trash"></i>&nbsp;ELIMINA
                        </a>
  
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr><td colspan="3" class="text-xs-center">
             <?php     
             require_once 'navigator.php';
             ?>
                    </td>
                    <td colspan="3" class="text-info text-xl-left">
                        <?php
                        $recordsDi = $page*$recordPerPage;
                         if($recordsDi> $totalRecords){
                             $recordsDi = $totalRecords;
                         }
                        ?>
                        <?=$recordsDi?> records di <?=$totalRecords?>
                    </td>
                </tr>
            </tfoot>
        <?php
        else : ?>
        <tr><th class="text-info text-xs-center" colspan="6"><h3>Nessun record trovato!</h3></th></tr>
        <?php
        
    endif;
    ?>

</table>
<?php
require_once 'footer.php';


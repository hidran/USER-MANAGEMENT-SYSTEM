<nav class="navbar navbar-expand-lg  fixed-top navbar-dark bg-dark">
    <a class="navbar-brand" href="#"><i class="fa fa-user fa-2x"></i></a>
    <div class="navbar-nav mr-auto">
        <a class="nav-item nav-link <?= stristr($_SERVER['PHP_SELF'],'index.php')?'active':''?>" href="index.php">
           <i class="fa fa-users fa-1x"></i>
            ELENCO UTENTI
        </a>
       <a   class="<?=  stristr($_SERVER['PHP_SELF'],'updateRecord.php')?'active':''?> nav-item  nav-link" href="updateRecord.php?action=insert">
         <i class="fa fa-user-plus"></i>  NUOVO UTENTE
       </a>
   </div>  
    <?php
      $recordPerPage = filter_input(INPUT_GET, 'recordPerPage', FILTER_VALIDATE_INT);
    ?>
    <form method="GET" class="form-inline pull-xs-right" action="index.php">
        <span>Mostra</span> 
        <select class="form-control" id="recordPerPage" name="recordPerPage">
             <option <?=$recordPerPage === 5?'selected':''?> value="5">5</option>
           <option <?=$recordPerPage === 10?'selected':''?> value="10">10</option>
             <option  <?=$recordPerPage === 20?'selected':''?>  value="20">20</option>
              <option  <?=$recordPerPage === 30?'selected':''?>  value="30">30</option>
                <option  <?=$recordPerPage === 40?'selected':''?>  value="40">40</option>
               <option  <?=$recordPerPage === 50?'selected':''?>   value="50">50</option>
                <option  <?=$recordPerPage === 100?'selected':''?>   value="100">100</option>
        </select>
      
        <input type="search" value="<?= $search ?>" name="search" id="search" class="form-control" placeholder="parametro">
        
   
        <button   tabindex="1" class="btn btn-primary">
            <i class="fa fa-search fa-fw"></i>CERCA</button>
            <button  onclick = "location.href='index.php'" class="btn  btn-outline-danger" type="reset" name="reset" id="reset"> 
                <i class="fa fa-eraser  fa-fw"></i>REIMPOSTA
            </button>
    </form>
    <?php if (isUserLoggedin()){ ?>
        <ul class="nav">
        <li class="nav-item"><?=getUserFullName()?></li>
            <li  class="nav-item"><a href="index.php?logout=1">Logout</a></li>
        </ul>
    <?php } ?>
    
</nav>
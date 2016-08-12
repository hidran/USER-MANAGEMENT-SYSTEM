<?php

if(!$page){
    $page = 1;
}
$numPagesNavigator = $config['numPagesNavigator']; 
?>
<nav class="nav nav-inline ">
    <ul   class="pagination">
    <?php
     $i = ($page - $numPagesNavigator) > 0 ? ($page - $numPagesNavigator) : 1; 
     
       if($i<2) :?>
   <li class="page-item"> <span class="page-link">&lt; &lt; &lt;&nbsp;&nbsp;</span></li>
    <?php
    else : ?>
     <li class="page-item"><a class="page-link" href="?<?=$paginatorParams?>&amp;page=<?=$i-1?>">&lt; &lt; &lt;</a></li>
    <?php
        
        
    endif;
    
        
      for( ; $i < $page ; $i++) : 
          
          ?>
        <li class="page-item"><a class="page-link" href="?<?=$paginatorParams?>&amp;page=<?=$i?>"><?=$i?></a></li>   
     <?php
      endfor;
   
    ?>
   <li class="page-item active"> <span class="page-link"><?=$page?></span></li>
    <?php
      for($i = $page +1; $i < $page + ($numPagesNavigator+1) ; $i++) : 
            if($i> $numPages){
                break;
            }
          
          ?>
        <li class="page-item"> <a class="page-link" href="?<?=$paginatorParams?>&amp;page=<?=$i?>"><?=$i?></a></li>   
     <?php
      endfor;
       if ($i <= $numPages) : ?>
        <li class="page-item"> <a class="page-link" href="?<?=$paginatorParams?>&amp;page=<?=$i?>">&gt;&gt;&gt;</a></li>  
        
          <?php
          else : ?>
        <li class="page-item"> <span class="page-link"> &nbsp;&nbsp;&gt;&gt;&gt;</span></li>
        <?php
       endif;
    ?>
        </ul>
</nav>

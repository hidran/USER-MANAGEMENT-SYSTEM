
<table class="table table-striped" id="table-users">
    <thead>

    <tr>
        <th<?=$orderBy ==='id'? " class=\"$orderDir\"":''?>>
            <a href="index.php?orderBy=id&amp;<?= $sorterParams ?>">ID</a>
        </th>
        <th<?=$orderBy ==='username'? " class=\"$orderDir\"":''?>>
            <a href="index.php?orderBy=username&amp;<?= $sorterParams ?>">USER NAME</a>
        </th>
        <th<?=$orderBy ==='username'? " class=\"$orderDir\"":''?>>
            <a href="index.php?orderBy=roletype&amp;<?= $sorterParams ?>">ROLE</a>
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
                    <?= $user['roletype'] ?>
                </td>
                <td>

                    <?php


                    if($user['avatar'] && file_exists(AVATAR_DIR.$user['avatar'])){
                        $bigImg = str_replace('.jpg','_Big.jpg', $user['avatar']);
                        ?>

                        <a class="thumbnail" href="#thumb"> <img class="thumbnail" src="<?=AVATAR_DIR.$user['avatar']?>" alt="<?=$user['avatar']?>"><span>

                                   <img src="<?=AVATAR_DIR.$bigImg?>"> </span></a>



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
                    <?php if (userCanModify()){?>
                    <a class="btn btn-success btn-sm"
                       href="updateRecord.php?action=update&amp;id=<?= $user['id'] ?>&amp;<?= $paginatorParams ?>&amp;page=<?= $page ?>">
                        <i class="fa fa-pencil-square"></i>&nbsp;MODIFICA
                    </a>
                    <?php 
                    }
                    if(userCanDelete()){
                    ?>
                    
                    <a onclick="return confirm('Vuoi eliminare il recod?')" class="btn btn-danger btn-sm" href="updateRecord.php?action=delete&amp;id=<?=$user['id']?>&amp;<?=$paginatorParams?>&amp;page=<?=$page?>">
                        <i class="fa fa-trash"></i>&nbsp;ELIMINA
                    </a>
                <?php } ?>
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
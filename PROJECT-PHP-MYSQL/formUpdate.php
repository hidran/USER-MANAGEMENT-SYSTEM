

<form enctype="multipart/form-data" style="z-index: 20" id="formUpdate" action="updateRecord.php?<?= $qString ?>" method="POST">


    <input type="hidden" name="action" id="action" value="<?= $id?'updateRecord':'insertRecord'?>">
        
    <input type="hidden" name="id" id="id" value="<?= $row['id'] ?>">
    <div class="input-group margin-bottom-sm">

        <span class="input-group-addon"><i class="fa fa-user fa-fw" aria-hidden="true"></i></span>
        <input title="Nome utente" placeholder="Nome utente" pattern="[a-zA-Z0-9]-\.\$]{6:128}" type="text" name="username"  class="form-control" value="<?= $row['username'] ?>" id="username" required>
    </div>
    <div class="input-group margin-bottom-sm">

        <span class="input-group-addon"><i class="fa fa-calendar fa-fw" aria-hidden="true"></i></span>

        <input type="number" title="Inserire età " placeholder="Inserire età" name="age" id="age" size="2" class="form-control" value="<?= $row['age'] ?>"  required min="18" max="99" maxlength="2">
    </div>
    <div class="input-group margin-bottom-sm">
        <span class="input-group-addon"><i class="fa fa-credit-card fa-fw" aria-hidden="true"></i></span>

        <input type="text" pattern="[A-Z0-9]{16}" name="fiscalcode" title="Inserire codice fiscale" placeholder="Inserire codice fiscale"  size="16" class="form-control"  value="<?= $row['fiscalcode'] ?>"  id="fiscalcode" maxlength="16" minlength="16" required>
    </div>
    <div class="input-group margin-bottom-lg">
        <span class="input-group-addon"><i class="fa fa-envelope fa-fw" aria-hidden="true"></i></span>


        <input type="email" name="email" title="Inserire email" placeholder="Inserire email"  class="form-control"  value="<?= $row['email'] ?>"  id="email"  required>
    </div>
    <div class="input-group margin-bottom-lg">
        <span class="input-group-addon"><i class="fa fa-key fa-fw" aria-hidden="true"></i></span>


        <input type="text" name="password" title="Inserire password" placeholder="Inserire password"  class="form-control"  value=""  id="password">
    </div>
    <div class="input-group margin-bottom-lg">
        <span class="input-group-addon"><i class="fa fa-users fa-fw" aria-hidden="true"></i></span>
    
        <select name="roletype" class="form-control" id="roletype" required>
            <?php
            $roletype = $row['roletype']? : 'user';
            foreach (getRoles() as $role){
                $selected = $role == $roletype?'selected': '';
                echo "<option $selected value='$role'>$role</option>";
            }
            ?>
            ?>
        </select>
    </div>
    <div class="form-group">
        <img width="<?=THUMB_MAX_FILE_HEIGHT?>"  height="<?=THUMB_MAX_FILE_HEIGHT?>"
                id="thumbnail" src="<?=empty($row['avatar'])?'images/placeholder.jpg' : AVATAR_DIR.$row['avatar']?>">
    </div>
    <div class="input-group margin-bottom-lg">
        <span class="input-group-addon"><i class="fa fa-image fa-fw" aria-hidden="true"></i></span>

        <input type="hidden" name="MAX_FILE_SIZE" value="<?=MAX_FILE_SIZE?>" />

        <input  onchange="previewFile(this)" type="file" name="avatar" title="Inserire avatar" placeholder="Inserire avatar"  class="form-control"  value="<?= $row['avatar'] ?>"  id="avatar" accept="image/jpeg">
    </div>
    <div class="form-group">
        <div class="row">
            <?php if ($id && userCanDelete()) : ?>
                <div class="col-xs-6 text-md-center">
                    <button  onclick="return(verifyDelete('<?= $id ?>','formUpdate'))" 
                             class="btn btn-danger">
                        <i class="fa fa-trash-o" aria-hidden="true"> ELIMINA</i>

                    </button>
                </div>
            <?php endif;
             if(userCanModify()){
            ?>
            <div class="col-md-<?= $id ? 6 : 12 ?> text-md-center">

                <button   class="btn btn-success">
                    <i class="fa fa-pencil"> <?= $id ? 'AGGIORNA' : 'INSERISCI' ?></i>
                </button>
            </div>
            <?php } ?>
        </div>
    </div>

</form>

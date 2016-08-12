

<form style="z-index: 20" id="formUpdate" action="updateRecord.php?<?= $qString ?>" method="POST">


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

    <div class="form-group">
        <div class="row">
            <?php if ($id) : ?>
                <div class="col-xs-6 text-md-center">
                    <button  onclick="return(verifyDelete('<?= $id ?>','formUpdate'))" 
                             class="btn btn-danger">
                        <i class="fa fa-trash-o" aria-hidden="true"> ELIMINA</i>

                    </button>
                </div>
            <?php endif; ?>
            <div class="col-xs-<?= $id ? 6 : 12 ?> text-md-center">

                <button   class="btn btn-success">
                    <i class="fa fa-pencil"> <?= $id ? 'AGGIORNA' : 'INSERISCI' ?></i>
                </button>
            </div>
        </div>
    </div>

</form>

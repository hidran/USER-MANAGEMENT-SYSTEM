<?php
session_start();
include 'header.php';
 $token = bin2hex(random_bytes(32));
 $_SESSION['token'] = $token;
?>


    <form method="post" action="verify-login.php" id="formLogin">
        <input type="hidden" name="_csrf" value="<?=$token?>">
        <div class="form-row">
            <div class="col-md-6 mx-auto">
                <h1>LOGIN</h1>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input required type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" minlength="6" required name="password" id="password" class="form-control">
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-lg btn-success">Login</button>
                </div>
            </div>
        </div>
    </form>
<?php
include 'footer.php';
?>
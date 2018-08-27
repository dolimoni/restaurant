<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/images/favicon.png'); ?>"/>

    <link rel="stylesheet" href="<?php echo base_url('assets/build/css/login.css'); ?>">
</head>

<body>
<!--<img class="logo" src="<?php /*echo base_url('assets/images/logo_md.png'); */?>"/>-->
    <div id="parent">
        <div class="loginPage form_login">
            <header>
                <h2>Administration Login</h2>
            </header>
            <?php echo validation_errors(); ?>

            <?php echo form_open('login/checklogin'); ?>
            <input value="admin@admin.com" placeholder="Email" type="email" name="email">
            <input value="admin" placeholder="Password" type="password" name="password">
            <section class="links">
                <button class="button"><span>LOGIN</span></button>
                <br><br>
            </section>
            </form>
        </div>
    </div>

</body>
</html>
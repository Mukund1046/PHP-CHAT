<?php
    use classes\{Config, Common, Token, Validation, DB, Redirect};
    use models\User;

    $pathToLogo = Config::get("root/path");

?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">
<header>
    <div>
        <a href="<?php echo Config::get("root/path") . "index.php"; ?>"><img src="<?php echo $pathToLogo ?>public/assets/images/logos/Chroma 772.png" alt="logo" class="wide-logo"></a>
    </div>
    <div id="menu-login-credentials-container">
        <div style="margin: 0 12px"></div>
        <div class="flex-column">

            <!----------------------  EMAIL OR USERNAME  ---------------------->

            <input type="text" name="email-or-username" id="username-or-email" tabindex="1" autocomplete="off" value="<?php echo htmlspecialchars(Common::getInput($_POST, 'email-or-username'));?>" class="text-input medium-text-input" form="login-form" placeholder="Email">

            <!----------------------  REMEMBER ME  ---------------------->
            <div class="row-v-flex">
                <input type="checkbox" tabindex="3" name="remember" form="login-form" checked>
                <label class="link" for="remember">KEEP ME CONNECTED</label>
            </div>
        </div>
        <div style="margin: 0 4px"></div>
        <div class="flex-column">

            <!----------------------  PASSWORD  ---------------------->

            <input type="password" name="password" tabindex="2" autocomplete="off" id="password" class="text-input medium-text-input" form="login-form" placeholder="Password">
            <a href="<?php echo Config::get("root/path");?>login/passwordRecover.php" tabindex="5" class="link">FORGOT YOUR PASSWORD?</a>

        </div>
        <div style="margin: 0 4px"></div>
        <form action="<?php echo htmlspecialchars(Config::get("root/path")) . "Login/login.php" ?>" method="post" class="flex-form" id="login-form">
            <input type="hidden" name="token_log" value="<?php echo Token::generate("login"); ?>">

            <!----------------------  LOGIN  ---------------------->
            <div class="button-star-container">
            <input type="submit" name="login" tabindex="4" value="Login" class="button-style">
        </form>
        <div style="margin: 0 12px 0 4px"></div>
    </div>
</header>

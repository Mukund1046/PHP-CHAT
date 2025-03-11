<?php

    require_once "../vendor/autoload.php";
    require_once "../core/init.php";

    use classes\{DB, Config, Validation, Common, Session, Token, Hash, Redirect};
    use models\User;

    // First we check if the user is already connected we redirect him to index page
    if($user->getPropertyValue("isLoggedIn")) {
        Redirect::to("../index.php");
    }
    $validate = new Validation();

    $reg_success_message = '';
    $login_failure_message = '';

    if(isset($_POST["login"])) {
        if(Token::check(Common::getInput($_POST, "token_log"), "login")) {
            $validate->check($_POST, array(
                "email-or-username"=>array(
                    "name"=>"Email or username",
                    "required"=>true,
                    "max"=>255,
                    "min"=>6,
                    "email-or-username"=>true
                ),
                "password"=>array(
                    "name"=>"Password",
                    "required"=>true,
                    // Later
                    "strength"=>true
                )
            ));

            if($validate->passed()) {
                // Remember $user is created in init file
                $remember = isset($_POST["remember"]) ? true: false;
                $log = $user->login(Common::getInput($_POST, "email-or-username"), Common::getInput($_POST, "password"), $remember);

                if($log) {
                    Redirect::to("../index.php");
                } else {
                    // Here define a variable with value and display it in error div in case credentials are wrong
                    $login_failure_message = "Either email or password is invalid!";
                }
            } else {
                // Here instead of printing out errors we can put them in an array and use them in proper html labels
                $login_failure_message = "Please correct the errors in the form.";
            }
        } else {
            $validate->addError('Invalid CSRF token');
        }
    }

    if(isset($_POST["register"])) {
        $validate = new Validation();
        if(Token::check(Common::getInput($_POST, "token_reg"), "register")) {
            $validate->check($_POST, array(
                "firstname"=>array(
                    "name"=>"Firstname",
                    "min"=>2,
                    "max"=>50
                ),
                "lastname"=>array(
                    "name"=>"Lastname",
                    "min"=>2,
                    "max"=>50
                ),
                "username"=>array(
                    "name"=>"Username",
                    "required"=>true,
                    "min"=>6,
                    "max"=>20,
                    "unique"=>true
                ),
                "email"=>array(
                    "name"=>"Email",
                    "required"=>true,
                    "email-or-username"=>true
                ),
                "password"=>array(
                    "name"=>"Password",
                    "required"=>true,
                    "min"=>6
                ),
                "password_again"=>array(
                    "name"=>"Repeated password",
                    "required"=>true,
                    "matches"=>"password"
                ),
            ));

            if($validate->passed()) {
                $salt = Hash::salt(16);

                $user = new User();
                $user->setData(array(
                    "firstname"=>Common::getInput($_POST, "firstname"),
                    "lastname"=>Common::getInput($_POST, "lastname"),
                    "username"=>Common::getInput($_POST, "username"),
                    "email"=>Common::getInput($_POST, "email"),
                    "password"=> Hash::make(Common::getInput($_POST, "password"), $salt),
                    "salt"=>$salt,
                    "joined"=> date("Y/m/d h:i:s"),
                    "user_type"=>1,
                    "cover"=>'',
                    "picture"=>'',
                    "private"=>-1
                ));
                $user->add();

                mkdir("../data/users/" . Common::getInput($_POST, "username")."/");
                mkdir("../data/users/" . Common::getInput($_POST, "username")."/posts/");
                mkdir("../data/users/" . Common::getInput($_POST, "username")."/media/");
                mkdir("../data/users/" . Common::getInput($_POST, "username")."/media/pictures/");
                mkdir("../data/users/" . Common::getInput($_POST, "username")."/media/covers/");

                $reg_success_message = "Your account has been created successfully.";
                /* The following flash will be shown in the index page if the user is new, and we'll also check if the user registered
                is the same person log in because the user could create a new account but login with other account, in that case we won't
                show any welcome message*/

                Session::flash("register_success", "welcome to VOID47 chat application");
                Session::flash("new_username", Common::getInput($_POST, "username"));
            } else {
                $login_failure_message = $validate->errors()[0];
            }
        }
    }
?>

<!DOCTYPE html>
<body lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FLUXX91 - Login</title>
    <link rel='shortcut icon' type='image/x-icon' href='../public/assets/images/favicons/favicon.ico' />
    <link rel="stylesheet" href="../public/css/global.css">
    <link rel="stylesheet" href="../public/css/login.css">
    <link rel="stylesheet" href="../public/css/log-header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <?php include "../page_parts/basic/log-header.php" ?>
    <main>
        <div class="login-img-reg-container">
            <div id="left-asset-wrapper">
                <h2 id="login-left-text"><span>T</span><span>h</span><span>e</span>
        <span> </span>
        <span>s</span><span>u</span><span>r</span><span>v</span><span>e</span><span>i</span><span>l</span><span>l</span><span>a</span><span>n</span><span>c</span><span>e</span>
        <span> </span>
        <span>s</span><span>t</span><span>a</span><span>t</span><span>e</span>
        <span> </span>
        <span>i</span><span>s</span>
        <span> </span>
        <span>a</span>
        <span> </span>
        <span>t</span><span>o</span><span>t</span><span>a</span><span>l</span><span>i</span><span>t</span><span>a</span><span>r</span><span>i</span><span>a</span><span>n</span>
        <span> </span>
        <span>s</span><span>t</span><span>a</span><span>t</span><span>e</span><span>.</span>
        <br>
        <span>-</span>
        <span> </span>
        <span>E</span><span>d</span><span>w</span><span>a</span><span>r</span><span>d</span>
        <span> </span>
        <span>S</span><span>n</span><span>o</span><span>w</span><span>d</span><span>e</span><span>n</span></h2>
                <img src="../public/assets/images//logos/Chroma 771.png" id="login-image-preview" alt="">
            </div>
            <div id="registration-section">
                <div class="green-message">
                    <p class="green-message-text"><?php echo $reg_success_message; ?></p>
                    <script>
                        if($(".green-message-text").text() !== "") {
                            $(".green-message").css("display", "block");
                        }
                    </script>
                </div>
                <div class="red-message">
                    <p class="red-message-text"><?php echo $login_failure_message; ?></p>
                    <script>
                        if($(".red-message-text").text() !== "") {
                            $(".red-message").css("display", "block");
                        }
                    </script>
                </div>
                <div class="title-style1">CREATE AN ACCOUNT</div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="flex-column">
                    <div class="inner-flex-box">
                    <div class="classic-form-input-wrapper">
                        <label for="firstname" class="classic-label">FIRSTNAME</label>
                        <input type="text" name="firstname" value="<?php echo htmlspecialchars(Common::getInput($_POST, "firstname")); ?>" id="firstname" placeholder="Firstname" autocomplete="off" class="input-text-style-1">
                    </div>
                    <div class="classic-form-input-wrapper">
                        <label for="lastname" class="classic-label">LASTNAME</label>
                        <input type="text" name="lastname" value="<?php echo htmlspecialchars(Common::getInput($_POST, "lastname")); ?>" id="lastname" placeholder="Lastname" autocomplete="off" class="input-text-style-1">
                    </div>
                    <div class="classic-form-input-wrapper">
                        <label for="username" class="classic-label">USERNAME</label>
                        <input type="text" name="username" value="<?php echo htmlspecialchars(Common::getInput($_POST, "username")); ?>" id="username" placeholder="Username" autocomplete="off" class="input-text-style-1">
                    </div>
                    <div class="classic-form-input-wrapper">
                        <label for="email" class="classic-label">EMAIL</label>
                        <input type="text" name="email" value="<?php echo htmlspecialchars(Common::getInput($_POST, "email")); ?>" id="email" placeholder="Email address" autocomplete="off" class="input-text-style-1">
                    </div>
                    <div class="classic-form-input-wrapper">
                        <label for="password" class="classic-label">PASSWORD</label>
                        <input type="password" name="password" id="password" placeholder="Password" autocomplete="off" class="input-text-style-1">
                    </div>
                    <div class="classic-form-input-wrapper">
                        <label for="password_again" class="classic-label">RE-ENTER YOUR PASSWORD</label>
                        <input type="password" name="password_again" id="password_again" placeholder="Re-enter password" autocomplete="off" class="input-text-style-1">
                    </div>

                    <div class="classic-form-input-wrapper">
                        <input type="hidden" name="token_reg" value="<?php echo Token::generate("register"); ?>">
<div class="button-star-container-style1">
                        <input type="submit" value="Register" name="register" class="button-style" style="width: 70px;">
</div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
</body>
<script>
class QuotePressure {
    constructor() {
        this.mouse = { x: window.innerWidth/2, y: window.innerHeight/2 };
        this.active = true;
        this.init();
    }

    init() {
        this.element = document.getElementById('login-left-text');
        if(!this.element) return;

        this.preserveMarkup();
        this.spans = Array.from(this.element.querySelectorAll('.char-unit'));
        this.addEventListeners();
        this.animate();
    }

    preserveMarkup() {
        const processNode = (node) => {
            if(node.nodeType === Node.TEXT_NODE) {
                const wrapper = document.createElement('span');
                wrapper.className = 'char-group';
                wrapper.innerHTML = node.textContent.split('')
                    .map(c => <span class="char-unit">${c}</span>)
                    .join('');
                node.replaceWith(wrapper);
            }
            else if(node.nodeType === Node.ELEMENT_NODE) {
                Array.from(node.childNodes).forEach(processNode);
            }
        };

        Array.from(this.element.childNodes).forEach(processNode);
    }

    addEventListeners() {
        window.addEventListener('mousemove', e => {
            if(!this.active) return;
            this.mouse.x = e.clientX;
            this.mouse.y = e.clientY;
        });

        window.addEventListener('touchmove', e => {
            if(!this.active) return;
            e.preventDefault();
            this.mouse.x = e.touches[0].clientX;
            this.mouse.y = e.touches[0].clientY;
        }, { passive: false });
    }

    animate() {
        const calcEffect = (elem) => {
            const rect = elem.getBoundingClientRect();
            const dx = this.mouse.x - (rect.left + rect.width/2);
            const dy = this.mouse.y - (rect.top + rect.height/2);
            const distance = Math.sqrt(dx*dx + dy*dy);
            return Math.max(0, 1 - distance/200); // Increased sensitivity
        };

        const update = () => {
            if(!this.active) return;

            this.spans.forEach(span => {
                const intensity = calcEffect(span);
                const parentStyle = {
                    isBold: span.closest('strong'),
                    isItalic: span.closest('i')
                };

                // Enhanced weight variation range
                const weight = parentStyle.isBold
                    ? 700 + Math.floor(intensity * 200)  // 700-900 range
                    : 400 + Math.floor(intensity * 300); // 400-700 range

                // Increased slant variation
                const slant = parentStyle.isItalic
                    ? -10 - (intensity * 10)  // -10 to -20 range
                    : -intensity * 8;         // 0 to -8 range

                span.style.fontVariationSettings = `
                    'wght' ${weight},
                    'slnt' ${slant}
                `;

                // Added scaling effect
                span.style.transform = `
                    scale(${1 + intensity * 0.15})
                    translateY(${intensity * -2}px)
                `;

                // Subtle opacity effect
                span.style.opacity = 0.8 + (intensity * 0.2);
            });

            requestAnimationFrame(update);
        };

        update();
    }
}

// Initialize with enhanced effect
document.addEventListener('DOMContentLoaded', () => {
    const effect = new QuotePressure();

    // Enable hover effect on container
    document.querySelector('#login-left-text').parentElement.addEventListener(
        'mouseenter', () => effect.active = true
    );
    document.querySelector('#login-left-text').parentElement.addEventListener(
        'mouseleave', () => effect.active = false
    );
});
</script>
<script src="../public/javascript/grainEffect.js"></script>
<script src="../public/javascript/tilt.js"></script>
<script src="../public/javascript/starborder.js"></script>
<script src="../public/javascript/shiny-button.js"></script>
</html>

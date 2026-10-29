
<header class="header_container">

    <div class="audioseg_title">
        <img src="../../assets/images/AudioSegLogo.png" alt="AudioSeg Logo" class="logo_img">
        <h2>AudioSeg</h2>
    </div>

    <?php
        if (validate_researcher()) {
            include __DIR__ . "/../header/header_researcher.php";
        }
        else if (validate_policeman()) {
            include __DIR__ . "/../header/header_policeman.php";
        }
        else if (validate_delegate()) {
            include __DIR__ . "/../header/header_delegate.php";
        }
        else if (validate_director()) {
            include __DIR__ . "/../header/header_director.php";
        }
        else {
            redirect();
        }
    ?>

    <nav class="header_nav">
        <a href="../main/setting.php" class="header_icon" aria-label="User Configurations" title="User Configurations">
            <span class="material-symbols-rounded">settings</span>
        </a>

        <form action="../../server/register/logout_service.php" method="POST">
            <button type="submit" class="header_icon logout_icon" aria-label="Logout" title="Logout">
                <span class="material-symbols-rounded">logout</span>
            </button>
        </form>
    </nav>
</header>
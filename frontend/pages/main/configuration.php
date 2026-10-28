<?php
    session_start();

    include __DIR__ . "/../../server/security/validation.php";
    include __DIR__ . "/../../server/security/expiration.php";

    if (!validate_user()) {
        redirect();
    }

    verify_expiration();
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="../../assets/images/AudioSegLogo.png" type="image/png">
    <link rel="stylesheet" href="../../style/main/configuration.css">

    <script src="../../script/configuration.js" defer></script>

    <title>AudioSeg - User Configuration</title>
</head>

<body>
    <?php include __DIR__ . "/../header/header.php"?>

    <main>
        <aside>
            <h1 class="edtion_title">Settings</h1>

            <nav class="edition_options">
                <a onclick="changeScreen('account', 'account_opt')" id="account_opt"
                    class="edition_opt opt_active">Account</a>
                <a onclick="changeScreen('address', 'address_opt')" id="address_opt" class="edition_opt">Address</a>
                <a onclick="changeScreen('notifications', 'notifications_opt')" id="notifications_opt"
                    class="edition_opt">Notifications</a>
            </nav>
        </aside>

        <form action="#" method="POST" id="account" class="screen active">
            <div class="input_group photo_group">
                <img src="../../assets/images/profile_photo.jpg" alt="Profile Photo" class="profile">
                <input class="input_file" type="file" name="profile_photo">
            </div>

            <hr>

            <div class="input_group">
                <label>Username</label>
                <input class="input_bars" type="text" name="username">
            </div>

            <hr>

            <div class="input_group">
                <label>E-mail</label>
                <input class="input_bars" type="email" name="email">
            </div>

            <hr>

            <div class="input_group">
                <label>Password</label>
                <input class="input_bars" type="password" name="password">
            </div>
            
            <hr>

            <div class="input_group">
                <label>Birth Date</label>
                <input class="input_bars" type="date" name="birth_date">
            </div>

            <hr>

            <div class="input_group">
                <label>Phone</label>
                <input class="input_bars" type="text" name="phone">
            </div>

            <hr>

            <div class="save_bt_container">
                <button type="submit" class="submit_button">Save</button>
            </div>
        </form>

        <form action="#" method="POST" id="address" class="screen">
            <div class="input_group">
                <label><span class="material-symbols-rounded field_icon"
                        aria-hidden="true">local_post_office</span>Zip-Code</label>
                <input class="input_bars" type="text" id="cep" name="cep" inputmode="numeric" autocomplete="postal-code"
                    maxlength="9" pattern="[0-9]{5}-[0-9]{3}" title="CEP" required>
            </div>

            <hr>

            <div class="input_group">
                <label><span class="material-symbols-rounded field_icon" aria-hidden="true">public</span>Country</label>
                <input class="input_bars" type="text" id="country" name="country" required>
            </div>

            <hr>

            <div class="input_group">
                <label><span class="material-symbols-rounded field_icon" aria-hidden="true">map</span>State</label>
                <input class="input_bars" type="text" id="state" name="state" required>
            </div>

            <hr>

            <div class="input_group">
                <label><span class="material-symbols-rounded field_icon"
                        aria-hidden="true">location_city</span>City</label>
                <input class="input_bars" type="text" id="city" name="city" required>
            </div>

            <hr>

            <div class="input_group">
                <label><span class="material-symbols-rounded field_icon"
                        aria-hidden="true">home_work</span>Neighborhood</label>
                <input class="input_bars" type="text" id="neighborhood" name="neighborhood" required>
            </div>

            <hr>

            <div class="input_group">
                <label><span class="material-symbols-rounded field_icon"
                        aria-hidden="true">add_road</span>Street</label>
                <input class="input_bars" type="text" id="street" name="street" required>
            </div>

            <hr>

            <div class="input_group">
                <label><span class="material-symbols-rounded field_icon" aria-hidden="true">tag</span>Number</label>
                <input class="input_bars" type="text" id="number" name="number_house" inputmode="numeric" maxlength="5"
                    pattern="[0-9]{1,5}" title="Number" required>
            </div>

            <hr>

            <div class="input_group">
                <label><span class="material-symbols-rounded field_icon"
                        aria-hidden="true">corporate_fare</span>Complement</label>
                <input class="input_bars" type="text" id="complement" name="additional_information">
            </div>

            <hr>

            <div class="save_bt_container">
                <button type="submit" class="submit_button">Save</button>
            </div>
        </form>

        <form aciton="#" method="POST" id="notifications" class="screen">
            <div class="input_group">
                <label>Allow sound alarms</label>
                <input class="input_bars" type="checkbox">
            </div>

            <hr>

            <div class="input_group">
                <label>Allow Lorem Ipsum Dolor Sit Amet</label>
                <input class="input_bars" type="checkbox">
            </div>

            <hr>

            <div class="input_group">
                <label>Allow Lorem Ipsum Dolor Sit Amet</label>
                <input class="input_bars" type="checkbox">
            </div>

            <hr>

            <div class="input_group">
                <label>Allow Lorem Ipsum Dolor Sit Amet</label>
                <input class="input_bars" type="checkbox">
            </div>

            <hr>

            <div class="save_bt_container">
                <button type="submit" class="submit_button">Save</button>
            </div>
        </form>

    </main>
</body>

</html>
<?php
    session_start();

    include __DIR__ . "/../../server/security/validation.php";
    include __DIR__ . "/../../server/security/expiration.php";

    if (!validate_user()) {
        redirect();
        exit;
    }

    verify_expiration();

    $user = $_SESSION["user_data"];
?>

<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="../../assets/images/AudioSegLogo.png" type="image/png">
        <link rel="stylesheet" href="../../style/main/settings.css">

        <script src="../../script/main/settings.js" defer></script>

        <title>AudioSeg - User Configuration</title>

    </head>

    <body>
        <?php include __DIR__ . "/../header/header.php"; ?>

        <main>
            <aside>
                <h1 class="edtion_title">Settings</h1>

                <nav class="edition_options">
                    <a href="#account" onclick="changeScreen('account', 'account_opt'); return false;" id="account_opt" class="edition_opt opt_active" aria-current="page">Account</a>
                    <a href="#address" onclick="changeScreen('address', 'address_opt'); return false;" id="address_opt" class="edition_opt">Address</a>
                    <a href="#notifications" onclick="changeScreen('notifications', 'notifications_opt'); return false;" id="notifications_opt" class="edition_opt">Notifications</a>
                </nav>
            </aside>

            <form action="../../server/main/settings_service.php" method="POST" enctype="multipart/form-data" id="account" class="screen active">

                <input type="hidden" name="action" value="account">

                <div class="settings-heading">
                    <span class="eyebrow">YOUR PERSONAL SPACE</span>
                    <h2>Account settings</h2>
                </div>

                <div class="profile-card">
                    <div class="profile-avatar">
                        <img src="../../assets/images/profile_photo.jpg" alt="Profile photo" class="profile" id="profile_preview">

                        <label class="avatar-edit" for="profile_photo" title="Change profile photo">
                            <span class="material-symbols-rounded" aria-hidden="true"> photo_camera</span>
                        </label>
                    </div>

                    <div class="profile-identity">
                        <h3><?php echo $user["username"]; ?></h3>
                        <p><?php echo $user["role_user"]; ?></p>
                    </div>
                </div>

                <input type="file" id="profile_photo" name="photo" class="file-input" accept="image/jpeg,image/png,image/webp">

                <div class="settings-section">
                    <div class="section-heading">
                        <span class="material-symbols-rounded">person</span>
                        <h3>Personal information</h3>
                    </div>

                    <div class="field-grid">
                        
                        <div class="input_group">
                            <label for="username">Username</label>
                            <input class="input_bars" id="username" type="text" name="username" maxlength="50" autocomplete="username" required value="<?php echo $user["username"]; ?>">
                        </div>

                        <div class="input_group">
                            <label for="birth_date">Birth date</label>
                            <input class="input_bars" id="birth_date" type="date" name="birth_date" value="<?php echo $user["birth_date"]; ?>">
                        </div>

                        <div class="input_group full-width">
                            <label for="description">Profile description</label>
                            <textarea class="input_bars description-input" id="description" name="description" maxlength="300" rows="4" placeholder="Description..."><?php echo $user["description"] ?? ""; ?></textarea>

                            <span class="field-hint">
                                <span id="description_count">0</span>/300 characters
                            </span>
                        </div>
                    </div>
                </div>

                <div class="settings-section">
                    <div class="section-heading">
                        <span class="material-symbols-rounded">shield</span>
                        <h3>Private information</h3>
                    </div>

                    <div class="private-field">
                        <label>E-mail address</label>
                        <button type="button" class="secondary-button" data-action="change-email">Change E-Mail</button>
                    </div>

                    <div class="private-field">
                        <label>Phone number</label>
                        <button type="button" class="secondary-button" data-action="change-phone">Change Phone</button>
                    </div>

                    <div class="private-field">
                        <label>Password</label>
                        <button type="button" class="secondary-button" data-action="change-password">Change Password</button>
                    </div>
                </div>

                <div class="settings-section danger-zone">
                    <div class="section-heading">
                        <span class="material-symbols-rounded">warning</span>

                        <div>
                            <h3>Danger Zone</h3>
                            <p>Irreversible actions related to your account.</p>
                        </div>
                    </div>

                    <div class="danger-card">
                        <h3>Delete Account</h3>

                        <button type="button" class="danger-button" data-action="delete-account">
                            <span class="material-symbols-rounded">delete_forever</span>
                            Delete Account
                        </button>
                    </div>
                </div>

                <div class="save_bt_container">

                    <button type="reset" class="secondary-button">Discard</button>

                    <button type="submit" class="submit_button">
                        <span class="material-symbols-rounded">save</span>
                        Save Changes
                    </button>
                </div>
            </form>

            <form action="../../server/main/settings_service.php" method="POST" id="address" class="screen">

                <input type="hidden" name="action" value="address">

                <div class="settings-heading">
                    <span class="eyebrow">YOUR PERSONAL SPACE</span>
                    <h2>Address Settings</h2>
                </div>

                <div class="settings-section">
                    <div class="section-heading">
                        <span class="material-symbols-rounded">location_on</span>
                        
                        <div>
                            <h3>Location details</h3>

                            <?php
                                if (isset($_SESSION["settings_error"])) {

                                    $message = $_SESSION["settings_error"];
                                    echo "<p class='form-error'>" . $message . "</p>";
                                    
                                    unset($_SESSION["settings_error"]);
                                }
                            ?>
                        </div>
                    </div>

                    <div class="field-grid">

                        <div class="input_group">
                            <label for="cep">CEP</label>
                            <input class="input_bars" type="text" id="cep" name="cep" inputmode="numeric" autocomplete="postal-code" maxlength="9" pattern="[0-9]{5}-?[0-9]{3}" required value="<?php echo $user['cep']; ?>">
                        </div>

                        <div class="input_group">
                            <label for="country">Country</label>
                            <input class="input_bars" type="text" id="country" name="country" required value="<?php echo $user['country']; ?>">
                        </div>

                        <div class="input_group">
                            <label for="state">State</label>
                            <input class="input_bars" type="text" id="state" name="state" required value="<?php echo $user['state']; ?>">
                        </div>

                        <div class="input_group">
                            <label for="city">City</label>
                            <input class="input_bars" type="text" id="city" name="city" required value="<?php echo $user['city']; ?>">
                        </div>

                        <div class="input_group">
                            <label for="neighborhood">Neighborhood</label>
                            <input class="input_bars" type="text" id="neighborhood" name="neighborhood" required value="<?php echo $user['neighborhood']; ?>">
                        </div>

                        <div class="input_group">
                            <label for="street">Street</label>
                            <input class="input_bars" type="text" id="street" name="street" required value="<?php echo $user['street']; ?>">
                        </div>

                        <div class="input_group">
                            <label for="number_house">Number</label>
                            <input class="input_bars" type="text" id="number_house" name="number_house" maxlength="5" required value="<?php echo $user['number_house']; ?>">
                        </div>

                        <div class="input_group">
                            <label for="additional_information">Complement</label>
                            <input class="input_bars" type="text" id="additional_information" name="additional_information" value="<?php echo $user['additional_information']; ?>">
                        </div>
                    </div>
                </div>

                <div class="save_bt_container">
                    <button type="reset" class="secondary-button">Discard</button>

                    <button type="submit" class="submit_button">
                        <span class="material-symbols-rounded">save</span>
                        Save changes
                    </button>
                </div>
            </form>

            <form action="../../server/main/settings_service.php" method="POST" id="notifications" class="screen">

                <input type="hidden" name="action" value="notifications">

                <div class="settings-heading">
                    <span class="eyebrow">YOUR PERSONAL SPACE</span>
                    <h2>Notifications Settings</h2>
                </div>

                <div class="settings-section">
                    <div class="section-heading">
                        <span class="material-symbols-rounded">notifications</span>
                        <h3>Notification preferences</h3>
                    </div>

                    <label class="notification-option">
                        <span>
                            <strong>Sound alarms</strong>
                            <small>Allow audio alerts from the application.</small>
                        </span>
                        <input type="checkbox" name="sound_alarms" value="1">
                        <span class="toggle"></span>
                    </label>

                    <label class="notification-option">
                        <span>
                            <strong>Research updates</strong>
                            <small>Receive updates about research activities.</small>
                        </span>
                        <input type="checkbox" name="research_updates" value="1">
                        <span class="toggle"></span>
                    </label>

                    <label class="notification-option">
                        <span>
                            <strong>Security alerts</strong>
                            <small>Receive important account security alerts.</small>
                        </span>
                        <input type="checkbox" name="security_alerts" value="1" checked>
                        <span class="toggle"></span>
                    </label>
                </div>

                <div class="save_bt_container">
                    <button type="submit" class="submit_button">
                        <span class="material-symbols-rounded">save</span>
                        Save preferences
                    </button>
                </div>
            </form>
        </main>

        <dialog id="security_dialog" class="security-dialog">
            
            <div class="dialog-header">
                <div>
                    <span class="eyebrow">ACCOUNT SECURITY</span>
                    <h2 id="dialog_title">Change information</h2>
                </div>

                <button type="button" class="close-dialog" id="close_dialog" aria-label="Close dialog">
                    <span class="material-symbols-rounded">close</span>
                </button>
            </div>

            <form action="../../server/main/settings_service.php" method="POST" class="security-form" id="email_form" hidden>

                <input type="hidden" name="action" value="change_email">

                <p class="dialog-description">Confirm your identity before changing your e-mail address.</p>

                <div class="input_group">
                    <label for="email_password">Current password</label>
                    <input class="input_bars" type="password" id="email_password" name="current_password" autocomplete="current-password" placeholder="Enter your current password" required>
                </div>

                <div class="input_group">
                    <label for="new_email">New e-mail address</label>
                    <input class="input_bars" type="email" id="new_email" name="new_email" autocomplete="email" placeholder="Enter your new e-mail" required>
                </div>

                <div class="input_group">
                    <label for="confirm_email">Confirm new e-mail</label>
                    <input class="input_bars" type="email" id="confirm_email" name="confirm_email" autocomplete="email" placeholder="Confirm your new e-mail" required>
                </div>

                <div class="dialog-actions">

                    <button type="button" class="secondary-button cancel-dialog">Cancel</button>

                    <button type="submit" class="submit_button">
                        <span class="material-symbols-rounded">save</span>
                        Change E-Mail
                    </button>
                </div>
            </form>

            <form action="../../server/main/settings_service.php" method="POST" class="security-form" id="phone_form" hidden>

                <input type="hidden" name="action" value="change_phone">

                <p class="dialog-description">Confirm your identity before changing your phone number.</p>

                <div class="input_group">
                    <label for="phone_password">Current password</label>
                    <input class="input_bars" type="password" id="phone_password" name="current_password" autocomplete="current-password" placeholder="Enter your current password" required>
                </div>

                <div class="input_group">
                    <label for="new_phone">New phone number</label>
                    <input class="input_bars" type="tel" id="new_phone" name="new_phone" autocomplete="tel" placeholder="Enter your new phone number" required>
                </div>

                <div class="dialog-actions">
                    <button type="button" class="secondary-button cancel-dialog">Cancel</button>
                    <button type="submit" class="submit_button">
                        <span class="material-symbols-rounded">save</span>
                        Change phone
                    </button>
                </div>
            </form>

            <form action="../../server/main/settings_service.php" method="POST" class="security-form" id="password_form" hidden>

                <input type="hidden" name="action" value="change_password">

                <p class="dialog-description">Enter your current password and choose a new password.</p>

                <div class="input_group">
                    <label for="current_password">Current password</label>
                    <input class="input_bars" type="password" id="current_password" name="current_password" autocomplete="current-password" placeholder="Enter your current password" required>
                </div>

                <div class="input_group">
                    <label for="new_password">New password</label>
                    <input class="input_bars" type="password" id="new_password" name="new_password" autocomplete="new-password" placeholder="Enter your new password" required>
                </div>

                <div class="input_group">
                    <label for="confirm_password">Confirm new password</label>
                    <input class="input_bars" type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" placeholder="Confirm your new password" required>
                </div>

                <div class="dialog-actions">
                    <button type="button" class="secondary-button cancel-dialog">Cancel</button>
                    <button type="submit" class="submit_button">
                        <span class="material-symbols-rounded">lock_reset</span>
                        Change Password
                    </button>
                </div>
            </form>

            <form action="../../server/main/settings_service.php" method="POST" class="security-form" id="delete_form" hidden>

                <input type="hidden" name="action" value="delete_account">

                <div class="delete-warning">
                    <span class="material-symbols-rounded">error</span>
                    <p>This action is permanent. Your account and associated information will be deleted.</p>
                </div>

                <div class="input_group">
                    <label for="delete_password">Current password</label>
                    <input class="input_bars" type="password" id="delete_password" name="current_password" autocomplete="current-password" placeholder="Enter your current password" required>
                </div>

                <div class="dialog-actions">
                    <button type="button" class="secondary-button cancel-dialog">Cancel</button>
                    <button type="submit" class="danger-button">
                        <span class="material-symbols-rounded">delete_forever</span>
                        Delete permanently
                    </button>
                </div>
            </form>
        </dialog>
    </body>
</html>
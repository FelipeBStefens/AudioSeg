<?php
    function show_researchers(array $researcher) {
?>

    <article class="researcher_item">

        <button class="researcher_trigger" type="button" aria-expanded="false">
            <div class="researcher_identity">
                <img src="../../assets/images/profile_photo.jpg" alt="Researcher profile" class="researcher_photo">
                <div class="researcher_summary">
                    <h3><?php echo $researcher["username"] ?></h3>
                    <span><?php echo $researcher["email"] ?></span>
                </div>
            </div>

            <div class="researcher_metadata">
                <span class="institute_tag"><?php echo $researcher["institute"] ?></span>
                <span class="material-symbols-rounded expand_icon">keyboard_arrow_down</span>
            </div>
        </button>

        <div class="researcher_details">

            <div class="details_content">
                <div class="details_heading">
                    <div>
                        <span class="eyebrow">ACCOUNT INFORMATION</span>
                        <h3>Researcher Details</h3>
                    </div>
                </div>

                <div class="profile_overview">
                    <img src="../../assets/images/profile_photo.jpg" alt="Researcher profile" class="details_photo">

                    <div>
                        <h2><?php echo $researcher["username"] ?></h2>
                        <p><?php echo $researcher["institute"] ?></p>
                        <span>RESEARCHER</span>
                    </div>
                </div>

                <div class="information_grid">
                    <div class="information_group">
                        <span>Username</span>
                        <strong><?php echo $researcher["username"] ?></strong>
                    </div>

                    <div class="information_group">
                        <span>Email</span>
                        <strong><?php echo $researcher["email"] ?></strong>
                    </div>

                    <div class="information_group">
                        <span>CPF</span>
                        <strong><?php echo $researcher["cpf"] ?></strong>
                    </div>

                    <div class="information_group">
                        <span>Birth Date</span>
                        <strong><?php echo $researcher["birth_date"] ?></strong>
                    </div>

                    <div class="information_group">
                        <span>Phone</span>
                        <strong>+<?php echo $researcher["international_dialling_code"] ?> (<?php echo $researcher["local_dialling_code"] ?>) <?php echo $researcher["number_phone"] ?></strong>
                    </div>

                    <div class="information_group">
                        <span>Institute</span>
                        <strong><?php echo $researcher["institute"] ?></strong>
                    </div>

                    <div class="information_group full_width">
                        <span>Description</span>
                        <strong><?php echo $researcher["description_user"] ?></strong>
                    </div>

                    <div class="information_group full_width">
                        <span>Address</span>
                        <strong>To complete On PHP</strong>
                    </div>
                </div>

                <div class="expiration_section">

                    <div class="expiration_heading">
                        <div>
                            <span class="eyebrow">ACCESS MANAGEMENT</span>
                            <h3>Account Expiration</h3>
                        </div>

                        <span class="material-symbols-rounded">calendar_clock</span>
                    </div>

                    <div class="expiration_controls">

                        <div class="expiration_input">
                            <label for="expiration_date">New expiration date</label>
                            <input type="datetime-local" id="expiration_date" name="expiration_date">
                            
                            </div>
                                <button type="button" class="save_expiration">
                                    <span class="material-symbols-rounded">save</span>
                                    Save Changes
                                </button>
                            </div>
                        </div>

                        <div class="researcher_actions">

                            <div>
                                <h4>Danger Zone</h4>
                                <p>Permanently remove this researcher account.</p>
                            </div>

                            <button type="button" class="delete_researcher">
                                <span class="material-symbols-rounded">delete</span>
                                Delete Researcher
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
<?php
    }
?>
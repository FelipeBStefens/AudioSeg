<?php
    function show_researchers() {
?>

    <article class="researcher_item">

        <button class="researcher_trigger" type="button" aria-expanded="false">
            <div class="researcher_identity">
                <img src="../../assets/images/profile_photo.jpg" alt="Researcher profile" class="researcher_photo">
                <div class="researcher_summary">
                    <h3>Researcher Name</h3>
                    <span>researcher@email.com</span>
                </div>
            </div>

            <div class="researcher_metadata">
                <span class="institute_tag">Research Institute</span>
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
                        <h2>Researcher Name</h2>
                        <p>Research Institute</p>
                        <span>RESEARCHER</span>
                    </div>
                </div>

                <div class="information_grid">
                    <div class="information_group">
                        <span>Username</span>
                        <strong>researcher_username</strong>
                    </div>

                    <div class="information_group">
                        <span>Email</span>
                        <strong>researcher@email.com</strong>
                    </div>

                    <div class="information_group">
                        <span>CPF</span>
                        <strong>000.000.000-00</strong>
                    </div>

                    <div class="information_group">
                        <span>Birth Date</span>
                        <strong>01/01/2000</strong>
                    </div>

                    <div class="information_group">
                        <span>Phone</span>
                        <strong>+55 (51) 99999-9999</strong>
                    </div>

                    <div class="information_group">
                        <span>Institute</span>
                        <strong>Research Institute</strong>
                    </div>

                    <div class="information_group full_width">
                        <span>Description</span>
                        <strong>Researcher description goes here.</strong>
                    </div>

                    <div class="information_group full_width">
                        <span>Address</span>
                        <strong>Street Name, 123 - City, State</strong>
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
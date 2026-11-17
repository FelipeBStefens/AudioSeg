
<?php

function station_escape($value) {
    return htmlspecialchars(
        (string)($value ?? ""),
        ENT_QUOTES,
        "UTF-8"
    );
}

function show_police_stations(array $station) {

    $policemen = $station["policemen"] ?? [];

?>

<article class="station_item researcher_item">

    <!-- STATION HEADER -->

    <button
        class="station_trigger researcher_trigger"
        type="button"
        aria-expanded="false"
    >

        <div class="researcher_identity">

            <img
                src="../../assets/images/profile_photo.jpg"
                alt="Police station"
                class="researcher_photo"
            >

            <div class="researcher_summary">

                <h3><?= station_escape($station["username"]) ?></h3>

                <span><?= station_escape($station["email"]) ?></span>

            </div>

        </div>

        <div class="researcher_metadata">

            <span class="institute_tag">
                <?= station_escape($station["city"] ?? "Police Station") ?>
            </span>

            <span class="material-symbols-rounded expand_icon">
                keyboard_arrow_down
            </span>

        </div>

    </button>


    <!-- STATION DETAILS -->

    <div class="researcher_details">

        <div class="details_content">

            <div class="details_heading">

                <div>
                    <span class="eyebrow">STATION INFORMATION</span>
                    <h3>Police Station Details</h3>
                </div>

            </div>


            <!-- STATION PROFILE -->

            <div class="profile_overview">

                <img
                    src="../../assets/images/profile_photo.jpg"
                    alt="Police station"
                    class="details_photo"
                >

                <div>

                    <h2><?= station_escape($station["username"]) ?></h2>

                    <p><?= station_escape($station["address"] ?? "") ?></p>

                    <span>POLICE STATION</span>

                </div>

            </div>


            <!-- STATION INFORMATION -->

            <div class="information_grid">

                <div class="information_group">
                    <span>Station Name</span>
                    <strong><?= station_escape($station["username"]) ?></strong>
                </div>

                <div class="information_group">
                    <span>Email</span>
                    <strong><?= station_escape($station["email"]) ?></strong>
                </div>

                <div class="information_group">
                    <span>Phone</span>
                    <strong><?= station_escape($station["number_phone"] ?? "") ?></strong>
                </div>

                <div class="information_group">
                    <span>City</span>
                    <strong><?= station_escape($station["city"] ?? "") ?></strong>
                </div>

                <div class="information_group full_width">
                    <span>Address</span>
                    <strong><?= station_escape($station["address"] ?? "") ?></strong>
                </div>

            </div>


            <!-- POLICE OFFICERS -->

            <section class="officers_section">

                <div class="officers_heading">

                    <div>
                        <span class="eyebrow">STATION MANAGEMENT</span>
                        <h3>Registered Officers</h3>
                        <p>Manage the officers assigned to this police station.</p>
                    </div>

                    <span class="officer_counter">
                        <?= count($policemen) ?> Officers
                    </span>

                </div>


                <!-- OFFICER LIST -->

                <div class="officers_list">

                    <?php foreach ($policemen as $policeman): ?>

                        <article
                            class="officer_item"
                            data-officer-id="<?= station_escape($policeman["id"] ?? "") ?>"
                        >

                            <div class="officer_identity">

                                <img
                                    src="../../assets/images/profile_photo.jpg"
                                    alt="Police officer"
                                    class="officer_photo"
                                >

                                <div>
                                    <h4><?= station_escape($policeman["username"]) ?></h4>
                                    <span><?= station_escape($policeman["email"]) ?></span>
                                </div>

                            </div>

                            <button
                                type="button"
                                class="remove_officer"
                                title="Remove officer"
                            >
                                <span class="material-symbols-rounded">person_remove</span>
                                <span>Remove</span>
                            </button>

                        </article>

                    <?php endforeach; ?>

                    <?php if (empty($policemen)): ?>

                        <div class="empty_officers">
                            <span class="material-symbols-rounded">group_off</span>
                            <p>No officers registered in this station.</p>
                        </div>

                    <?php endif; ?>

                </div>


                <!-- ADD OFFICER -->

                <div class="add_officer_section">

                    <div class="add_officer_heading">

                        <div>
                            <h4>Add an Officer</h4>
                            <p>Assign a new police officer to this station.</p>
                        </div>

                        <span class="material-symbols-rounded">
                            person_add
                        </span>

                    </div>

                    <form class="add_officer_form">

                        <div class="officer_form_group">

                            <label>Officer Username</label>

                            <input
                                type="text"
                                name="officer_username"
                                placeholder="Enter officer username"
                                required
                            >

                        </div>

                        <div class="officer_form_group">

                            <label>Officer Email</label>

                            <input
                                type="email"
                                name="officer_email"
                                placeholder="Enter officer email"
                                required
                            >

                        </div>

                        <button type="submit" class="add_officer_button">

                            <span class="material-symbols-rounded">
                                person_add
                            </span>

                            Add Officer

                        </button>

                    </form>

                </div>

            </section>


            <!-- DANGER ZONE -->

            <div class="researcher_actions">

                <div>
                    <h4>Danger Zone</h4>
                    <p>Permanently remove this police station account.</p>
                </div>

                <button type="button" class="delete_researcher">

                    <span class="material-symbols-rounded">delete</span>

                    Delete Station

                </button>

            </div>

        </div>

    </div>

</article>

<?php
}
?>

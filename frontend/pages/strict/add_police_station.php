<?php
    session_start();
    
    include __DIR__ . "/../../server/security/validation.php";
    include __DIR__ . "/../../server/security/expiration.php";

    if (!validate_director()) {
        redirect();
    }

    verify_expiration();
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="../../assets/images/audioseg_logo.png" type="image/png">
        <link rel="stylesheet" href="../../style/strict/add_police_station.css">
        <script src="../../script/strict/add_police_station.js" defer></script>

        <title>AudioSeg - Add Police Station</title>
    </head>

    <body>

        <?php include __DIR__ . "/../header/header.php"?>

        <main class="add_station_container">

            <div class="page_heading">

                <div>
                    <span class="eyebrow">ADMINISTRATION PANEL</span>
                    <h1>Register Police Station</h1>
                    <p>Add a new police station to the AudioSeg system.</p>
                </div>

                <a href="police_station.php" class="back_button">
                    <span class="material-symbols-rounded">arrow_back</span>
                    Back to Stations
                </a>

            </div>

            <form action="../../server/strict/add_station_service.php" method="POST" class="station_form">

                <section class="form_section">

                    <div class="form_section_heading">

                        <div class="section_icon">
                            <span class="material-symbols-rounded">local_police</span>
                        </div>

                        <div>
                            <span class="eyebrow">GENERAL INFORMATION</span>
                            <h2>Police Station Information</h2>
                            <p>Provide the identification details of the station.</p>
                        </div>

                    </div>

                    <div class="form_grid">

                        <div class="form_group full_width">
                            <label for="name_police_station">Police Station Name</label>
                            <input type="text" name="name_police_station" placeholder="E.g. 1st Police Station - Porto Alegre" required>
                        </div>

                    </div>

                </section>

                <section class="form_section">

                    <div class="form_section_heading">

                        <div class="section_icon">
                            <span class="material-symbols-rounded">location_on</span>
                        </div>

                        <div>
                            <span class="eyebrow">LOCATION DETAILS</span>
                            <h2>Station Address</h2>
                            <p>Enter the complete address of the police station.</p>
                        </div>

                    </div>

                    <div class="form_grid">

                        <div class="form_group">
                            <label for="country">Country</label>
                            <input type="text" name="country" value="Brazil" required>
                        </div>

                        <div class="form_group">
                            <label for="state">State</label>

                            <input type="text" name="state" value="Rio Grande do Sul" required>
                        </div>

                        <div class="form_group">
                            <label for="city">City</label>
                            <input type="text" name="city" placeholder="Enter city" required>
                        </div>

                        <div class="form_group">
                            <label for="neighborhood">Neighborhood</label>
                            <input type="text" name="neighborhood" placeholder="Enter neighborhood" required>
                        </div>

                        <div class="form_group full_width">
                            <label for="street">Street</label>
                            <input type="text" name="street" placeholder="Enter street name" required>
                        </div>

                        <div class="form_group">
                            <label for="cep">Postal Code (CEP)</label>
                            <input type="text" id="cep" name="cep" class="cep" placeholder="00000-000" maxlength="9" pattern="[0-9]{5}-[0-9]{3}" title="Enter a valid CEP in the format 00000-000" required>
                        </div>

                        <div class="form_group">
                            <label for="number_house">Building Number</label>
                            <input type="number" name="number_house" placeholder="E.g. 150" min="1" required>
                        </div>

                        <div class="form_group full_width">
                            <label for="additional_information">
                                Additional Information
                                <span class="optional_tag">OPTIONAL</span>
                            </label>

                            <textarea name="additional_information" placeholder="Apartment, building, reference points, etc."></textarea>
                        </div>

                    </div>

                </section>

                <div class="form_actions">

                    <a href="police_station.php" class="cancel_button">
                        Cancel
                    </a>

                    <button type="submit" class="submit_button">
                        <span class="material-symbols-rounded">add_business</span>
                        Register Police Station
                    </button>

                </div>

            </form>

        </main>

    </body>
</html>

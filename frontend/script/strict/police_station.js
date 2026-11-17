
const stationItems = document.querySelectorAll(".station_item");


// ========================================
// EXPAND / COLLAPSE STATIONS
// ========================================

stationItems.forEach(item => {

    const trigger = item.querySelector(".station_trigger");

    trigger.addEventListener("click", () => {

        const isActive = item.classList.contains("active");

        stationItems.forEach(station => {

            station.classList.remove("active");

            station.querySelector(".station_trigger")
                .setAttribute("aria-expanded", "false");

        });

        if (!isActive) {

            item.classList.add("active");

            trigger.setAttribute("aria-expanded", "true");

        }

    });

});


// ========================================
// REMOVE OFFICER
// ========================================

document.addEventListener("click", event => {

    const button = event.target.closest(".remove_officer");

    if (!button) return;

    const officer = button.closest(".officer_item");

    const officerName = officer.querySelector("h4").textContent;

    const confirmation = confirm(
        `Are you sure you want to remove ${officerName} from this police station?`
    );

    if (!confirmation) return;

    const section = officer.closest(".officers_section");
    const list = section.querySelector(".officers_list");

    officer.remove();

    updateOfficerCounter(section);

    if (!list.querySelector(".officer_item")) {

        list.innerHTML = `
            <div class="empty_officers">
                <span class="material-symbols-rounded">group_off</span>
                <p>No officers registered in this station.</p>
            </div>
        `;

    }

});


// ========================================
// ADD OFFICER
// ========================================

document.addEventListener("submit", event => {

    const form = event.target.closest(".add_officer_form");

    if (!form) return;

    event.preventDefault();

    const username = form.elements.officer_username.value.trim();
    const email = form.elements.officer_email.value.trim();

    if (!username || !email) return;

    const section = form.closest(".officers_section");
    const list = section.querySelector(".officers_list");

    // Remove empty message if present
    const emptyMessage = list.querySelector(".empty_officers");

    if (emptyMessage) {
        emptyMessage.remove();
    }

    // Create officer element
    const officer = document.createElement("article");

    officer.className = "officer_item";

    const identity = document.createElement("div");
    identity.className = "officer_identity";

    const photo = document.createElement("img");
    photo.src = "../../assets/images/profile_photo.jpg";
    photo.alt = "Police officer";
    photo.className = "officer_photo";

    const information = document.createElement("div");

    const name = document.createElement("h4");
    name.textContent = username;

    const officerEmail = document.createElement("span");
    officerEmail.textContent = email;

    information.append(name, officerEmail);
    identity.append(photo, information);

    const removeButton = document.createElement("button");

    removeButton.type = "button";
    removeButton.className = "remove_officer";
    removeButton.title = "Remove officer";

    const icon = document.createElement("span");
    icon.className = "material-symbols-rounded";
    icon.textContent = "person_remove";

    const label = document.createElement("span");
    label.textContent = "Remove";

    removeButton.append(icon, label);

    officer.append(identity, removeButton);

    list.append(officer);

    updateOfficerCounter(section);

    form.reset();

});


// ========================================
// UPDATE OFFICER COUNTER
// ========================================

function updateOfficerCounter(section) {

    const count = section.querySelectorAll(".officer_item").length;

    section.querySelector(".officer_counter").textContent =
        `${count} Officers`;

}


// ========================================
// DELETE STATION
// ========================================

document.querySelectorAll(".delete_researcher").forEach(button => {

    button.addEventListener("click", event => {

        event.stopPropagation();

        const confirmation = confirm(
            "Are you sure you want to permanently delete this police station?"
        );

        if (!confirmation) return;

        // Backend deletion will be implemented here.

    });

});


// ========================================
// SEARCH STATIONS AND OFFICERS
// ========================================

const searchInput = document.querySelector("#station_search_input");
const searchResults = document.querySelector("#search_results");

searchInput.addEventListener("input", () => {

    const searchValue = searchInput.value.trim().toLowerCase();

    let visibleCount = 0;

    stationItems.forEach(item => {

        const searchableContent = item.textContent.toLowerCase();

        const matches = searchableContent.includes(searchValue);

        item.classList.toggle("hidden", !matches);

        if (matches) {

            visibleCount++;

        } else {

            item.classList.remove("active");

            item.querySelector(".station_trigger")
                .setAttribute("aria-expanded", "false");

        }

    });

    if (searchValue === "") {

        searchResults.textContent = "";

    } else {

        searchResults.textContent =
            `${visibleCount} police station(s) found`;

    }

});

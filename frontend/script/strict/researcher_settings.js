
const researcherItems = document.querySelectorAll(".researcher_item");

researcherItems.forEach(item => {

    const trigger = item.querySelector(".researcher_trigger");

    trigger.addEventListener("click", () => {

        const isActive = item.classList.contains("active");

        // Close all researchers
        researcherItems.forEach(researcher => {

            researcher.classList.remove("active");

            researcher.querySelector(".researcher_trigger")
                .setAttribute("aria-expanded", "false");

        });

        // Open selected researcher
        if (!isActive) {

            item.classList.add("active");

            trigger.setAttribute("aria-expanded", "true");

        }

    });

});

// Delete confirmation
document.querySelectorAll(".delete_researcher").forEach(button => {

    button.addEventListener("click", event => {

        event.stopPropagation();

        const confirmation = confirm(
            "Are you sure you want to permanently delete this researcher?"
        );

        if (confirmation) {
            // Backend deletion will be handled here.
        }

    });

});


const searchInput = document.querySelector("#researcher_search_input");
const searchResults = document.querySelector("#search_results");

searchInput.addEventListener("input", () => {

    const searchValue = searchInput.value
        .trim()
        .toLowerCase();

    let visibleCount = 0;

    researcherItems.forEach(item => {

        const searchableContent = item.textContent.toLowerCase();

        const matches = searchableContent.includes(searchValue);

        item.classList.toggle("hidden", !matches);

        if (matches) {
            visibleCount++;
        } else {
            item.classList.remove("active");

            item.querySelector(".researcher_trigger")
                .setAttribute("aria-expanded", "false");
        }

    });

    if (searchValue === "") {
        searchResults.textContent = "";
    } else {
        searchResults.textContent =
            `${visibleCount} researcher(s) found`;
    }

});

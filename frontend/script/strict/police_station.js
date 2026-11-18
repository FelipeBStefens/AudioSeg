
const stationItems = document.querySelectorAll(".station_item");


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



const counter = document.getElementById("station_counter");
counter.textContent = document.querySelectorAll(".station_item").length;



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

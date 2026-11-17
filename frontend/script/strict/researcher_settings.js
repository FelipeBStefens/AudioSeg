const researcherItems = document.querySelectorAll(".researcher_item");
let quantity = 0

researcherItems.forEach(item => {

    const trigger = item.querySelector(".researcher_trigger");
    quantity++;

    trigger.addEventListener("click", () => {

        const isActive = item.classList.contains("active");

        researcherItems.forEach(researcher => {
            researcher.classList.remove("active");
            researcher.querySelector(".researcher_trigger").setAttribute("aria-expanded", "false");
        });

        if (!isActive) {
            item.classList.add("active");
            trigger.setAttribute("aria-expanded", "true");
        }
    });
});

document.getElementById("quantity").textContent = quantity;

const searchInput = document.querySelector("#researcher_search_input");
const searchResults = document.querySelector("#search_results");

searchInput.addEventListener("input", () => {

    const searchValue = searchInput.value.trim().toLowerCase();
    let visibleCount = 0;

    researcherItems.forEach(item => {

        const searchableContent = item.textContent.toLowerCase();
        const matches = searchableContent.includes(searchValue);

        item.classList.toggle("hidden", !matches);

        if (matches) {
            visibleCount++;
        } 
        else {
            item.classList.remove("active");
            item.querySelector(".researcher_trigger").setAttribute("aria-expanded", "false");
        }
    });

    if (searchValue === "") {
        searchResults.textContent = "";
    } 
    else {
        searchResults.textContent = `${visibleCount} researcher(s) found`;
    }
});
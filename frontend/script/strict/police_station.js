const stationItems = document.querySelectorAll(".station_item");

stationItems.forEach(item => {

    const trigger = item.querySelector(".station_trigger");

    trigger.addEventListener("click", () => {

        const isActive = item.classList.contains("active");

        stationItems.forEach(station => {
            station.classList.remove("active");
            station.querySelector(".station_trigger").setAttribute("aria-expanded", "false");
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
        } 
        else {

            item.classList.remove("active");
            item.querySelector(".station_trigger").setAttribute("aria-expanded", "false");
        }
    });

    if (searchValue === "") {
        searchResults.textContent = "";
    } 
    else {
        searchResults.textContent = `${visibleCount} police station(s) found`;
    }
});

function formatCPF(value) {
    const numbers = value.replace(/\D/g, "").slice(0, 11);

    return numbers
        .replace(/^(\d{3})(\d)/, "$1.$2")
        .replace(/^(\d{3})\.(\d{3})(\d)/, "$1.$2.$3")
        .replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d{1,2})$/, "$1.$2.$3-$4");
}

const cpfInput = document.querySelectorAll(".cpf");

cpfInput.forEach(cpf => {
    cpf.addEventListener("input", function () {
        const formattedValue = formatCPF(this.value);
        this.value = formattedValue;
    });
});

function formatPhone(value) {
    const numbers = value.replace(/\D/g, "").slice(0, 13);

    if (numbers.length <= 2) {
        return numbers.length ? `(${numbers}` : ""; 
    }
    if (numbers.length <= 4) {
        return `(${numbers.slice(0, 2)}) ${numbers.slice(2)}`;
    }
    if (numbers.length <= 9) {
        return `(${numbers.slice(0, 2)}) ${numbers.slice(2, 4)} ${numbers.slice(4)}`;
    }

    return `(${numbers.slice(0, 2)}) ${numbers.slice(2, 4)} ${numbers.slice(4, 9)}-${numbers.slice(9)}`;
}

const phoneInput = document.querySelectorAll(".phone");
phoneInput.forEach(phone => {
    phone.addEventListener("input", function () {
        this.value = formatPhone(this.value);
    });
});

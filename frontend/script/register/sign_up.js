const password = document.getElementById("password");
const togglePassword = document.getElementById("togglePassword");
const passwordIcon = document.getElementById("passwordIcon");

togglePassword.addEventListener("click", () => {

    const showPassword = password.type === "password";

    password.type = showPassword ? "text" : "password";
    passwordIcon.textContent = showPassword ? "visibility_off" : "visibility";

    togglePassword.setAttribute("aria-label", showPassword ? "hide" : "show");
    togglePassword.setAttribute("aria-pressed", String(showPassword));
});


const video = document.getElementById("video");

const videos = [
    "../../assets/videos/city.mp4",
    "../../assets/videos/earth.mp4",
    "../../assets/videos/forest.mp4",
    "../../assets/videos/gun.mp4",
    "../../assets/videos/people.mp4",
    "../../assets/videos/polar_light.mp4",
    "../../assets/videos/server.mp4"
];

let currentVideo = 0;

function playNextVideo() {
    currentVideo = (currentVideo + 1) % videos.length;

    video.src = videos[currentVideo];
    video.load();

    video.play().catch(error => {console.error(error);});
}

video.addEventListener("ended", playNextVideo);


function formatCPF(value) {
    const numbers = value.replace(/\D/g, "").slice(0, 11);

    return numbers
        .replace(/^(\d{3})(\d)/, "$1.$2")
        .replace(/^(\d{3})\.(\d{3})(\d)/, "$1.$2.$3")
        .replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d{1,2})$/, "$1.$2.$3-$4");
}

const cpfInput = document.getElementById("cpf");
cpfInput.addEventListener("input", function () {
    const formattedValue = formatCPF(this.value);
    this.value = formattedValue;
});


function formatCEP(value) {
    const numbers = value.replace(/\D/g, "").slice(0, 8);

    return numbers.replace(/^(\d{5})(\d)/, "$1-$2");
}

const cepInput = document.getElementById("cep");
cepInput.addEventListener("input", function () {
    const formattedValue = formatCEP(this.value);
    this.value = formattedValue;
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

const phoneInput = document.getElementById("phone");
phoneInput.addEventListener("input", function () {
    this.value = formatPhone(this.value);
});


function formatHouse(value) {
    return value.replace(/\D/g, "").slice(0, 5);
}

const houseNumberInput = document.getElementById("number");
houseNumberInput.addEventListener("input", function () {
    const formattedValue = formatHouse(this.value);
    this.value = formattedValue;
});


const listInputs = document.querySelectorAll("input[required]");
const registerButton = document.getElementById("submit_button");

function validateInputs() {
    let empty = false;

    for (let input of listInputs) {
        if (input.value.trim() === "") {
            empty = true;
            break;
        }
    }

    if (empty) {
        registerButton.disabled = true;
        registerButton.style.backgroundColor = "#eacd3eff";
        registerButton.style.cursor = "not-allowed";
    } 
    else {
        registerButton.disabled = false;
        registerButton.style.backgroundColor = "#fcde33ff";
        registerButton.style.cursor = "pointer";
    }
}

validateInputs();
listInputs.forEach(input => {input.addEventListener("input", validateInputs);});
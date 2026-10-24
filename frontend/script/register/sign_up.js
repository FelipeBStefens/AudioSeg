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


const form = document.querySelector(".register_left form");
const formBox = form.querySelector(".form_box");
const registerButton = document.getElementById("submit_button");
const nextButton = form.querySelector(".step_next");
const progressDots = [...form.querySelectorAll(".progress_dot")];
const stepContainers = [...formBox.querySelectorAll(".form_step")];

const steps = [
    {fields: ["username", "email", "password"]},
    {fields: ["birth_date", "cpf", "phone", "institute"]},
    {fields: ["country", "state", "city", "neighborhood"]},
    {fields: ["street", "cep", "number", "complement"]}
];

let currentStep = 0;
form.noValidate = true;

function showStep(index) {
    
    if (index < 0 || index >= stepContainers.length) {
        return;
    }

    currentStep = index;
    stepContainers.forEach((container, i) => {
        container.hidden = i !== currentStep;
    });

    progressDots.forEach((dot, i) => {
        dot.classList.toggle("active", i === currentStep);
        dot.classList.remove("completed");
        dot.setAttribute("aria-current", i === currentStep ? "step" : "false");
    });

    nextButton.hidden = currentStep === stepContainers.length - 1;
    registerButton.hidden = currentStep !== stepContainers.length - 1;

    const firstInput = stepContainers[currentStep].querySelector("input");

    if (firstInput) {
        firstInput.focus({ preventScroll: true });
    }
}

progressDots.forEach((dot, index) => {
    dot.addEventListener("click", () => showStep(index));
});

nextButton.addEventListener("click", () => {
    const inputs = stepContainers[currentStep].querySelectorAll("input");

    for (const input of inputs) {
        if (!input.checkValidity()) {
            input.reportValidity();
            return;
        }
    }

    showStep(currentStep + 1);
});

form.addEventListener("submit", event => {
    for (let i = 0; i < stepContainers.length; i++) {
        const inputs = stepContainers[i].querySelectorAll("input");

        for (const input of inputs) {
            if (!input.checkValidity()) {
                event.preventDefault();
                showStep(i);
                input.reportValidity();
                return;
            }
        }
    }
});


function validateInputs() {
    const allValid = [...requiredInputs].every(input =>
        input.value.trim() !== "" && input.checkValidity()
    );

    registerButton.disabled = !allValid;
    registerButton.style.backgroundColor = allValid ? "#fcde33ff" : "#eacd3eff";
    registerButton.style.cursor = allValid ? "pointer" : "not-allowed";
}

showStep(0);
validateInputs();

const requiredInputs = form.querySelectorAll("input[required]");

requiredInputs.forEach(input => {
    input.addEventListener("input", validateInputs);
    input.addEventListener("change", validateInputs);
});
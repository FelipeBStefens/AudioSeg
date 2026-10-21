const password = document.getElementById("password");
const togglePassword = document.getElementById("togglePassword");
const passwordIcon = document.getElementById("passwordIcon");
const video = document.getElementById("video");

togglePassword.addEventListener("click", () => {

    const showPassword = password.type === "password";

    password.type = showPassword ? "text" : "password";
    passwordIcon.textContent = showPassword ? "visibility_off" : "visibility";

    togglePassword.setAttribute("aria-label", showPassword ? "hide" : "show");
    togglePassword.setAttribute("aria-pressed", String(showPassword));
});

if (video) {

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

        video.play().catch(error => {
            console.error(error);
        });
    }

    video.addEventListener("ended", playNextVideo);
}

const listInputs = document.querySelectorAll("input");
const registerButton = document.getElementById("submit_bt");

function validateInputs() {
    let empty = false;

    for (let input of listInputs) {
        if (input.value.trim() == "") {
            empty = true;
            break;
        }
    }

    if (empty) {
        registerButton.disabled = true;
        registerButton.style.backgroundColor = "#979909";
        registerButton.style.cursor = "not-allowed";
    } else {
        registerButton.disabled = false;
        registerButton.style.backgroundColor = "#fcde33ff";
        registerButton.style.cursor = "pointer";
    }
}

validateInputs();

listInputs.forEach(input => {
    input.addEventListener("input", validateInputs);
})
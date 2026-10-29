
"use strict";

function changeScreen(id, optionId) {
    const allScreens = document.querySelectorAll(".screen");
    const allOptions = document.querySelectorAll(".edition_opt");

    const currentScreen = document.getElementById(id);
    const currentOption = document.getElementById(optionId);

    if (!currentScreen || !currentOption) {
        return;
    }

    allScreens.forEach((screen) => {
        screen.classList.remove("active");
    });

    allOptions.forEach((option) => {
        option.classList.remove("opt_active");
        option.removeAttribute("aria-current");
    });

    currentScreen.classList.add("active");
    currentOption.classList.add("opt_active");
    currentOption.setAttribute("aria-current", "page");
}

// Contador de caracteres da descrição.
const description = document.getElementById("description");
const descriptionCount = document.getElementById("description_count");

function updateDescriptionCount() {
    if (!description || !descriptionCount) {
        return;
    }

    descriptionCount.textContent = description.value.length;
}

description?.addEventListener("input", updateDescriptionCount);
updateDescriptionCount();

// Pré-visualização da foto de perfil.
const photoInput = document.getElementById("profile_photo");
const profileImage = document.getElementById("profile_preview");

let previewUrl = null;

photoInput?.addEventListener("change", () => {
    const file = photoInput.files?.[0];

    if (!file) {
        return;
    }

    const allowedTypes = [
        "image/jpeg",
        "image/png",
        "image/webp"
    ];

    const maxSize = 2 * 1024 * 1024;

    if (!allowedTypes.includes(file.type) || file.size > maxSize) {
        alert("Choose a JPEG, PNG or WebP image up to 2 MB.");
        photoInput.value = "";
        return;
    }

    if (previewUrl) {
        URL.revokeObjectURL(previewUrl);
    }

    previewUrl = URL.createObjectURL(file);
    profileImage.src = previewUrl;
});

document.querySelectorAll("[data-action]").forEach((button) => {
    button.addEventListener("click", () => {
        const action = button.dataset.action;

        switch (action) {
            case "change-email":
                alert("The secure e-mail change flow must be implemented.");
                break;

            case "change-phone":
                alert("The secure phone change flow must be implemented.");
                break;

            case "change-password":
                alert("The secure password change flow must be implemented.");
                break;
        }
    });
});

changeScreen("account", "account_opt");
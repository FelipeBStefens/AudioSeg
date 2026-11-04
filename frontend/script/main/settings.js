function changeScreen(id, optionId) {

    const allScreens = document.querySelectorAll(".screen");
    const allOptions = document.querySelectorAll(".edition_opt");
    const currentScreen = document.getElementById(id);
    const currentOption = document.getElementById(optionId);

    if (!currentScreen || !currentOption) {
        return;
    }

    allScreens.forEach((screen) => {screen.classList.remove("active");});

    allOptions.forEach((option) => {
        option.classList.remove("opt_active");
        option.removeAttribute("aria-current");
    });

    currentScreen.classList.add("active");
    currentOption.classList.add("opt_active");
    currentOption.setAttribute("aria-current", "page");
}


const description = document.getElementById("description");
const descriptionCount = document.getElementById("description_count");

function updateDescriptionCount() {

    if (!description || !descriptionCount) {
        return;
    }
    descriptionCount.textContent = description.value.length;
}

description.addEventListener("input", updateDescriptionCount);
updateDescriptionCount();


const photoInput = document.getElementById("profile_photo");
const profileImage = document.getElementById("profile_preview");
let previewUrl = null;

photoInput?.addEventListener("change", () => {

    const file = photoInput.files?.[0];
    if (!file) {
        return;
    }

    const allowedTypes = ["image/jpeg", "image/png", "image/webp"];
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


const securityDialog = document.getElementById("security_dialog");
const dialogTitle = document.getElementById("dialog_title");
const closeDialog = document.getElementById("close_dialog");
const securityForms = document.querySelectorAll(".security-form");

const dialogOptions = {
    "change-email": {title: "Change e-mail", form: "email_form"},
    "change-phone": {title: "Change phone", form: "phone_form"},
    "change-password": {title: "Change password", form: "password_form"},
    "delete-account": {title: "Delete account", form: "delete_form"}
};

function openSecurityDialog(action) {

    const option = dialogOptions[action];
    if (!option) {
        return;
    }

    securityForms.forEach((form) => {
        form.reset();
        form.hidden = true;
    });

    const selectedForm = document.getElementById(option.form);
    if (!selectedForm) {
        return;
    }

    selectedForm.hidden = false;
    dialogTitle.textContent = option.title;
    
    securityDialog.showModal();
}

function closeSecurityDialog() {
    if (securityDialog.open) {
        securityDialog.close();
    }
}


document.querySelectorAll("[data-action]").forEach((button) => {

    button.addEventListener("click", () => {
        const action = button.dataset.action;
        openSecurityDialog(action);
    });
});

closeDialog.addEventListener("click", closeSecurityDialog);

document.querySelectorAll(".cancel-dialog").forEach((button) => {
    button.addEventListener("click", closeSecurityDialog);
});

securityDialog.addEventListener("close", () => {

    securityForms.forEach((form) => {
        form.reset();
        form.hidden = true;
    });
});


changeScreen("account", "account_opt");

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

const phoneInput = document.getElementById("new_phone");
phoneInput.addEventListener("input", function () {
    this.value = formatPhone(this.value);
});
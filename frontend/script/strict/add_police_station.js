function formatCEP(value) {
    const numbers = value.replace(/\D/g, "").slice(0, 8);

    return numbers.replace(/^(\d{5})(\d)/, "$1-$2");
}

const cepInput = document.getElementById("cep");
cepInput.addEventListener("input", function () {
    const formattedValue = formatCEP(this.value);
    this.value = formattedValue;
});
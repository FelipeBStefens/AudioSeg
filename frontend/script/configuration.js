function changeScreen(id, option_id){
    let allScreens = document.querySelectorAll(".screen");
    allScreens.forEach(screen => {
        screen.classList.remove("active");
    })

    let allOptions = document.querySelectorAll(".edition_opt");
    allOptions.forEach(option => {
        option.classList.remove("opt_active");
    })

    const currentScreen = document.getElementById(id);
    currentScreen.classList.add("active");

    const currentOption = document.getElementById(option_id);
    currentOption.classList.add("opt_active");
}
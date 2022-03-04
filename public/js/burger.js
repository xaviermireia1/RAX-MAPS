var btnBurger = document.getElementById("btn-burger");
var sidebar = document.getElementById("sidebar");
var formSidebar = document.getElementById("form-sidebar");

btnBurger.onclick = function() {
    if (sidebar.classList.contains("expanded")) {
        sidebar.classList.remove("expanded");
        formSidebar.classList.add("hidden");
    } else {
        sidebar.classList.add("expanded");
        formSidebar.classList.remove("hidden");
    }

}
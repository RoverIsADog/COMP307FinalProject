var navOpen = true;

function toggleNav() {
    var x = document.getElementById("sidebar");
    if (navOpen) {
        navOpen = false;
        x.style.width = "10px";
    }
    else {
        navOpen = true;
        x.style.width = "250px";
    }

}
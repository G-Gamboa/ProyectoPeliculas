var slider = document.getElementById("myRange");
var marker = document.getElementById("marker");

slider.oninput = function() {
    marker.style.left = (this.value / 10) * 100 + "%";
    marker.innerText = this.value;
};

slider.onchange = function() {
    var selectedNumber = this.value;
    window.location.href = "peliculas.php?numero=" + selectedNumber;
};

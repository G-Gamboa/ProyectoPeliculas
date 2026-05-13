$(document).ready(function () {
    var page = 2;
    var isLoading = false;

    function loadSeries() {
        if (!isLoading) {
            isLoading = true;
            $.ajax({
                url: 'controladores/obtenerSeries.php',
                type: 'GET',
                data: { page: page },
                success: function (data) {
                    $('#movies-container').append(data);
                    page++;
                    isLoading = false;
                },
                error: function (xhr, status, error) {
                    console.error('Error al cargar más series:', error);
                    isLoading = false;
                }
            });
        }
    }

    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
            loadSeries();
        }
    });
});

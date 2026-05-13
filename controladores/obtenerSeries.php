<?php

if (isset($_GET['genero']) && !empty($_GET['genero'])) {
    $genero = $_GET['genero'];
    include 'obtenerSeriesPorNombre.php';
    $titulos = json_decode($response, true);
} elseif (isset($_GET['id']) || isset($_GET['anio']) || isset($_GET['numero'])) {
    include 'obtenerSeriesMayoria.php';
    $json_data = file_get_contents('json/datosGeneralesSeries.json');
    $titulos = json_decode($json_data, true);
} else {
    include 'obtenerSeriesActuales.php';
    $titulos = json_decode($response, true);
}

foreach ($titulos['results'] as $name) {
    if (isset($_GET['id'])) {
        $idBuscado = $_GET['id'];
        foreach ($name['genre_ids'] as $gene) {
            if ($gene == $idBuscado) {
                MostrarSeries($name);
            }
        }
    } elseif (isset($_GET['anio'])) {
        $anioBuscado = $_GET['anio'];
        $anio = date('Y', strtotime($name['first_air_date']));
        if ($anio == $anioBuscado) {
            MostrarSeries($name);
        }
    } elseif (isset($_GET['numero'])) {
        $valoracion = (float) $_GET['numero'];
        $vota = $name['vote_average'];
        if ($vota >= $valoracion && $vota < $valoracion + 1) {
            MostrarSeries($name);
        }
    } else {
        MostrarSeries($name);
    }
}

function MostrarSeries($name)
{
    echo "<div class='col-md-4 card' style='width: 18rem;'>
        <a data-aos='fade-in' href='infoDetalladaSeries.php?id=" . $name['id'] . "'>
            <img src='https://media.themoviedb.org/t/p/w220_and_h330_face/" . $name['poster_path'] . "' class='card-img-top'>
            <div class='card-body'>
                <h3 class='card-title text-center'>" . htmlspecialchars($name['name'], ENT_QUOTES, 'UTF-8') . "</h3>
            </div>
        </a>
    </div>";
}

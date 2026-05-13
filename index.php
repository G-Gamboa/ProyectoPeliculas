<?php

include 'controladores/obtenerProximos.php';

if ($err) {
    echo "cURL Error #:" . $err;
}

$data = json_decode($response, true);
$results = $data['results'];
$num_results = min(12, count($results));

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CinePlus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos/general.css">
    <link rel="stylesheet" href="estilos/swiper.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">CinePlus</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="peliculas.php">Peliculas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="series.php">Series</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="seriesPopulares.php">Más Populares</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="proximos">
        <h2 class="titu2">Proximamente...</h2>

        <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" slides-per-view="4"
            space-between="30" free-mode="true">

            <?php
            for ($i = 0; $i < $num_results; $i++) {
                $peli = $results[$i];
                echo "<swiper-slide>
                    <a href='infoDetallada.php?id=" . $peli['id'] . "'>
                        <img src='https://media.themoviedb.org/t/p/w220_and_h330_face/" . $peli['poster_path'] . "' alt='" . htmlspecialchars($peli['title'], ENT_QUOTES, 'UTF-8') . "' class='d-block w-100'>
                    </a>
                </swiper-slide>";
            }
            ?>

        </swiper-container>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 1000 });
    </script>
</body>

</html>

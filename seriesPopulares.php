<?php
    include 'controladores/obtenerSeriesPopulares.php';
    $titulos = json_decode($response, true);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Series</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos/general.css">
    <link rel="stylesheet" href="estilos/peliculas.css">

    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="./index.php">CinePlus</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
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
    </nav>
    <main>
        <div class="container">
            <div class="row" id=movies-container>
                <?php 
            foreach ($titulos['results'] as $name) {
              echo "
              <div class='col-md-4 card' style='width: 18rem;'>
              <a href='infoDetalladaSeries.php?id=".$name['id']."'>
                  <img src='https://media.themoviedb.org/t/p/w220_and_h330_face/".$name['poster_path']."' class='card-img-top'>
                  <div class='card-body'>
                      <h3 class='card-title text-center'>".$name['name']."</h3>
                  </div>
                  </a>
              </div>";
            }
             ?>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 1000 // Duración de la animación en milisegundos
        });

    </script>
</body>

</html>
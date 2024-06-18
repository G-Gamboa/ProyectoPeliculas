<?php
    include 'controladores/obtenerGeneros.php';
    include 'controladores/obtenerSeriesActuales.php';

if ($err) {
  echo "cURL Error #:" . $err;
}

$generos = json_decode($generes,true);
$filtroAnios=json_decode($response,true);

$aniosDistintos=[];

foreach($filtroAnios['results'] as $serie){
    $fecha=$serie['first_air_date'];
    $anio = date('Y', strtotime($fecha));

    if(!in_array($anio,$aniosDistintos)){
        $aniosDistintos[]=$anio;
    }
}

rsort($aniosDistintos);

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
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php">CinePlus</a>
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


    <main>
        <aside class="row">

            <form class="form-inline col-12 col-md-4 filtro" action="series.php" method="GET">
                <input class="form-control mr-sm-2" type="search" name="genero" placeholder="Nombre Serie"
                    aria-label="Search">
                <div class="lado">
                    <button class="buscar btn btn-outline-primary my-2 my-sm-0" type="submit">Buscar</button>
                </div>
            </form>


            <div class="col-12 col-md-3 filtro mt-3 mt-md-0">
                <h2>Calificación</h2>
                <div class="recta">
                    <input type="range" min="0" max="10" value="0" class="slider" id="myRange">
                    <div id="marker">0</div>
                </div>
            </div>



            <div class="col-6 col-md-2 filtro mt-3 mt-md-0 dropdown">
                <a class="genColor btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Géneros
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="series.php">Todos los géneros</a></li>
                    <?php
                        foreach ($generos['genres'] as $genre) {
                            echo "<li>
                            <a class='dropdown-item' href='series.php?id=".$genre['id']."'.>". $genre['name']."</a>
                            </li>";
                        }
                    ?>
                </ul>
            </div>


            <div class="col-6 col-md-2 filtro mt-3 mt-md-0 dropdown">
                <a class="genColor btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Años de Estreno
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="series.php">Actualmente</a></li>
                    <?php
                        foreach ($aniosDistintos as $an) {
                            echo "<li>
                            <a class='dropdown-item' href='series.php?anio=".$an."'.>". $an."</a>
                            </li>";
                        }
                    ?>
                </ul>
            </div>



        </aside>
        <div class="container">
            <div class="row" id=movies-container>
                <?php include '<controladores/obtenerSeries.php'; ?>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="scripts/cargarMasSeries.js"></script>
    <script src="scripts/barraSeries.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>


    <script>
        AOS.init({
            duration: 1000 // Duración de la animación en milisegundos
        });

    </script>
</body>

</html>
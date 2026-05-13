<?php

if (isset($_GET['id'])) {
    $movie_id = $_GET['id'];
    include 'controladores/obtenerCreditos.php';
    include 'controladores/obtenerDetallesPeliculas.php';
    include 'controladores/obtenerVideos.php';
    include 'controladores/obtenerReview.php';
    include 'controladores/obtenerSimilares.php';

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $data = json_decode($response, true);
        $dataCredits = json_decode($credits, true);
        $multimedia = json_decode($trailer, true);
        $opinion = json_decode($review, true);
        $recomend = json_decode($similares, true);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($data['title'], ENT_QUOTES, 'UTF-8'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos/general.css">
    <link rel="stylesheet" href="estilos/swiper.css">
    <link rel="stylesheet" href="estilos/info.css">
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

    <header class="bg-header py-5" data-aos="fade-in"
        style="background-image: url('https://image.tmdb.org/t/p/w1920_and_h800_multi_faces/<?php echo $data['backdrop_path']; ?>')">
        <div class="overlay"></div>
        <div class="cHeader container px-5">
            <div class="row gx-5 align-items-center justify-content-center">
                <div class="col-lg-8 col-xl-7 col-xxl-6">
                    <div class="my-5 text-center text-xl-start text-header">
                        <h1 class="display-5 fw-bolder text-white mb-2">
                            <?php echo htmlspecialchars($data['title'], ENT_QUOTES, 'UTF-8'); ?>
                        </h1>
                        <p class="lead fw-normal text-white-50 mb-4">
                            <?php echo htmlspecialchars($data['overview'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                            <?php
                            $key = '';
                            $videoTrailer = $multimedia['results'];
                            foreach ($videoTrailer as $dato) {
                                if ($dato['iso_3166_1'] === 'ES' && $dato['type'] === "Trailer") {
                                    $key = $dato['key'];
                                }
                            }
                            ?>
                            <a id="trailerButton" class="btn btn-primary btn-lg px-4 me-sm-3">Ver Trailer</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center img-header">
                    <img class="img-fluid rounded-3 my-5"
                        src="https://media.themoviedb.org/t/p/w220_and_h330_face/<?php echo $data['poster_path']; ?>"
                        alt="<?php echo htmlspecialchars($data['title'], ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
            </div>
        </div>
    </header>

    <dialog id="modal" data-aos="fade-down-left">
        <span id="cerrar" class="close">&times;</span>
        <iframe id="trailerFrame" src="" frameborder="0" allowfullscreen></iframe>
    </dialog>

    <section class="cSection py-5" id="features" data-aos="zoom-in">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-4 mb-5 mb-lg-0 text-center">
                    <h2 class="titu2 fw-bolder mb-0">Calificación</h2>
                    <div class="grafico">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row gx-5 row-cols-1 row-cols-md-2">
                        <div class="col mb-5 h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                <i class="bi bi-clock-fill"></i> <b>Duración</b>
                            </div>
                            <h2 class="h5"><?php echo $data['runtime']; ?> minutos</h2>
                        </div>
                        <div class="col mb-5 h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                <i class="bi bi-coin"></i> <b>Presupuesto</b>
                            </div>
                            <h2 class="h5">$<?php echo number_format($data['budget']); ?></h2>
                        </div>
                        <div class="col mb-5 mb-md-0 h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                <i class="bi bi-person-circle"></i> <b>Director</b>
                            </div>
                            <h2 class="h5">
                                <?php
                                foreach ($dataCredits['crew'] as $member) {
                                    if ($member['job'] === 'Director') {
                                        echo htmlspecialchars($member['name'], ENT_QUOTES, 'UTF-8');
                                        break;
                                    }
                                }
                                ?>
                            </h2>
                        </div>
                        <div class="col h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                <i class="bi bi-cash-coin"></i> <b>Ingresos</b>
                            </div>
                            <h2 class="h5">$<?php echo number_format($data['revenue']); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="cast" data-aos="zoom-out">
        <h2 class="titu2">Elenco</h2>
        <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" slides-per-view="4"
            space-between="20" free-mode="true">
            <?php
            $castResults = $dataCredits['cast'];
            $num_cast = min(12, count($castResults));
            for ($i = 0; $i < $num_cast; $i++) {
                $person = $castResults[$i];
                echo "<swiper-slide>
                    <img src='https://media.themoviedb.org/t/p/w220_and_h330_face/" . $person['profile_path'] . "' alt='" . htmlspecialchars($person['name'], ENT_QUOTES, 'UTF-8') . "' class='d-block w-100'>
                    <div class='person-info'>
                        <p class='person-name'>" . htmlspecialchars($person['name'], ENT_QUOTES, 'UTF-8') . "</p>
                        <p class='person-character'>" . htmlspecialchars($person['character'], ENT_QUOTES, 'UTF-8') . "</p>
                    </div>
                </swiper-slide>";
            }
            ?>
        </swiper-container>
    </div>

    <section class="recomend py-5" data-aos="fade-down">
        <div class="container px-5 my-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="text-center">
                        <h2 class="titu2 fw-bolder">Recomendaciones</h2>
                    </div>
                </div>
            </div>
            <div class="row gx-5">
                <?php
                $recomResults = $recomend['results'];
                $num_recom = min(3, count($recomResults));
                for ($i = 0; $i < $num_recom; $i++) {
                    $peliSimilar = $recomResults[$i];
                    echo "<div class='col-lg-4 mb-5'>
                        <div class='card h-100 shadow border-0'>
                            <img class='card-img-top' src='https://media.themoviedb.org/t/p/w220_and_h330_face/" . $peliSimilar['poster_path'] . "'/>
                            <div class='card-body p-4'>
                                <a class='text-decoration-none link-dark stretched-link' href='infoDetallada.php?id=" . $peliSimilar['id'] . "'>
                                    <h5 class='card-title mb-3'>" . htmlspecialchars($peliSimilar['title'], ENT_QUOTES, 'UTF-8') . "</h5>
                                </a>
                                <p class='card-text mb-0'>" . htmlspecialchars($peliSimilar['overview'], ENT_QUOTES, 'UTF-8') . "</p>
                            </div>
                        </div>
                    </div>";
                }
                ?>
            </div>
        </div>
    </section>

    <?php
    $resultados = $opinion['results'];
    if (!empty($resultados)) {
        $review_data = $opinion['results'][0];
        $author_name = $review_data['author'];
        $avatar_path = $review_data['author_details']['avatar_path'];
        $content = $review_data['content'];
        $username = $review_data['author_details']['username'];

        echo "<div class='py-5 bg-light' data-aos='flip-left'>
            <div class='container px-5 my-5'>
                <div class='row gx-5 justify-content-center'>
                    <div class='col-lg-10 col-xl-7'>
                        <div class='text-center'>
                            <h2 class='titu2 fw-bolder'>Opinión</h2>
                        </div>
                        <div class='text-center'>
                            <div class='comentario fs-4 mb-4 fst-italic'>" . htmlspecialchars($content, ENT_QUOTES, 'UTF-8') . "</div>
                            <div class='d-flex align-items-center justify-content-center'>
                                <img class='profile rounded-circle me-3' src='https://media.themoviedb.org/t/p/w220_and_h330_face/" . $avatar_path . "'/>
                                <div class='fw-bold'>" .
                                    htmlspecialchars($author_name, ENT_QUOTES, 'UTF-8') .
                                    "<span class='fw-bold text-primary mx-1'>/</span>" .
                                    htmlspecialchars($username, ENT_QUOTES, 'UTF-8') .
                                "</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <script>
        var ctx = document.getElementById('pieChart').getContext('2d');
        var voteAverage = <?php echo $data['vote_average'] * 10; ?>;
        var missingPercentage = 100 - voteAverage;

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Aceptada', 'Rechazada'],
                datasets: [{
                    data: [voteAverage, missingPercentage],
                    backgroundColor: ['#00488B', '#E2001A'],
                    borderColor: ['#FFC72C', '#FFC72C']
                }]
            },
            options: {
                responsive: true,
                legend: { display: false },
                animation: { animateScale: true, animateRotate: true }
            }
        });

        document.getElementById('trailerButton').addEventListener('click', function () {
            var modal = document.getElementById('modal');
            var trailerFrame = document.getElementById('trailerFrame');
            trailerFrame.src = "https://www.youtube.com/embed/" + "<?php echo $key; ?>";
            modal.classList.add('show');
        });

        document.querySelector('.close').addEventListener('click', function () {
            var modal = document.getElementById('modal');
            modal.classList.remove('show');
            document.getElementById('trailerFrame').src = "";
        });

        window.addEventListener('click', function (event) {
            var modal = document.getElementById('modal');
            if (event.target == modal) {
                modal.classList.remove('show');
                document.getElementById('trailerFrame').src = "";
            }
        });

        AOS.init({ duration: 1000 });
    </script>
</body>

</html>

<?php
    }
}
?>

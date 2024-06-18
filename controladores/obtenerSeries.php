<?php

if (isset($_GET['genero']) && !empty($_GET['genero'])) {
  $genero = $_GET['genero'];
  include 'obtenerSeriesPorNombre.php';
  $titulos = json_decode($response, true);
}
else if (isset($_GET['id']) || isset($_GET['anio']) || isset($_GET['numero']) ){
  include 'obtenerSeriesMayoria.php';
  $json_data = file_get_contents('json/datosGeneralesSeries.json');
  $titulos = json_decode($json_data, true);
}
else{

  include 'obtenerSeriesActuales.php';
  $titulos = json_decode($response, true);
}


$idGeneros=[];

foreach ($titulos['results'] as $name) {
  
  if (isset($_GET['id'])){
      $idBuscado = $_GET['id'];
      $idGeneros=$name['genre_ids'];
      foreach ($idGeneros as $gene){
        if($gene == $idBuscado){
          MostrarSeries($name);
        }
      }

    }else if (isset($_GET['anio'])){
      $anioBuscado = $_GET['anio'];

      $fecha=$name['first_air_date'];
      $anio = date('Y', strtotime($fecha));

      if($anio == $anioBuscado){
        MostrarSeries($name);
      }
    } else if (isset($_GET['numero'])){
      $valoracion= $_GET['numero'];
      $vota=$name['vote_average'];

        if($vota >= $valoracion && $vota<$valoracion+1){
            MostrarSeries($name);
      }

    }
    else{
        MostrarSeries($name);
    }
}



function MostrarSeries($name){
  echo "
  <div class='col-md-4 card' style='width: 18rem;'>
  <a data-aos='fade-in' href='infoDetalladaSeries.php?id=".$name['id']."'>
      <img src='https://media.themoviedb.org/t/p/w220_and_h330_face/".$name['poster_path']."' class='card-img-top'>
      <div class='card-body'>
          <h3 class='card-title text-center'>".$name['name']."</h3>
      </div>
      </a>
  </div>";
}



?>

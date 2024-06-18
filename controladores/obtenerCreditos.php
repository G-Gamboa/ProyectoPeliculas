<?php	

    //Consumo para obtener la información del personal que participo
    $curl = curl_init();
    $url="https://api.themoviedb.org/3/movie/" . $movie_id . "/credits?language=es-GT";
    curl_setopt_array($curl, [
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => [
        "Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI5MGYxNDZhNzU0ZWYxN2E3OWNkYWE4MzVjYzc1NmYxMSIsInN1YiI6IjY2M2MzNGFjZTZmM2U5NGQ2YTExNzI3ZCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ._prxOXrj-hUWxhJmF3pfM9V1aLwuQTGDkhvkxtcWQwE",
        "accept: application/json"
      ],
    ]);


    $credits = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

?>
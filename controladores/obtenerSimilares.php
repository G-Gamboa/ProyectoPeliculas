<?php

require_once __DIR__ . '/../config.php';

$curl = curl_init();
$url = "https://api.themoviedb.org/3/movie/" . $movie_id . "/similar?language=es-GT&page=1";

curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer " . TMDB_TOKEN,
        "accept: application/json"
    ],
]);

$similares = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

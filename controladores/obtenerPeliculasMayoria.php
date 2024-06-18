<?php
function fetchDataAsync($total_pages) {
    $multiCurl = [];
    $results = [];
    $mh = curl_multi_init();

    for ($page = 1; $page <= $total_pages; $page++) {
        $url = "https://api.themoviedb.org/3/movie/now_playing?language=es-gt&page=" . $page;

        $curl = curl_init();
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

        curl_multi_add_handle($mh, $curl);
        $multiCurl[$page] = $curl;
    }

    $index = null;
    do {
        curl_multi_exec($mh, $index);
    } while ($index > 0);

    foreach ($multiCurl as $page => $curl) {
        $response = curl_multi_getcontent($curl);
        $data = json_decode($response, true);
        if (isset($data['results'])) {
            $results = array_merge($results, $data['results']);
        }
        curl_multi_remove_handle($mh, $curl);
    }

    curl_multi_close($mh);

    return $results;
}

$total_pages = 100;
$combined_results = fetchDataAsync($total_pages);

// Guarda los resultados combinados en un archivo JSON dentro de un elemento 'results'
$output = ['results' => $combined_results];
file_put_contents('json/datosGeneralesPeliculas.json', json_encode($output, JSON_UNESCAPED_UNICODE));

?>

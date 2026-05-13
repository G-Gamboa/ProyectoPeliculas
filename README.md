# CinePlus

Aplicación web para explorar películas y series de televisión, desarrollada en PHP. Consume la API de [The Movie Database (TMDb)](https://www.themoviedb.org/) para mostrar información actualizada sobre títulos en cartelera, próximos estrenos y series en emisión.

## Características

- **Inicio** — carrusel de próximos estrenos con navegación deslizable
- **Películas** — listado con filtros por género, año de lanzamiento y calificación; carga infinita por scroll
- **Series** — listado con los mismos filtros; incluye una sección de series más populares
- **Detalle de película** — sinopsis, elenco, director, presupuesto, ingresos, gráfico de calificación, trailer y recomendaciones
- **Detalle de serie** — sinopsis, elenco, creador, temporadas, estado de emisión, próximo episodio y recomendaciones

## Tecnologías

| Capa | Herramienta |
|---|---|
| Backend | PHP (cURL, curl_multi) |
| Frontend | Bootstrap 5, Bootstrap Icons |
| Animaciones | AOS 2.3.4 |
| Carrusel | Swiper 11 |
| Gráficos | Chart.js |
| Peticiones AJAX | jQuery 3.6 |
| API | TMDb API v3 |

## Instalación

### Requisitos

- PHP 7.4 o superior con extensión `curl` habilitada
- Servidor web (Apache, Nginx, PHP built-in server)
- Token de API de TMDb ([obtener aquí](https://developer.themoviedb.org/docs/getting-started))

### Pasos

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/G-Gamboa/ProyectoPeliculas.git
   cd ProyectoPeliculas
   ```

2. Copiar el archivo de configuración y añadir el token:
   ```bash
   cp config.example.php config.php
   ```
   Editar `config.php` y reemplazar `YOUR_TMDB_API_TOKEN_HERE` con el token de lectura de TMDb.

3. Iniciar el servidor de desarrollo:
   ```bash
   php -S localhost:8000
   ```

4. Abrir `http://localhost:8000` en el navegador.


## Estructura del proyecto

```
ProyectoPeliculas/
├── index.php                   # Página de inicio
├── peliculas.php               # Listado de películas
├── series.php                  # Listado de series
├── seriesPopulares.php         # Series más populares
├── infoDetallada.php           # Detalle de película
├── infoDetalladaSeries.php     # Detalle de serie
├── config.php                  # Token de API (excluido de git)
├── config.example.php          # Plantilla de configuración
├── controladores/              # Controladores de llamadas a la API
├── estilos/                    # Hojas de estilo CSS
├── scripts/                    # Scripts JavaScript
└── json/                       # Caché de datos (excluido de git)
```

## Uso de la caché

Los filtros por género, año y calificación requieren que los archivos de caché existan en `json/`. Estos se generan automáticamente la primera vez que se accede a cualquier filtro, descargando datos en paralelo mediante `curl_multi`. La generación puede tardar varios segundos dependiendo de la conexión.

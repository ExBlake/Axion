<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutoriales</title>
    <link rel="icon" type="image/x-icon" href="Icono">
    <link rel="stylesheet" href="Estilos_Menu">
    <link rel="stylesheet" href="Estilos_Tutoriales">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500&display=swap">
    <!-- Fuentes adicionales -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&display=swap">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include 'Layout/HeaderLeft.php'; ?>

        <!-- Main Content -->
        <div class="main-content">

            <!-- Tutorials Content -->
            <div class="dashboard-content">
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Tutoriales</h1>
                    <p>Aprende a utilizar nuestro panel de control y visualiza tus datos de forma clara y precisa.</p>
                </div>
                <!-- Videos Grid -->
                <div class="videos-grid" id="videos-grid">
                    <div class="video-card" data-video-id="1"
                        data-video-url="https://www.youtube.com/embed/1qnUnR8QQfI?si=Qabm27NBPjdChUcT"
                        data-description="Descubre cómo personalizar tu panel de control para adaptarlo a tus necesidades, visualizar la información más relevante y mejorar tu experiencia dentro de la plataforma de forma rápida y sencilla.">
                        <div class="video-thumbnail">
                            <div class="thumbnail-placeholder">
                                <img src="PImageTutoriales/Configuracion.png" alt="Perzonalización"
                                    loading="lazy">
                                <i class="fas fa-play-circle"></i>
                                <div class="play-button-center"><i class="fas fa-play"></i></div>
                            </div>
                            <div class="duration-badge">8:45</div>
                        </div>
                        <div class="video-info">
                            <h3 class="video-title">Guía rápida para personalizar tu Panel de Control</h3>
                        </div>
                    </div>
                    <div class="video-card" data-video-id="2" data-video-url="https://www.youtube.com/embed/0EwXW_C17z0?si=NP5T-I3OYLAQUEZ-"
                        data-description="Aprende cómo gestionar de manera efectiva tus PQRS (Peticiones, Quejas, Reclamos y Sugerencias) dentro de nuestra plataforma, asegurando una atención oportuna, organizada y conforme a los lineamientos de calidad del servicio.">
                        <div class="video-thumbnail">
                            <div class="thumbnail-placeholder">
                                <img src="PImageTutoriales/PQRS.png" alt="PQRS"
                                    loading="lazy">
                                <i class="fas fa-play-circle"></i>
                                <div class="play-button-center"><i class="fas fa-play"></i></div>
                            </div>
                            <div class="duration-badge">8:45</div>
                        </div>
                        <div class="video-info">
                            <h3 class="video-title">Todo lo que Debes Saber para Gestionar tus PQRS</h3>
                        </div>
                    </div>
                    <div class="video-card" data-video-id="1" data-video-url="https://www.youtube.com/embed/dQw4w9WgXcQ"
                        data-description="Una introducción completa al panel principal.">
                        <div class="video-thumbnail">
                            <div class="thumbnail-placeholder">
                                <img src="PImageTutoriales/PBI.png" alt="Dashboard Overview - Getting Started"
                                    loading="lazy">
                                <i class="fas fa-play-circle"></i>
                                <div class="play-button-center"><i class="fas fa-play"></i></div>
                            </div>
                            <div class="duration-badge">8:45</div>
                        </div>
                        <div class="video-info">
                            <h3 class="video-title">Dashboard Overview - Getting Started</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Modal -->
    <div id="video-modal" class="modal">
        <div class="modal-content video-modal-content">
            <div class="modal-header">
                <h2 id="video-title">Tutorial Title</h2>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="video-player">
                    <div class="video-placeholder" id="video-player">
                        <i class="fas fa-play-circle"></i>
                        <p>Click to play video</p>
                    </div>
                </div>
                <div class="video-info">
                    <div class="video-description">
                        <h3>Descripción</h3>
                        <p id="video-description">Video description will appear here...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="Funcion_Menu"></script>
    <script src="Funcion_Sincronizacion"></script>
    <script src="Funcion_Tutoriales"></script>
</body>

</html>
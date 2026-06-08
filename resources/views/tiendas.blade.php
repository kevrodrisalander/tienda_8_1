@extends('layouts.app')

@section('content')
    <style>
        :root {
            --cherry-main: #D91A46;
            --cherry-dark: #A30B2E;
            --cherry-light: #FFF0F3;
            --bg-global: #F8F9FA;
            --text-dark: #2B2D42;
        }

        /* Ajuste por si el layout no tiene el fondo que deseas */
        .cherry-body-wrapper {
            font-family: 'Montserrat', sans-serif;
            color: var(--text-dark);
            padding-bottom: 50px;
        }

        /* HERO REIMAGINADO */
        .hero {
            background: linear-gradient(135deg, var(--cherry-dark), var(--cherry-main));
            color: white;
            padding: 60px 20px;
            border-radius: 24px;
            text-align: center;
            margin-top: 20px;
            box-shadow: 0 10px 30px rgba(217, 26, 70, 0.2);
            position: relative;
            overflow: hidden;
        }

        .hero h1 {
            font-family: 'Poppins', Arial, sans-serif;
            font-weight: 700;
            font-size: 2.8rem;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .hero p {
            font-weight: 300;
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* SECCIÓN DE CONTENIDO */
        .section-title {
            font-family: 'Poppins', Arial, sans-serif;
            font-weight: 700;
            color: var(--cherry-dark);
            font-size: 1.25rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .section-title::before,
        .section-title::after {
            content: "";
            display: block;
            width: 40px;
            height: 2px;
            background: var(--cherry-main);
        }

        /* CONTENEDOR DE ENLACES (GRID REPOSITIVO) */
        .links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
            margin-bottom: 50px;
        }

        .font_links {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            background: white;
            color: var(--text-dark);
            font-weight: 600;
            text-decoration: none !important;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(0, 0, 0, 0.02);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .font_links::after {
            content: "➔";
            font-size: 1.1rem;
            color: var(--cherry-main);
            transition: transform 0.3s ease;
        }

        .font_links:hover {
            background: white;
            color: var(--cherry-main);
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(217, 26, 70, 0.12);
            border-color: rgba(217, 26, 70, 0.2);
        }

        .font_links:hover::after {
            transform: translateX(5px);
        }

        /* MODALES ESTILIZADOS */
        .modal-content {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--cherry-dark), var(--cherry-main));
            color: white;
            border-bottom: none;
            padding: 24px;
        }

        .modal-title {
            font-family: 'Poppins', Arial, sans-serif;
            font-weight: 600;
        }

        .modal-body {
            padding: 30px;
            background: white;
        }

        .info-box {
            background-color: var(--cherry-light);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid var(--cherry-main);
            color: var(--text-dark);
        }

        .modal-footer {
            border-top: none;
            padding: 15px 30px 25px;
        }

        .btn-cherry-secondary {
            background-color: #E2E8F0;
            color: #4A5568;
            border: none;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 12px;
            transition: background 0.2s;
        }

        .btn-cherry-secondary:hover {
            background-color: #CBD5E1;
            color: #1E293B;
        }

        iframe {
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* .close {
                        text-shadow: none;
                        opacity: 0.8;
                        transition: opacity 0.2s;
                    } */

        /* .close:hover {
                        opacity: 1;
                    } */
    </style>

    <div class="container cherry-body-wrapper">

        <div class="hero">
            <h1>🍒 Tiendas Cherry</h1>
            <p>Localiza tu sucursal u oficina más cercana seleccionando tu ubicación</p>
        </div>

        <div class="mt-5">
            <h2 class="section-title">Primera Etapa</h2>

            <div class="links-grid">
                <button class="font_links" data-bs-toggle="modal" data-bs-target="#campechecc">Ciudad del Carmen,
                    Campeche</button>
                <button class="font_links" data-bs-toggle="modal" data-bs-target="#chiapas">Tuxtla Gutiérrez,
                    Chiapas</button>
                <button class="font_links" data-bs-toggle="modal" data-bs-target="#durango">Durango</button>
            </div>
        </div>

    </div>

    <div class="modal fade" id="campechecc" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">📍 Campeche - Ciudad del Carmen</h5>
                    {{-- <button type="button" class="close text-white" data-dismiss="modal">×</button> --}}
                </div>

                <div class="modal-body">
                    <div class="info-box">
                        <p class="mb-2"><strong>📍 Domicilio:</strong> Avenida Isla de Tris, Ciudad del Carmen.</p>
                        <div class="row">
                            <div class="col-md-6"><strong>📞 Tel:</strong> 9386890153</div>
                            <div class="col-md-6"><strong>✉️ Email:</strong> ciudaddelcarmen@centrolaboral.gob.mx</div>
                        </div>
                    </div>

                    <iframe width="100%" height="350" src="https://www.google.com/maps/embed?pb=!1m18..." loading="lazy">
                    </iframe>
                </div>

                {{-- <div class="modal-footer">
                    <button class="btn btn-cherry-secondary" data-dismiss="modal">Cerrar</button>
                </div> --}}

            </div>
        </div>
    </div>

    <div class="modal fade" id="chiapas" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">📍 Chiapas - Tuxtla Gutiérrez</h5>
                    {{-- <button type="button" class="close text-white" data-dismiss="modal">×</button> --}}
                </div>

                <div class="modal-body">
                    <div class="info-box">
                        <p class="mb-2"><strong>📍 Domicilio:</strong> 6ª Calle Oriente, Tuxtla Gutiérrez.</p>
                        <div class="row">
                            <div class="col-md-6"><strong>📞 Tel:</strong> 9616888673</div>
                            <div class="col-md-6"><strong>✉️ Email:</strong> chiapas@centrolaboral.gob.mx</div>
                        </div>
                    </div>

                    <iframe width="100%" height="350" src="https://www.google.com/maps/embed?pb=!1m18..." loading="lazy">
                    </iframe>
                </div>

                {{-- <div class="modal-footer">
                    <button class="btn btn-cherry-secondary" data-dismiss="modal">Cerrar</button>
                </div> --}}

            </div>
        </div>
    </div>

    <div class="modal fade" id="durango" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">📍 Durango</h5>
                    {{-- <button type="button" class="close text-white" data-dismiss="modal">×</button> --}}
                </div>

                <div class="modal-body">
                    <div class="info-box">
                        <p class="mb-2"><strong>📍 Domicilio:</strong> Centro, Durango.</p>
                        <div class="row">
                            <div class="col-md-6"><strong>📞 Tel:</strong> 6186883162</div>
                            <div class="col-md-6"><strong>✉️ Email:</strong> durango@centrolaboral.gob.mx</div>
                        </div>
                    </div>

                    <iframe width="100%" height="350" src="https://www.google.com/maps/embed?pb=!1m18..." loading="lazy">
                    </iframe>
                </div>

                {{-- <div class="modal-footer">
                    <button class="btn btn-cherry-secondary" data-dismiss="modal">Cerrar</button>
                </div> --}}

            </div>
        </div>
    </div>
@endsection
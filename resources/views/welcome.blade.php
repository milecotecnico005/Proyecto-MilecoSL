@extends('layouts.clientlayout')

@section('content')
 
    <!--==================== HOME ====================-->
    <section class="home section" id="home">
        <div class="home__container container grid">
            <div class="home__data">
                <h1 class="home__title">
                    Descubre la <br> Propiedad <br> Perfecta
                </h1>
                <p class="home__description">
                    Encuentra fácilmente una amplia gama de soluciones que se adapten a tus necesidades. 
                    Olvídate de los problemas en tu residencia!.
                </p>
    
                <div class="home__value">
                    <div>
                        <h1 class="home__value-number">
                            9K <span>+</span>
                        </h1>
                        <span class="home__value-description">
                            Propiedades <br> Premium
                        </span>
                    </div>
    
                    <div>
                        <h1 class="home__value-number">
                            2K <span>+</span>
                        </h1>
                        <span class="home__value-description">
                            Clientes <br> Satisfechos
                        </span>
                    </div>
    
                    <div>
                        <h1 class="home__value-number">
                            28K <span>+</span>
                        </h1>
                        <span class="home__value-description">
                            Premios <br> Ganados
                        </span>
                    </div>
                </div>
            </div>
    
            <div class="home__images">
                <div class="home__orbe"></div>
    
                <div class="home__img">
                    <img src="{{ asset('img/home.jpg') }}" alt="Imagen Principal">
                </div>
            </div>
        </div>
    </section>

    <!--==================== LOGOS ====================-->
    <section class="logos section">
        <div class="logos__container container grid">
            <div class="logos__img">
                <img src="{{ asset('img/logo1.png') }}" alt="Logo de la Empresa 1">
            </div>
            <div class="logos__img">
                <img src="{{ asset('img/logo2.png') }}" alt="Logo de la Empresa 2">
            </div>
            <div class="logos__img">
                <img src="{{ asset('img/logo3.png') }}" alt="Logo de la Empresa 3">
            </div>
            <div class="logos__img">
                <img src="{{ asset('img/logo4.png') }}" alt="Logo de la Empresa 4">
            </div>
        </div>
    </section>

    <!--==================== POPULAR ====================-->
    <section class="section" id="popular">
        <div class="container">
            <span class="section__subtitle">Mejor Elección</span>
            <h2 class="section__title">
                Residencias Populares<span>.</span>
            </h2>
    
            <div class="popular__container grid swiper">
                <div class="swiper-wrapper">
                    <article class="popular__card swiper-slide">
                        <img src="{{ asset('img/popular1.jpg') }}" alt="Residencia Popular 1" class="popular__img">
    
                        <div class="popular__data">
                            <h2 class="popular__price">
                                <span>€</span>60,000
                            </h2>
                            <h3 class="popular__title">
                                Garden City Assat
                            </h3>
                            <p class="popular__description">
                                Calle Lope de Hoces, 15, 14002 Córdoba, España
                            </p>
                        </div>
                    </article>
    
                    <article class="popular__card swiper-slide">
                        <img src="{{ asset('img/popular2.jpg') }}" alt="Residencia Popular 2" class="popular__img">
    
                        <div class="popular__data">
                            <h2 class="popular__price">
                                <span>€</span>32,000
                            </h2>
                            <h3 class="popular__title">
                                Casa de Lujo Gables
                            </h3>
                            <p class="popular__description">
                                Avenida Conde de Vallellano, 22, 14004 Córdoba, España
                            </p>
                        </div>
                    </article>
    
                    <article class="popular__card swiper-slide">
                        <img src="{{ asset('img/popular3.jpg') }}" alt="Residencia Popular 3" class="popular__img">
    
                        <div class="popular__data">
                            <h2 class="popular__price">
                                <span>€</span>70,000
                            </h2>
                            <h3 class="popular__title">
                                Ciudad Jardín Orchard
                            </h3>
                            <p class="popular__description">
                                Calle Alcalde de la Cruz García, 8, 14003 Córdoba, España
                            </p>
                        </div>
                    </article>
    
                    <article class="popular__card swiper-slide">
                        <img src="{{ asset('img/popular4.jpg') }}" alt="Residencia Popular 4" class="popular__img">
    
                        <div class="popular__data">
                            <h2 class="popular__price">
                                <span>€</span>58,000
                            </h2>
                            <h3 class="popular__title">
                                Ciudad Jardín de Lujo
                            </h3>
                            <p class="popular__description">
                                Avenida del Brillante, 55, 14012 Córdoba, España
                            </p>
                        </div>
                    </article>
    
                    <article class="popular__card swiper-slide">
                        <img src="{{ asset('img/popular5.jpg') }}" alt="Residencia Popular 5" class="popular__img">
    
                        <div class="popular__data">
                            <h2 class="popular__price">
                                <span>€</span>45,000
                            </h2>
                            <h3 class="popular__title">
                                Jardín Privado Aliva
                            </h3>
                            <p class="popular__description">
                                Calle Poeta Alonso de Bonilla, 4, 14012 Córdoba, España
                            </p>
                        </div>
                    </article>
                </div>
    
                <div class="swiper-button-next">
                    <i class='bx bx-chevron-right'></i>
                </div>
                <div class="swiper-button-prev">
                    <i class='bx bx-chevron-left'></i>
                </div>
            </div>
        </div>
    </section>
    
    <!--==================== VALUE ====================-->
    <section class="value section" id="value">
        <div class="value__container container grid">
            <div class="value__images">
                <div class="value__orbe"></div>
    
                <div class="value__img">
                    <img src="{{ asset('img/value.jpg') }}" alt="Imagen de Valor">
                </div>
            </div>
    
            <div class="value__content">
                <div class="value__data">
                    <span class="section__subtitle">Nuestros Valores</span>
                    <h2 class="section__title">
                        El Valor que Brindamos<span>.</span>
                    </h2>
                    <p class="value__description">
                        Siempre listos para ayudarte proporcionando el mejor servicio. 
                        Creemos que un buen lugar para vivir puede mejorar tu vida.
                    </p>
                </div>
    
                <div class="value__accordion">
                    <div class="value__accordion-item">
                        <header class="value__accordion-header">
                            <i class='bx bxs-shield-x value__accordion-icon'></i>
                            <h3 class="value__accordion-title">
                                Mejores tasas de interés en el mercado
                            </h3>
                            <div class="value__accordion-arrow">
                                <i class='bx bxs-down-arrow'></i>
                            </div>
                        </header>
    
                        <div class="value__accordion-content">
                            <p class="value__accordion-description">
                                El precio que ofrecemos es el mejor para ti, 
                                garantizamos que no habrá cambios en el precio de tu propiedad debido a diversos costos inesperados que puedan surgir.
                            </p>
                        </div>
                    </div>
    
                    <div class="value__accordion-item">
                        <header class="value__accordion-header">
                            <i class='bx bxs-x-square value__accordion-icon'></i>
                            <h3 class="value__accordion-title">
                                Prevenir precios inestables
                            </h3>
                            <div class="value__accordion-arrow">
                                <i class='bx bxs-down-arrow'></i>
                            </div>
                        </header>
    
                        <div class="value__accordion-content">
                            <p class="value__accordion-description">
                                El precio que ofrecemos es el mejor para ti, 
                                garantizamos que no habrá cambios en el precio de tu propiedad debido a diversos costos inesperados que puedan surgir.
                            </p>
                        </div>
                    </div>
    
                    <div class="value__accordion-item">
                        <header class="value__accordion-header">
                            <i class='bx bxs-bar-chart-square value__accordion-icon' ></i>
                            <h3 class="value__accordion-title">
                                Mejores precios en el mercado
                            </h3>
                            <div class="value__accordion-arrow">
                                <i class='bx bxs-down-arrow'></i>
                            </div>
                        </header>
    
                        <div class="value__accordion-content">
                            <p class="value__accordion-description">
                                El precio que ofrecemos es el mejor para ti, 
                                garantizamos que no habrá cambios en el precio de tu propiedad debido a diversos costos inesperados que puedan surgir.
                            </p>
                        </div>
                    </div>
    
                    <div class="value__accordion-item">
                        <header class="value__accordion-header">
                            <i class='bx bxs-checkbox-checked value__accordion-icon'></i>
                            <h3 class="value__accordion-title">
                                Seguridad de tus datos
                            </h3>
                            <div class="value__accordion-arrow">
                                <i class='bx bxs-down-arrow'></i>
                            </div>
                        </header>
    
                        <div class="value__accordion-content">
                            <p class="value__accordion-description">
                                El precio que ofrecemos es el mejor para ti, 
                                garantizamos que no habrá cambios en el precio de tu propiedad debido a diversos costos inesperados que puedan surgir.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!--==================== CONTACT ====================-->
    <section class="contact section" id="contact">
        <div class="contact__container container grid">
            <div class="contact__images">
                <div class="contact__orbe"></div>
    
                <div class="contact__img">
                    <img src="{{ asset('img/contact.png') }}" alt="Imagen de Contacto">
                </div>
            </div>
    
            <div class="contact__content">
                <div class="contact__data">
                    <span class="section__subtitle">Contáctanos</span>
                    <h2 class="section__title">
                        Fácil Contacto<span>.</span>
                    </h2>
                    <p class="contact__description">
                    ¿Necesitas una guía para reparar tu vivienda? ¿O necesitas una consulta sobre temas residenciales? Contáctanos ahora mismo.
                    </p>
                </div>
    
                <div class="contact__card">
                    <div class="contact__card-box">
                        <div class="contact__card-info">
                            <i class='bx bxs-phone-call'></i>
                            
                            <div>
                                <h3 class="contact__card-title">
                                    Llamar
                                </h3>
                                <p class="contact__card-description">
                                    022.321.165.19
                                </p>
                            </div>
                        </div>
                        <button class="button contact__card-button">
                            Llamar Ahora
                        </button>
                    </div>
    
                    <div class="contact__card-box">
                        <div class="contact__card-info">
                            <i class='bx bxs-message-rounded-dots' ></i>
                            
                            <div>
                                <h3 class="contact__card-title">
                                    Chat
                                </h3>
                                <p class="contact__card-description">
                                    022.321.165.19
                                </p>
                            </div>
                        </div>
                        <button class="button contact__card-button">
                            Chat Ahora
                        </button>
                    </div>
    
                    <div class="contact__card-box">
                        <div class="contact__card-info">
                            <i class='bx bxs-video' ></i>
                            
                            <div>
                                <h3 class="contact__card-title">
                                    Videollamada
                                </h3>
                                <p class="contact__card-description">
                                    022.321.165.19
                                </p>
                            </div>
                        </div>
                        <button class="button contact__card-button">
                            Videollamada Ahora
                        </button>
                    </div>
    
                    <div class="contact__card-box">
                        <div class="contact__card-info">
                            <i class='bx bxs-envelope'></i>
                            
                            <div>
                                <h3 class="contact__card-title">
                                    Mensaje
                                </h3>
                                <p class="contact__card-description">
                                    022.321.165.19
                                </p>
                            </div>
                        </div>
                        <button class="button contact__card-button">
                            Mensaje Ahora
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@stop
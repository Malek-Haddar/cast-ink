@extends('layouts.app')

@section('content')
@php($featuredPodcast = $podcasts->first())

    <section class="hero-section-version1 zindex1 position-relative">
        <div class="container">
            <div class="hero-v1-content text-center">
                <span class="listing-text">
                    <img src="assets/img/banner/listing-text.png" alt="img">
                </span>
                <h1 class="hero-title white-clr text-uppercase mb-xxl-13 mb-xl-10 mb-lg-8 mb-md-7 mb-sm-7 mb-6">
                    To Us Daily
                </h1>
                <div class="hero-tag">
                    <a href="#"
                        class="hero-tag-item theme-bg d-flex align-items-center gap-2 py-xxl-3 py-2 px-xxl-8 px-xl-6 px-5">
                        <i class="ph-fill ph-soundcloud-logo fs20"></i>
                        <span class="fs12 fw-700 body-font white-clr text-uppercase">
                            Soundcloud
                        </span>
                    </a>
                    <a href="#"
                        class="hero-tag-item theme-bg d-flex align-items-center gap-2 py-xxl-3 py-2 px-xxl-8 px-xl-6 px-5">
                        <i class="ph-fill ph-spotify-logo fs20"></i>
                        <span class="fs12 fw-700 body-font white-clr text-uppercase">
                            Spotify
                        </span>
                    </a>
                    <a href="#"
                        class="hero-tag-item theme-bg d-flex align-items-center gap-2 py-xxl-3 py-2 px-xxl-8 px-xl-6 px-5">
                        <i class="ph-fill ph-apple-logo fs20"></i>
                        <span class="fs12 fw-700 body-font white-clr text-uppercase">
                            Apple
                        </span>
                    </a>
                </div>
                <!-- Arrow -->
                <img src="assets/img/element/bn-arrowv1.png" alt="img" class="bn-arrowv1">
            </div>
        </div>
    </section>

    <!-- Audio Player -->
    <div class="audio-onetime-player pt-sm-0 pt-5 whitebg overflow-visible">
        <div class="container">
            <div class="cmn-playerwrap">
                <audio id="myAudio" ontimeupdate="onTimeUpdate()">
                    <source id="source-audio"
                        src="https://demo.ovatheme.com/podover/wp-content/uploads/2022/05/Audio-Layer.mp3"
                        type="audio/mpeg">
                </audio>
                <div
                    class="player-ctn d-flex flex-md-nowrap flex-wrap align-items-center justify-content-center gap-xxl-8 gap-xl-4 gap-3 py-xxl-7 py-xl-5 py-lg-3 py-3 px-2">
                    <div
                        class="title-audio-adjust d-flex align-items-center justify-content-md-start justify-content-center gap-xxl-8 gap-xl-4 gap-3 pe-xxl-8 pe-xl-6 pe-lg-5 pe-4">
                        <div class="btn-action theme-bg theme-circle-audio" onclick="toggleAudio()">
                            <div id="btn-faws-play-pause">
                                <i class='fas fa-play' id="icon-play"></i>
                                <i class='fas fa-pause' id="icon-pause" style="display: none"></i>
                            </div>
                        </div>
                        @if($featuredPodcast)
                            <div class="audio-cmn-title">
                                <a href="{{ route('podcasts.show', $featuredPodcast) }}" class="black-clr d-block fs20 fw-700 body-font">
                                    {{ $featuredPodcast->title }}
                                </a>
                                <span class="episode-sri d-flex align-items-center gap-2 pra-clr position-relative">
                                    {{ $featuredPodcast->episodes->count() }} Episode{{ $featuredPodcast->episodes->count() === 1 ? '' : 's' }}
                                    <span class="vdot"></span>
                                    <span class="pra-clr">
                                        @php($first = $featuredPodcast->episodes->first())
                                        {{ $first && $first->duration ? gmdate('i:s', $first->duration) : '00:00' }}
                                    </span>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="btn-ctn right-adjustment">
                        <div class="btn-action first-btn d-none" onclick="previous()">
                            <div id="btn-faws-back">
                                <i class='fas fa-step-backward'></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 pe-xxl-5 pe-3">
                            <div class="btn-action rewindforword" onclick="rewind()">
                                <div id="btn-faws-rewind">
                                    <i class='fas fa-backward'></i>
                                </div>
                            </div>
                            <div class="btn-play rewindforword" onclick="forward()">
                                <div id="btn-faws-forward">
                                    <i class='fas fa-forward'></i>
                                </div>
                            </div>
                        </div>
                        <div class="btn-action d-none" onclick="next()">
                            <div id="btn-faws-next">
                                <i class='fas fa-step-forward'></i>
                            </div>
                        </div>
                        <div id="myProgress">
                            <div id="myBar"></div>
                        </div>
                        <div class="infos-ctn ps-2">
                            <div class="timer minutes-clr fs14">00:00</div>
                            <div class="title d-none"></div>
                            <span class="ps-3 minutes-clr">/</span>
                            <div class="duration minutes-clr fs14">00:00</div>
                        </div>
                        <div class="btn-mute ps-xxl-8 ps-xl-4 ps-3" id="toggleMute" onclick="toggleMute()">
                            <div id="btn-faws-volume">
                                <i id="icon-vol-up" class='fas fa-volume-up'></i>
                                <i id="icon-vol-mute" class='fas fa-volume-mute' style="display: none"></i>
                            </div>
                        </div>
                    </div>
                    <div class="playlist-ctn d-none"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main start -->
    <main class="main position-relative overflow-hidden" id="mains">

        <!-- Latest V-01 Episote -->
        <section class="latest-episode-section whitebg pt-space pb-xxl-17 pb-xl-10 pb-8">
            <div class="container">
                <div
                    class="d-flex flex-sm-nowrap flex-wrap gap-5 align-items-center justify-content-between  mb-xxl-15 mb-xl-12 mb-lg-10 mb-8">
                    <div class="section-title">
                        <span class="fs18 fw-500 theme-clr d-block mb-lg-4 mb-3" data-aos="zoom-in-left"
                            data-aos-duration="1400">
                            Enjoy New Shows
                        </span>
                        <h3 class="heading black-clr" data-aos="zoom-in-right" data-aos-duration="1700">
                            Latest episodes
                        </h3>
                    </div>
                    <div class="slider-button d-flex align-items-center gap-xxl-2 gap-2">
                        <div class="cust-test-next cmn-nextpre-controll bg4-clr d-center">
                            <i class="ph-light ph-arrow-left fs-20"></i>
                        </div>
                        <div class="cust-test-prev active cmn-nextpre-controll bg4-clr d-center">
                            <i class="ph-light ph-arrow-right fs-20"></i>
                        </div>
                    </div>
                </div>
                <div class="swiper latest-episodewrap">
                    <div class="swiper-wrapper">
                        @foreach($podcasts as $podcast)
                        <div class="swiper-slide">
                            <div class="latest-episode-itemv1">
                                <div class="thumb overflow-hidden w-100">
                                    <img src="{{ asset('storage/' . $podcast->cover_image) }}" alt="img" class="overflow-hidden w-100">
                                </div>
                                <div class="content p-xxl-8 p-xl-6 p-lg-5 p-4">
                                    <div class="fashion-life d-flex align-items-center gap-2 mb-xxl-5 mb-xl-3 mb-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="icon d-center theme-bg">
                                                <i class="ph-fill ph-headphones white-clr fs20"></i>
                                            </div>
                                            <a href="{{ route('podcasts.show', $podcast) }}" class="theme-clr fs18 fw-700 body-font">
                                                {{ $podcast->title }}
                                            </a>
                                        </div>
                                        
                                        <span class="episode-sri d-flex align-items-center pra-clr position-relative">
                                            {{ $podcast->episodes->count() }} Episode{{ $podcast->episodes->count() === 1 ? '' : 's' }}
                                        </span>
                                    </div>
                                    <h5 class="mb-xxl-6 mb-xl-5 mb-4">
                                        <a href="{{ route('podcasts.show', $podcast) }}" class="black-clr fw-700">
                                        {{ $podcast->title }}
                                        </a>
                                    </h5>
                                    <a href="{{ route('podcasts.show', $podcast) }}"
                                        class="view-all d-flex align-items-center gap-2 text-uppercase">
                                        View Episode
                                        <i class="ph-bold ph-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </section>
        <!-- Latest V-01 Episote -->

        <!-- About01 -->
        <section class="about-section whitebg pb-space">
            <div class="container">
                <div class="row align-items-lg-center justify-content-center flex-row-reverse g-xxl-6 g-6">
                    <div class="col-lg-7 col-md-8">
                        <div class="about-contentv2 ps-xxl-17">
                            <div class="section-title">
                                <span class="fs18 fw-500 theme-clr d-block mb-lg-4 mb-3" data-aos="zoom-in-up"
                                    data-aos-duration="800">
                                    Special Offer to Voice Over
                                </span>
                                <h2 class="heading black-clr mb-xxl-9 mb-xl-8 mb-lg-6 mb-sm-5 mb-4"
                                    data-aos="zoom-in-up" data-aos-duration="1000">
                                    Best podcast for your
                                    <span class="d-block black-clr">
                                        curious minds
                                    </span>
                                </h2>
                                <h6 class="fw-400 black-clr mb-xxl-9 mb-xl-8 mb-lg-6 mb-sm-5 mb-4" data-aos="zoom-in-up"
                                    data-aos-duration="1200">
                                    Our pick of the best podcasts on Spotify, Apple Podcasts & more covering technology,
                                    culture, science, politics & new
                                    ideas
                                </h6>
                                <p class="text-clr mb-xxl-7 mb-xl-6 mb-lg-5 mb-4" data-aos="zoom-in-up"
                                    data-aos-duration="1400">
                                    Nam ultrices odio a felis lobortis convallis. In ex nunc, ornare non condimentum et,
                                    egestas vel massa. Nullam hendrerit
                                    felis quis pellentesque porttitor. Aenean lobortis bibendum turpis et auctor. Nam
                                    iaculis, lectus vulputate cursus
                                    interdum, lacus odio commodo ipsum, nec condimentum purus tellus eu metus. Vivamus
                                    volutpat vitae dolor non suscipit.
                                </p>
                                <div class="d-flex flex-sm-nowrap flex-wrap align-items-center gap-xxl-5 gap-lg-4 gap-3"
                                    data-aos="zoom-in-up" data-aos-duration="1500">
                                    <a href="about.php"
                                        class="touch-btn theme-bg white-clr text-uppercase py-xxl-4 py-xl-4 py-3 px-xxl-12 px-lg-9 px-8">
                                        Discover More
                                    </a>
                                    <div class="d-flex align-items-center gap-xl-3 gap-2">
                                        <div class="donate-icon d-center">
                                            <img src="assets/img/element/donate-icon.png" alt="img">
                                        </div>
                                        <div class="cont">
                                            <h4 class="black-clr mb-0">
                                                $ 8800
                                            </h4>
                                            <span class="fw-500 pra-clr">
                                                70% Donation Collected
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-4">
                        <div class="about-thumbv2 position-relative mt-md-0 mt-4">
                            <div class="thumb1" data-aos="fade-in" data-aos-duration="1400">
                                <img src="assets/img/about/about-v2-thumb.png" alt="img">
                            </div>
                            <div class="about-thumb-bar">
                                <img src="assets/img/element/about-v2base.png" alt="img">
                            </div>
                            <a href="https://www.youtube.com/watch?v=XHOmBV4js_E" class="video-popup about-videov2">
                                <i class="ph-fill ph-play"></i>
                                <span class="vid-ani">
                                    <img src="assets/img/element/about-circle.png" alt="img">
                                </span>
                            </a>
                            <img src="assets/img/element/dots.png" alt="img" class="about-dot">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About V-01 -->

        <!-- Features V-01 -->
        <section class="feature-section pt-space pb-space bg4-clr zindex1 position-relative">
            <div class="container">
                <div class="section-title text-center mb-xxl-15 mb-xl-12 mb-lg-10 mb-8">
                    <span class="fs18 fw-500 theme-clr d-block mb-lg-4 mb-3" data-aos="zoom-in-left"
                        data-aos-duration="1400">
                        Enjoy New Shows
                    </span>
                    <h3 class="heading black-clr" data-aos="zoom-in-right" data-aos-duration="1700">
                        Featured podcasts
                    </h3>
                </div>
            </div>
            <div class="swiper feature-wrap">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="feature-item whitebg d-xxl-flex d-grid align-items-center gap-xxl-8 gap-xl-6 gap-4">
                            <div class="thumb position-relative overflow-hidden">
                                <img src="assets/img/feature/feature1.png" alt="img" class="overflow-hidden">
                                <span class="feature-headphoe">
                                    <i class="ph-fill ph-headphones"></i>
                                </span>
                            </div>
                            <div class="content px-xxl-0 px-4 pb-xxl-0 pb-7">
                                <div class="fashion-life d-flex align-items-center gap-2 mb-xxl-4 mb-xl-3 mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="episode-details.php" class="theme-clr fs18 fw-700 body-font">
                                            Fashion Life
                                        </a>
                                    </div>
                                    <span class="episode-sri d-flex align-items-center pra-clr position-relative">
                                        1 Episode
                                    </span>
                                </div>
                                <h4 class="mb-xxl-8 mb-xl-6 mb-5 d-block">
                                    <a href="{{ route('podcasts.show', $podcast) }}" class="black-clr fw-700">
                                        {{ $podcast->title }}
                                    </a>
                                </h4>
                                <a href="{{ route('podcasts.show', $podcast) }}"
                                    class="touch-btn bg4-clr black-clr text-uppercase fw-700 py-xxl-4 py-xl-4 py-3 px-xxl-12 px-lg-9 px-8">
                                    Episode Page
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="feature-item whitebg d-xxl-flex d-grid align-items-center gap-xxl-8 gap-xl-6 gap-4">
                            <div class="thumb position-relative overflow-hidden">
                                <img src="assets/img/feature/feature2.png" alt="img" class="overflow-hidden">
                                <span class="feature-headphoe">
                                    <i class="ph-fill ph-headphones"></i>
                                </span>
                            </div>
                            <div class="content px-xxl-0 px-4 pb-xxl-0 pb-7">
                                <div class="fashion-life d-flex align-items-center gap-2 mb-xxl-4 mb-xl-3 mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="episode-details.php" class="theme-clr fs18 fw-700 body-font">
                                            Fashion Life
                                        </a>
                                    </div>
                                    <span class="episode-sri d-flex align-items-center pra-clr position-relative">
                                        1 Episode
                                    </span>
                                </div>
                                <h4 class="mb-xxl-8 mb-xl-6 mb-5 d-block">
                                    <a href="{{ route('podcasts.show', $podcast) }}" class="black-clr fw-700">
                                        {{ $podcast->title }}
                                    </a>
                                </h4>
                                <a href="{{ route('podcasts.show', $podcast) }}"
                                    class="touch-btn bg4-clr black-clr text-uppercase fw-700 py-xxl-4 py-xl-4 py-3 px-xxl-12 px-lg-9 px-8">
                                    Episode Page
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="feature-item whitebg d-xxl-flex d-grid align-items-center gap-xxl-8 gap-xl-6 gap-4">
                            <div class="thumb position-relative overflow-hidden">
                                <img src="assets/img/feature/feature1.png" alt="img" class="overflow-hidden">
                                <span class="feature-headphoe">
                                    <i class="ph-fill ph-headphones"></i>
                                </span>
                            </div>
                            <div class="content px-xxl-0 px-4 pb-xxl-0 pb-7">
                                <div class="fashion-life d-flex align-items-center gap-2 mb-xxl-4 mb-xl-3 mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="episode-details.php" class="theme-clr fs18 fw-700 body-font">
                                            Fashion Life
                                        </a>
                                    </div>
                                    <span class="episode-sri d-flex align-items-center pra-clr position-relative">
                                        1 Episode
                                    </span>
                                </div>
                                <h4 class="mb-xxl-8 mb-xl-6 mb-5 d-block">
                                    <a href="{{ route('podcasts.show', $podcast) }}" class="black-clr fw-700">
                                        {{ $podcast->title }}
                                    </a>
                                </h4>
                                <a href="{{ route('podcasts.show', $podcast) }}"
                                    class="touch-btn bg4-clr black-clr text-uppercase fw-700 py-xxl-4 py-xl-4 py-3 px-xxl-12 px-lg-9 px-8">
                                    Episode Page
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cmn-pagination text-center mt-xxl-15 mt-xl-10 mt-lg-8 mt-6"></div>
            </div>
            <!-- Element -->
            <img src="assets/img/element/feature-shape.png" alt="img" class="feature-shape">
            <!-- Element -->
        </section>
        <!-- Features V-01 -->

        <!-- New Podcast V-01 -->
        <section class="new-podcast-sectionv2 position-relative pt-space pb-space">
            <div class="container">
                <div class="new-podcast-wrapsv2">
                    <div class="icon-thumb d-center theme-bg" data-aos="zoom-in-left" data-aos-duration="1600">
                        <img src="assets/img/element/support-listing.png" alt="img">
                    </div>
                    <div class="new-podcast-contentv2">
                        <div class="section-title">
                            <span class="fs18 fw-500 theme-clr d-block mb-lg-4 mb-3" data-aos="zoom-in-left"
                                data-aos-duration="1400">
                                Enjoy New Shows
                            </span>
                            <h2 class="heading white-clr d-block mb-xxl-15 mb-xl-10 mb-sm-9 mb-8"
                                data-aos="zoom-in-left" data-aos-duration="1600">
                                Support and listen to our latest show on apple podcast
                            </h2>
                            <a href="contact.php"
                                class="touch-btn theme-bg white-clr text-uppercase py-xxl-5 py-xl-4 py-3 px-xxl-12 px-lg-9 px-8">
                                Start Donating
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Element -->
            <img src="assets/img/element/fline.png" alt="img" class="podact-line">
        </section>
        <!-- New Podcast V-01 -->

        <!-- Playlist V-01 -->
        <section class="playlist-section zindex1 whitebg pt-space pb-space position-relative">
            <div class="container">
                <div class="row align-items-lg-center justify-content-between flex-row-reverse g-xxl-6 g-6">
                    <div class="col-lg-6">
                        <div class="playlist-bg-adding">
                            <div
                                class="playlist-version001-wrap position-relative overflow-hidden zindex1 p-xxl-15 p-xl-10 p-lg-8 p-sm-6 p-4">
                                <div class="audioplayer-listing-wraptwoverstion">
                                    <div class="play-list d-grid gap-xxl-7 gap-xl-5 gap-lg-4 gap-3">
                                        <div class="play-list-row d-flex align-items-center gap-xxl-1 gap-0"
                                            data-track-row="1">
                                            <div class="small-toggle-btn cmn-toggle-btnplay">
                                                <i class="small-play-btn white-clr">
                                                </i>
                                            </div>
                                            <div class="track-number">
                                                1.
                                            </div>
                                            <div class="track-title">
                                                <a class="playlist-track fs20 fw-700 black-clr d-block atitle" href="#"
                                                    data-play-track="1">
                                                    <span
                                                        class="body-font fw-400 pra-clr d-block d-flex align-items-center gap-2 mb-0">
                                                        Episode 2 <span class="vdot"></span> <span
                                                            class="pra-clr fw-400">Design</span>
                                                    </span>
                                                    Mike: the nature of design
                                                </a>
                                            </div>
                                        </div>
                                        <div class="play-line"></div>
                                        <div class="play-list-row d-flex align-items-center gap-xxl-1 gap-0"
                                            data-track-row="2">
                                            <div class="small-toggle-btn cmn-toggle-btnplay">
                                                <i class="small-play-btn white-clr">
                                                </i>
                                            </div>
                                            <div class="track-number">
                                                2.
                                            </div>
                                            <div class="track-title">
                                                <a class="playlist-track fs20 fw-700 black-clr d-block atitle" href="#"
                                                    data-play-track="2">
                                                    <span
                                                        class="body-font fw-400 pra-clr d-block d-flex align-items-center gap-2 mb-0">
                                                        Episode 2 <span class="vdot"></span> <span
                                                            class="pra-clr fw-400">Microphone</span>
                                                    </span>
                                                    Timmy: where seek advices?
                                                </a>
                                            </div>
                                        </div>
                                        <div class="play-line"></div>
                                        <div class="play-list-row d-flex align-items-center gap-xxl-1 gap-0"
                                            data-track-row="3">
                                            <div class="small-toggle-btn cmn-toggle-btnplay">
                                                <i class="small-play-btn white-clr">
                                                </i>
                                            </div>
                                            <div class="track-number">
                                                3.
                                            </div>
                                            <div class="track-title">
                                                <a class="playlist-track fs20 fw-700 black-clr d-block atitle" href="#"
                                                    data-play-track="3">
                                                    <span
                                                        class="body-font fw-400 pra-clr d-block d-flex align-items-center gap-2 mb-0">
                                                        Episode 3 <span class="vdot"></span> <span
                                                            class="pra-clr fw-400">Technology</span>
                                                    </span>
                                                    Kevin Smith: look for true love?
                                                </a>
                                            </div>
                                        </div>
                                        <div class="play-line"></div>
                                        <div class="play-list-row d-flex align-items-center gap-xxl-1 gap-0"
                                            data-track-row="4">
                                            <div class="small-toggle-btn cmn-toggle-btnplay">
                                                <i class="small-play-btn white-clr">
                                                </i>
                                            </div>
                                            <div class="track-number">
                                                4.
                                            </div>
                                            <div class="track-title">
                                                <a class="playlist-track fs20 fw-700 black-clr d-block atitle" href="#"
                                                    data-play-track="4">
                                                    <span
                                                        class="body-font fw-400 pra-clr d-block d-flex align-items-center gap-2 mb-0">
                                                        Episode 4 <span class="vdot"></span> <span
                                                            class="pra-clr fw-400">Microphone</span>
                                                    </span>
                                                    Craig Tyson: things to try today
                                                </a>
                                            </div>
                                        </div>
                                        <div class="play-line"></div>
                                        <div class="play-list-row d-flex align-items-center gap-xxl-1 gap-0"
                                            data-track-row="5">
                                            <div class="small-toggle-btn cmn-toggle-btnplay">
                                                <i class="small-play-btn white-clr">
                                                </i>
                                            </div>
                                            <div class="track-number">
                                                5.
                                            </div>
                                            <div class="track-title">
                                                <a class="playlist-track fs20 fw-700 black-clr d-block atitle" href="#"
                                                    data-play-track="5">
                                                    <span
                                                        class="body-font fw-400 pra-clr d-block d-flex align-items-center gap-2 mb-0">
                                                        Episode 5 <span class="vdot"></span> <span
                                                            class="pra-clr fw-400">Microphone</span>
                                                    </span>
                                                    Craig Tyson: things to try today
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="playlist-left-content001 pe-xxl-15">
                            <div class="section-title">
                                <span class="fs18 fw-500 theme-clr d-block mb-lg-4 mb-3" data-aos="zoom-in-up"
                                    data-aos-duration="800">
                                    Enjoy New shows
                                </span>
                                <h2 class="heading black-clr mb-xxl-9 mb-xl-8 mb-lg-6 mb-sm-5 mb-4"
                                    data-aos="zoom-in-up" data-aos-duration="1000">
                                    Check out the latest podcast playlist
                                </h2>
                                <p class="fw-400 pra-clr mb-xxl-7 mb-xl-6 mb-lg-5 mb-sm-4 mb-4" data-aos="zoom-in-up"
                                    data-aos-duration="1200">
                                    Nam ultrices odio a felis lobortis convallis. In ex nunc, ornare non condimentum et,
                                    egestas vel massa. Nullam hendrerit
                                    felis quis pellentesque porttitor.
                                </p>
                                <p class="text-clr mb-xxl-13 mb-xl-11 mb-lg-9 mb-md-7 mb-sm-6 mb-6"
                                    data-aos="zoom-in-up" data-aos-duration="1400">
                                    Aenean lobortis bibendum turpis et auctor. Nam iaculis, lectus vulputate cursus
                                    interdum, lacus odio commodo ipsum, nec
                                    condimentum purus tellus eu metus. Vivamus volutpat vitae dolor non suscipit.
                                </p>
                                <a href="listing2.php"
                                    class="touch-btn theme-bg white-clr text-uppercase py-xxl-4 py-xl-4 py-3 px-xxl-12 px-lg-9 px-8">
                                    View All Episodes
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Element -->
            <img src="assets/img/element/play-shape.png" alt="img" class="play-shape">
            <!-- Element -->
        </section>
        <!-- Playlist V-01 -->

        <!-- BLog Section V-01 -->
        <section class="blog-section01 whitebg position-relative pt-space">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section-title text-center mb-xxl-15 mb-xl-12 mb-lg-10 mb-8">
                            <span class="fs18 fw-500 theme-clr d-block mb-lg-4 mb-3" data-aos="zoom-in-left"
                                data-aos-duration="1400">
                                Direct from the Blog Posts
                            </span>
                            <h3 class="heading black-clr" data-aos="zoom-in-right" data-aos-duration="1700">
                                Checkout our latest news and articles
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center g-xxl-6 g-4">
                    <div class="col-lg-4 col-md-6 col-sm-6" data-aos="fade-up" data-aos-duration="500">
                        <div class="blog-widget-item whitebg">
                            <div class="thumb position-relative">
                                <img src="assets/img/blog/blog1.png" alt="img" class="overflow-hidden">
                                <div
                                    class="date-box theme-bg text-uppercase fs12 white-clr text-center d-grid align-items-center justify-content-center">
                                    <span>
                                        28
                                        <span class="april text-uppercase d-block fs12">
                                            April
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="content p-xxl-7 p-xl-5 p-md-4 p-3">
                                <div class="d-flex align-items-center gap-xxl-4 gap-xl-3 gap-2 mb-xxl-4 mb-3">
                                    <a href="#" class="d-flex align-items-center gap-2">
                                        <i class="ph-fill ph-user-circle theme-clr fs18"></i>
                                        <span class="pra-clr d-block fs14">
                                            by Admin
                                        </span>
                                    </a>
                                    <a href="#" class="d-flex align-items-center gap-2">
                                        <i class="ph-fill ph-chats-teardrop theme-clr fs18"></i>
                                        <span class="pra-clr d-block fs14">
                                            02 Comments
                                        </span>
                                    </a>
                                </div>
                                <h5 class="mb-xxl-7 mb-xl-5 mb-4">
                                    <a href="blog-details.php" class="black-clr fw-700">
                                        Everybody loves pineapples and donuts
                                    </a>
                                </h5>
                                <a href="blog-details.php"
                                    class="view-all d-flex align-items-center gap-2 text-uppercase">
                                    View All
                                    <i class="ph-bold ph-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6" data-aos="fade-up" data-aos-duration="900">
                        <div class="blog-widget-item whitebg">
                            <div class="thumb position-relative">
                                <img src="assets/img/blog/blog2.png" alt="img" class="overflow-hidden">
                                <div
                                    class="date-box theme-bg text-uppercase fs12 white-clr text-center d-grid align-items-center justify-content-center">
                                    <span>
                                        28
                                        <span class="april text-uppercase d-block fs12">
                                            April
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="content p-xxl-7 p-xl-5 p-md-4 p-3">
                                <div class="d-flex align-items-center gap-xxl-4 gap-xl-3 gap-2 mb-xxl-4 mb-3">
                                    <a href="#" class="d-flex align-items-center gap-2">
                                        <i class="ph-fill ph-user-circle theme-clr fs18"></i>
                                        <span class="pra-clr d-block fs14">
                                            by Admin
                                        </span>
                                    </a>
                                    <a href="#" class="d-flex align-items-center gap-2">
                                        <i class="ph-fill ph-chats-teardrop theme-clr fs18"></i>
                                        <span class="pra-clr d-block fs14">
                                            02 Comments
                                        </span>
                                    </a>
                                </div>
                                <h5 class="mb-xxl-7 mb-xl-5 mb-4">
                                    <a href="blog-details.php" class="black-clr fw-700">
                                        Everybody loves pineapples and donuts
                                    </a>
                                </h5>
                                <a href="blog-details.php"
                                    class="view-all d-flex align-items-center gap-2 text-uppercase">
                                    View All
                                    <i class="ph-bold ph-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6" data-aos="fade-up" data-aos-duration="1100">
                        <div class="blog-widget-item whitebg">
                            <div class="thumb position-relative">
                                <img src="assets/img/blog/blog3.png" alt="img" class="overflow-hidden">
                                <div
                                    class="date-box theme-bg text-uppercase fs12 white-clr text-center d-grid align-items-center justify-content-center">
                                    <span>
                                        28
                                        <span class="april text-uppercase d-block fs12">
                                            April
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="content p-xxl-7 p-xl-5 p-md-4 p-3">
                                <div class="d-flex align-items-center gap-xxl-4 gap-xl-3 gap-2 mb-xxl-4 mb-3">
                                    <a href="#" class="d-flex align-items-center gap-2">
                                        <i class="ph-fill ph-user-circle theme-clr fs18"></i>
                                        <span class="pra-clr d-block fs14">
                                            by Admin
                                        </span>
                                    </a>
                                    <a href="#" class="d-flex align-items-center gap-2">
                                        <i class="ph-fill ph-chats-teardrop theme-clr fs18"></i>
                                        <span class="pra-clr d-block fs14">
                                            02 Comments
                                        </span>
                                    </a>
                                </div>
                                <h5 class="mb-xxl-7 mb-xl-5 mb-4">
                                    <a href="blog-details.php" class="black-clr fw-700">
                                        Everybody loves pineapples and donuts
                                    </a>
                                </h5>
                                <a href="blog-details.php"
                                    class="view-all d-flex align-items-center gap-2 text-uppercase">
                                    View All
                                    <i class="ph-bold ph-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- BLog Section V-01 -->

        <!-- Application V-01 -->
        <section class="application-section01 whitebg position-relative pt-space pb-space">
            <div class="container">
                <div class="appilication-wrapper position-relative zindex1">
                    <div class="row align-items-center justify-content-md-start justify-content-center g-6">
                        <div class="col-lg-6 col-md-6 col-sm-8">
                            <div class="application-content text-md-start text-center pe-xxl-11">
                                <div class="section-title">
                                    <span class="fs18 fw-500 theme-clr d-block mb-lg-4 mb-3" data-aos="fade-up"
                                        data-aos-duration="1400">
                                        Streaming Applications
                                    </span>
                                    <h3 class="heading black-clr mb-xxl-9 mb-xl-6 mb-lg-5 mb-4" data-aos="zoom-in-right"
                                        data-aos-duration="1700">
                                        Most popular podcast listening platforms
                                    </h3>
                                    <p class="pra-clr" data-aos="fade-up" data-aos-duration="1600">
                                        Nam ultrices odio a felis lobortis convallis. In ex nunc, or condimentum et,
                                        egestas vel massa. Nullam hend rerit felis
                                        quis pellentes que porttitor. Aenean lobortis bibendum turpis et auctor.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-8">
                            <div class="application-sponsor d-grid gap-xxl-12 gap-xl-8 gap-lg-8 gap-md-8 gap-6">
                                <div
                                    class="d-flex align-items-center justify-content-between gap-xxl-10 gap-xl-5 gap-4">
                                    <a href="#" class="app-sponsor-item">
                                        <img src="assets/img/sponsor/s1.png" alt="img">
                                    </a>
                                    <a href="#" class="app-sponsor-item">
                                        <img src="assets/img/sponsor/s3.png" alt="img">
                                    </a>
                                    <a href="#" class="app-sponsor-item">
                                        <img src="assets/img/sponsor/s4.png" alt="img">
                                    </a>
                                </div>
                                <div
                                    class="d-flex align-items-center justify-content-between gap-xxl-10 gap-xl-5 gap-4">
                                    <a href="#" class="app-sponsor-item">
                                        <img src="assets/img/sponsor/s2.png" alt="img">
                                    </a>
                                    <a href="#" class="app-sponsor-item">
                                        <img src="assets/img/sponsor/s5.png" alt="img">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Element -->
                    <img src="assets/img/element/apnilation-circle.png" alt="img" class="application-circle">
                    <!-- Element -->
                </div>
            </div>
        </section>
        <!-- Application V-01 -->

        <!-- Newsletter V-01 -->
        <section class="newsletter-sectionv01 whitebg">
            <div class="container">
                <div class="newsletter-wrap01 theme-bg position-relative zindex1" data-aos="zoom-in-up"
                    data-aos-duration="1600">
                    <div class="newsletter-contv01 d-flex align-items-center gap-xxl-7 gap-xl-5 gap-sm-3">
                        <div class="newsletter-icon">
                            <i class="ph-thin ph-envelope-open"></i>
                        </div>
                        <div class="cont">
                            <span class="white-clr">
                                Get early access to the new episodes.
                            </span>
                            <h4 class="white-clr">
                                Subscribe to newsletter!
                            </h4>
                        </div>
                    </div>
                    <form action="#"
                        class="foote-formv1 d-flex align-items-center justify-content-between aos-init aos-animate"
                        data-aos="zoom-in-down" data-aos-duration="1200">
                        <input type="email" placeholder="Email Address">
                        <button type="submit" class="themebg d-center">
                            <span class="fs12 text-uppercase fw-700 body-font white-clr">
                                Go
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </section>
        <!-- Newsletter V-01 -->


    </main>
@endsection
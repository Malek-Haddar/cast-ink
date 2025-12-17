@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Facades\URL;
    $firstEpisode = $podcast->episodes->first();
    $firstEpisodeUrl = '';
    if ($accessGranted && $firstEpisode && $firstEpisode->audio_path) {
        $firstEpisodeUrl = URL::temporarySignedRoute(
            'audio.stream',
            now()->addMinutes(120),
            [
                'episode' => $firstEpisode->id,
                'user_ip' => request()->ip()
            ]
        );
    }
@endphp

<!-- Breadcrumnd Banner Start -->
<section class="breadcrumnd-episode-details">
    <div class="container">
        <div class="breadcrumnd-content">
            <div class="section-title mb-xxl-12 mb-xl-10 mb-lg-8 mb-7">
                <h2 class="heading white-clr" data-aos="zoom-in-right" data-aos-duration="1700">
                    {{ $podcast->title }}
                </h2>
            </div>
            <div class="subs" data-aos="zoom-in-up" data-aos-duration="1800">
                <a href="#"
                    class="touch-btn theme-bg white-clr text-uppercase py-xxl-5 py-xl-4 py-3 px-xxl-12 px-lg-9 px-8">
                    Subscribe Now
                </a>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumnd Banner End -->


<!-- Audio Player or Access Gate -->
<!-- Audio Player (Always Visible) -->
@if($firstEpisode && $firstEpisode->audio_path)
<div
    class="audio-onetime-player03 heading-bg overflow-visible py-xxl-8 py-xl-6 py-5 px-xxl-14 px-xl-10 px-lg-7 px-md-5 px-3">
    <div class="container-fluid">
        <div class="cmn-playerwrap">
                <audio id="myAudio" preload="metadata" ontimeupdate="onTimeUpdate()" controlsList="nodownload" oncontextmenu="return false;">
                    <source id="source-audio"
                        src="{{ $firstEpisodeUrl }}"
                        type="audio/mpeg">
                </audio>
            <div class="player-ctn">
                <div
                    class="d-md-flex d-grid gap-3 align-items-center justify-content-md-between justify-content-center w-100">
                    <div
                        class="title-audio-adjust d-md-flex d-grid align-items-center justify-content-md-start justify-content-center gap-xxl-7 gap-xl-4 gap-3 pe-xxl-8 pe-xl-6 pe-lg-5 pe-4">
                        <div class="btn-action theme-bg theme-circle-audio" onclick="toggleAudio()">
                            <div id="btn-faws-play-pause">
                                <i class='fas fa-play' id="icon-play"></i>
                                <i class='fas fa-pause' id="icon-pause" style="display: none"></i>
                            </div>
                        </div>
                        <div class="audio-cmn-title text-md-start text-center">
                            <span class="white-clr d-block fs20 fw-700 body-font">
                                {{ $firstEpisode?->title ?? 'No episodes yet' }}
                            </span>
                            <span
                                class="episode-sri d-flex justify-content-md-start justify-content-center align-items-center gap-2 position-relative">
                                {{ $podcast->episodes->count() }} Episode{{ $podcast->episodes->count() === 1 ? '' : 's' }}
                                @if($firstEpisode && $firstEpisode->duration)
                                    <span class="vdot"></span>
                                    <span class="pras">
                                        {{ gmdate('i:s', $firstEpisode->duration) }}
                                    </span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="btn-ctn right-adjustment">
                        <div
                            class="d-flex justify_content-md-start justify-content-center align-items-center gap-xxl-3 gap-xl-2 gap-2 pe-xxl-5 pe-3">
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
                        <div class="btn-action first-btn d-none" onclick="previous()">
                            <div id="btn-faws-back">
                                <i class='fas fa-step-backward'></i>
                            </div>
                        </div>

                        <div class="btn-action d-none" onclick="next()">
                            <div id="btn-faws-next">
                                <i class='fas fa-step-forward'></i>
                            </div>
                        </div>

                        <div class="infos-ctn ps-2 d-md-flex d-none">
                            <div class="timer me-2 text-white fs14">00:00</div>
                            <div class="title d-none"></div>
                            <div id="myProgress">
                                <div id="myBar"></div>
                            </div>
                            <div class="duration ms-2 text-white fs14">00:00</div>
                        </div>
                        <div class="btn-mute d-md-block d-none ps-xxl-8 ps-xl-4 ps-3" id="toggleMute"
                            onclick="toggleMute()">
                            <div id="btn-faws-volume">
                                <i id="icon-vol-up" class="fas fa-volume-up"></i>
                                <i id="icon-vol-mute" class="fas fa-volume-mute" style="display: none"></i>
                            </div>
                        </div>
                    </div>
                    <div class="playlist-ctn d-none"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Access Code Modal -->
<div class="modal fade" id="accessModal" tabindex="-1" aria-labelledby="accessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-xxl-8 p-xl-6 p-4 pt-0">
                <div class="text-center mb-5">
                    <h4 class="mb-3" id="accessModalLabel">Unlock this Podcast</h4>
                    <p class="pra-clr">Please enter your access code to listen to the episodes.</p>
                </div>
                
                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                @if($errors->has('code'))
                    <div class="alert alert-danger">{{ $errors->first('code') }}</div>
                @endif

                <form method="POST" action="{{ route('podcasts.access', $podcast) }}" class="d-grid gap-4">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="code" class="form-control py-3 px-4" placeholder="Enter access code" required>
                    </div>
                    <button type="submit" class="touch-btn theme-bg white-clr text-uppercase fw-bold py-3 w-100 border-0 rounded">
                        Unlock Now
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Audio Player or Access Gate -->

@if($firstEpisode && $firstEpisode->audio_path)
<script>
document.addEventListener('DOMContentLoaded', () => {
    const audio = document.getElementById('myAudio');
    if (!audio) return;

    const accessGranted = {{ $accessGranted ? 'true' : 'false' }};
    const accessModalEl = document.getElementById('accessModal');
    let accessModal = null;
    
    if (accessModalEl && window.bootstrap) {
        accessModal = new bootstrap.Modal(accessModalEl);
    }

    // Auto-show modal if there are errors
    @if($errors->has('code'))
        if (accessModal) accessModal.show();
    @endif

    const iconPlay = document.getElementById('icon-play');
    const iconPause = document.getElementById('icon-pause');
    const timerEl = document.querySelector('.timer');
    const durationEl = document.querySelector('.duration');
    const progressBar = document.getElementById('myBar');
    const progressContainer = document.getElementById('myProgress');

    function formatTime(t) {
        const m = Math.floor(t / 60);
        const s = Math.floor(t % 60);
        return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
    }

    function setPlaying(isPlaying) {
        if (!iconPlay || !iconPause) return;
        iconPlay.style.display = isPlaying ? 'none' : 'block';
        iconPause.style.display = isPlaying ? 'block' : 'none';
    }

    window.toggleAudio = function toggleAudio() {
        if (!accessGranted) {
            if (accessModal) accessModal.show();
            return;
        }

        if (audio.paused) {
            audio.play().catch(e => console.error('Play failed:', e));
            setPlaying(true);
        } else {
            audio.pause();
            setPlaying(false);
        }
    };

    window.rewind = function rewind() {
        if (!accessGranted) { if(accessModal) accessModal.show(); return; }
        audio.currentTime = Math.max(0, audio.currentTime - 5);
    };

    window.forward = function forward() {
        if (!accessGranted) { if(accessModal) accessModal.show(); return; }
        audio.currentTime = Math.min(audio.duration || 0, audio.currentTime + 5);
    };

    window.toggleMute = function toggleMute() {
        audio.muted = !audio.muted;
        const volUp = document.getElementById('icon-vol-up');
        const volMute = document.getElementById('icon-vol-mute');
        if (volUp && volMute) {
            volUp.style.display = audio.muted ? 'none' : 'block';
            volMute.style.display = audio.muted ? 'block' : 'none';
        }
    };

    window.onTimeUpdate = function onTimeUpdate() {
        if (timerEl) timerEl.textContent = formatTime(audio.currentTime || 0);
        if (durationEl && audio.duration) durationEl.textContent = formatTime(audio.duration);
        if (progressBar && audio.duration) {
            const pct = (audio.currentTime / audio.duration) * 100;
            progressBar.style.width = `${pct}%`;
        }
        if (audio.ended) setPlaying(false);
    };

    if (progressContainer) {
        progressContainer.addEventListener('click', (e) => {
            if (!accessGranted) { if(accessModal) accessModal.show(); return; }
            const rect = progressContainer.getBoundingClientRect();
            const percent = (e.clientX - rect.left) / rect.width;
            if (audio.duration) {
                audio.currentTime = audio.duration * percent;
            }
        });
    }

    audio.addEventListener('loadedmetadata', () => {
        if (durationEl && audio.duration) durationEl.textContent = formatTime(audio.duration);
    });

    // Playlist handling
    document.querySelectorAll('.playlist-track').forEach(item => {
        item.addEventListener('click', async function(e) {
            e.preventDefault();
            
            if (!accessGranted) {
                if (accessModal) accessModal.show();
                return;
            }

            const episodeId = this.getAttribute('data-episode-id');
            if (!episodeId) return;

            // Update UI active state
            document.querySelectorAll('.playlist-track').forEach(el => {
                el.closest('.play-list-row').querySelector('.small-toggle-btn i').classList.remove('active-play'); 
            });

            try {
                const response = await fetch(`/episodes/${episodeId}/url`);
                const data = await response.json();
                
                if (data.url) {
                    const source = document.getElementById('source-audio');
                    source.src = data.url;
                    audio.load();
                    audio.play();
                    setPlaying(true);
                    
                    // Update title
                    const titleEl = document.querySelector('.audio-cmn-title .white-clr');
                    const titleText = this.querySelector('.pra-clr').textContent.trim();
                    if (titleEl) titleEl.textContent = titleText;
                }
            } catch (error) {
                console.error('Error fetching audio URL:', error);
            }
        });
    });
});
</script>
@endif


<!-- Custom Search Start -->
<div class="search-wrap">
    <div class="search-inner">
        <i class="fas fa-times search-close" id="search-close"></i>
        <div class="search-cell">
            <form method="get">
                <div class="search-field-holder">
                    <input type="search" class="main-search-input" placeholder="Search...">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Custom Search End -->

<!-- Main start -->
<main class="main position-relative overflow-hidden" id="mains">

    <!-- Listing Episode V01 -->
    <section class="listing-details-section whitebg pt-lg-20 pt-15 mt-xl-5">
        <div class="container">
            <div class="listing-details-wrap pb-space">
                <div class="details-content">
                    <p class="pra-clr mb-xxl-9 mb-xl-7 mb-lg-4 mb-3">
                        Lorem ipsum dolor sit amet, cibo mundi ea duo, vim exerci phaedrum. There are many
                        variations of passages of
                        Lorem Ipsum
                        available, but the majority have alteration in some injected or words which don't look even
                        slightly believable.
                        If you
                        are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything
                        embarrang hidden in the
                        middle of
                        text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as
                        necessary, making this
                        the
                        first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined
                        with a handful of
                        model
                        sentence structures, to generate Lorem Ipsum which looks reasonable.
                    </p>
                    <p class="pra-clr mb-xxl-9 mb-xl-7 mb-lg-4 mb-3">
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                        unknown printer took a
                        galley of
                        type and scrambled it to make a type simen book. It has survived not only five centuries,
                        but also the leap into
                        electronic typesetting.
                    </p>
                    <p class="pra-clr">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. orem Ipsum has
                        been the industry's
                        standard
                        dummy text ever since the when an unknown printer took a galley of type and scrambled it to
                        make a type specimen
                        book.
                        It has survived not only five centuries, but also the leap into unchanged.
                    </p>
                </div>
                <div
                    class="d-md-flex d-grid gap-5 gap-md-0 align-items-center justify-content-between pt-xxl-20 pt-xl-15 pt-lg-10 pt-sm-8 pt-7 mt-xxl-5">
                    <div class="listing-timeline">
                        <h4 class="black-clr mb-xxl-7 mb-xl-6 mb-lg-5 mb-4">
                            Episode timeline
                        </h4>
                        <div class="playlist-version001-wra">
                            <div class="audioplayer-listing-wraptwoverstion">
                                <div class="play-list d-grid gap-xxl-6 gap-xl-5 gap-lg-4 gap-3">
                                    @forelse($podcast->episodes as $episode)
                                    <div class="play-list-row d-flex align-items-center gap-xxl-1 gap-0"
                                        data-track-row="1">
                                        <div class="small-toggle-btn cmn-toggle-btnplay">
                                            <i class="small-play-btn white-clr">
                                            </i>
                                        </div>
                                        <div class="track-number">
                                            {{ $loop->iteration }}.
                                        </div>
                                        <div class="track-title">
                                            <a class="playlist-track fs20 fw-700 black-clr d-block atitle" href="#"
                                                data-play-track="{{ $loop->iteration }}" data-episode-id="{{ $episode->id }}">
                                                <span class="d-flex align-items-center gap-xxl-4 gap-3">
                                                    @if($episode->duration)
                                                    <span class="fs18 fw-700 black-clr">
                                                    {{ gmdate('i:s', $episode->duration) }}
                                                    </span>
                                                    @endif
                                                    <span class="pra-clr fs18 fw-400">
                                                    {{ $episode->title }}
                                                    </span>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                    @empty
                                       <p>No episodes yet.</p>
                                    @endforelse
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="thumb" data-aos="zoom-in" data-aos-duration="1400">
                        <img src="assets/img/blog/timeline-img.png" alt="img">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Listing Episode V01 -->

    <!-- Sponsor -->
    <div class="sponsor-section sponsor-section01 overflow-hidden theme-bg py-xxl-20 py-xl-15 py-10">
        <div class="container">
            <div class="swiper sponsor-wrapper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="sponsor-item">
                            <img src="{{ asset('assets/img/sponsor/s1.png') }}" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="sponsor-item">
                            <img src="{{ asset('assets/img/sponsor/s2.png') }}" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="sponsor-item">
                            <img src="{{ asset('assets/img/sponsor/s3.png') }}" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="sponsor-item">
                            <img src="{{ asset('assets/img/sponsor/s4.png') }}" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="sponsor-item">
                            <img src="{{ asset('assets/img/sponsor/s5.png') }}" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sponsor -->

    <!-- Transcript -->
    <section class="transscript-section pt-space pb-space whitebg">
        <div class="container">
            <div class="row g-7 justify-content-between">
                <div class="col-lg-5 col-md-5">
                    <div class="trans-thumb w-100" data-aos="zoom-in" data-aos-duration="1400">
                        <img src="{{ asset('assets/img/blog/transcript.png') }}" alt="img" class="w-100">
                    </div>
                </div>
                <div class="col-lg-6 col-md-7">
                    <div class="episode-trans">
                        <h4 class="black-clr mb-xl-7 mb-xl-6 mb-4">
                            Episode transcript:
                        </h4>
                        <div class="michale mb-xxl-9 mb-xl-7 mb-4">
                            <span class="fs18 fw-700 black-clr">
                                Michale:
                            </span>
                            <p class="pra-clr fs18">
                                Nam ultrices odio a felis lobortis convallis. In ex nunc, ornare non condimentum et,
                                egestas vel massa. Nullam hendrerit
                                felis quis pellentesque porttitor.
                            </p>
                        </div>
                        <div class="michale mb-xxl-9 mb-xl-7 mb-4">
                            <span class="fs18 fw-700 black-clr">
                                Christine:
                            </span>
                            <p class="pra-clr fs18">
                                Nam ultrices odio a felis lobortis convallis. In ex nunc, ornare non condimentum et,
                                egestas vel massa. Nullam hendrerit
                                felis quis pellentesque porttitor.
                            </p>
                        </div>
                        <div class="michale">
                            <span class="fs18 fw-700 black-clr">
                                Jessica:
                            </span>
                            <p class="pra-clr fs18">
                                Nam ultrices odio a felis lobortis convallis. In ex nunc, ornare non condimentum et,
                                egestas vel massa. Nullam hendrerit
                                felis quis pellentesque porttitor.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-space">
                <div class="col-lg-7">
                    <div class="start-donating-wrap">
                        <h4 class="black-clr mb-xxl-7 mb-xl-5 mb-4">
                            Start donating
                        </h4>
                        <div class="singletab position-relative">
                            <ul class="tablinks mb-xxl-5 mb-xl-4 mb-3">
                                <li class="nav-links">
                                    <button class="tablink">
                                        $10
                                    </button>
                                </li>
                                <li class="nav-links">
                                    <button class="tablink">
                                        $50
                                    </button>
                                </li>
                                <li class="nav-links active">
                                    <button class="tablink">
                                        $100
                                    </button>
                                </li>
                                <li class="nav-links">
                                    <button class="tablink">
                                        $250
                                    </button>
                                </li>
                            </ul>
                            <div class="tabcontents">
                                <div class="tabitem">
                                    <div class="danating-valu-here d-center">
                                        <span class="black-clr">
                                            $10
                                        </span>
                                    </div>
                                </div>
                                <div class="tabitem">
                                    <div class="danating-valu-here d-center">
                                        <span class="black-clr">
                                            $50
                                        </span>
                                    </div>
                                </div>
                                <div class="tabitem active">
                                    <div class="danating-valu-here d-center">
                                        <span class="black-clr">
                                            $100
                                        </span>
                                    </div>
                                </div>
                                <div class="tabitem">
                                    <div class="danating-valu-here d-center">
                                        <span class="black-clr">
                                            $250
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="dnt-btn mt-xxl-5 mt-4">
                                <button type="submit"
                                    class="touch-btn theme-bg fw-500 white-clr text-uppercase py-xxl-3 py-2 px-xxl-12 px-lg-9 px-8">
                                    Donate Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="blog-details-wrap pt-space">
                    <div class="blog-widget-item">
                        <div class="blog-comment-wrap">
                            <h4 class="black-clr mb-xxl-15 mb-xl-10 mb-lg-8 mb-6">
                                2 Comments
                            </h4>
                            <div
                                class="comment-items pb-xxl-10 pb-xl-7 pb-lg-5 pb-4 light-bb d-sm-flex d-grid justify-content-sm-start justify-content-center align-items-md-center gap-xxl-8 gap-xl-6 gap-lg-4 gap-3">
                                <div class="thumb">
                                    <img src="{{ asset('assets/img/blog/martin.png') }}" alt="img">
                                </div>
                                <div class="content-comment">
                                    <div
                                        class="d-flex flex-wrap gap-2 align-items-center justify-content-between mb-xxl-5 mb-xl-4 mb-3">
                                        <span class="fs20 fw-700 black-clr body-font">
                                            Kevin martin
                                        </span>
                                        <button type="button" class="reply">
                                            Reply
                                        </button>
                                    </div>
                                    <p class="pra-clr">
                                        It has survived not only five centuries, but also the leap into
                                        electronic typesetting simply fee text aunchanged. It
                                        was popularised in the sheets containing lorem ipsum is simply free
                                        text.
                                    </p>
                                </div>
                            </div>
                            <div
                                class="comment-items pb-xxl-10 pb-xl-7 pb-lg-5 pb-4 pt-xxl-10 pt-xl-7 pt-lg-5 pt-4 light-bb d-sm-flex d-grid justify-content-sm-start justify-content-center align-items-md-center gap-xxl-8 gap-xl-6 gap-lg-4 gap-3">
                                <div class="thumb">
                                    <img src="{{ asset('assets/img/blog/sarah.png') }}" alt="img">
                                </div>
                                <div class="content-comment">
                                    <div
                                        class="d-flex flex-wrap gap-2 align-items-center justify-content-between mb-xxl-5 mb-xl-4 mb-3">
                                        <span class="fs20 fw-700 black-clr body-font">
                                            Sarah Albert
                                        </span>
                                        <button type="button" class="reply">
                                            Reply
                                        </button>
                                    </div>
                                    <p class="pra-clr">
                                        It has survived not only five centuries, but also the leap into
                                        electronic typesetting simply fee text
                                        aunchanged. It
                                        was popularised in the sheets containing lorem ipsum is simply free
                                        text.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="review-area pt-xxl-20 pt-xl-10 pt-5 mt-5">
                            <h4 class="black-clr mb-xxl-15 mb-xl-10 mb-lg-8 mb-6">
                                Leave a comment
                            </h4>
                            <form action="#" class="common-form main-contact-form row g-lg-5 g-4">
                                <div class="col-lg-6">
                                    <input type="text" placeholder="Your name">
                                </div>
                                <div class="col-lg-6">
                                    <input type="email" placeholder="Email address">
                                </div>
                                <div class="col-lg-12">
                                    <textarea name="write-message" rows="6" placeholder="Write message"></textarea>
                                </div>
                                <div class="submit-btn">
                                    <button type="submit"
                                        class="touch-btn theme-bg white-clr text-uppercase py-xxl-3 py-2 px-xxl-12 px-lg-9 px-8">
                                        Submit Comment
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Transcript -->

    <!-- Features -->
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
                            <img src="{{ asset('assets/img/feature/feature1.png') }}" alt="img" class="overflow-hidden">
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
                                <a href="episode-details.php" class="black-clr fw-700">
                                    Strategy for your next podcast shows
                                </a>
                            </h4>
                            <a href="episode-details.php"
                                class="touch-btn bg4-clr black-clr text-uppercase fw-700 py-xxl-4 py-xl-4 py-3 px-xxl-12 px-lg-9 px-8">
                                Episode Page
                            </a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="feature-item whitebg d-xxl-flex d-grid align-items-center gap-xxl-8 gap-xl-6 gap-4">
                        <div class="thumb position-relative overflow-hidden">
                            <img src="{{ asset('assets/img/feature/feature2.png') }}" alt="img" class="overflow-hidden">
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
                                <a href="episode-details.php" class="black-clr fw-700">
                                    Strategy for your next podcast shows
                                </a>
                            </h4>
                            <a href="episode-details.php"
                                class="touch-btn bg4-clr black-clr text-uppercase fw-700 py-xxl-4 py-xl-4 py-3 px-xxl-12 px-lg-9 px-8">
                                Episode Page
                            </a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="feature-item whitebg d-xxl-flex d-grid align-items-center gap-xxl-8 gap-xl-6 gap-4">
                        <div class="thumb position-relative overflow-hidden">
                            <img src="{{ asset('assets/img/feature/feature1.png') }}" alt="img" class="overflow-hidden">
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
                                <a href="episode-details.php" class="black-clr fw-700">
                                    Strategy for your next podcast shows
                                </a>
                            </h4>
                            <a href="episode-details.php"
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
        <img src="{{ asset('assets/img/element/feature-shape.png') }}" alt="img" class="feature-shape">
        <!-- Element -->
    </section>

</main>
@endsection
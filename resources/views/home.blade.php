@extends('layouts.main.master')
@section('title')
    {{ $setting->company }}
@endsection
@section('description')
    {{ $setting->webname }}
@endsection
@section('image')
    {{ url('' . $banner[0]->image) }}
@endsection
@section('schema')
    <script type="application/ld+json">
{!! json_encode([
   '@context' => 'https://schema.org',
   '@type' => 'WebPage',
   'name' => $setting->company,
   'url' => url()->current(),
   'description' => $setting->webname,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .trv_hp5-slider .banner-desktop-only {
            display: block;
        }

        .trv_hp5-slider .banner-mobile-only {
            display: none;
        }

        @media (max-width: 767.98px) {
            .trv_hp5-slider .banner-desktop-only {
                display: none;
            }

            .trv_hp5-slider .banner-mobile-only {
                display: block;
            }
        }


        header.site-header.header-style-3:not(.is-fixed) {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: transparent;
        }



        /* Banner wrap: full bleed, no padding, sits at very top of page */
        .page-content > .trv-hp5-bnr-wrap {
            padding: 0;
            background: #000;
            margin-top: 0;
        }

        .page-content > .trv-hp5-bnr-wrap .trv-hp5-bnr-sec {
            border-radius: 0;
            position: relative;
            min-height: 100vh;
            height: 100vh;
            overflow: hidden;
        }

        /* Hero slider (Swiper) takes full hero size */
        .trv-hero-slider {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .trv-hero-slider .swiper-wrapper,
        .trv-hero-slider .swiper-slide {
            height: 100%;
        }

        .trv-hero-slide {
            position: relative;
            overflow: hidden;
            background-color: #000;
        }

        /* Slide media (video or image) covers entire slide */
        .trv-hero-slide .trv-hero-media {
            position: absolute;
            inset: 0;
            z-index: 0;
            background-color: #000;
        }

        .trv-hero-slide .trv-vid-full,
        .trv-hero-slide .trv-img-full {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
            display: block;
        }

        /* YouTube iframe wrapper: 16:9 cover the whole hero */
        .trv-hero-slide .trv-yt-wrap {
            position: absolute;
            inset: 0;
            overflow: hidden;
            background: #000;
            z-index: 0;
            pointer-events: none;
        }

        .trv-hero-slide .trv-yt-frame {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100vw;
            height: 56.25vw;
            min-width: 177.78vh;
            min-height: 100vh;
            transform: translate(-50%, -50%);
            border: 0;
            display: block;
            pointer-events: none;
        }

        /* Subtle Ken-Burns zoom on active image slide for life */
        .trv-hero-slider .swiper-slide-active .trv-img-full {
            animation: trvHeroZoom 9s ease-out forwards;
        }

        @keyframes trvHeroZoom {
            0% { transform: translate(-50%, -50%) scale(1); }
            100% { transform: translate(-50%, -50%) scale(1.08); }
        }

        /* Dark overlay for text readability (per slide) */
        .trv-hero-slide .trv-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.55) 0%, rgba(0, 0, 0, 0.30) 45%, rgba(0, 0, 0, 0.65) 100%);
            z-index: 1;
        }

        /* Hero text/content over media (per slide) */
        .trv-hero-slide .trv-hero-content {
            position: absolute;
            inset: 0;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 180px 20px 80px;
            color: #fff;
        }

        .trv-hero-slide .trv-hero-content .trv-hero-sub {
            display: inline-block;
            font-size: 14px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #FFAA0D;
            margin-bottom: 16px;
            font-weight: 600;
        }

        .trv-hero-slide .trv-hero-content .trv-hero-title {
            font-family: "Afacad", "Montserrat", sans-serif;
            font-size: clamp(38px, 6vw, 80px);
            font-weight: 800;
            line-height: 1.05;
            margin: 0 0 20px;
            color: #fff;
            text-shadow: 0 4px 24px rgba(0, 0, 0, 0.45);
        }

        .trv-hero-slide .trv-hero-content .trv-hero-title .accent {
            color: #FFAA0D;
        }

        .trv-hero-slide .trv-hero-content .trv-hero-desc {
            max-width: 720px;
            font-size: clamp(15px, 1.2vw, 18px);
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.92);
            margin: 0 auto 32px;
            text-shadow: 0 2px 12px rgba(0, 0, 0, 0.45);
        }

        .trv-hero-slide .trv-hero-content .trv-hero-actions {
            display: inline-flex;
            gap: 14px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .trv-hero-slide .trv-hero-content .trv-hero-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 15px;
            text-decoration: none;
            transition: transform .25s ease, box-shadow .25s ease, background .25s ease;
        }

        .trv-hero-slide .trv-hero-content .trv-hero-btn.is-primary {
            background: #FFAA0D;
            color: #1a1a1a;
            box-shadow: 0 10px 26px rgba(255, 170, 13, 0.35);
        }

        .trv-hero-slide .trv-hero-content .trv-hero-btn.is-primary:hover {
            background: #ffbb33;
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(255, 170, 13, 0.45);
        }

        .trv-hero-slide .trv-hero-content .trv-hero-btn.is-ghost {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            border: 1.5px solid rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        }

        .trv-hero-slide .trv-hero-content .trv-hero-btn.is-ghost:hover {
            background: rgba(255, 255, 255, 0.18);
            transform: translateY(-2px);
        }

        /* Slide-in animation for hero text on active slide */
        .trv-hero-slider .swiper-slide-active .trv-hero-content .trv-hero-sub,
        .trv-hero-slider .swiper-slide-active .trv-hero-content .trv-hero-title,
        .trv-hero-slider .swiper-slide-active .trv-hero-content .trv-hero-desc,
        .trv-hero-slider .swiper-slide-active .trv-hero-content .trv-hero-actions {
            animation: trvHeroFadeUp .9s cubic-bezier(.2, .7, .2, 1) both;
        }

        .trv-hero-slider .swiper-slide-active .trv-hero-content .trv-hero-title { animation-delay: .15s; }
        .trv-hero-slider .swiper-slide-active .trv-hero-content .trv-hero-desc { animation-delay: .25s; }
        .trv-hero-slider .swiper-slide-active .trv-hero-content .trv-hero-actions { animation-delay: .35s; }

        @keyframes trvHeroFadeUp {
            0% { opacity: 0; transform: translateY(24px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Pagination dots */
        .trv-hero-slider .trv-hero-pagination {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 28px;
            z-index: 6;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .trv-hero-slider .trv-hero-pagination .swiper-pagination-bullet {
            width: 10px;
            height: 10px;
            background: rgba(255, 255, 255, 0.45);
            opacity: 1;
            margin: 0 !important;
            transition: width .3s ease, background .3s ease;
            border-radius: 999px;
        }

        .trv-hero-slider .trv-hero-pagination .swiper-pagination-bullet-active {
            width: 28px;
            background: #FFAA0D;
        }

        /* Prev/Next nav */
        .trv-hero-slider .trv-hero-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 6;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 1.5px solid rgba(255, 255, 255, 0.45);
            background: rgba(0, 0, 0, 0.25);
            color: #fff;
            font-size: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .25s ease, transform .25s ease, border-color .25s ease;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        }

        .trv-hero-slider .trv-hero-nav-btn:hover {
            background: #FFAA0D;
            border-color: #FFAA0D;
            color: #1a1a1a;
            transform: translateY(-50%) scale(1.05);
        }

        .trv-hero-slider .trv-hero-prev { left: 24px; }
        .trv-hero-slider .trv-hero-next { right: 24px; }

        /* Search bar slight overlap with hero */
        .page-content > .trv-hp5-bnr-wrap + .trv-search-st1-wrap {
            position: relative;
            z-index: 5;
        }

        @media (max-width: 991px) {
            .page-content > .trv-hp5-bnr-wrap .trv-hp5-bnr-sec {
                min-height: 90vh;
                height: 90vh;
            }

            .trv-hero-slide .trv-hero-content {
                padding: 140px 16px 60px;
            }

            .trv-hero-slider .trv-hero-nav-btn {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }

            .trv-hero-slider .trv-hero-prev { left: 12px; }
            .trv-hero-slider .trv-hero-next { right: 12px; }
        }

        @media (max-width: 767px) {
            .page-content > .trv-hp5-bnr-wrap .trv-hp5-bnr-sec {
                min-height: 80vh;
                height: 80vh;
            }

            .trv-hero-slide .trv-hero-content {
                padding: 120px 16px 60px;
            }

            .trv-hero-slide .trv-hero-content .trv-hero-sub {
                font-size: 12px;
                letter-spacing: 3px;
            }

            .trv-hero-slide .trv-hero-content .trv-hero-btn {
                padding: 12px 22px;
                font-size: 14px;
            }

            .trv-hero-slider .trv-hero-nav-btn {
                display: none;
            }

            .trv-hero-slider .trv-hero-pagination {
                bottom: 16px;
            }

            .page-content > .trv-hp5-bnr-wrap + .trv-search-st1-wrap {
                margin-top: 0px;
            }
        }

        .trv-head-title.trv-head-title-star {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            text-align: center;
            line-height: 1.1;
            white-space: nowrap;
        }

        .trv-head-title-star .fav-top,
        .trv-head-title-star .fav-bottom {
            position: relative;
            z-index: 2;
            display: inline-block;
        }

        .trv-head-title-star .fav-star {
            position: relative;
            z-index: 3;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #eef8f7;
            color: #FFAA0D;
            font-size: 15px;
            line-height: 1;
            box-shadow: 0 0 0 3px rgba(238, 248, 247, 0.95);
        }

        .trv-head-title-star .fav-star::before,
        .trv-head-title-star .fav-star::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 92px;
            height: 1px;
            transform: translateY(-50%);
            opacity: 0.7;
            pointer-events: none;
        }

        .trv-head-title-star .fav-star::before {
            right: calc(100% - 1px);
            background: linear-gradient(90deg, rgba(255, 170, 13, 0), rgba(255, 170, 13, 0.9), rgba(255, 170, 13, 0.35));
        }

        .trv-head-title-star .fav-star::after {
            left: calc(100% - 1px);
            background: linear-gradient(90deg, rgba(255, 170, 13, 0.35), rgba(255, 170, 13, 0.9), rgba(255, 170, 13, 0));
        }
    </style>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof WOW !== 'undefined') {
                new WOW({
                    boxClass: 'wow',
                    animateClass: 'animate__animated',
                    offset: 80,
                    mobile: true,
                    live: true
                }).init();
            }

            var heroEl = document.querySelector('.trv-hero-slider');
            if (!heroEl || typeof Swiper === 'undefined') return;

            var slideCount = heroEl.querySelectorAll('.swiper-slide').length;
            var enableLoop = slideCount > 1;

            var heroSwiper = new Swiper(heroEl, {
                slidesPerView: 1,
                centeredSlides: false,
                loop: enableLoop,
                speed: 900,
                effect: 'fade',
                fadeEffect: { crossFade: true },
                allowTouchMove: enableLoop,
                autoplay: enableLoop ? {
                    delay: 7000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: false,
                } : false,
                pagination: enableLoop ? {
                    el: heroEl.querySelector('.trv-hero-pagination'),
                    clickable: true,
                } : false,
                navigation: enableLoop ? {
                    nextEl: heroEl.querySelector('.trv-hero-next'),
                    prevEl: heroEl.querySelector('.trv-hero-prev'),
                } : false,
            });

            function ytCommand(iframe, func) {
                if (!iframe || !iframe.contentWindow) return;
                try {
                    iframe.contentWindow.postMessage(JSON.stringify({
                        event: 'command',
                        func: func,
                        args: []
                    }), '*');
                } catch (e) {}
            }

            function syncMedia() {
                var slides = heroEl.querySelectorAll('.swiper-slide');
                slides.forEach(function(slide) {
                    var isActive = slide.classList.contains('swiper-slide-active') ||
                        slide.classList.contains('swiper-slide-duplicate-active');

                    var v = slide.querySelector('video');
                    if (v) {
                        if (isActive) {
                            try { v.currentTime = 0; } catch (e) {}
                            var p = v.play();
                            if (p && typeof p.catch === 'function') p.catch(function() {});
                        } else {
                            try { v.pause(); } catch (e) {}
                        }
                    }

                    var yt = slide.querySelector('iframe.trv-yt-frame');
                    if (yt) {
                        ytCommand(yt, isActive ? 'playVideo' : 'pauseVideo');
                    }
                });
            }

            heroSwiper.on('slideChangeTransitionStart', syncMedia);
            heroSwiper.on('init', syncMedia);
            syncMedia();
        });
    </script>
@endsection
@section('content')
    <!-- CONTENT START -->
    <div class="page-content">
        <div class="trv-hp5-bnr-wrap">
            <div class="trv-hp5-bnr-sec">
                @php
                    $heroSlides = collect($banner ?? [])
                        ->filter(function ($b) {
                            return !empty($b->image);
                        })
                        ->values();
                    $heroLoop = $heroSlides->count() > 1;
                @endphp

                @if ($heroSlides->isNotEmpty())
                <div class="swiper trv-hero-slider">
                    <div class="swiper-wrapper">
                        @foreach ($heroSlides as $slide)
                            @php
                                $media = detectMediaType($slide->image ?? '');
                                $sTitle = trim((string) languageName($slide->title ?? ''));
                                $sSub = trim((string) languageName($slide->subtitle ?? ''));
                                $sDesc = trim((string) languageName($slide->description ?? ''));
                                $sLink = trim((string) ($slide->link ?? ''));
                                $ytEmbedParams = http_build_query([
                                    'autoplay' => 1,
                                    'mute' => 1,
                                    'controls' => 0,
                                    'loop' => 1,
                                    'playlist' => $media['youtubeId'],
                                    'modestbranding' => 1,
                                    'playsinline' => 1,
                                    'rel' => 0,
                                    'showinfo' => 0,
                                    'iv_load_policy' => 3,
                                    'disablekb' => 1,
                                    'fs' => 0,
                                    'enablejsapi' => 1,
                                ]);
                            @endphp
                            <div class="swiper-slide trv-hero-slide">
                                <div class="trv-hero-media">
                                    @if ($media['type'] === 'youtube')
                                        <div class="trv-yt-wrap">
                                            <iframe class="trv-yt-frame"
                                                src="https://www.youtube.com/embed/{{ $media['youtubeId'] }}?{{ $ytEmbedParams }}"
                                                title="{{ $sTitle ?: ($setting->company ?? 'Banner') }}"
                                                frameborder="0"
                                                allow="autoplay; encrypted-media; picture-in-picture"
                                                allowfullscreen
                                                loading="lazy"></iframe>
                                        </div>
                                    @elseif ($media['type'] === 'video')
                                        <video class="trv-vid-full" muted autoplay playsinline loop preload="metadata">
                                            <source src="{{ $media['url'] }}" type="{{ $media['mime'] }}">
                                        </video>
                                    @elseif ($media['type'] === 'image')
                                        <img class="trv-img-full" src="{{ $media['url'] }}"
                                            alt="{{ $sTitle ?: ($setting->company ?? 'Banner') }}" loading="eager">
                                    @endif
                                </div>

                                <div class="trv-hero-overlay"></div>

                                <div class="trv-hero-content">
                                    <span class="trv-hero-sub">
                                        {{ $sSub !== '' ? $sSub : ($setting->webname ?? $setting->company ?? 'Welcome') }}
                                    </span>
                                    <h1 class="trv-hero-title">
                                        @if ($sTitle !== '')
                                            {!! $sTitle !!}
                                        @else
                                            Khám phá <span class="accent">hành trình</span><br>
                                            đáng nhớ cùng {{ $setting->company ?? '' }}
                                        @endif
                                    </h1>
                                   
                                    <p class="trv-hero-desc">
                                        {{ $sDesc !== '' ? $sDesc : ($setting->description ?? 'Trải nghiệm những điểm đến tuyệt vời, dịch vụ chuyên nghiệp và những kỷ niệm khó quên cho chuyến đi của bạn.') }}
                                    </p>
                                    <div class="trv-hero-actions">
                                        @if ($sLink !== '')
                                            <a href="{{ $sLink }}" class="trv-hero-btn is-primary">
                                                <i class="bi bi-arrow-right-circle"></i> {{getLanguage('learnMore')}}
                                            </a>
                                        @else
                                            <a href="{{ route('allProduct') }}" class="trv-hero-btn is-primary">
                                                <i class="bi bi-compass"></i> {{getLanguage('discoverTour')}}
                                            </a>
                                        @endif
                                        <a href="{{ route('lienHe') }}" class="trv-hero-btn is-ghost">
                                            <i class="bi bi-telephone"></i> {{getLanguage('contactNow')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($heroLoop)
                        <div class="trv-hero-pagination swiper-pagination"></div>
                        <button type="button" class="trv-hero-nav-btn trv-hero-prev" aria-label="Previous slide">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="trv-hero-nav-btn trv-hero-next" aria-label="Next slide">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    @endif
                </div>
                @endif
            </div>
        </div>
        <!-- Banner Style One -->
        
        <!-- Banner Style One End -->

        <!-- SEARCH BAR START-->
        <div class="trv-search-st1-wrap mt-30 wow animate__fadeInUp" data-wow-delay="0.1s">
            <div class="trv-search-st1">
                <div class="trv-search-st1-bg">
                    <form id="product-filter-form" method="GET" action="{{ route('allProduct') }}">
                        <div class="trv-search-st1-column-wrap">
                            <div class="trv-search-st1-column">
                                <div class="form-group">
                                    <label><i><img loading="lazy" src="/frontend/images/icon1.png"
                                                alt="Image"></i>{{getLanguage('destination')}}</label>
                                    <select class="form-select form-control js-auto-filter" aria-label="Default select example"
                                        name="cate_filter">
                                        <option value="">{{getLanguage('all')}}</option>
                                        @foreach ($categoryhome as $item)
                                            <option value="{{ $item->slug }}" {{ request('cate_filter') == $item->slug ? 'selected' : '' }}>
                                                {{ languageName($item->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="trv-search-st1-column">
                                <div class="form-group form-group-2column-wrap twm-input-with-icon">
                                    <label><i><img loading="lazy" src="/frontend/images/icon3.png"
                                                alt="Image"></i>{{getLanguage('time')}}</label>
                                    <select class="form-select form-control js-auto-filter" aria-label="Default select example"
                                        name="duration_range">
                                        <option value="">{{getLanguage('all')}}</option>
                                        <option value="1-3" {{ request('duration_range') == '1-3' ? 'selected' : '' }}>1-3 {{getLanguage('days')}}</option>
                                        <option value="4-7" {{ request('duration_range') == '4-7' ? 'selected' : '' }}>4-7 {{getLanguage('days')}}</option>
                                        <option value="8-11" {{ request('duration_range') == '8-11' ? 'selected' : '' }}>8-11 {{getLanguage('days')}}</option>
                                        <option value="12-15" {{ request('duration_range') == '12-15' ? 'selected' : '' }}>12-15 {{getLanguage('days')}}</option>
                                        <option value="16-20" {{ request('duration_range') == '16-20' ? 'selected' : '' }}>16-20 {{getLanguage('days')}}</option>
                                        <option value="21-23" {{ request('duration_range') == '21-23' ? 'selected' : '' }}>21-23 {{getLanguage('days')}}</option>
                                        <option value="24-27" {{ request('duration_range') == '24-27' ? 'selected' : '' }}>24-27 {{getLanguage('days')}}</option>
                                        <option value="28-31" {{ request('duration_range') == '28-31' ? 'selected' : '' }}>28-31 {{getLanguage('days')}}</option>
                                        <option value="32+" {{ request('duration_range') == '32+' ? 'selected' : '' }}>32+ {{getLanguage('days')}}</option>
                                    </select>
                                </div>
                            </div>
                            @if (!empty($filter) && count($filter) > 0)
                                @foreach ($filter as $filterItem)
                                    @if (!empty($filterItem->tags) && count($filterItem->tags) > 0)
                                        <div class="trv-search-st1-column">
                                            <div class="form-group">
                                                <label><i><img loading="lazy" src="https://thewebmax.org/travlla/images/search-icon/icon2.png" alt="Image"></i>{{ languageName($filterItem->name) }}</label>
                                                <select class="form-select form-control js-auto-filter" aria-label="Default select example" name="fillter[]">
                                                    <option value="">{{getLanguage('all')}}</option>
                                                    @foreach ($filterItem->tags as $tag)
                                                        <option value="{{ $tag->slug }}" {{ in_array($tag->slug, (array) request('fillter', [])) ? 'selected' : '' }}>
                                                            {{ languageName($tag->name) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
 
                            <div class="trv-search-st1-column-last">
                                <div class="trv-search-st1-search-btn">
                                    <button type="submit" class="srch-btn"><i class="bi bi-search"></i></button>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
        <!-- SEARCH BAR END-->

        <!--POPULAR DESTINATION SECTION START-->
        <div class="section-full p-t40 p-b40 trv-popular-destination tvr-hot-ballon-wrap wow animate__fadeInUp" data-wow-delay="0.15s"
            style="background-image: url(/frontend/images/Cloud-bg.png)">
            <div class="container">
                <!-- TITLE START-->
                <div class="section-head trv-head-title-wrap center-position">
                    <h2 class="trv-head-title trv-head-title-star">
                        <span class="fav-bottom">{{getLanguage('popular_destination')}}</span>
                    </h2>
                    <div class="trv-head-discription">{{getLanguage('des_popular_destination')}}</div>
                    <div class="trv-head-title-image">
                        <img loading="lazy" src="/frontend/images/Title-Separator.png" alt="Image">
                    </div>
                </div>
                <!-- TITLE END-->

                <div class="section-content">

                    <div class="swiper trv-popular-destination-row trv-pop-des-st1-carousal swiper-nav-center-bottom">
                        <div class="swiper-wrapper">
                            @foreach ($categoryhome as $item)
                                <div class="swiper-slide">
                                    <div class="trv-destination-bx1">
                                        <div class="trv-media">
                                            <a href="{{route('allListProCate', ['danhmuc' => $item->slug])}}"><img loading="lazy" src="{{ $item->imagehome }}"
                                                    alt="Image"></a>
                                        </div>
                                        <div class="trv-content">
                                            <h3 class="trv-title"><a
                                                    href="{{ route('allListProCate', ['danhmuc' => $item->slug]) }}">{{ languageName($item->name) }}</a>
                                            </h3>
                                        </div>
                                        <div class="trv-on-hover">
                                            <img loading="lazy" src="/frontend/images/hotballon-right.png" alt="image">
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                </div>

            </div>


        </div>
        <!--POPULAR DESTINATION SECTION END-->
        <div class="section-full p-t60 p-b0 trv-tour-category-section wow animate__fadeInUp" data-wow-delay="0.15s" style="background-image: url(https://thewebmax.org/travlla/images/background/tour-bg.jpg);">
            <div class="container">
                <div class="trv-btm-title-section">
                    
                    <h2 class="trv-btm-title-large text-capitalize">{{getLanguage('service')}}</h2>
                    <span>{{getLanguage('service_description')}}</span>
                </div>
            </div>
            <div id="module">
                
                <div class="swiper trv-tr-cat-carousal">
                    <div class="swiper-wrapper">
                        @foreach ($servicecatehome as $item)
                        <div class="trv-cat-sld swiper-slide" data-title="{{languageName($item->name)}}">
                            <div class="trv-tr-cat-carousal-media">
                                <img src="{{$item->image}}" alt="Image">
                                <h3 class="trv-bx-title"><a href="javascript:;">{{languageName($item->name)}}</a></h3>
                                <p class="trv-bx-description line_2">{{languageName($item->description)}}</p>
                            </div>
                            
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>

            

        </div>
        <div class="section-full p-t120 p-b90 trv-visa-sec-media-wrap wow animate__fadeInUp" data-wow-delay="0.15s" style="background-image: url(/frontend/images/quick-visa-bg.jpg);">
            <div class="container">

                <!-- TITLE START-->
                <div class="section-head trv-head-title-wrap center-position">
                    <h2 class="trv-head-title"> {{getLanguage('popular_tour')}}</h2>
                    <div class="trv-head-discription">{{getLanguage('popular_tour_description')}}</div>
                </div>
                <!-- TITLE END-->

                <div class="section-content">

                    <!-- FILTER BUTTONS -->
                    <div class="trv-visa-filter-bx-wrap">

                        <!-- Filter Tabs -->
                        <div class="trv-visa-filter">
                            @foreach ($categoryhome as $key => $item)
                                <span data-filter="{{ $item->slug }}" class="{{ $key == 0 ? 'active' : '' }}">{{ languageName($item->name) }}</span>
                            @endforeach
                        </div>

                        <!-- Swiper Carousel -->
                        <div class="swiper trv-visa-filter-bx">
                            <div class="swiper-wrapper">
                                @php $hasPopularTour = false; @endphp
                                @foreach ($categoryhome as $cate)
                                    @php
                                        $popularTours = collect($cate->product ?? [])->where('status', 1)->take(8);
                                    @endphp
                                    @foreach ($popularTours as $tour)
                                        @php
                                            $hasPopularTour = true;
                                            $tourImages = [];
                                            if (!empty($tour->images)) {
                                                $decoded = json_decode($tour->images, true);
                                                if (is_array($decoded)) {
                                                    $tourImages = $decoded;
                                                }
                                            }
                                            $thumb = !empty($tourImages) ? $tourImages[0] : ($cate->imagehome ?? '/frontend/images/default.jpg');
                                            $tagcate = $cate;
                                        @endphp
                                        <div class="swiper-slide" data-filter="{{ $cate->slug }}">
                                            @include('layouts.product.item', ['pro' => $tour, 'tagcateContext' => $tagcate])
                                        </div>
                                    @endforeach
                                @endforeach
                                @if (!$hasPopularTour)
                                    <div class="swiper-slide" data-filter="{{ $categoryhome->first()->slug ?? '' }}">
                                        <div class="trv-visa-sec-media">
                                            <img src="/frontend/images/default.jpg" alt="Image">
                                            <h3 class="trv-bx-title">
                                                <a href="javascript:;">Chưa có tour nổi bật</a>
                                            </h3>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!-- Navigation Arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>

                    </div>
                    
                </div> 

            </div>
                  
        </div>
     {{-- {{dd($tagCate)}} --}}
     @foreach ($tagCate as $tagcate)
         @if (count($tagcate->product) > 0 && $tagcate->status == 1)
             <!--WE RECOMMEND SECTION START-->
        <div class="section-full p-t40 p-b0 trv-we-recommend wow animate__fadeInUp" data-wow-delay="0.15s">
         <div class="container-fluid">
             <!-- TITLE START-->
             <div class="section-head trv-head-title-wrap center-position">
                 <h2 class="trv-head-title"><span class="site-text-yellow"> {{ languageName($tagcate->name) }}</span> Tours!</h2>
                 <div class="trv-head-title-image">
                    <img loading="lazy" src="/frontend/images/Title-Separator.png" alt="Image">
                 </div>
             </div>
             <!-- TITLE END-->

             <div class="section-content">

                 <div class="swiper trv-popular-tours-row trv-tours-st1-carousal swiper-nav-center-bottom">
                     <div class="swiper-wrapper">
                         @foreach ($tagcate->product as $item)
                         {{-- {{dd($item->tags)}} --}}
                             <div class="swiper-slide">
                                 @include('layouts.product.item', ['pro' => $item, 'tagcateContext' => $tagcate])
                             </div>
                         @endforeach
                     </div>
                     <div class="swiper-button-next"></div>
                     <div class="swiper-button-prev"></div>
                 </div>

             </div>

         </div>

     </div>
     <!--WE RECOMMEND SECTION END-->
         @endif
     @endforeach
        

     <div class="section-full p-t60 p-b50 trv-ben-book-wrap">
        <div class="container">
            <!-- TITLE START-->
            <div class="section-head trv-head-title-wrap center-position">
                <h2 class="trv-head-title">Why Travel With EPIC TRIP TRAVEL</h2>
                <div class="trv-head-discription">Discover the unrivalled benefits that promise memorable journeys all along.</div>
                <div class="trv-head-title-image">
                    <img loading="lazy" src="/frontend/images/Title-Separator.png" alt="Image">
                </div>
            </div>
            <!-- TITLE END-->

            <div class="section-content">
                <div class="trv-ben-book-sec row">
                    @forelse ($whyTravelWith ?? [] as $item)
                    <div class="col-lg-3 col-md-6">
                        <div class="trv-ben-book-bx">
                            @if($item->image)
                            <div class="trv-ben-media">
                                <img loading="lazy" src="{{ $item->image }}" alt="{{ strip_tags(languageName($item->title)) }}">
                            </div>
                            @endif
                            <h3 class="trv-ben-title">{{ languageName($item->title) }}</h3>
                            <p>{{ languageName($item->description) }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="col-lg-3 col-md-6">
                        <div class="trv-ben-book-bx">
                            <div class="trv-ben-media">
                                <img loading="lazy" src="/frontend/images/book-rating/001.png" alt="image">
                            </div>
                            <h3 class="trv-ben-title">Customised Itineraries</h3>
                            <p>Enjoy fully customisable tour packages, shaped around your interests for a truly personal experience.</p>
                        </div>
                    </div>
                    @endforelse
                </div>
                
            </div> 

        </div>
    </div>
    <!--Benefits of Booking With Us SECTION END-->


</div>


        <!--3 STEP SECTION START-->
        
        <!--3 STEP SECTION END-->

        <!--TESTIMONIAL SECTION START-->
        <div class="section-full trv-testimonial-st2-wrap tvr-hot-ballon-wrap wow animate__fadeInUp" data-wow-delay="0.15s">
            <div class="container">
                <!-- TITLE START-->
                <div class="section-head trv-head-title-wrap center-position">
                    <h2 class="trv-head-title"> {!!getLanguage('feedbacktitle')!!}</h2>
                    <div class="trv-head-discription">{!!getLanguage('feedbacktitledes')!!}</div>
                    <div class="trv-head-title-image">
                        <img loading="lazy" src="/frontend/images/Title-Separator.png" alt="Image">
                    </div>
                </div>
                <!-- TITLE END-->
                <div class="section-content">
                    {{-- <div class="trv-gradi-text">
                        Testimonials
                        <img loading="lazy" src="/frontend/images/airplane-takeoff1.png" alt="Image">
                    </div> --}}
                    <div class="swiper trv-trv-t-monial-row trv-t-monial-carousal swiper-nav-center-bottom">
                        <div class="swiper-wrapper">
                            <!--BOX-1-->
                            @foreach ($ReviewCus as $item)
                            <div class="swiper-slide">
                                <div class="trv-testimo-bx1">
                                    {{-- <div class="media">
                                        <img src="{{$item->avatar}}" alt="image">

                                        <div class="rating">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                    </div> --}}
                                    <div class="info">
                                        <div class="trv-testimo-head">
                                            <div class="left-part">
                                                <h4 class="trv-testimonial-name">{{languageName($item->name)}}</h4>
                                                <span class="trv-testimonial-position">{{languageName($item->position) ?? 'Tourist'}}</span>
                                            </div>
                                            <div class="right-part">
                                                <img src="{{url('frontend/images/Quote.png')}}" alt="image">
                                            </div>
                                        </div>
                                        <p>
                                            {!!languageName($item->content)!!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                           

                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!--TESTIMONIAL SECTION End-->

        <!--ALL BLOGS SECTION START-->
        <div class="trv-blog-all-style p-t40 p-b90 wow animate__fadeInUp" data-wow-delay="0.15s">
            <div class="container">
                <!-- TITLE START-->
                <div class="row trv-column-style-head">
                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="section-head trv-head-title-wrap left-position">
                            <h2 class="trv-head-title">{!!getLanguage('blog')!!}</h2>
                        </div>
                    </div>
                </div>
                <!-- TITLE END-->

                <div class="section-content">

                    @php
                        $news = $hotnews->values();
                        $news1 = $news->get(0);
                        $news2 = $news->get(1);
                        $news3 = $news->get(2);
                        $news4 = $news->get(3);
                        $news5 = $news->get(4);
                        $news6 = $news->get(5);
                    @endphp
                    <div class="row d-flex justify-content-center">

                        <div class="col-xl-4 col-lg-6 col-md-6">
                            @if ($news1)
                                <div class="trv-blog-st1">
                                    <div class="trv-post-media">
                                        <a href="{{ route('detailBlog', ['slug' => $news1->slug]) }}"><img loading="lazy" src="{{ $news1->image }}"
                                                alt="{{ languageName($news1->title) }}"></a>
                                    </div>

                                    <div class="post-date"><span>{{ optional($news1->created_at)->format('d') }}</span>{{ optional($news1->created_at)->format('M') }}</div>
                                    <div class="trv-post-info">
                                        <div class="post-category">News</div>
                                        <div class="trv-post-title ">
                                            <h5 class="post-title"><a href="{{ route('detailBlog', ['slug' => $news1->slug]) }}">{{ languageName($news1->title) }}</a></h5>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($news2)
                                <div class="trv-blog-st1">
                                    <div class="trv-post-media">
                                        <a href="{{ route('detailBlog', ['slug' => $news2->slug]) }}"><img loading="lazy" src="{{ $news2->image }}"
                                                alt="{{ languageName($news2->title) }}"></a>
                                    </div>

                                    <div class="post-date"><span>{{ optional($news2->created_at)->format('d') }}</span>{{ optional($news2->created_at)->format('M') }}</div>
                                    <div class="trv-post-info">
                                        <div class="post-category">News</div>
                                        <div class="trv-post-title ">
                                            <h5 class="post-title"><a href="{{ route('detailBlog', ['slug' => $news2->slug]) }}">{{ languageName($news2->title) }}</a></h5>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($news3)
                                <div class="trv-blog-st1">
                                    <div class="trv-post-media">
                                        <a href="{{ route('detailBlog', ['slug' => $news3->slug]) }}"><img loading="lazy" src="{{ $news3->image }}"
                                                alt="{{ languageName($news3->title) }}"></a>
                                    </div>

                                    <div class="post-date"><span>{{ optional($news3->created_at)->format('d') }}</span>{{ optional($news3->created_at)->format('M') }}</div>
                                    <div class="trv-post-info">
                                        <div class="post-category">News</div>
                                        <div class="trv-post-title ">
                                            <h5 class="post-title"><a href="{{ route('detailBlog', ['slug' => $news3->slug]) }}">{{ languageName($news3->title) }}</a></h5>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6">
                            @if ($news4)
                                <div class="trv-blog-st1">
                                    <div class="trv-post-media">
                                        <a href="{{ route('detailBlog', ['slug' => $news4->slug]) }}"><img loading="lazy" src="{{ $news4->image }}"
                                                alt="{{ languageName($news4->title) }}"></a>
                                    </div>

                                    <div class="post-date"><span>{{ optional($news4->created_at)->format('d') }}</span>{{ optional($news4->created_at)->format('M') }}</div>
                                    <div class="trv-post-info">
                                        <div class="post-category">News</div>
                                        <div class="trv-post-title ">
                                            <h5 class="post-title"><a href="{{ route('detailBlog', ['slug' => $news4->slug]) }}">{{ languageName($news4->title) }}</a></h5>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            @if ($news5)
                                <div class="trv-blog-st2">
                                    <div class="trv-post-media">
                                        <a href="{{ route('detailBlog', ['slug' => $news5->slug]) }}"><img loading="lazy" src="{{ $news5->image }}"
                                                alt="{{ languageName($news5->title) }}"></a>
                                    </div>

                                    <div class="post-date"><span>{{ optional($news5->created_at)->format('d') }}</span>{{ optional($news5->created_at)->format('M') }}</div>
                                    <div class="trv-post-info">
                                        <div class="post-category">News</div>
                                        <div class="trv-post-title ">
                                            <h5 class="post-title"><a href="{{ route('detailBlog', ['slug' => $news5->slug]) }}">{{ languageName($news5->title) }}</a></h5>
                                        </div>
                                    </div>
                                </div>
                            @endif


                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6">

                            @if ($news6)
                                <div class="trv-blog-st3">
                                    <div class="trv-post-media">
                                        <a href="{{ route('detailBlog', ['slug' => $news6->slug]) }}"><img loading="lazy" src="{{ $news6->image }}"
                                                alt="{{ languageName($news6->title) }}"></a>
                                    </div>

                                    <div class="post-date"><span>{{ optional($news6->created_at)->format('d') }}</span>{{ optional($news6->created_at)->format('M') }}</div>
                                    <div class="trv-post-info">
                                        <div class="post-category">News</div>
                                        <div class="trv-post-title ">
                                            <h3 class="post-title"><a href="{{ route('detailBlog', ['slug' => $news6->slug]) }}">{{ languageName($news6->title) }}</a></h3>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>

                </div>

            </div>
        </div>
        <!--ALL BLOGS SECTION END-->


    </div>
    <!-- CONTENT END -->
@endsection

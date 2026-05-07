@extends('layouts.main.master')
@section('title')
{{languageName($product->name)}}
@endsection
@section('description')
{{languageName($product->description)}}
@endsection
@section('image')
@php
$img = json_decode($product->images);
$route = json_decode($product->size);
$datetour = json_decode($product->preserve);
$ingredient = json_decode($product->ingredient);
//  dd(json_decode($product->content));
@endphp
{{url(''.$img[0])}}
@endsection
@section('schema')
<script type="application/ld+json">
{!! json_encode([
   '@context' => 'https://schema.org',
   '@type' => 'TouristTrip',
   'name' => languageName($product->name),
   'description' => strip_tags(languageName($product->description)),
   'image' => [url('' . $img[0])],
   'url' => url()->current(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
   '@context' => 'https://schema.org',
   '@type' => 'BreadcrumbList',
   'itemListElement' => [
      [
         '@type' => 'ListItem',
         'position' => 1,
         'name' => 'Home',
         'item' => url('/'),
      ],
      [
         '@type' => 'ListItem',
         'position' => 2,
         'name' => 'Tour',
         'item' => url('/'),
      ],
      [
         '@type' => 'ListItem',
         'position' => 3,
         'name' => languageName($product->name),
         'item' => url()->current(),
      ],
   ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endsection
@section('css')
@endsection
@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var nav = document.querySelector('.navbar-one');
    if (!nav) return;
    var links = Array.prototype.slice.call(nav.querySelectorAll('a[href^="#"]'));
    var sections = links
        .map(function (a) { var el = document.querySelector(a.getAttribute('href')); return el ? { id: a.getAttribute('href'), el: el } : null; })
        .filter(Boolean);

    function setActive(href) {
        links.forEach(function (a) {
            if (a.getAttribute('href') === href) {
                a.classList.add('active');
            } else {
                a.classList.remove('active');
            }
        });
    }

    // Click smooth scroll + active state
    links.forEach(function (a) {
        a.addEventListener('click', function (e) {
            var targetId = a.getAttribute('href');
            var target = document.querySelector(targetId);
            if (!target) return;
            e.preventDefault();
            var top = target.getBoundingClientRect().top + window.pageYOffset - 100; // offset for sticky header
            window.scrollTo({ top: top, behavior: 'smooth' });
            setActive(targetId);
        });
    });

    // Observe sections for active on scroll
    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    setActive('#' + entry.target.id);
                }
            });
        }, { root: null, rootMargin: '-40% 0px -50% 0px', threshold: [0, 0.2, 0.5, 1] });

        sections.forEach(function (s) { observer.observe(s.el); });
    } else {
        // Fallback: throttle scroll
        var onScroll = function () {
            var scrollPos = window.pageYOffset + 120;
            var current = sections[0] ? sections[0].id : null;
            sections.forEach(function (s) {
                var top = s.el.offsetTop;
                if (scrollPos >= top) current = '#' + s.el.id;
            });
            if (current) setActive(current);
        };
        document.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    // Initialize TouchSpin for quantity inputs (adults/children)
    try {
        if (window.jQuery && typeof jQuery.fn.TouchSpin === 'function') {
            jQuery('input[name="nguoilon"]').TouchSpin({
                min: 1,
                max: 100,
                step: 1,
                initval: 1,
                verticalbuttons: false,
                buttondown_class: 'btn btn-sm btn-outline-secondary',
                buttonup_class: 'btn btn-sm btn-outline-secondary',
                buttondown_txt: '-',
                buttonup_txt: '+',
            });
            jQuery('input[name="treem"]').TouchSpin({
                min: 0,
                max: 100,
                step: 1,
                initval: 0,
                verticalbuttons: false,
                buttondown_class: 'btn btn-sm btn-outline-secondary',
                buttonup_class: 'btn btn-sm btn-outline-secondary',
                buttondown_txt: '-',
                buttonup_txt: '+',
            });
        }
    } catch (e) {}
});
</script>
@endsection
@section('content')
<div class="page-content">

   <!-- INNER PAGE BANNER -->
   <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image: url({{$img[0] ?? url('frontend/images/inr-banner.jpg')}});">
       <div class="overlay-main innr-bnr-olay"></div>
       <div class="wt-bnr-inr-entry">
           <div class="banner-title-outer">
               <div class="banner-title-name">
                   <h2 class="wt-title">{{languageName($product->name)}}</h2>
               </div>
               <!-- BREADCRUMB ROW -->                            
               <div>
                   <ul class="wt-breadcrumb breadcrumb-style-2">
                       <li><a href="{{ route('home') }}">Home</a></li>
                       <li>{{languageName($product->name)}}</li>
                   </ul>
               </div>
           </div>
           <!-- BREADCRUMB ROW END -->                        
       </div>
       <div class="trv-inr-bnr-cloud">            
           <div class="marquee">
               <img src="/frontend/images/inr-banner-cloud.png" alt="Image">
           </div>
       </div>
       <div class="trv-inr-bnr-plane">
           <div class="trv-inr-bnr-plane-bx"><img src="/frontend/images/airplane.png" alt="Image"></div>
           
       </div>
   </div>
   <!-- INNER PAGE BANNER END -->

   <!-- SECTION START -->
   <div class="section-full  p-t120 p-b90">
       <div class="container">
       
           <!-- SECTION START -->
           <div class="section-content">
               <div class="row d-flex justify-content-center">

                   <div class="col-xl-8 col-lg-8 col-md-12 m-b30">
                       <div class="trv-detail-main-wrap">
                           
                           <!--Info Start-->
                           <div class="trv-detail-bx-wrap">

                               <div class="trv-inr-para2">
                                   <h1 class="trv-inner-title-lg">{{languageName($product->name)}}</h1>
                                   

                                 <div class="section-full trv-gallery-wrap">
                                    <div class="section-content">
                        
                                       <div class="trv-gallery-section row">
                   
                                           <!-- COLUMNS 1 -->
                                           <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
                                               @php $__g = is_array($img) ? $img : (array) $img; @endphp
                                               @if(isset($__g[0]))
                                               <div class="trv-gallery-st1 l-pic">
                                                   <div class="trv-gallery-st1-media">
                                                       <img src="{{ $__g[0] }}" alt="{{ languageName($product->name) }}">
                                                       <a class="elem trv-gallery-st1-btn" href="{{ $__g[0] }}" title="{{ languageName($product->name) }}" data-lcl-txt="" data-lcl-author="" data-lcl-thumb="{{ $__g[0] }}" data-lcl-group="product-gallery"><i class="bi bi-arrows-fullscreen"></i>    
                                                       </a>
                                                   </div>
                                               </div> 
                                               @endif
                                               @if(isset($__g[1]))
                                               <div class="trv-gallery-st1 l-pic">
                                                   <div class="trv-gallery-st1-media">
                                                       <img src="{{ $__g[1] }}" alt="{{ languageName($product->name) }}">
                                                       <a class="elem trv-gallery-st1-btn" href="{{ $__g[1] }}" title="{{ languageName($product->name) }}" data-lcl-txt="" data-lcl-author="" data-lcl-thumb="{{ $__g[1] }}" data-lcl-group="product-gallery"><i class="bi bi-arrows-fullscreen"></i>    
                                                       </a>
                                                   </div>
                                               </div>  
                                               @endif                    
                                           </div>
                   
                                           <!-- COLUMNS 2 -->
                                           <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6  col-6">
                                               @if(isset($__g[2]))
                                               <div class="trv-gallery-st1 p-pic">
                                                   <div class="trv-gallery-st1-media">
                                                       <img src="{{ $__g[2] }}" alt="{{ languageName($product->name) }}">
                                                       <a class="elem trv-gallery-st1-btn" href="{{ $__g[2] }}" title="{{ languageName($product->name) }}" data-lcl-txt="" data-lcl-author="" data-lcl-thumb="{{ $__g[2] }}" data-lcl-group="product-gallery"><i class="bi bi-arrows-fullscreen"></i>    
                                                       </a>
                                                   </div>
                                               </div> 
                                               @endif
                                           </div>
                   
                                            <!-- COLUMNS 3 -->
                                            <div class="col-xl-4 col-lg-4 col-md-4">
                                                @if(isset($__g[3]))
                                                <div class="trv-gallery-st1 p-pic">
                                                   <div class="trv-gallery-st1-media">
                                                       <img src="{{ $__g[3] }}" alt="{{ languageName($product->name) }}">
                                                       <a class="elem trv-gallery-st1-btn" href="{{ $__g[3] }}" title="{{ languageName($product->name) }}" data-lcl-txt="" data-lcl-author="" data-lcl-thumb="{{ $__g[3] }}" data-lcl-group="product-gallery"><i class="bi bi-arrows-fullscreen"></i>    
                                                       </a>
                                                   </div>
                                               </div> 
                                                @endif
                                            </div>
                                          
                                           
                                            @if(count($__g) > 4)
                                           <div class="col-12 text-center m-b20">
                                                <a href="{{ $__g[4] }}" class="elem butn-bg-shape" data-lcl-txt="" data-lcl-author="" data-lcl-thumb="{{ $__g[4] }}" data-lcl-group="product-gallery" style="text-decoration: underline; color: #85d200; font-weight: 700; font-style: italic;">View more images</a>
                                               <div style="display:none">
                                                    @foreach (array_slice($__g, 8) as $__extra)
                                                       <a class="elem" href="{{ $__extra }}" data-lcl-thumb="{{ $__extra }}" data-lcl-group="product-gallery" title="{{ languageName($product->name) }}"></a>
                                                   @endforeach
                                               </div>
                                           </div>
                                           @endif
                                               
                                       </div>
                                       
                                           
                                   </div> 
                                </div>

                                   <!-- Navigation -->
                                   <nav class="navbar-one">
                                       <a href="#overview">Overview</a>
                                       <a href="#itinerary">Day Wise Itinerary</a>
                                       <a href="#TermCondition">Terms & Condition</a>
                                   </nav>

                                   <!-- Over View-->
                                   <section id="overview" class="content">
                                    <div class="trv-tour-single-r-info">
                                       <div class="trv-main-rg-hol">
                                           <div class="trv-man-sec-hol">
                                               <ul>
                                                   <li>
                                                       <span class="trv-tmi-hlo"><i class="bi bi-clock"></i> Duration : </span>
                                                       <span class="ng-binding"> {{($product->duration)}} </span>
                                                   </li>
                                                   <li>
                                                       <span  class="trv-tmi-hlo"><i class="bi bi-geo-alt"></i> Places to Visit :</span>
                                                       <span class="trv-tmi-hlo-info">
                                                            @if (!empty($ingredient) && is_array($ingredient))
                                                                @foreach ($ingredient as $key => $item)
                                                                    {{ languageName(json_encode($item->title)) }}@if($key < count($ingredient) - 1) | @endif
                                                                @endforeach
                                                            @endif
                                                       </span>
                                                   </li>
                                               </ul>
                                           </div>
                                           
                                       </div>
                                   </div>
                                   <div class="content">
                                    {!! languageName($product->content) !!}
                                   </div>
                                       

                                   </section>

                                   <!-- Day Wise Itinerary-->
                                   <section id="itinerary">

                                       <h3 class="trv-inner-title-sm">Day Wise Itinerary</h3>
                                   
                                       <div class="trv-clist-st-3-wrap">
                                           <ul class="trv-list-st-3">
                                               @foreach ($ingredient as $key => $item)
                                               <li>
                                                <div class="trv-list-content">
                                                    <div class="duration">
                                                        <span class="day">DAY</span>
                                                        <div class="media">
                                                            <div class="green-bg">{{$key + 1}}</div>
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="info">
                                                        <h4 class="trv-title">{{languageName(json_encode($item->title))}}</h4>
                                                        {{languageName(json_encode($item->content))}}
                                                    </div>
                                                </div>
                                            </li>
                                               @endforeach
                                               

                                           </ul>
                                       </div>

                                   </section>

                                  

                                   <section id="TermCondition">
                                     
                                        <h4 class="trv-inner-title-sm">Term & Condition</h4>
                                        @if($terms)
                                       <div class="trv-de-list-st1">
                                           {!! ($terms->content) ? ($terms->content) : '' !!}
                                       </div>
                                       @endif
                                   </section>

                               </div>

                           </div>
                       </div> 
                   </div> 

                   <!-- SIDE BAR START -->
                   <div class="col-xl-4 col-lg-4 col-md-12 rightSidebar  m-b30">
                   
                       <aside  class="side-bar">
                        <div class="trv-tour-single-r-detail">
                           <span class="trv-star-from">Price</span>
                           <span class="trv-star-amount">
                               Contact Us
                           </span>
                       </div>
                        <div class="twm-post-com-wrap">
                           <div class="clear" id="comment-list">
                               <div class="comments-area" id="comments">
                                  <div>
                                       
                                       <!-- LEAVE A REPLY START -->
                                       <div class="comment-respond trv-form" id="respond">
           
                                           <!-- TITLE START-->
                                           <div class="section-head trv-head-title-wrap left-position">
                                               <h2 class="trv-head-title"><span class="site-text-yellow">Booking</span> This Tour</h2>
                                               <div class="trv-head-discription">You can book this tour by filling the form below</div>
                                           </div>
                                           <!-- TITLE END-->
           
                                           <form class="trv-cons-contact-form" method="post" action="{{route('postBookTour')}}">
                                            @csrf
                                            <input type="text" hidden name="tour_id" value="{{$product->id}}">
                                            <input type="text" hidden name="service_id" value="{{isset($servicereqest) ? json_encode($servicereqest) : ''}}">
                                           
                                            <input type="text" hidden name="total" value="0">
                                               <div class="form-group">
                                                   <input class="form-control" type="text" placeholder="Enter Your Name" name="name" required>
                                               </div>
                                               <div class="form-group">
                                                   <input class="form-control" type="text" placeholder="Enter Email Address" name="email">
                                               </div>
                                               <div class="form-group">
                                                   <input class="form-control" type="text" placeholder="Enter Phone Number" name="phone" required>
                                               </div>
                                               <div class="form-group">
                                                   <div class="row g-2">
                                                       <div class="col-6">
                                                           <label class="form-label small m-b5">Adults</label>
                                                           <input class="form-control form-control-sm" type="text" name="nguoilon" value="1">
                                                       </div>
                                                       <div class="col-6">
                                                           <label class="form-label small m-b5">Children</label>
                                                           <input class="form-control form-control-sm" type="text" name="treem" value="0">
                                                       </div>
                                                   </div>
                                               </div>
                                               
                                               <div class="form-group">
                                                   <textarea  class="form-control" placeholder="Message" name="note"></textarea>
                                               </div>
                                               <button type="submit" class="site-button butn-bg-shape">Booking</button>
                                           </form>
                                           
           
                                       </div>
                                       <!-- LEAVE A REPLY END -->
                                   </div>
                               </div>
                           </div>
                       </div>

                   </div>
           </div>                
       </div>   

                          

                       </aside>

                   </div>
                   <!-- SIDE BAR END -->
               
               </div>

           </div>
           
       </div>
       
   </div>   
   <!-- SECTION END --> 
   <div class="section-full p-t40 p-b0 trv-we-recommend">
      <div class="container-fluid">
          <!-- TITLE START-->
          <div class="section-head trv-head-title-wrap center-position">
              <h2 class="trv-head-title">You May Interested With</h2>
              <div class="trv-head-title-image">
                  <img src="/frontend/images/Title-Separator.png" alt="Image">
              </div>
          </div>
          <!-- TITLE END-->

          <div class="section-content">

              <div class="swiper trv-popular-tours-row trv-tours-st1-carousal swiper-nav-center-bottom">
                  <div class="swiper-wrapper">
                      @foreach ($productlq as $item)
                          <div class="swiper-slide">
                              @include('layouts.product.item', ['pro' => $item])
                          </div>
                      @endforeach
                  </div>
                  <div class="swiper-button-next"></div>
                  <div class="swiper-button-prev"></div>
              </div>

          </div>

      </div>

  </div>




</div>
@endsection
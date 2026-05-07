@extends('layouts.main.master')
@section('title')
Gallery
@endsection
@section('description')
Gallery - Our activities
@endsection
@section('image')
{{url(''.$banner[0]->image)}}
@endsection
@section('js')
@endsection
@section('css')
@endsection
@section('content')
<div class="page-content">

   <!-- INNER PAGE BANNER -->
   <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image: url({{$setting->facebook ?? url('frontend/images/inr-banner.jpg')}});">
       <div class="overlay-main innr-bnr-olay"></div>
       <div class="wt-bnr-inr-entry">
           <div class="banner-title-outer">
               <div class="banner-title-name">
                   <h2 class="wt-title">Gallery</h2>
               </div>
               <!-- BREADCRUMB ROW -->                            
               <div>
                   <ul class="wt-breadcrumb breadcrumb-style-2">
                       <li><a href="{{route('home')}}">Home</a></li>
                       <li>Gallery</li>
                   </ul>
               </div>
           </div>
           <!-- BREADCRUMB ROW END -->                        
       </div>
   </div>
   <!-- INNER PAGE BANNER END -->

   <!--GALLERY SECTION START-->
   <div class="section-full trv-gallery-wrap p-t60 p-b40">
       <div class="container">

           <!-- TITLE START-->
               <div class="section-head trv-head-title-wrap center-position">
                   <h2 class="trv-head-title"><span class="site-text-yellow">Best Memorable</span> Gallery!</h2>
                   <div class="trv-head-discription">Destinations worth exploring! Here are a few popular spots</div>
                   <div class="trv-head-title-image">
                       <img src="{{url('frontend/images/Title-Separator.png')}}" alt="Image">
                   </div>
               </div>
           <!-- TITLE END-->

           <div class="section-content">

               <div class="trv-gallery-section row">

                   @foreach($list as $item)
                   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
                       <div class="trv-gallery-st1 l-pic">
                           <div class="trv-gallery-st1-media">
                               <img src="{{ url($item->image) }}" alt="{{ $item->name }}">
                               <p style="margin-bottom: 0;color: #fff;">{{ $item->name }}</p>
                               <a class="elem trv-gallery-st1-btn" href="{{ url($item->image) }}" title="{{ $item->name }}" data-lcl-txt="" data-lcl-author="" data-lcl-thumb="{{ url($item->image) }}"><i class="bi bi-arrows-fullscreen"></i>    
                               </a>
                           </div>
                       </div> 
                   </div>
                   @endforeach
                   
               </div>

                   
           </div> 

       </div>
   </div>
   <!--GALLERY TOUR SECTION END-->


</div>
@endsection


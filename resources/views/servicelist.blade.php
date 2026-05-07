@extends('layouts.main.master')
@section('title')
{{languageName($cateService->name)}}
@endsection
@section('description')
{{$cateService->description}}
@endsection
@section('image')
{{url('frontend/images/12.jpg')}}
@endsection
@section('schema')
<script type="application/ld+json">
{!! json_encode([
   '@context' => 'https://schema.org',
   '@type' => 'CollectionPage',
   'name' => languageName($cateService->name),
   'url' => url()->current(),
   'description' => $cateService->description,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endsection
@section('css')
@endsection
@section('js')
@endsection
@section('content')
<div class="page-content">

   <!-- INNER PAGE BANNER -->
   <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image: url({{$bannerPage ?? url('frontend/images/inr-banner.jpg')}});">
       <div class="overlay-main innr-bnr-olay"></div>
       <div class="wt-bnr-inr-entry">
           <div class="banner-title-outer">
               <div class="banner-title-name">
                   <h2 class="wt-title">{{languageName($cateService->name)}}</h2>
               </div>
               <!-- BREADCRUMB ROW -->                            
               <div>
                   <ul class="wt-breadcrumb breadcrumb-style-2">
                       <li><a href="{{route('home')}}">{{getLanguage('welcome')}}</a></li>
                       <li><a href="">{{getLanguage('service')}}</a></li>
                       <li>{{languageName($cateService->name)}}</li>
                   </ul>
               </div>
           </div>
           <!-- BREADCRUMB ROW END -->                        
       </div>
   </div>
   <!-- INNER PAGE BANNER END -->
   
   <div class="trv-service-st1">

      <div class="trv-service-back-bg">
          <div class="row d-flex justify-content-center">
            @if (count($list) > 0)
            @foreach ($list as $item)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
               <div class="trv-service-bx1">
                   <div class="trv-media">
                     <a href="{{route('serviceDetail',['danhmuc'=>$item->cate_slug,'slug'=>$item->slug])}}">
                       <img src="{{$item->image}}" alt="image">
                     </a>
                   </div>
                   <div class="trv-info">
                       <h4 class="trv-title"><a href="{{route('serviceDetail',['danhmuc'=>$item->cate_slug,'slug'=>$item->slug])}}">{{languageName($item->name)}}</a></h4>
                   </div>
               </div>
           </div>
            @endforeach
            @else
            <h5>{{getLanguage('content_updating')}}</h5>
            @endif
          </div>
      </div>
  </div>
 
 
 </div>


@endsection
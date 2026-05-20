@extends('layouts.main.master')
@section('title')
{{$title_page}} 
@endsection
@section('description')
New update
@endsection
@section('image')
{{url(''.$banner[0]->image)}}
@endsection
@section('schema')
<script type="application/ld+json">
{!! json_encode([
   '@context' => 'https://schema.org',
   '@type' => 'CollectionPage',
   'name' => $title_page,
   'url' => url()->current(),
   'description' => 'new update',
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endsection
@section('css')
@endsection
@section('content')
<div class="page-content">

  <!-- INNER PAGE BANNER -->
  <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image: url({{$bannerPage ?? url('frontend/images/inr-banner.jpg')}});">
      <div class="overlay-main innr-bnr-olay"></div>
      <div class="wt-bnr-inr-entry">
          <div class="banner-title-outer">
              <div class="banner-title-name">
                  <h2 class="wt-title">{{$title_page}}</h2>
              </div>
              <!-- BREADCRUMB ROW -->                            
              <div>
                  <ul class="wt-breadcrumb breadcrumb-style-2">
                      <li><a href="{{route('home')}}">{{getLanguage('home')}}</a></li>
                      <li><a href="{{route('allListBlog')}}">{{getLanguage('blog')}}</a></li>
                      <li>{{$title_page}}</li>
                  </ul>
              </div>
          </div>
          <!-- BREADCRUMB ROW END -->                        
      </div>
  </div>
  <!-- INNER PAGE BANNER END -->
  
  <!-- SECTION START -->
  <div class="section-full  p-t40 p-b40">
      <div class="container">
      
          <!-- BLOG SECTION START -->
          <div class="section-content">
              <div class="row d-flex justify-content-center">
              
                  <div class="col-xl-8 col-lg-8 col-md-12 m-b30">
                      <div class="row">
                        @foreach ($blog as $item)
                        <div class="col-lg-6 col-md-6 col-sm-6">
                          <div class="trv-blog-st3">
                              <div class="trv-post-media">
                                  <a href="{{route('detailBlog',['slug'=>$item->slug])}}"><img src="{{$item->image}}" alt="Image"></a>
                              </div>
                              
                              <div class="post-date"><span>{{date_format($item->created_at,'d')}}</span>{{date_format($item->created_at,'M')}}</div>                                        
                              <div class="trv-post-info">
                                  <div class="post-category">by Epic Travel</div>
                                  <div class="trv-post-title ">
                                      <h3 class="post-title"><a href="{{route('detailBlog',['slug'=>$item->slug])}}">{{languageName($item->title)}}</a></h3>
                                  </div>
                              </div>                                
                          </div>
                      </div>
                        @endforeach
                          


                      </div>
                        {{$blog->links()}}
                  </div> 
                  
                  <!-- SIDE BAR START -->
                  <div class="col-xl-4 col-lg-4 col-md-12 rightSidebar  m-b30">
                  
                      <aside  class="side-bar">
                          <!-- RECENT POSTS -->
                          <div class="widget trv-recent-posts">
                              <div class="m-b20">
                                  <h4 class="widget-title">{{getLanguage('latest_news')}}</h4>
                              </div>
                              <div class="trv-recent-posts-bx">
                                @foreach ($blognew as $item)
                                <div class="trv-rc-po-st1">
                                  <div class="post-date"><span>{{date_format($item->created_at,'d')}}</span>{{date_format($item->created_at,'M')}}</div>                                        
                                  <div class="trv-post-info">
                                      <div class="trv-post-title ">
                                          <h5 class="post-title"><a href="{{route('detailBlog',['slug'=>$item->slug])}}">{{languageName($item->title)}}</a></h5>
                                      </div>
                                  </div>                                
                              </div>
                                @endforeach
                              </div>
                              
                          </div>

                          <!-- Top Destinations -->   
                          <div class="widget widget_services">
                              <div class="m-b20">
                                  <h4 class="widget-title">{{getLanguage('popular_destination')}}</h4>
                              </div>
                              <ul>
                                @foreach ($categoryhome as $item)
                                <li><a href="{{route('listCateBlog',['slug'=>$item->slug])}}">{{languageName($item->name)}}</a><span class="badge">( {{count($item->product)}} Listing )</span></li>
                                @endforeach
                              </ul>
                          </div>  

                          <!-- GALLERY -->
                          <div class="widget widget_gallery">
                              <div class="m-b20">
                                  <h4 class="widget-title">{{getLanguage('gallery')}}</h4>
                              </div>
                              <div class="tw-sidebar-gallery">
                                  <ul>
                                    @foreach ($gallery as $item)
                                      <li>
                                          <div class="tw-service-gallery-thumb">
                                              <a class="elem" href="{{url($item->image)}}" title="Title 1" data-lcl-author="" data-lcl-thumb="{{url($item->image)}}">
                                                  <img src="{{url($item->image)}}" alt="">
                                                  <i class="fa fa-file-image"></i>     
                                              </a>
                                          </div>
                                      </li>
                                      @endforeach
                                      
                                  </ul>
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


</div>






@endsection
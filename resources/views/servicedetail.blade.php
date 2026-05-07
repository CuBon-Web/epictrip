@extends('layouts.main.master')
@section('title')
{{languageName($detail_service->name)}}
@endsection
@section('description')
{{($detail_service->description)}}
@endsection
@section('image')
{{url(''.$detail_service->image)}}
@endsection
@section('schema')
<script type="application/ld+json">
{!! json_encode([
   '@context' => 'https://schema.org',
   '@type' => 'Service',
   'headline' => languageName($detail_service->name),
   'description' => strip_tags(languageName($detail_service->description)),
   'image' => [url('' . $detail_service->image)],
   'datePublished' => optional($detail_service->created_at)->toIso8601String(),
   'dateModified' => optional($detail_service->updated_at)->toIso8601String(),
   'mainEntityOfPage' => url()->current(),
   'author' => [
      '@type' => 'Organization',
      'name' => config('app.name'),
   ],
   'publisher' => [
      '@type' => 'Organization',
      'name' => config('app.name'),
      'logo' => [
         '@type' => 'ImageObject',
         'url' => url('' . $setting->logo),
      ],
   ],
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
	<div class="wt-bnr-inr overlay-wraper bg-center" style="background-image: url({{$detail_service->image ?? url('frontend/images/inr-banner.jpg')}});">
		<div class="overlay-main innr-bnr-olay"></div>
		<div class="wt-bnr-inr-entry">
			<div class="banner-title-outer">
				<div class="banner-title-name">
					<h2 class="wt-title"> {{languageName($detail_service->name)}}</h2>
				</div>
				<!-- BREADCRUMB ROW -->                            
				<div>
					<ul class="wt-breadcrumb breadcrumb-style-2">
						<li><a href="{{route('home')}}">{{getLanguage('welcome')}}</a></li>
						<li><a href="{{route('serviceList',['slug'=>$detail_service->cate_slug])}}">{{getLanguage('service')}}</a></li>
						<li>{{languageName($detail_service->name)}}</li>
					</ul>
				</div>
			</div>
			<!-- BREADCRUMB ROW END -->                        
		</div>
	</div>
	<!-- INNER PAGE BANNER END -->
  
	<!-- SECTION START -->
	<div class="section-full  p-t120 p-b90">
		<div class="container">
		
			<!-- BLOG SECTION START -->
			<div class="section-content">
				<div class="row d-flex justify-content-center">
				
					<div class="col-xl-8 col-lg-8 col-md-12 m-b30">
						<div class="trv-detail-main-wrap">
							<!--Top Image-->
							<div class="trv-detail-media">
								<img src="{{$detail_service->image}}" alt="image">
							</div>
							<!--Info Image-->
							<div class="trv-detail-bx-wrap">
								<h1 class="trv-inner-title-lg">{{languageName($detail_service->name)}}</h1>
								<div class="trv-inr-para content">
								  {!!languageName($detail_service->content)!!}
								</div>
  
  
  
							</div>
						</div> 
					</div> 
					
					<!-- SIDE BAR START -->
					<div class="col-xl-4 col-lg-4 col-md-12 rightSidebar  m-b30">
					
						<aside  class="side-bar">
							<div class="twm-post-com-wrap p-b30">
								<div class="clear" id="comment-list">
									<div class="comments-area" id="comments">
									   <div>
											
											<!-- LEAVE A REPLY START -->
											<div class="comment-respond trv-form" id="respond">
				
												<!-- TITLE START-->
												<div class="section-head trv-head-title-wrap left-position">
													<h2 class="trv-head-title"><span class="site-text-yellow">Book Service</span> </h2>
													<div class="trv-head-discription">You can book this service by filling the form below</div>
												</div>
												<!-- TITLE END-->
				
												<form class="trv-cons-contact-form" method="post" action="{{ route('postBookService') }}">
												 @csrf
												 <input type="hidden" name="service_id" value="{{ $detail_service->id }}">
												 <input type="hidden" name="total" value="0">
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
														<textarea  class="form-control" placeholder="Enter Your Note" name="note"></textarea>
													</div>
													<button type="submit" class="site-button butn-bg-shape">Book Service</button>
												</form>
												
				
											</div>
											<!-- LEAVE A REPLY END -->
										</div>
									</div>
								</div>
							</div>
  
							<!-- RECENT POSTS -->
							<div class="widget trv-recent-posts">
								<div class="m-b20">
									<h4 class="widget-title">Related Service</h4>
								</div>
								<div class="trv-recent-posts-bx">
								  @foreach ($servicelq as $item)
									<div class="trv-rc-po-st1">
										<div class="post-date"><span>{{date_format($item->created_at,'d')}}</span>{{date_format($item->created_at,'M')}}</div>                                        
										<div class="trv-post-info">
											{{-- <div class="post-category">by Epic Travel</div> --}}
											<div class="trv-post-title ">
												<h5 class="post-title"><a href="{{route('serviceDetail',['danhmuc'=>$item->cate_slug,'slug'=>$item->slug])}}">{{languageName($item->name)}}</a></h5>
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
							
  
							
  
						</aside>
  
					</div>
					<!-- SIDE BAR END -->                          
												
				</div>
  
			</div>
			
		</div>
		
	</div> 
  </div>  
@endsection
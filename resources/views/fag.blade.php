@extends('layouts.main.master')
@section('title')
FAG | {{$setting->company}}
@endsection
@section('description')
FAG | {{$setting->webname}}
@endsection
@section('css')
@endsection
@section('js')
@endsection
@section('content')
<div class="page-content">

  <!-- INNER PAGE BANNER -->
  <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image: url({{$setting->logo_mobi ?? url('frontend/images/inr-banner.jpg')}});">
      <div class="overlay-main innr-bnr-olay"></div>
      <div class="wt-bnr-inr-entry">
          <div class="banner-title-outer">
              <div class="banner-title-name">
                  <h2 class="wt-title">{{getLanguage('faq')}}</h2>
              </div>
              <!-- BREADCRUMB ROW -->                            
              <div>
                  <ul class="wt-breadcrumb breadcrumb-style-2">
                      <li><a href="{{route('home')}}">{{getLanguage('home')}}</a></li>
                      <li>{{getLanguage('faq')}}</li>
                  </ul>
              </div>
          </div>
          <!-- BREADCRUMB ROW END -->                        
      </div>
  </div>
  <!-- INNER PAGE BANNER END -->

  <!--FAQ SECTION START-->
  <div class="section-full trv-faq-warp p-t120 p-b90">
      <div class="container">
          <div class="row">
              @php
                  $faqDetails = collect();
                  foreach (json_decode($setting->footer_content) ?? [] as $item) {
                      foreach ($item->fag_detail ?? [] as $faqItem) {
                          $faqDetails->push($faqItem);
                      }
                  }
                  $faqColumns = $faqDetails->chunk((int) ceil(max($faqDetails->count(), 1) / 2));
              @endphp
              @foreach ($faqColumns as $colIndex => $faqs)
                  <div class="col-lg-6 col-md-12">
                      <div class="trv-faq-right-section m-b30">
                          <!-- Accordian -->
                          <div class="wt-accordion" id="accordion-two-{{$colIndex}}">
                              @foreach ($faqs as $key => $i)
                                  @php
                                      $globalIndex = ($colIndex * $faqColumns->first()->count()) + $key;
                                  @endphp
                                  <div class="panel wt-panel">
                                      <div class="acod-head" id="heading{{$globalIndex}}">
                                          <h4 class="acod-title">
                                              <a class="collapsed" data-bs-toggle="collapse" href="#collapse{{$globalIndex}}" aria-expanded="{{($key == 0) ? 'true' : 'false'}}" aria-controls="collapse{{$globalIndex}}">
                                                {{$i->name}}
                                                  <span class="indicator"><i class="bi bi-chevron-{{($key == 0) ? 'down' : 'right'}}"></i></span>
                                              </a>
                                          </h4>
                                      </div>
                                      <div id="collapse{{$globalIndex}}" class="collapse {{($key == 0) ? 'show' : ''}}" aria-labelledby="heading{{$globalIndex}}" data-bs-parent="#accordion-two-{{$colIndex}}">
                                          <div class="acod-content p-tb15">
                                              {!!$i->content!!}
                                          </div>
                                      </div>
                                  </div>
                              @endforeach
                          </div>
                      </div>
                  </div>
              @endforeach
          </div>
      </div>
  </div>
  <!--FAQ SECTION END-->


</div>
@endsection
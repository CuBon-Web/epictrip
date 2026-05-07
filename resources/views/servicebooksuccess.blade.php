<!DOCTYPE html>
<html lang="vi">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{ $setting->favicon ?? '' }}" type="image/x-icon">
	<link rel="shortcut icon" type="image/x-icon" href="{{ $setting->favicon ?? '' }}">
	<title>Đặt dịch vụ thành công</title>
	<link rel="stylesheet" href="/frontend/css/bootstrap.min.css">
	<link rel="stylesheet" href="/frontend/css/style.css">
</head>

<body>
<div class="loading-area">
	<div class="loading-box"></div>
	<div class="loading-pic">
		<figure class="loader">
			<div class="dot white"></div>
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
		</figure>
	</div>
</div>
<div class="cursor"></div>
<div class="cursor2"></div>
<div class="page-wraper">
	<div class="page-content">
		<div class="section-full trv-under-main-wrap" style="background-image: url(/frontend/images/aaa.png);">
			<div class="container">
				<div class="trv-under-main-Content">
					<div class="trc-comi-logo">
						<a href="{{ route('home') }}"><img src="{{ $setting->logo ?? '' }}" alt="Logo"></a>
					</div>
					<h4 class="trv-under-mainsm-title">Cảm ơn bạn đã đặt dịch vụ</h4>
					<h2 class="trv-under-mainlg-title">Đặt dịch vụ thành công</h2>
					@if(isset($booking))
						<p class="trv-under-mainpara-text">Mã tham chiếu: <strong>#{{ $booking->id }}</strong>. Chúng tôi sẽ liên hệ với bạn sớm.</p>
					@else
						<p class="trv-under-mainpara-text">Chúng tôi sẽ liên hệ với bạn sớm.</p>
					@endif
					<ul class="social-icons">
						<li><a href="{{ route('home') }}">Về trang chủ</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="/frontend/js/jquery-3.7.1.min.js"></script>
<script src="/frontend/js/popper.min.js"></script>
<script src="/frontend/js/bootstrap.min.js"></script>
<script src="/frontend/js/bootstrap-select.min.js"></script>
<script src="/frontend/js/magnific-popup.min.js"></script>
<script src="/frontend/js/waypoints.min.js"></script>
<script src="/frontend/js/counterup.min.js"></script>
<script src="/frontend/js/isotope.pkgd.min.js"></script>
<script src="/frontend/js/imagesloaded.pkgd.min.js"></script>
<script src="/frontend/js/owl.carousel.min.js"></script>
<script src="/frontend/js/theia-sticky-sidebar.js"></script>
<script src="/frontend/js/jquery.bootstrap-touchspin.js"></script>
<script src="/frontend/js/lc_lightbox.lite.js"></script>
<script src="/frontend/js/bootstrap-slider.min.js"></script>
<script src="/frontend/js/swiper-bundle.min.js"></script>
<script src="/frontend/js/img-parallax.js"></script>
<script src="/frontend/js/gsap.min.js"></script>
<script src="/frontend/js/custom.js"></script>
<script src="/frontend/js/moment.min.js"></script>
<script src="/frontend/js/bootstrap-datetimepicker.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>PORTAL</title>
	    <meta charset="utf-8" />
	    <meta
	      name="description"
	      content="The most advanced IT Environtment kalimantan used. Crafted with laravel framework, Bring automation of data collecting. integrated with same environtment and others."
	    />
	    <meta
	      name="keywords"
	      content="tomman, tomman.app, portal.tomman.app, smpro, wmpro, pmpro, wasaka, mom online, promise, kawan, perwira"
	    />
	    <meta name="viewport" content="width=device-width, initial-scale=1" />
	    <link rel="shortcut icon" href="favicon.ico" />
	    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
	</head>
	<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<style>body { background-image: url('assets/media/auth/bg4.jpg'); } [data-bs-theme="dark"] body { background-image: url('assets/media/auth/bg4-dark.jpg'); }</style>
			<div class="d-flex flex-column flex-column-fluid flex-lg-row">
				<div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
					<div class="d-flex flex-center flex-lg-start flex-column">
					</div>
				</div>
				<div class="d-flex flex-column-fluid flex-row-auto p-20">
					<div class="bg-body d-flex flex-column align-items-stretch rounded-4 h-md-400px p-20">
						<div class="d-flex flex-column flex-column-fluid">
							<form class="form" novalidate="novalidate" id="kt_sign_in_form" method="post" action="/otp">
								<div class="text-center mb-11">
									<h1 class="text-gray-900 fw-bolder mb-3">Kopegtel Sales</h1>
									<h3 class="text-muted mb-3">Enter OTP</h1>
								</div>
								@if(Session::has('send_to'))
						            <div class="alert alert-success alert-dismissible fade show" role="alert">OTP dikirim ke {{ session('send_to') }}. berlaku 1 menit.
						            	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						            </div>
						        @endif
								@if ($errors->any())
								    <div class="alert alert-danger alert-dismissible fade show" role="alert">
								        @foreach ($errors->all() as $error)
								            <li>{{ $error }}</li>
								        @endforeach
								        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								    </div>
								@endif
								<input type="hidden" name="nik" value="{{ session('nik') }}" autocomplete="off" class="form-control bg-transparent" />
								<div class="fv-row mb-5">
									<input type="number" placeholder="Enter Otp" name="otp" autocomplete="off" class="form-control bg-transparent" />
								</div>
								@error('otp')
						            <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ $message }}
						            	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						            </div>
						        @enderror
								<div class="d-grid mb-10">
									<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
										<span class="indicator-label">Submit Login</span>
										<span class="indicator-progress">Please wait... 
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>var hostUrl = "/assets/";</script>
		<script src="/assets/plugins/global/plugins.bundle.js"></script>
		<script src="/assets/js/scripts.bundle.js"></script>
		<script type="text/javascript">
			const form_login = document.querySelector('#kt_sign_in_form');
			  var validator_login = FormValidation.formValidation(form_login,{
			    fields: {
			      'otp': {
			        validators: {
			          notEmpty: {
			            message: 'Isi mang'
			          }
			        }
			      }
			    },
			    plugins: {
			      trigger: new FormValidation.plugins.Trigger(),
			      bootstrap: new FormValidation.plugins.Bootstrap5({
			          rowSelector: '.fv-row',
			          eleInvalidClass: '',
			          eleValidClass: ''
			      })
			    }
			  });
			  var button_submit = document.querySelector("#kt_sign_in_submit");
			  button_submit.addEventListener("click", function(e) {
			    e.preventDefault();
			    if (validator_login) {
			      validator_login.validate().then(function (status) {
			        console.log('validated!');
			        if (status == 'Valid') {
			          button_submit.setAttribute('data-kt-indicator', 'on');
			          button_submit.disabled = true;
			          form_login.submit();
			        }
			      });
			    }
			  });
		</script>
	</body>
</html>
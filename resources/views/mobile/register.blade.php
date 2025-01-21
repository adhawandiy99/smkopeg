<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title>Register</title>
<link rel="stylesheet" type="text/css" href="/mobile/styles/bootstrap.css">
<link rel="stylesheet" type="text/css" href="/mobile/fonts/bootstrap-icons.css">
<link rel="stylesheet" type="text/css" href="/mobile/styles/style.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="manifest" href="/_manifest.json">
<meta id="theme-check" name="theme-color" content="#FFFFFF">
<link rel="apple-touch-icon" sizes="180x180" href="/mobile/app/icons/icon-192x192.png"></head>
<style>
.error { color: red; }
</style>
<body class="theme-light">

<div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>

<!-- Page Wrapper-->
<div id="page">
  <div class="card card-style mt-5">
    <div class="content">
      <form id="form_register" class="form form-horizontal" method="post" novalidate>
        <h1 class="font-30 font-800 mb-0">SMPRO</h1>
        <p>Create an account</p>
        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
          <i class="bi bi-person-circle font-13"></i>
          <label for="nik" class="color-theme form-label-always-active">Nik</label>
          <input name="nik" type="number" class="form-control rounded-xs" id="nik" placeholder="Nik" value="{{ old('nik') }}" autocomplete="off" required>
          <span>(required)</span>
        </div>
        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
          <i class="bi bi-person-circle font-13"></i>
          <input name="nama" type="text" class="form-control rounded-xs" id="nama" placeholder="Nama" value="{{ old('nama') }}" autocomplete="off" required>
          <label for="nama" class="color-theme form-label-always-active">Nama</label>
          <span>(required)</span>
        </div>
        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
          <i class="bi bi-person-circle font-13"></i>
          <input name="instansi" type="text" class="form-control rounded-xs" id="instansi" placeholder="Instansi" value="{{ old('instansi') }}" autocomplete="off" required>
          <label for="instansi" class="color-theme form-label-always-active">Instansi</label>
          <span>(required)</span>
        </div>
        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
          <i class="bi bi-bank font-13"></i>
          <select name="witel[]"  class="form-select rounded-xs" id="witel" required>
            <option disabled="true">Select Witel</option>
            @foreach($witel as $w)
              <option value="{{ $w->id_witel }}" {{ old('id_witel')==$w->id_witel? 'selected':'' }}>{{ $w->witel_name }}</option>
            @endforeach
          </select>
          <label for="witel" class="color-theme form-label-always-active">Select Witel</label>
        </div>
        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
          <i class="bi bi-asterisk font-13"></i>
          <input name="password" type="text" class="form-control rounded-xs" id="c2" placeholder="Choose Password" value="{{ old('password') }}" autocomplete="off" required>
          <label for="c2" class="color-theme form-label-always-active">Choose Password</label>
          <span>(required)</span>
        </div>
        <div class="form-check form-check-custom">
          <input name="t_c" class="form-check-input" type="checkbox" name="type" value="1" id="c2a" required>
          <label class="form-check-label font-12" for="c2a">I agree with the <a href="#">Terms and Conditions</a>.</label>
          <i class="is-checked color-highlight font-13 bi bi-check-circle-fill"></i>
          <i class="is-unchecked color-highlight font-13 bi bi-circle"></i>
        </div>
        <a id="button_submit" href="#" class="btn btn-full gradient-highlight shadow-bg shadow-bg-s mt-4">Create Account</a>
        <div class="row">
          <div class="col-6 text-start">
            <!-- <a href="/forgotpwd" class="font-11 color-theme opacity-40 pt-4 d-block">Forgot Password?</a> -->
          </div>
          <div class="col-6 text-end">
            <a href="/login" class="font-11 color-theme opacity-40 pt-4 d-block">Sign In Account</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  @if(Session::has('alerts'))
    @php
      $type = 0;
      if(session('alerts')['type']=='success'){
        $type = 1;
      }
    @endphp
    <div id="menu-top-detached" class="offcanvas offcanvas-top rounded-m offcanvas-detached alert-auto-activate">
      <div class="d-flex m-3">
        <div class="align-self-center">
          <h2 class="font-700 mb-0">{{ $type?'Berhasil':'Gagal' }}</h2>
        </div>
        <div class="align-self-center ms-auto">
          <a href="#" class="icon icon-xs me-n2" data-bs-dismiss="offcanvas">
              <i class="bi bi-x-circle-fill color-{{ $type?'green':'red' }}-dark font-16"></i>
          </a>
        </div>
      </div>
      <div class="content mt-0">
        <h4 class="pt-0 mb-4">{!! session('alerts')['text'] !!}</h4>
        <a href="#" data-bs-dismiss="offcanvas" class="btn btn-full gradient-{{ $type?'green':'red' }} shadow-bg shadow-bg-xs">Oke!</a>
      </div>
    </div>
  @endif
</div>
<!-- End of Page ID-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="/mobile/scripts/bootstrap.min.js"></script>
<script src="/mobile/scripts/custom.js"></script>
@if(Session::has('alerts'))
  <script type="text/javascript">
    var autoActivates = new bootstrap.Offcanvas(document.getElementsByClassName('alert-auto-activate')[0])
    autoActivates.show();
  </script>
@endif
<script type="text/javascript">
  $("#form_register").validate({
      errorElement: "div",
      errorContainer: $(".invalid-feedback"),
      success: function(label) {
        label.text("ok!").addClass("d-none");
      }
  });
  var button_submit = document.querySelector("#button_submit");
  button_submit.addEventListener("click", function(e) {
    e.preventDefault();
    $("#form_register").submit();
  });
</script>
</body>
@extends('mobile')

@section('css')
<style type="text/css">

  .input-photos img {
    width: 100px;
    height: 150px;
    margin-bottom: 5px;
  }
</style>
@endsection

@section('tittle', 'Home')

@section('content')
<?php
  $witel = $role = '';
?>
<div class="card card-style">

  <div class="content">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
      <form id="form_register" class="form form-horizontal" enctype="multipart/form-data" method="post" novalidate>
        @if($data && isset($data->role_user))
            <input name="role_user" type="hidden" value="{{ $data->role_user }}">
        @else
            <input name="role_user" type="hidden" value="">
        @endif
        @if($data && isset($data->status_user))
            <input name="status_user" type="hidden" value="{{ $data->status_user }}">
        @else
            <input name="status_user" type="hidden" value="">
        @endif
        <h1 class="font-30 font-800 mb-3">Profile</h1>
        <div class="row">
          <div class="col-6">
            <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
              <i class="bi bi-person-circle font-13"></i>
              <label for="nik" class="color-theme form-label-always-active">Nik</label>
              <input name="nik" type="number" class="form-control rounded-xs" id="nik" placeholder="Nik" value="{{ $data->username ?? old('nik') }}" autocomplete="off" required>
              <span>(required)</span>
            </div>
          </div>
          <div class="col-6">
            <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
              <i class="bi bi-person-circle font-13"></i>
              <input name="name" type="text" class="form-control rounded-xs" id="name" placeholder="Nama" value="{{ $data->name ?? old('name') }}" autocomplete="off" required>
              <label for="name" class="color-theme form-label-always-active">Nama</label>
              <span>(required)</span>
            </div>
          </div>
        </div>
        
        
        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
          <i class="bi bi-telephone font-13"></i>
          <input name="phone" type="text" class="form-control rounded-xs" id="phone" placeholder="Phone" value="{{ $data->phone ?? old('Phone') }}" autocomplete="off" required>
          <label for="Phone" class="color-theme form-label-always-active">Phone</label>
          <span>(required)</span>
        </div>
        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
          <i class="bi bi-at font-13"></i>
          <input name="email" type="text" class="form-control rounded-xs" id="email" placeholder="Email" value="{{ $data->email ?? old('email') }}" autocomplete="off" required>
          <label for="email" class="color-theme form-label-always-active">Email</label>
          <span>(required)</span>
        </div>
        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
          <i class="bi bi-telegram font-13"></i>
          <input name="chat_id" type="text" class="form-control rounded-xs" id="chat_id" placeholder="Chat Id" value="{{ $data->chat_id ?? old('chat_id') }}" autocomplete="off" required>
          <label for="chat_id" class="color-theme form-label-always-active">Chat ID Telegram</label>
          <span>(required)</span>
        </div>

        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
          <i class="bi bi-wallet font-13"></i>
          <input name="instansi" type="text" class="form-control rounded-xs" id="instansi" placeholder="Instansi" value="{{ $data->instansi ?? old('instansi') }}" autocomplete="off" required>
          <label for="instansi" class="color-theme form-label-always-active">Instansi</label>
          <span>(required)</span>
        </div>
        <div class="form-custom form-label form-border mb-3 bg-transparent">
          <select name="level"  class="form-select rounded-xs" id="level" required>
            <option value="">Select Role</option>
            @foreach($level as $t)
              @if($t->id_role != '1' || session('auth')->role_user == '1')
                <option value="{{$t->id_role}}" {{ @$data->role_user == $t->id_role ? 'selected' : '' }}>{{$t->role}}</option>
              @endif
            @endforeach
          </select>
          <label for="role" class="color-theme form-label-always-active">Role</label>
          <span>(required)</span>
        </div>
        <div class="form-custom form-label form-border mb-3 bg-transparent">
          <select name="tl"  class="form-select rounded-xs" id="tl" required>
            <option value="">Select TL</option>
            @foreach($tl as $t)
              <option value="{{$t->username}}" {{ @$data->tl == $t->username ? 'selected' : '' }}>{{$t->name}}</option>
            @endforeach
          </select>
          <label for="tl" class="color-theme form-label-always-active">TL</label>
        </div>
        <div class="form-custom form-label form-border mb-3 bg-transparent">
          <select name="spv"  class="form-select rounded-xs" id="spv" required>
            <option value="">Select SPV</option>
            @foreach($spv as $t)
              <option value="{{$t->username}}" {{ @$data->spv == $t->username ? 'selected' : '' }}>{{$t->name}}</option>
            @endforeach
          </select>
          <label for="spv" class="color-theme form-label-always-active">SPV</label>
        </div>
        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
          <i class="bi bi-asterisk font-13"></i>
          <input name="password" type="text" class="form-control rounded-xs" id="c2" placeholder="Choose Password" value="{{ old('password') }}" autocomplete="off">
          <label for="c2" class="color-theme form-label-always-active">Choose Password</label>
          <span>(optional)</span>
        </div>
        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
          <i class="bi bi-telegram font-13"></i>
          <input name="nama_bank" type="text" class="form-control rounded-xs" id="nama_bank" placeholder="Nama Bank" value="{{ $data->nama_bank ?? old('nama_bank') }}" autocomplete="off" required>
          <label for="nama_bank" class="color-theme form-label-always-active">Nama Bank</label>
          <span>(required)</span>
        </div>
        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
          <i class="bi bi-telegram font-13"></i>
          <input name="no_rekening" type="text" class="form-control rounded-xs" id="no_rekening" placeholder="No. Rekening" value="{{ $data->no_rekening ?? old('no_rekening') }}" autocomplete="off" required>
          <label for="no_rekening" class="color-theme form-label-always-active">No. Rekening</label>
          <span>(required)</span>
        </div>
        <div class="row text-center mb-3">
        @foreach($foto as $p)
          <?php

            $path = "/storage/user/".Request::segment(2)."/".$p;
            $th   = $path."-th.jpg";
            $flag = "";
            $name = "flag_evidence";
            if(file_exists(public_path().$th)){
              $img  = $path.".jpg";
              $thumb = $th;
              $class = "0";
            }else{
              $img  = "/images/placeholder.gif";
              $thumb = "/images/placeholder.gif";
              $class = "1";
            }
          ?>
          <div class="col-6 text-center photos mb-3">
            <div class="form-custom input-photos">
              <img id="evidence_{{$p}}" src="{{ $thumb }}" class="rounded-l evidence_show" />
              <p>Photo {{ ucfirst($p) }}</p>
            </div>
            <input type="file" name="{{$p}}" class="upload_file d-none" accept="image/*" required>
            <a href="#" class="btn gradient-blue shadow-bg shadow-bg-s btn-camera"><i class="bi-camera-fill"></i></a>
          </div>
        @endforeach
        
      </div>
        <!-- <div class="form-check form-check-custom">
          <input name="t_c" class="form-check-input" type="checkbox" name="type" value="1" id="c2a" required>
          <label class="form-check-label font-12" for="c2a">I agree with the <a href="#">Terms and Conditions</a>.</label>
          <i class="is-checked color-highlight font-13 bi bi-check-circle-fill"></i>
          <i class="is-unchecked color-highlight font-13 bi bi-circle"></i>
        </div> -->
        <a id="button_submit" href="#" class="btn btn-full gradient-highlight shadow-bg shadow-bg-s mt-4">Save</a>
        <div class="row">
          <div class="col-6 text-start">
            <!-- <a href="/forgotpwd" class="font-11 color-theme opacity-40 pt-4 d-block">Forgot Password?</a> -->
          </div>
          <div class="col-6 text-end">
            <!-- <a href="/login" class="font-11 color-theme opacity-40 pt-4 d-block">Sign In Account</a> -->
          </div>
        </div>
      </form>
  </div>
</div>
@endsection

@section('offcanvas')
@endsection
@section('js')
<script type="text/javascript">
  $(document).ready(function () {
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
    $('.btn-camera').on('click', function (e) {
        e.preventDefault(); // Prevent default action of the link
        $(this).closest('.photos').find('.upload_file').click(); // Trigger the closest file input click
    });
    document.querySelectorAll('input[type=file]').forEach(function(inputEl) {
      inputEl.addEventListener('change', function(e) {
        let file = e.target.files[0]; // Get the selected file
        let idEl = this.name; // Use the input's name as the target ID
        if (this.files && this.files[0]) {
          let reader = new FileReader();
          let wrapper = this.closest('.photos').querySelector('.evidence_show');

          reader.onload = function(event) {
            wrapper.src = event.target.result;
          };
          reader.readAsDataURL(this.files[0]); 
        }
      });
    });
  });
</script>
@endsection
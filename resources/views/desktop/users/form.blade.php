@extends('desktop')
@section('css')

@endsection
@section('tittle', 'Users')
@section('content')
<div class="col-xl">
  @if(session('auth')->id_user == Request::segment(2) || session('auth')->role_user == 1)
	 <div class="card shadow-lg mb-3 mb-xl-10">
      <div class="card-header">
        <div class="card-title m-0">
          <h3 class="fw-bold m-0">Profile Form</h3>
        </div>
      </div>
      <div class="card-body border-top p-9">
        <form id="form" method="post" class="form fv-plugins-bootstrap5 fv-plugins-framework" enctype="multipart/form-data" novalidate="novalidate">
          @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif
          <div class="row mb-3">
            <div class="col-lg-2">
              <div class="fv-row mb-0 fv-plugins-icon-container">
                <label for="nik" class="form-label fs-6 fw-bold mb-1">Nik <i class="text-muted">Username</i></label>
                <input type="text" class="form-control form-control-lg form-control-solid" name="nik" id="nik" value="{{ $data->username ?? old('username') }}" autocomplete="off">
              <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
            </div>
            <div class="col-lg-3">
              <div class="fv-row mb-0 fv-plugins-icon-container">
                <label for="name" class="form-label fs-6 fw-bold mb-1">Name</label>
                <input type="text" class="form-control form-control-lg form-control-solid" name="name" id="name" value="{{ $data->name ?? old('name') }}" autocomplete="off">
              <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
            </div>

            <div class="col-lg-3">
              <div class="fv-row mb-0 fv-plugins-icon-container">
                <label for="phone" class="form-label fs-6 fw-bold mb-1">Phone</label>
                <input type="number" class="form-control form-control-lg form-control-solid" name="phone" id="phone" value="{{ $data->phone ?? old('phone') }}" autocomplete="off">
              <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
            </div>

            <div class="col-lg-4">
              <div class="fv-row mb-0 fv-plugins-icon-container">
                <label for="email" class="form-label fs-6 fw-bold mb-1">Email</label>
                <input type="text" class="form-control form-control-lg form-control-solid" name="email" id="email" value="{{ $data->email ?? old('email') }}" autocomplete="off">
              <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-lg-2">
              <div class="fv-row mb-0 fv-plugins-icon-container">
                <label for="chat_id" class="form-label fs-6 fw-bold mb-1">Chat ID <i class="text-muted">Telegram</i></label>
                <input type="number" class="form-control form-control-lg form-control-solid" name="chat_id" id="chat_id" value="{{ $data->chat_id ?? old('chat_id') }}" autocomplete="off">
              <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
            </div>

            <div class="col-lg-3">
              <div class="fv-row mb-0 fv-plugins-icon-container">
                <label for="instansi" class="form-label fs-6 fw-bold mb-1">Instansi</label>
                <input type="text" class="form-control form-control-lg form-control-solid" name="instansi" id="instansi" value="{{ $data->instansi ?? old('instansi') }}" autocomplete="off">
              <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
            </div>
            <div class="col-lg-3">
              <div class="fv-row mb-0 fv-plugins-icon-container">
                <label for="role_user" class="form-label fs-6 fw-bold mb-1">Role <i class="text-muted">Level</i></label>
                <select name="role_user" class="form-select form-select-solid" data-control="select2" data-placeholder="Select Level" data-allow-clear="true" data-hide-search="true" id="role_user">
                  <option></option>
                  @foreach($level as $t)
                    @if($t->id_role != '1' || session('auth')->role_user == '1')
                      <option value="{{$t->id_role}}" {{ @$data->role_user == $t->id_role ? 'selected' : '' }}>{{$t->role}}</option>
                    @endif
                  @endforeach
                </select>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="fv-row mb-0 fv-plugins-icon-container">
                <label for="password" class="form-label fs-6 fw-bold mb-1">Password</label>
                <input type="text" class="form-control form-control-lg form-control-solid" name="password" id="password" placeholder="Keep empty to save current value" autocomplete="off">
              <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
            </div>
            
          </div>


          <div class="row mb-3">
            <div class="col-lg-3">
              <div class="fv-row mb-0 fv-plugins-icon-container">
                <label for="nama_bank" class="form-label fs-6 fw-bold mb-1">Nama Bank</label>
                <input type="text" class="form-control form-control-lg form-control-solid" name="nama_bank" id="nama_bank" value="{{ $data->nama_bank ?? old('nama_bank') }}" autocomplete="off">
              <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
            </div>
            <div class="col-lg-3">
              <div class="fv-row mb-0 fv-plugins-icon-container">
                <label for="no_rekening" class="form-label fs-6 fw-bold mb-1">No. Rekening</label>
                <input type="text" class="form-control form-control-lg form-control-solid" name="no_rekening" id="no_rekening" value="{{ $data->no_rekening ?? old('no_rekening') }}" autocomplete="off">
              <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
            </div>
            <div class="col-lg-3">
              <div class="fv-row mb-0 fv-plugins-icon-container">
                <label for="tl" class="form-label fs-6 fw-bold mb-1">TL</label>
                <select name="tl" class="form-select form-select-solid" data-control="select2" data-placeholder="Select TL" data-allow-clear="true" data-hide-search="true" id="tl">
                  <option></option>
                  @foreach($tl as $t)
                    <option value="{{$t->username}}" {{ @$data->tl == $t->username ? 'selected' : '' }}>{{$t->name}}</option>
                  @endforeach
                </select>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="fv-row mb-0 fv-plugins-icon-container">
                <label for="spv" class="form-label fs-6 fw-bold mb-1">SPV</label>
                <select name="spv" class="form-select form-select-solid" data-control="select2" data-placeholder="Select SPV" data-allow-clear="true" data-hide-search="true" id="spv">
                  <option></option>
                  @foreach($spv as $t)
                    <option value="{{$t->username}}" {{ @$data->spv == $t->username ? 'selected' : '' }}>{{$t->name}}</option>
                  @endforeach
                </select>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
              </div>
            </div>
            
          </div>
          <div class="col {{ session('auth')->role_user == 1 ? 'd-block':'d-none' }}">
            <div class="fv-row mb-0 fv-plugins-icon-container">
              <label for="status_user" class="form-label fs-6 fw-bold mb-1">Status</label>
              <select id="status_user" name="status_user" class="form-select form-select-solid" data-control="select2" data-placeholder="Select an option" data-minimum-results-for-search="Infinity" data-allow-clear="true">
                <option></option>
                <option value="1" {{ @$data->status_user == 1 ? 'selected' : '' }}>Active</option>
                <option value="2" {{ @$data->status_user == 2 ? 'selected' : '' }}>Suspend</option>
              </select>
              <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
            </div>
          </div>

        </form>
        <div class="col">
        
        <div id="map" style="height: 60%;" class="mb-7"></div>
        <div class="row g-3">
          @foreach($foto as $p)
            <div class="col evidence text-center">

              <?php
                $path = "/storage/user/".Request::segment(2)."/".$p;
                $th   = $path."-th.jpg";
                $flag = "";
                $name = "flag_evidence";
                if(file_exists(public_path().$th)){
                  $style = "background-image:url('$th')";
                  $img  = $path.".jpg";
                  $class = "0";
                }else{
                  $style = "background-image:url('/assets/media/svg/files/blank-image.svg')";
                  $img  = "/assets/media/svg/files/blank-image.svg";
                  $class = "1";
                }
              ?>
              <div class="d-block overlay fv-row" data-fslightbox="lightbox-hot-sales">
                <!-- 
                <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px">
                  <img width="173" height="200" src="/assets/media/stock/900x600/16.jpg" alt="" />
                </div> -->
                <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-275px" style="{{ $style }}"></div>
                <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                  <input type="file" name="{{ $p }}" class="d-none" need_validate="{{ $class }}" id="id_{{$p}}" accept="jpg,jpeg,png">
                  <a href="{{ $img }}" target="_BLANK">
                    <i class="ki-duotone ki-eye fs-3x text-light-primary">
                      <span class="path1"></span>
                      <span class="path2"></span>
                      <span class="path3"></span>
                    </i>
                  </a>
                  <a href="#" class="ms-5 input-photos">
                    <i class="ki-duotone ki-picture fs-2x text-light-primary">
                     <span class="path1"></span>
                     <span class="path2"></span>
                    </i>
                  </a>
                </div>
                <div class="fv-plugins-message-container invalid-feedback"></div>
              </div>

              <span class="required">Photo {{ ucfirst($p) }}</span>
              <div class="fv-plugins-message-container invalid-feedback"></div>
            </div>
          @endforeach
        </div>
      </div>
      </div>

      
      <div class="card-footer d-flex justify-content-end py-6 px-9">
        <button type="button" class="btn btn-primary" id="form_submit">Save Changes</button>
      </div>
    </div>
  @else
   <div class="d-flex flex-column flex-center flex-column-fluid">
      <!--begin::Content-->
      <div class="d-flex flex-column flex-center text-center p-10">
        <!--begin::Wrapper-->
        <div class="card shadow-lg card-flush w-lg-650px py-5">
          <div class="card-body py-15 py-lg-20">
            <!--begin::Title-->
            <h1 class="fw-bolder fs-2hx text-gray-900 mb-4">Oops!</h1>
            <!--end::Title-->
            <!--begin::Text-->
            <div class="fw-semibold fs-6 text-gray-500 mb-7">We can't find that page.</div>
            <!--end::Text-->
            <!--begin::Illustration-->
            <div class="mb-3">
              <img src="/assets/media/auth/404-error.png" class="mw-100 mh-300px theme-light-show" alt="">
              <img src="/assets/media/auth/404-error-dark.png" class="mw-100 mh-300px theme-dark-show" alt="">
            </div>
            <!--end::Illustration-->
            <!--begin::Link-->
            <div class="mb-0">
              <a href="index.html" class="btn btn-sm btn-primary">Return Home</a>
            </div>
            <!--end::Link-->
          </div>
        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Content-->
    </div>
  @endif


</div>
@endsection
@section('modal')
@endsection
@section('js')
<script type="text/javascript">
  $(document).ready(function(){
    var user = <?= json_encode($data); ?>;
    
    const form = $('#form')[0]; // Use jQuery to get the form element
    // Define validator
    var validator = FormValidation.formValidation(form, {
      fields: {
        'name': {
          validators: {
            notEmpty: {
              message: 'Fill Please.'
            }
          }
        },
        'nik': {
          validators: {
            notEmpty: {
              message: 'Fill Please.'
            }
          }
        },
        'status_user': {
          validators: {
            notEmpty: {
              message: 'Fill Please.'
            }
          }
        },
        'role_user': {
          validators: {
            notEmpty: {
              message: 'Fill Please.'
            }
          }
        },
        'instansi': {
          validators: {
            notEmpty: {
              message: 'Fill Please.'
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

    // Add field validators
    const addFields = function(index) {
      validator.addField(index, {
        validators: {
          notEmpty: {
            message: "Fill Please."
          }
        }
      });
    };

    // Remove field validators
    const removeFields = function(index) {
      validator.addField(index);
      validator.removeField(index);
    };
    $("#role_user").change(function(e) {
      var role = $(this).val();
      var validRoles = [3, 4, 5];
      if (validRoles.includes(parseInt(role))) { // Check if role is in the array
        addFields("ktp");
        addFields("selfi");
        addFields("npwp");
        addFields("buku_rekening");
      } else {
        removeField("ktp");
        removeField("selfi");
        removeField("npwp");
        removeField("buku_rekening");
      }
    });

    //button submit
    var form_submit = document.querySelector("#form_submit");
    form_submit.addEventListener("click", function(e) {
      e.preventDefault();
      if (validator) {
        validator.validate().then(function (status) {
          console.log('validated!');
          if (status == 'Valid') {
            form_submit.setAttribute('data-kt-indicator', 'on');
            form_submit.disabled = true;
            form.submit();
          }
        });
      }
    });
    $('.input-photos').on('click', function() {
      $(this).parent().find('input[type=file]').click();
    });
    document.querySelectorAll('input[type=file]').forEach(function(inputEl) {
      inputEl.addEventListener('change', function(e) {
        let file = e.target.files[0]; // Get the selected file
        let idEl = this.name; // Use the input's name as the target ID
        if (this.files && this.files[0]) {
          let reader = new FileReader();
          let wrapper = this.closest('.overlay').querySelector('.overlay-wrapper');

          reader.onload = function(event) {
            wrapper.style.backgroundImage = `url('${event.target.result}')`;
          };
          reader.readAsDataURL(this.files[0]); // Read the file
        }
      });
    });
  });
</script>
@endsection
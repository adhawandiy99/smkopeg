@extends('desktop')
@section('css')

@endsection
@section('tittle', 'Setting')
@section('content')
<div class="row g-5">
	<div class="col-lg-9">
    <div class="card mb-5">
      <div class="card-header">
        <h3 class="card-title">Paket</h3>
        <div class="card-toolbar">
          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_paket" data-bs-paket="new">
            <i class="ki-duotone ki-plus fs-2"></i>
          </button>
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive">
  		    <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="table_paket">
  		      <thead>
  		        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
  		          <th>#</th>
  		          <th>ISP</th>
                <th>Nama Paket</th>
                <th>Expired</th>
                <th>Actions</th>
  		        </tr>
  		      </thead>
  		      <tbody>
  		      	@php
						    $number = 1;
							@endphp
              @foreach($paket as $key => $l)
                <tr>
                  <td>{{ $number++ }}</td>
                  <td>{{ $isp[$l->isp_id]->nama_isp ?? 'not set' }}</td>
                  <td>{{ $l->nama_paket }}</td>
                  <td>{{ $l->expired }}</td>
                  <td class="text-end">
                    <a class="btn btn-icon btn-flex btn-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#modal_paket" data-bs-paket="{{ $key }}">
                      <i class="ki-duotone ki-notepad-edit fs-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit paket">
                        <span class="path1"></span>
                        <span class="path2"></span>
                      </i>
                    </a>
                  </td>
                </tr>
              @endforeach
  		      </tbody>
  		    </table>
  		  </div>
      </div>
    </div>
  </div>

	<div class="col-lg-3">
    <div class="card mb-5">
      <div class="card-header">
        <h3 class="card-title">ISP</h3>
        <div class="card-toolbar">
          <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modal_isp" data-bs-isp="new">
            <i class="ki-duotone ki-plus fs-2"></i>
          </button>
        </div>
      </div>

      <div class="card-body">
        @foreach($isp as $key => $m)
          <a class="btn {{ $m->status?'btn-primary':'btn-light' }} btn-sm me-2 mb-2" data-bs-toggle="modal" data-bs-target="#modal_isp" data-bs-isp="{{ $key }}">{{$m->nama_isp}}</a>
        @endforeach
      </div>
    </div>
  </div>
</div>


<div class="table-responsive">
    <table class="table table-striped table-rounded border border-gray-300 table-row-bordered table-row-gray-300 gy-7 gs-7">
        <thead>
            <tr class="fw-semibold fs-4 text-gray-800">
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td><a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Link with href
  </a></td>
            </tr>
            <tr class="collapse" id="collapseExample">
                <td colspan="4">
                    <table class="table table-row-dashed table-row-gray-500 gy-5 gs-5 mb-0">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-800">
                                <th scope="col">Header</th>
                                <th scope="col">Header</th>
                                <th scope="col">Header</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">A</th>
                                <td>First</td>
                                <td>Last</td>
                            </tr>
                            <tr>
                                <th scope="row">B</th>
                                <td>First</td>
                                <td>Last</td>
                            </tr>
                            <tr>
                                <th scope="row">C</th>
                                <td>First</td>
                                <td>Last</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
@section('modal')
<div class="modal fade" tabindex="-1" id="modal_paket">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Paket</h5>
        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
          <span class="svg-icon svg-icon-2x"></span>
        </div>
      </div>
      <div class="modal-body">
        <form action="/paket" method="post" id="form_paket">
          <input type="hidden" name="id_paket">
          <div class="mb-8 fv-row">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
              <span class="required">Select ISP</span>
            </label>
            <select name="isp" class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#modal_paket" data-placeholder="Select an option" data-allow-clear="true">
              <option></option>
              @foreach($isp as $m)
                <option value="{{$m->id_isp}}">{{$m->nama_isp}}</option>
              @endforeach
            </select>
        	</div>
        	<div class="mb-8 fv-row">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
              <span class="required">Nama Paket</span>
            </label>
            <input type="text" class="form-control form-control-solid" placeholder="Enter Paket Name" name="nama_paket">
            <div class="fv-plugins-message-container invalid-feedback"></div>
          </div>
          <div class="mb-8 fv-row">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
              <span class="required">Expired</span>
            </label>
            <input type="text" class="form-control form-control-solid" placeholder="Enter Expired" name="expired" id="expired">
            <div class="fv-plugins-message-container invalid-feedback"></div>
          </div>
          
          <div class="row">
            <div class="col-6">
              <div class="mb-8 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                  <span class="required">Nilai Biaya Langganan</span>
                </label>
                <input type="text" class="form-control form-control-solid" placeholder="Nilai Biaya Langganan" name="biaya_langganan" id="biaya_langganan">
                <div class="fv-plugins-message-container invalid-feedback"></div>
              </div>
              <div class="mb-8 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                  <span class="required">Nilai Fee Team Leader</span>
                </label>
                <input type="text" class="form-control form-control-solid" placeholder="Nilai Fee Team Leader" name="fee_tl" id="fee_tl">
                <div class="fv-plugins-message-container invalid-feedback"></div>
              </div>
              <div class="mb-8 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                  <span class="required">Nilai Fee Marketing</span>
                </label>
                <input type="text" class="form-control form-control-solid" placeholder="Nilai Fee Marketing" name="fee_marketing" id="fee_marketing">
                <div class="fv-plugins-message-container invalid-feedback"></div>
              </div>
            </div>
            <div class="col-6">
              <div class="mb-8 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                  <span class="required">Nilai Fee Sales</span>
                </label>
                <input type="text" class="form-control form-control-solid" placeholder="Nilai Fee Sales" name="fee_sales" id="fee_sales">
                <div class="fv-plugins-message-container invalid-feedback"></div>
              </div>
              <div class="mb-8 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                  <span class="required">Nilai Fee Supervisor</span>
                </label>
                <input type="text" class="form-control form-control-solid" placeholder="Nilai Fee Supervisor" name="fee_spv" id="fee_spv">
                <div class="fv-plugins-message-container invalid-feedback"></div>
              </div>
              <div class="mb-8 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                  <span class="required">Nilai Fee Management</span>
                </label>
                <input type="text" class="form-control form-control-solid" placeholder="Nilai Fee Management" name="fee_management" id="fee_management">
                <div class="fv-plugins-message-container invalid-feedback"></div>
              </div>
            </div>
          </div>
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button id="submit_paket" type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_isp">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form ISP</h5>
        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
          <span class="svg-icon svg-icon-2x"></span>
        </div>
      </div>
      <div class="modal-body">
        <form action="/isp" method="post" id="form_isp">
          <input type="hidden" name="id_isp">
        	<div class="mb-8 fv-row">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
              <span class="required">Nama ISP</span>
            </label>
            <input type="text" class="form-control form-control-solid" placeholder="Enter ISP Name" name="nama_isp">
            <div class="fv-plugins-message-container invalid-feedback"></div>
          </div>
        	
          <div class="mb-8 fv-row">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
              <span class="required">Select Status</span>
            </label>
            <select name="status" class="form-select form-select-solid" data-placeholder="Select an option">
              <option>Select Status</option>
              <option value="1">Active</option>
              <option value="0">Lock</option>
            </select>
        	</div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button id="submit_isp" type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	$(document).ready(function () {
		var isp = <?= json_encode($isp); ?>;
		var modal_isp = $('#modal_isp');
		modal_isp.on('show.bs.modal', function (event) {
		    $('input[name=id_isp]').val('');
		    $('input[name=nama_isp]').val('');
		    $('select[name=status]').val('');
		    var button = $(event.relatedTarget);
		    var id_isp = button.data('bs-isp');
		    if (id_isp !== 'new') {
		        $('input[name=id_isp]').val(isp[id_isp].id_isp);
		        $('input[name=nama_isp]').val(isp[id_isp].nama_isp);
		        $('select[name=status]').val(isp[id_isp].status);
		    } else {
		        $('input[name=id_isp]').val(id_isp);
		    }
		    $('select[name=status]').trigger('change');
		});

		var paket = <?= json_encode($paket); ?>;
		var modal_paket = $('#modal_paket');
		modal_paket.on('show.bs.modal', function (event) {
		    $('input[name=id_paket]').val('');
		    $('input[name=nama_paket]').val('');
		    $('input[name=expired]').val('');
		    $('select[name=isp]').val('');
        $('input[name=fee_sales]').val('');
		    var button = $(event.relatedTarget);
		    var id_paket = button.data('bs-paket');
		    if (id_paket !== 'new') {
		        $('input[name=id_paket]').val(paket[id_paket].id_paket);
		        $('input[name=nama_paket]').val(paket[id_paket].nama_paket);
		        $('input[name=expired]').val(paket[id_paket].expired);
		        $('select[name=isp]').val(paket[id_paket].isp_id);
            $('input[name=fee_sales]').val(paket[id_paket].fee_sales);
		    } else {
		        $('input[name=id_paket]').val(id_paket);
		    }
		    $('select[name=isp]').trigger('change');
		});

		const form_isp = document.querySelector('#form_isp');
	  var validator_isp = FormValidation.formValidation(form_isp,{
	    fields: {
	      'nama_isp': {
	        validators: {
	          notEmpty: {
	            message: 'required'
	          }
	        }
	      },
	      'status': {
	        validators: {
	          notEmpty: {
	            message: 'required'
	          }
	        }
	      },
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

		$('#submit_isp').on('click', function (e) {
		    e.preventDefault();

		    if (validator_isp) {
		        validator_isp.validate().then(function (status) {
		            console.log('validated!');
		            if (status === 'Valid') {
		                $('#submit_isp').attr('data-kt-indicator', 'on');
		                $('#submit_isp').prop('disabled', true);
		                $('#form_isp').submit();
		            }
		        });
		    }
		});

		const form_paket = document.querySelector('#form_paket');
	  var validator_paket = FormValidation.formValidation(form_paket,{
	    fields: {
	      'nama_paket': {
	        validators: {
	          notEmpty: {
	            message: 'required'
	          }
	        }
	      },
	      'expired': {
	        validators: {
	          notEmpty: {
	            message: 'required'
	          }
	        }
	      },
        'isp': {
          validators: {
            notEmpty: {
              message: 'required'
            }
          }
        },
        'biaya_langganan': {
          validators: {
            notEmpty: {
              message: 'required'
            }
          }
        },
        'fee_sales': {
          validators: {
            notEmpty: {
              message: 'required'
            }
          }
        },
        'fee_management': {
          validators: {
            notEmpty: {
              message: 'required'
            }
          }
        },
        'fee_spv': {
          validators: {
            notEmpty: {
              message: 'required'
            }
          }
        },
        'fee_marketing': {
          validators: {
            notEmpty: {
              message: 'required'
            }
          }
        },
        'fee_tl': {
          validators: {
            notEmpty: {
              message: 'required'
            }
          }
        },
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

		$('#submit_paket').on('click', function (e) {
		    e.preventDefault();

		    if (validator_paket) {
		        validator_paket.validate().then(function (status) {
		            console.log('validated!');
		            if (status === 'Valid') {
		                $('#submit_paket').attr('data-kt-indicator', 'on');
		                $('#submit_paket').prop('disabled', true);
		                $('#form_paket').submit();
		            }
		        });
		    }
		});
	});
</script>
@endsection
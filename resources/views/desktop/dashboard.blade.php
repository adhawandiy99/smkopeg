@extends('desktop')
@section('css')

@endsection
@section('tittle', 'Dashboard')
@section('content')
<div class="col-xl mb-5" id="konten">
  <div class="card shadow">
    <div class="card-body">
      <form method="get" action="/dashboard">
        <div class="row g-3 mb-3 align-items-center">
          <!-- Filter ISP -->
          <div class="col-12 col-md-4 col-lg-3">
            <div class="form-floating">
              <select name="isp" id="isp" class="form-select form-select-solid" data-control="select2" data-placeholder="Select ISP" data-allow-clear="true" data-hide-search="true">
                <option value="ALL">ALL ISP</option>
                @foreach($isp as $i)
                  <option value="{{ $i->nama_isp }}" {{ $i->nama_isp==Request::get('isp')?'selected':'' }}>
                    {{ $i->nama_isp }}
                  </option>
                @endforeach
              </select>
              <label for="isp">Filter ISP</label>
            </div>
          </div>

          <!-- Filter Tahun -->
          <div class="col-6 col-md-4 col-lg-2">
            <div class="form-floating">
              <select name="tahun" id="tahun" class="form-select form-select-solid" data-control="select2" data-placeholder="Tahun" data-allow-clear="true" data-hide-search="true">
                <option value="ALL">ALL</option>
                @for($thn=2025;$thn<=date('Y');$thn++)
                  <option value="{{ $thn }}" {{ $thn==Request::get('tahun')?'selected':'' }}>
                    {{ $thn }}
                  </option>
                @endfor
              </select>
              <label for="tahun">Filter Tahun</label>
            </div>
          </div>

          <!-- Filter Bulan -->
          <div class="col-6 col-md-4 col-lg-3">
            <div class="form-floating">
              <select name="bulan" id="bulan" class="form-select form-select-solid" data-control="select2" data-placeholder="Bulan" data-allow-clear="true" data-hide-search="true">
                <option value="ALL">ALL</option>
                @for($bln=1;$bln<=12;$bln++)
                  <option value="{{ date('m', mktime(0, 0, 0, $bln, 1)) }}" {{ $bln==Request::get('bulan')?'selected':'' }}>
                    {{ date('F', mktime(0, 0, 0, $bln, 1)) }}
                  </option>
                @endfor
              </select>
              <label for="bulan">Filter Bulan</label>
            </div>
          </div>

          <!-- Filter Button -->
          <div class="col-12 col-md-4 col-lg-2 d-grid">
            <button type="submit" class="btn btn-primary btn-lg">Filter</button>
          </div>
          <div class="col-12 col-md-4 col-lg-2 d-grid">
            <button type="button" id="export" class="btn btn-primary btn-lg">Download Excel</button>
          </div>
        </div>
      </form>

      
      <div class="table-responsive">
        <table class="table table-bordered gy-2">
          <thead>
            <tr>
              <th rowspan="2" class="align-middle">#</th>
              <th rowspan="2" class="text-sm-center align-middle">ISP</th>
              <th rowspan="2" class="text-sm-center align-middle">Kota</th>
              <th colspan="7" class="text-sm-center align-middle">Status Order</th>
              <th colspan="3" class="text-sm-center align-middle">Status Rekon</th>
              <th rowspan="2" class="text-sm-center align-middle">Curn</th>
            </tr>
            <tr>
              <th class="text-sm-center align-middle">Registered</th>
              <th class="text-sm-center align-middle">Validated</th>
              <th class="text-sm-center align-middle">Order Issued</th>
              <th class="text-sm-center align-middle">Kendala Input</th>
              <th class="text-sm-center align-middle">Prosess Install</th>
              <th class="text-sm-center align-middle">Kendala Install</th>
              <th class="text-sm-center align-middle">Online</th>
              <th class="text-sm-center align-middle">Hold</th>
              <th class="text-sm-center align-middle">Reject</th>
              <th class="text-sm-center align-middle">Approve</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $no => $d)
              <tr>
                <td class="align-middle">{{ ++$no }}</td>
                <td class="align-middle">{{ $d->isp_name }}</td>
                <td class="align-middle">{{ $d->kota }}</td>
                <td class="text-end">
                  <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="registered" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="{{ $d->kota }}" data-bs-label="{{ $d->isp_name }} - {{ $d->kota }} - Registered" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                    {{ $d->registered ?: '-' }}
                  </a>
                </td>
                <td class="text-end">
                  <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="validated" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="{{ $d->kota }}" data-bs-label="{{ $d->isp_name }} - {{ $d->kota }} - Validated" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                    {{ $d->validated ?: '-' }}
                  </a>
                </td>
                <td class="text-end">
                  <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="order_issued" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="{{ $d->kota }}" data-bs-label="{{ $d->isp_name }} - {{ $d->kota }} - Order Issued" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                    {{ $d->order_issued ?: '-' }}
                  </a>
                </td>
                <td class="text-end">
                  <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="kendala_input" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="{{ $d->kota }}" data-bs-label="{{ $d->isp_name }} - {{ $d->kota }} - Kendala Input" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                    {{ $d->kendala_input ?: '-' }}
                  </a>
                </td>
                <td class="text-end">
                  <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="kendala_install" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="{{ $d->kota }}" data-bs-label="{{ $d->isp_name }} - {{ $d->kota }} - Prosess Install" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                    {{ $d->kendala_install ?: '-' }}
                  </a>
                </td>
                <td class="text-end">
                  <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="prosess_install" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="{{ $d->kota }}" data-bs-label="{{ $d->isp_name }} - {{ $d->kota }} - Kendala Install" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                    {{ $d->prosess_install ?: '-' }}
                  </a>
                </td>
                <td class="text-end">
                  <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="online" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="{{ $d->kota }}" data-bs-label="{{ $d->isp_name }} - {{ $d->kota }} - Online" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                    {{ $d->online ?: '-' }}
                  </a>
                </td>
                <td class="text-end">
                  <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="rekon_hold" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="{{ $d->kota }}" data-bs-label="{{ $d->isp_name }} - {{ $d->kota }} - Rekon Hold" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                    {{ $d->rekon_hold ?: '-' }}
                  </a>
                </td>
                <td class="text-end">
                  <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="rekon_reject" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="{{ $d->kota }}" data-bs-label="{{ $d->isp_name }} - {{ $d->kota }} - Rekon Reject" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                    {{ $d->rekon_reject ?: '-' }}
                  </a>
                </td>
                <td class="text-end">
                  <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="rekon_approve" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="{{ $d->kota }}" data-bs-label="{{ $d->isp_name }} - {{ $d->kota }} - Rekon Approve" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                    {{ $d->rekon_approve ?: '-' }}
                  </a>
                </td>
                <td class="text-end">
                  <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="curn" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="{{ $d->kota }}" data-bs-label="{{ $d->isp_name }} - {{ $d->kota }} - Curn/Cabut" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                    {{ $d->curn ?: '-' }}
                  </a>
                </td>
              </tr>
            @endforeach
            <tr>
              <td colspan="3" class="align-middle">Total</td>
              <td class="text-end">
                <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="registered" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="ALL" data-bs-label="Total - Registered" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                  {{ $data->sum('registered') ?: '-' }}
                </a>
              </td>
              <td class="text-end">
                <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="validated" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="ALL" data-bs-label="Total - Validated" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                  {{  $data->sum('validated') ?: '-' }}
                </a>
              </td>
              <td class="text-end">
                <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="order_issued" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="ALL" data-bs-label="Total - Order Issued" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                  {{  $data->sum('order_issued') ?: '-' }}
                </a>
              </td>
              <td class="text-end">
                <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="kendala_input" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="ALL" data-bs-label="Total - Kendala Input" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                  {{ $data->sum('kendala_input') ?: '-' }}
                </a>
              </td>
              <td class="text-end">
                <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="kendala_install" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="ALL" data-bs-label="Total - Prosess Install" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                  {{ $data->sum('kendala_install') ?: '-' }}
                </a>
              </td>
              <td class="text-end">
                <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="prosess_install" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="ALL" data-bs-label="Total - Kendala Install" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                  {{ $data->sum('prosess_install') ?: '-' }}
                </a>
              </td>
              <td class="text-end">
                <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="online" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="ALL" data-bs-label="Total - Online" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                  {{ $data->sum('online') ?: '-' }}
                </a>
              </td>
              <td class="text-end">
                <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="rekon_hold" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="ALL" data-bs-label="Total - Rekon Hold" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                  {{ $data->sum('rekon_hold') ?: '-' }}
                </a>
              </td>
              <td class="text-end">
                <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="rekon_reject" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="ALL" data-bs-label="Total - Rekon Reject" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                  {{ $data->sum('rekon_reject') ?: '-' }}
                </a>
              </td>
              <td class="text-end">
                <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="rekon_approve" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="ALL" data-bs-label="Total - Rekon Approve" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                  {{ $data->sum('rekon_approve') ?: '-' }}
                </a>
              </td>
              <td class="text-end">
                <a href="#" style="color: inherit; text-decoration: none;" data-bs-col="curn" data-bs-isp_name="{{ $d->isp_name }}" data-bs-kota="ALL" data-bs-label="Total - Curn/Cabut" data-bs-toggle="modal" data-bs-target="#modal_detil_matrix">
                  {{ $data->sum('curn') ?: '-' }}
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
@section('modal')
  <div class="modal bg-body fade" tabindex="-1" id="modal_detil_matrix">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content shadow-none">
        <div class="modal-header">
          <h5 id="text_detil_matrix" class="modal-title">Modal title</h5>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
          </div>
        </div>
        <div class="modal-body" id="ajax_detil_matrix">
        </div>
      </div>
    </div>
  </div>
@endsection
@section('js')
<script type="text/javascript">
  var requestData = @json(Request::all());
  var modal = $('#modal_detil_matrix');

  modal.on('show.bs.modal', function (event) {
    $('#ajax_detil_matrix').html('');
    var button = $(event.relatedTarget); // Get the button that triggered the modal
    var col = button.data('bs-col');
    var isp_name = button.data('bs-isp_name');
    var kota = button.data('bs-kota');
    var label = button.data('bs-label');
    
    $('#text_detil_matrix').text(label.toUpperCase().replace("_", " "));
  
    $.ajax({
        url: '/ajax/dashboard',
        data: $.extend({}, requestData, { 
            col: col, 
            isp_name: isp_name,
            kota: kota
        }),
        success: function(html) {
            $('#ajax_detil_matrix').html(html);
            // console.log(html);
        },
        dataType: 'html'
    });
  });
  $('#export').click(function(){
    var ispName = $('#isp').val();
    var tahun = $('#tahun').val();
    var bulan = $('#bulan').val();
    // Construct the URL with query parameters
    var url = `/export_orders?isp_name=${encodeURIComponent(ispName)}&tahun=${encodeURIComponent(tahun)}&bulan=${encodeURIComponent(bulan)}`;

    // Redirect to the URL to trigger file download
    window.location.href = url;
  });
</script>
@endsection
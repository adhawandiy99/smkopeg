@extends('desktop')
@section('css')
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
@endsection
@section('tittle')

@if($data && $data->status_id>=1)
  @if($data->status_id == 1)
    Approval TL
  @else if($data->status_id == 2)
    Approval SPV
  @else if($data->status_id > 2)
    Admin Action
  @endif
@else
  Input Order
@endif
@endsection
@section('content')
@if(!session('auth')->tl && !session('auth')->spv && Request::segment(2)=='new')
<div class="col-xl">
  <div class="card card-xl-stretch mb-5 mb-xl-8">
    <div class="card-body">
      Silahkan update Profile : isi TL & SPV
    </div>
  </div>
</div>
@else
<div class="col-xl">
  <div class="card card-xl-stretch mb-5 mb-xl-8">
  	<div class="card-body">
  		<form id="form" class="needs-validation" method="post" enctype="multipart/form-data" novalidate>
        
  			<div class="row g-3">
				  <div class="col me-5">
            <div class="row g-3">
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <select name="id_isp" class="form-select" data-control="select2" data-placeholder="Select ISP" data-allow-clear="true" data-hide-search="true" id="isp">
                    <option></option>
                    @foreach($isp as $i)
                        <option value="{{ $i->id_isp }}">{{ $i->nama_isp }}</option>
                    @endforeach
                  </select>
                  <label for="isp">ISP<span class="text-danger">*</span></label>
                  <div class="invalid-feedback">Please provide a isp.</div>
                </div>
              </div>
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <select name="homepass" class="form-select" data-control="select2" data-placeholder="Select Homepass" data-allow-clear="true" data-hide-search="true" id="homepass">
                    <option></option>
                  </select>
                  <label for="homepass">Homepass</label>
                  <div class="invalid-feedback">Please provide a homepass.</div>
                </div>
              </div>
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <select name="service" class="form-select" data-control="select2" data-placeholder="Select service" data-allow-clear="true" data-hide-search="true" id="service">
                    <option></option>
                    <option value="FIBER 20">FIBER 20</option>
                    <option value="FIBER 50">FIBER 50</option>
                    <option value="FIBER 100">FIBER 100</option>
                    <option value="FIBER PRO 100">FIBER PRO 100</option>
                  </select>
                  <label for="service">Service<span class="text-danger">*</span></label>
                  <div class="invalid-feedback">Please provide a service.</div>
                </div>
              </div>
            </div>

            <div class="row g-3">
              <div class="col-6">
                <div class="form-floating mb-7 fv-row">
                  <select name="paket" class="form-select" data-control="select2" data-placeholder="Select paket" data-allow-clear="true" data-hide-search="true" id="paket">
                    <option></option>
                  </select>
                  <label for="paket" class="form-label"><i class="bi bi-tag-fill font-13"></i>
                    Paket<span class="text-danger">*</span>
                  </label>
                  <div class="invalid-feedback">Please provide a Paket.</div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-floating mb-7 fv-row">
                  <select name="odp" class="form-select" data-control="select2" data-placeholder="Select ODP" data-allow-clear="true" data-hide-search="true" id="odp">
                    <option></option>
                  </select>
                  <label for="odp" class="form-label">ODP <span class="text-danger">*</span></label>
                  <div class="invalid-feedback">Please provide a odp.</div>
                </div>
              </div>
            </div>

            <div class="row g-3">
              <div class="col-6">
                <div class="form-floating mb-7 fv-row">
                  <input name="nama_pelanggan" type="text" class="form-control" id="nama_pelanggan" placeholder="Nama Pelanggan" autocomplete="off" value="{{ $data->nama_pelanggan ?? old('nama_pelanggan') }}" required>
                  <label for="nama_pelanggan" class="form-label">
                    <i class="bi bi-person-circle font-13"></i>
                    Nama Pelanggan
                    <span class="text-danger">*</span>
                  </label>
                  <div class="invalid-feedback">Please provide a valid name.</div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-floating mb-7 fv-row">
                  <input name="email" type="text" class="form-control" id="email" placeholder="Email" autocomplete="off" value="{{ $data->email ?? old('email') }}" required>
                  <label for="email" class="form-label">
                    <i class="bi bi-mailbox2-flag font-13"></i>
                    Email
                    <span class="text-danger">*</span>
                  </label>
                  <div class="invalid-feedback">Please provide a valid Email.</div>
                </div>
              </div>
            </div>

            <div class="row g-3">
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <input name="vendor_name" type="text" class="form-control" id="vendor_name" placeholder="vendor name" autocomplete="off" value="{{ $data->vendor_name ?? old('vendor_name') }}">
                  <label for="vendor_name">Vendor Name<span class="text-danger">*</span></label>
                  <div class="invalid-feedback">Please provide a vendor name.</div>
                </div>
              </div>
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <input name="no_ktp" type="text" class="form-control" id="no_ktp" placeholder="No.KTP" autocomplete="off" value="{{ $data->no_ktp ?? old('no_ktp') }}">
                  <label for="no_ktp">No. Ktp<span class="text-danger">*</span></label>
                  <div class="invalid-feedback">Please provide a no_ktp.</div>
                </div>
              </div>
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <input name="tgl_lahir" type="text" class="form-control" id="tgl_lahir" placeholder="Tgl. Lahir" autocomplete="off" value="{{ $data->tgl_lahir ?? old('tgl_lahir') }}">
                  <label for="tgl_lahir">Tgl. Lahir<span class="text-danger">*</span></label>
                  <div class="invalid-feedback">Please provide a Tgl. Lahir.</div>
                </div>
              </div>
            </div>

            <div class="row g-3">
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <input name="telp_pelanggan" type="number" class="form-control" id="telp_pelanggan" placeholder="No. Telp" autocomplete="off" value="{{ $data->no_telp_pelanggan ?? old('telp_pelanggan') }}" required>
                  <label for="telp_pelanggan" class="form-label">
                    <i class="bi bi-telephone-fill font-13"></i>
                    No. Telp
                    <span class="text-danger">*</span>
                  </label>
                  <div class="invalid-feedback">Please provide a valid phone number.</div>
                </div>
              </div>
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <input name="telp_pelanggan_alt" type="number" class="form-control" id="telp_pelanggan_alt" placeholder="No. Telp" autocomplete="off" value="{{ $data->no_telp_pelanggan_alt ?? old('telp_pelanggan_alt') }}" required>
                  <label for="telp_pelanggan" class="form-label">
                    <i class="bi bi-telephone font-13"></i>
                    No. Telp Alternatif
                  </label>
                  <div class="invalid-feedback">Please provide a valid alt phone number.</div>
                </div>
              </div>
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <input name="koordinat_pelanggan" type="text" class="form-control" id="koordinat_pelanggan" placeholder="Koordinat Pelanggan" autocomplete="off" value="{{ $data->koordinat_pelanggan ?? old('koordinat_pelanggan') }}">
                  <label for="koordinat_pelanggan" class="form-label">
                    <i class="bi bi-geo-alt-fill font-13"></i>
                    Koordinat Instalasi
                    <span class="text-danger">*</span>
                  </label>
                </div>
              </div>
            </div>

            
	    			<div class="form-floating mb-7 fv-row">
				        <textarea name="alamat_pelanggan" class="form-control" id="alamat_pelanggan" placeholder="Alamat Pelanggan" autocomplete="off" required>{{ $data->alamat_pelanggan ?? old('alamat_pelanggan') }}</textarea>
				        <label for="alamat_pelanggan" class="form-label">
				            <i class="bi bi-textarea font-13"></i>
				            Alamat Instalasi
				            <span class="text-danger">*</span>
				        </label>
				        <div class="invalid-feedback">Please provide a valid address.</div>
				    </div>

            <div class="row g-3">
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <input name="kelurahan" type="text" class="form-control" id="kelurahan" placeholder="Kelurahan" autocomplete="off" value="{{ $data->kelurahan ?? old('kelurahan') }}">
                  <label for="kelurahan" class="form-label">
                    <i class="bi bi-geo-alt-fill font-13"></i>
                    Kelurahan
                    <span class="text-danger">*</span>
                  </label>
                </div>
              </div>
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <input name="kecamatan" type="text" class="form-control" id="kecamatan" placeholder="Kecamatan" autocomplete="off" value="{{ $data->kecamatan ?? old('kecamatan') }}">
                  <label for="kecamatan" class="form-label">
                    <i class="bi bi-geo-alt-fill font-13"></i>
                    Kecamatan
                    <span class="text-danger">*</span>
                  </label>
                </div>
              </div>
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <input name="kota" type="text" class="form-control" id="kota" placeholder="Kota" autocomplete="off" value="{{ $data->kota ?? old('kota') }}">
                  <label for="kota" class="form-label">
                    <i class="bi bi-geo-alt-fill font-13"></i>
                    Kota
                    <span class="text-danger">*</span>
                  </label>
                </div>
              </div>
            </div>

            <div class="row g-3">
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <input name="jenis_bangunan" type="text" class="form-control" id="jenis_bangunan" placeholder="Jenis Bangunan" autocomplete="off" value="{{ $data->jenis_bangunan ?? old('jenis_bangunan') }}">
                  <label for="jenis_bangunan">Jenis Bangunan<span class="text-danger">*</span></label>
                  <div class="invalid-feedback">Please provide a Jenis Bangunan.</div>
                </div>
              </div>
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <select name="building_status" class="form-select" data-control="select2" data-placeholder="Select Building Status" data-allow-clear="true" data-hide-search="true" id="building_status">
                    <option></option>
                    <option value="PEMILIK">PEMILIK</option>
                    <option value="SEWA">SEWA</option>
                  </select>
                  <label for="building_status">Building Status<span class="text-danger">*</span></label>
                  <div class="invalid-feedback">Please provide a Building Status.</div>
                </div>
              </div>
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <input name="install_date" type="text" class="form-control" id="install_date" placeholder="Install Date" autocomplete="off" value="{{ $data->install_date ?? old('install_date') }}">
                  <label for="install_date">Install Date<span class="text-danger">*</span></label>
                  <div class="invalid-feedback">Please provide a Install Date.</div>
                </div>
              </div>
            </div>

            <div class="row g-3">
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <select name="jam" class="form-select" data-control="select2" data-placeholder="Select Jam" data-allow-clear="true" data-hide-search="true" id="jam">
                    <option></option>
                    <option value="09.00-11.00">09.00-11.00</option>
                    <option value="11.00-13.00">11.00-13.00</option>
                    <option value="13.00-15.00">13.00-15.00</option>
                    <option value="15.00-17.00">15.00-17.00</option>
                  </select>
                  <label for="jam">Jam<span class="text-danger">*</span></label>
                  <div class="invalid-feedback">Please provide a Jam.</div>
                </div>
              </div>
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <select name="router" class="form-select" data-control="select2" data-placeholder="Select Router" data-allow-clear="true" data-hide-search="true" id="router">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                  <label for="router">Router<span class="text-danger">*</span></label>
                  <div class="invalid-feedback">Please provide a Router.</div>
                </div>
              </div>
              <div class="col-4">
                <div class="form-floating mb-7 fv-row">
                  <select name="stb" class="form-select" data-control="select2" data-placeholder="Select STB" data-allow-clear="true" data-hide-search="true" id="stb">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                  <label for="stb">STB<span class="text-danger">*</span></label>
                  <div class="invalid-feedback">Please provide a STB.</div>
                </div>
              </div>
            </div>
				    

            <input name="kode_sf" type="hidden" id="sales" value="{{ $data->kode_sf ?? session('auth')->username }}" readonly>
            @if($data && $data->status_id>=1)
              @if($data->status_id==1 && session('auth') && in_array(session('auth')->role_user, [1, 4]))
                <div class="form-floating mb-7 fv-row">
                  <select name="status" class="form-select" data-control="select2" data-placeholder="Select status" data-allow-clear="true" data-hide-search="true" id="status">
                    <option></option>
                    <option value="2">Approve</option>
                  </select>
                  <label for="catatan" class="form-label">Status</label>
                </div>
                <div class="form-floating mb-7 fv-row">
                  <textarea name="catatan" class="form-control" id="catatan" placeholder="Catatan" autocomplete="off"></textarea>
                  <label for="catatan" class="form-label">
                      <i class="bi bi-textarea font-13"></i>
                      Catatan
                  </label>
                  <div class="invalid-feedback">Please provide a note.</div>
                </div>
              @endif
              @if($data->status_id==2 && session('auth') && in_array(session('auth')->role_user, [1, 5]))
                <div class="form-floating mb-7 fv-row">
                  <select name="status" class="form-select" data-control="select2" data-placeholder="Select status" data-allow-clear="true" data-hide-search="true" id="status">
                    <option></option>
                    <option value="3">Approve</option>
                  </select>
                  <label for="catatan" class="form-label">Status</label>
                </div>
                <div class="form-floating mb-7 fv-row">
                  <textarea name="catatan" class="form-control" id="catatan" placeholder="Catatan" autocomplete="off"></textarea>
                  <label for="catatan" class="form-label">
                      <i class="bi bi-textarea font-13"></i>
                      Catatan
                  </label>
                  <div class="invalid-feedback">Please provide a note.</div>
                </div>
              @endif
              @if($data->status_id > 2 && session('auth') && in_array(session('auth')->role_user, [1, 2]))
                <div class="form-floating mb-7 fv-row">
                  <select name="status" class="form-select" data-control="select2" data-placeholder="Select status" data-allow-clear="true" data-hide-search="true" id="status">
                    <option></option>
                    <option value="4">Problem Install</option>
                    <option value="5">Proses Install</option>
                    <option value="6">Online</option>
                    <option value="7">Cancel</option>
                  </select>
                  <label for="catatan" class="form-label">Status</label>
                </div>
                <div class="form-floating mb-7 fv-row">
                  <textarea name="catatan" class="form-control" id="catatan" placeholder="Catatan" placeholder="Please provide a note." autocomplete="off"></textarea>
                  <label for="catatan" class="form-label">
                      <i class="bi bi-textarea font-13"></i>
                      Catatan
                  </label>
                  <div class="invalid-feedback">Please provide a note.</div>
                </div>
              @endif
            @endif
				    <div class="form-check mb-7 fv-row">
				        <input name="t_c" class="form-check-input" type="checkbox" id="c2a" required>
				        <label class="form-check-label" for="c2a">I agree with the <a href="#">Terms and Conditions</a>.</label>
				        <div class="invalid-feedback">You must agree before submitting.</div>
				    </div>
				    <button type="button" id="button_submit" class="btn btn-full btn-success">Save</button>
            @if(count($logs))
              <button type="button" id="view_log" class="btn btn-full btn-primary" data-bs-toggle="modal" data-bs-target="#modal_logs">View Log</button>
            @endif
				  </div>
				  <div class="col">
				    
				    <div id="map" style="height: 60%;" class="mb-3"></div>
            <div class="mb-3 msg"></div>
            <div class="row g-3">
              @php
                $photos = ["ktp","rumah","formulir"];
                $relationId = $data->relation_id ?? 'default_relation_id';
              @endphp
              @foreach($photos as $p)
                <div class="col evidence text-center">

                  <?php
                    $path = "/storage/".$relationId."/evidence_".$p;
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
                      <input type="file" name="evidence_{{ $p }}" class="d-none" need_validate="{{ $class }}" id="id_{{$p}}" accept="jpg,jpeg,png">
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
			</form>
  	</div>
  </div>
</div>
@endif
@endsection
@section('modal')
@if(count($logs))
  <div class="modal fade" tabindex="-1" id="modal_logs">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Log History</h5>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <span class="svg-icon svg-icon-2x"></span>
          </div>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="table_paket">
              <thead>
                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                  <th>#</th>
                  <th>Status</th>
                  <th>Catatan</th>
                  <th>Update By</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                @foreach($logs as $no => $l)
                  <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ $l->status }}</td>
                    <td>{{ $l->catatan }}</td>
                    <td>{{ $l->update_by }}</td>
                    <td>{{ $l->ts }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif
@endsection
@section('js')
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/exifr/dist/lite.umd.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
    var data_pelanggan = <?= json_encode($data); ?>;
    let markerHomepass;
    let koordinatPelanggan = data_pelanggan?.koordinat_pelanggan ?? '';
    let selectedIsp = data_pelanggan?.isp_id ?? '';
    let selectedPaket = data_pelanggan?.paket_id ?? '';
    let selectedOdp = data_pelanggan?.odp_id ?? '';

    // Event listener for ISP dropdown
    $('#isp').on('change', function () {
        selectedIsp = $(this).val();
        $.post('/ajax/get_paket', { isp_id: selectedIsp })
            .done(function (response) {
                let $paketSelect = $('#paket');
                $paketSelect.empty().append('<option value="">Select</option>');

                if (response.paket && Array.isArray(response.paket)) {
                    response.paket.forEach(function (paket) {
                        if (selectedPaket == paket.id_paket) {
                            $paketSelect.append(
                                `<option value="${paket.id_paket}" selected>${paket.nama_paket}</option>`
                            );
                        } else {
                            $paketSelect.append(
                                `<option value="${paket.id_paket}">${paket.nama_paket}</option>`
                            );
                        }
                    });
                }
                $paketSelect.trigger('change');
            })
            .fail(function (error) {
                console.error('Error updating data:', error);
            });

        checkAndSubmit();
    });

    if (data_pelanggan && data_pelanggan.service) {
      $('#isp').val(data_pelanggan.isp_id).trigger('change');
      $('#service').val(data_pelanggan.service).trigger('change');
      $('#building_status').val(data_pelanggan.building_status).trigger('change');
      $('#jam').val(data_pelanggan.jam).trigger('change');
      $('#router').val(data_pelanggan.router).trigger('change');
      $('#stb').val(data_pelanggan.stb).trigger('change');
    }
    $("#tgl_lahir").flatpickr();
    $("#install_date").flatpickr();
    // Function to check both values and make an AJAX call
    function checkAndSubmit() {
          if (koordinatPelanggan && selectedIsp) {
              $.post('/ajax/get_odp', {
                  koordinat: koordinatPelanggan,
                  id_isp: selectedIsp
              })
              .done(function (response) {
                  deleteAllMarkerHomepass();
                  let $odpSelect = $('#odp');
                  let $homepassSelect = $('#homepass');
                  $odpSelect.empty().append('<option value="">Select</option>');
                  console.log(response);
                  if (response.odps && Array.isArray(response.odps)) {
                      response.odps.forEach(function (odp) {
                          if (selectedOdp == odp.id_odp) {
                              $odpSelect.append(
                                  `<option value="${odp.id_odp}" selected>${odp.nama_odp} (${odp.distance_in_meters} m)</option>`
                              );
                          } else {
                              $odpSelect.append(
                                  `<option value="${odp.id_odp}">${odp.nama_odp} (${odp.distance_in_meters} m)</option>`
                              );
                          }
                          addOrUpdateMarker(odp.lat, odp.lon, odp.nama_odp, odp.nama_odp, 'green');
                      });
                  }

                  $odpSelect.trigger('change');
                  $homepassSelect.empty().append('<option value="">Select</option>');
                  if (response.homepassed && response.homepassed.length > 0) {
                      let homepass = response.homepassed[0];
                      if (!data_pelanggan) {
                          $('#kelurahan').val(homepass.kelurahan);
                          $('#kecamatan').val(homepass.kecamatan);
                          $('#kota').val(homepass.kota);
                          $('#alamat_pelanggan').val(homepass.nama_jalan+' no:'+homepass.no_rumah_gedung);
                          
                          $homepassSelect.append(
                              `<option value="${homepass.id_homepass}" selected>${homepass.id_homepass}</option>`
                          );
                          $odpSelect.val(homepass.splitter_id).trigger('change');
                      }else{
                        
                        response.homepassed.forEach(function (hp) {
                            $homepassSelect.append(
                                `<option value="${hp.id_homepass}">${hp.id_homepass} (${hp.distance_in_meters} m)</option>`
                            );
                            addOrUpdateMarker(hp.latitude, hp.longitude, hp.id_homepass, hp.id_homepass, 'home');
                        });
                        $homepassSelect.append(
                            `<option value="${data_pelanggan.homepass}" selected>${data_pelanggan.homepass}</option>`
                        );
                      }
                      $homepassSelect.trigger('change');
                  } 
                  $('.msg').text(response.message);
              })
              .fail(function (error) {
                  console.error('Error updating data:', error);
              });
          }
      }


		var map = L.map('map').setView([0, 0], 2); // Default location is center of the world

    // Set up the OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    var sector = <?= json_encode($sector); ?>;

    // Add polygons to the map
    sector.forEach(function(polygonData) {
        var polygonCoordinates = JSON.parse(polygonData.polygons);
        var latLngs = polygonCoordinates.map(function(coord) {
            return [parseFloat(coord[0]), parseFloat(coord[1])];
        });
        L.polygon(latLngs, {
            color: 'blue',
            fillColor: '#f2f2f2',
            fillOpacity: 0.5
        })
        .addTo(map);
    });
    // Draggable marker variable
    var marker = null;

    // Try to get the user's location
    if(!$('#koordinat_pelanggan').val()){
      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            // Get the user's current location
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;

            // Center the map on the user's location
            map.setView([lat, lon], 13);

            // Create a draggable marker at the user's location
            marker = L.marker([lat, lon], { draggable: true }).addTo(map)
                .bindPopup("Tikor Instalasi: " + lat + "," + lon).openPopup();
            $('#koordinat_pelanggan').val(lat + ',' + lon);
              

          }, function(error) {
            // Fallback if the user's location is not available
            alert("Geolocation failed: " + error.message);
            // Optionally set a default marker or leave it null
            map.setView([-3.319234, 114.589323], 13); // Example: Default to London
          });
      } else {
        alert("Geolocation is not supported by this browser.");
      }
    }else{
      handleCoordinateInput();
    }
    

    // Handle marker if user drags it manually (this will still work even with a default location)
     map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lon = e.latlng.lng;

        // Check if the marker exists; if so, move it, otherwise create it
        if (marker) {
            marker.setLatLng([lat, lon]); // Move existing marker
        } else {
            marker = L.marker([lat, lon], { draggable: true }).addTo(map)
                .bindPopup("Tikor Instalasi: " + lat.toFixed(5) + "," + lon.toFixed(5))
                .openPopup(); // Create new marker
        }

        koordinatPelanggan = lat + ',' + lon;
        $('#koordinat_pelanggan').val(lat + ',' + lon);
        checkAndSubmit();
        // Display marker's new coordinates
        marker.getPopup().setContent("Tikor Instalasi: " + lat.toFixed(5) + "," + lon.toFixed(5)).openOn(map);
        // When the marker is dragged, update the coordinates
        marker.on('dragend', function(e) {
          // console.log(e);
          var lat = e.target._latlng.lat;
          var lon = e.target._latlng.lng;

          // Check if the marker exists; if so, move it, otherwise create it
          if (marker) {
              marker.setLatLng([lat, lon]); // Move existing marker
          } else {
              marker = L.marker([lat, lon], { draggable: true }).addTo(map)
                  .bindPopup("Tikor Instalasi: " + lat.toFixed(5) + "," + lon.toFixed(5))
                  .openPopup(); // Create new marker
          }
          koordinatPelanggan = lat + ',' + lon;
          $('#koordinat_pelanggan').val(lat + ',' + lon);
          checkAndSubmit();
          // Display marker's new coordinates
          marker.getPopup().setContent("Tikor Instalasi: " + lat.toFixed(5) + "," + lon.toFixed(5)).openOn(map);
        });
    });
    function handleCoordinateInput() {
        var koordinat = document.getElementById('koordinat_pelanggan').value;
        var coords = koordinat.split(',').map(function(item) {
            return parseFloat(item.trim());
        });

        if (coords.length === 2 && !isNaN(coords[0]) && !isNaN(coords[1])) {
            updateMap(coords[0], coords[1]); // Update the map if valid coordinates
        } else {
            
        }
        koordinatPelanggan = koordinat;
    }

    $('#koordinat_pelanggan').on('paste', function () {
        setTimeout(handleCoordinateInput, 100);
    }).on('blur', handleCoordinateInput);

    function updateMap(latitude, longitude) {
      if (!map) {

        // Initialize the Leaflet map only once
        map = L.map('map').setView([latitude, longitude], 17);

        // Add the base map layer from OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add click event to update marker and coordinates when user clicks on the map
        map.on('click', function (e) {
          let lat = e.latlng.lat;
          let lng = e.latlng.lng;

          // Update marker position and input field with the new coordinates
          if (marker) {
            marker.setLatLng([lat, lng]);
          } else {
            marker = L.marker([lat, lng]).addTo(map)
              .bindPopup('Koordinat Pelanggan')
              .openPopup();
          }
          koordinatPelanggan = lat + ',' + lng;
          $('#koordinat_pelanggan').val(lat + ',' + lng);
          checkAndSubmit();
        });

      } else {
        // Recenter the map if it already exists
        map.setView([latitude, longitude], 17);
      }

      // Update the marker or create one if it doesn't exist
      if (marker) {
        marker.setLatLng([latitude, longitude]);
      } else {
        marker = L.marker([latitude, longitude]).addTo(map)
          .bindPopup('Koordinat Pelanggan')
          .openPopup();
      }
      checkAndSubmit();
      
    }
		// Helper function to convert DMS to decimal format
    function convertDMSToDecimal(dms) {
      if (Array.isArray(dms)) {
        const [degrees, minutes, seconds] = dms;
        return degrees + minutes / 60 + seconds / 3600;
      }
      return dms; // Return if already in decimal format
    }

    
    function addOrUpdateMarker(lat, lng, markerId, popupText,icon) {
      const markerSizes = {
        small: [20, 32],
        medium: [30, 48],
        large: [40, 64]
      };

      // Get the size dimensions
      const [iconWidth, iconHeight] = markerSizes['small'];

      // Create a custom icon
      const customIconHome = L.icon({
          iconUrl: `/images/location_${icon}.png`, // Replace with your marker icon URL
          iconSize: [iconWidth, iconHeight], // Size of the icon
          iconAnchor: [iconWidth / 2, iconHeight], // Anchor point
          popupAnchor: [0, -iconHeight / 2] // Popup position relative to the icon
      });
      if (markerHomepass[markerId]) {
          // Update existing marker
          markerHomepass[markerId].setLatLng([lat, lng]).setIcon(customIconHome);
      } else {
          // Add new marker
          markerHomepass[markerId] = L.marker([lat, lng]).addTo(map).setIcon(customIconHome);
      }
    }
    function deleteAllMarkerHomepass() {
        for (let markerId in markerHomepass) {
            if (markerHomepass.hasOwnProperty(markerId)) {
                // Remove the marker from the map
                map.removeLayer(markerHomepass[markerId]);
            }
        }
        // Clear the markerHomepass object
        markerHomepass = {};
    }

    // Select the file input element
    // Add an event listener for all file input elements
    $('input[type="file"]').on('change', function(e) {
      let file = e.target.files[0]; // Get the selected file
      let idEl = $(this).attr('name'); // Use the input's name as the target ID

      if (file) {
        let reader = new FileReader();
        let wrapper = $(this).closest('.overlay').find('.overlay-wrapper');

        reader.onload = function(event) {
          wrapper.css('background-image', `url('${event.target.result}')`);
        };
        reader.readAsDataURL(file); // Read the file

        exifr.parse(file).then(function(exifData) {
          console.log(exifData); // Log to inspect EXIF structure
          let latitude = exifData.latitude || exifData.GPSLatitude || (exifData.gps && exifData.gps.latitude);
          let longitude = exifData.longitude || exifData.GPSLongitude || (exifData.gps && exifData.gps.longitude);

          // Convert DMS to decimal if necessary
          latitude = convertDMSToDecimal(latitude);
          longitude = convertDMSToDecimal(longitude);

          if (latitude && longitude) {
            console.log('Latitude:', latitude);
            console.log('Longitude:', longitude);
            // Update koordinat_pelanggan value with the latitude and longitude
            $('#koordinat_pelanggan').val(`${latitude}, ${longitude}`);
            // Update the map with the latitude and longitude
            updateMap(latitude, longitude);
          } else {
            alert('No geotag (GPS) data found. Please set Koordinat manually.');
            // Fallback to device location if no GPS data is found in the image
            if (!marker) {
              getDeviceLocation();
            }
          }
        }).catch(function(error) {
          console.log(error);
        });
      }
    });



    const addFields = function(index) {
      // Add validators
      validator.addField(index, {
        validators: {
          notEmpty: {
            message: "Required"
          }
        }
      });
    };
    const removeFields = function(index) {
      validator.addField(index);
      validator.removeField(index);
    }
    $('.input-photos').on('click', function() {
      $(this).parent().find('input[type=file]').click();
    });
    const form = document.querySelector('#form');
    var validator = FormValidation.formValidation(form,{
      fields: {
        'nama_pelanggan': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'telp_pelanggan': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'alamat_pelanggan': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'koordinat_pelanggan': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            },
            regexp: {
              regexp: /^-?([1-8]?\d(\.\d+)?|90(\.0+)?),-?(1[0-7]\d(\.\d+)?|180(\.0+)?|\d{1,2}(\.\d+)?)$/, // Regex for latitude, longitude without spaces
              // regexp: /^-?([1-8]?\d(\.\d+)?|90(\.0+)?),\s?-?(1[0-7]\d(\.\d+)?|180(\.0+)?|\d{1,2}(\.\d+)?)$/,
              message: 'Format koordinat tidak valid. Contoh yang benar: -3.317217955165058,114.58523699702049'
            }
          }
        },
        'service': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'id_isp': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'paket': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'odp': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'email': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'vendor_name': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'no_ktp': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'tgl_lahir': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'kelurahan': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'kecamatan': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'kota': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'jenis_bangunan': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'building_status': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'install_date': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'jam': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'router': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'stb': {
          validators: {
            notEmpty: {
              message: 'Fill this field'
            }
          }
        },
        'evidence_ktp': {
          validators: {
            notEmpty: {
              message: 'Upload Evidence'
            }
          }
        },
        'evidence_rumah': {
          validators: {
            notEmpty: {
              message: 'Upload Evidence'
            }
          }
        },
        'evidence_formulir': {
          validators: {
            notEmpty: {
              message: 'Upload Evidence'
            }
          }
        },
        't_c': {
          validators: {
            notEmpty: {
              message: 'Check this field'
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
    if(!data_pelanggan?.relation_id){
      addFields("evidence_ktp");
      addFields("evidence_rumah");
      addFields("evidence_formulir");
    }else{
      removeFields("evidence_ktp");
      removeFields("evidence_rumah");
      removeFields("evidence_formulir");
    }
    var button_submit = document.querySelector("#button_submit");
    button_submit.addEventListener("click", function(e) {
      e.preventDefault();
      if (validator) {
        validator.validate().then(function (status) {
          console.log('validated!');
          if (status == 'Valid') {
            button_submit.setAttribute('data-kt-indicator', 'on');
            button_submit.disabled = true;
            form.submit();
          }
        });
      }
    });
	});
</script>
@endsection
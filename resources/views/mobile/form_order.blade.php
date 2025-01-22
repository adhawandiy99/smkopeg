@extends('mobile')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style type="text/css">
  .error{
    color:red;
  }
  .input-photos img {
    width: 100px;
    height: 150px;
    margin-bottom: 5px;
  }
</style>
@endsection

@section('tittle', 'Input Order')

@section('content')
@if(!session('auth')->tl && !session('auth')->spv && Request::segment(2)=='new')
  <div class="card card-style">
    <div class="content">
      Silahkan update Profile : isi TL & SPV
    </div>
  </div>
@else
<div class="card card-style">
  <div class="content">
    <div class="mt-3"></div>
    <form id="form" class="form form-horizontal" method="post" enctype="multipart/form-data" novalidate>
      <div class="row">
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <select name="id_isp"  class="form-select rounded-xs" id="isp" required>
              <option value="" selected>Select ISP</option>
              @foreach($isp as $i)
                  <option value="{{ $i->id_isp }}">{{ $i->nama_isp }}</option>
              @endforeach
            </select>
            <label for="isp" class="color-theme form-label-always-active">Select Isp</label>
          </div>
        </div>
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="koordinat_pelanggan" class="color-theme form-label-always-active">Koordinat Instalasi</label>
            <input name="koordinat_pelanggan" type="text" class="form-control rounded-xs" id="koordinat_pelanggan" placeholder="Koordinat Pelanggan" autocomplete="off" value="{{ $data->koordinat_pelanggan ?? old('koordinat_pelanggan') }}">
          </div>
        </div>
      </div>
      
      <div id="map" style="height: 400px;" class="mb-3"></div>
      <div class="mb-3 msg"></div>

      <div class="form-custom form-label form-border mb-3 bg-transparent">
        <label for="paket" class="color-theme form-label-always-active">Paket</label>
         <select name="paket" class="form-select rounded-xs" id="paket" required>
          <option value="">Select</option>
        </select>
      </div>
      <div class="form-custom form-label form-border mb-3 bg-transparent">
        <select name="odp"  class="form-select rounded-xs" id="odp" required>
          <option value="">Select</option>
        </select>
        <label for="odp" class="color-theme form-label-always-active">Select ODP</label>
      </div>
      
      <div class="row">
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="homepass" class="color-theme form-label-always-active">homepass</label>
            <select name="homepass"  class="form-select rounded-xs" id="homepass">
              <option value="">Select</option>
            </select>
            <span>(required)</span>
          </div>
        </div>
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="nama_pelanggan" class="color-theme form-label-always-active">Nama Pelanggan</label>
            <input name="nama_pelanggan" type="text" class="form-control rounded-xs" id="nama_pelanggan" placeholder="Nama Pelanggan" autocomplete="off" value="{{ $data->nama_pelanggan ?? old('nama_pelanggan') }}" required>
            <span>(required)</span>
          </div>
        </div>
      </div>
      
      <input name="kode_sf" type="hidden" class="form-control rounded-xs" id="kode_sf" placeholder="Nik Sales" autocomplete="off" value="{{  $data->kode_sf ?? session('auth')->username }}" readonly>

      <div class="row">
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="telp_pelanggan" class="color-theme form-label-always-active">No.Telp</label>
            <input name="telp_pelanggan" type="number" class="form-control rounded-xs" id="telp_pelanggan" placeholder="No.Telp" autocomplete="off" value="{{ $data->no_telp_pelanggan ?? old('telp_pelanggan') }}" required>
            <span>(required)</span>
          </div>
        </div>
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="telp_pelanggan_alt" class="color-theme form-label-always-active">No.Telp Alternatif</label>
            <input name="telp_pelanggan_alt" type="number" class="form-control rounded-xs" id="telp_pelanggan_alt" placeholder="No.Telp Alternatif" autocomplete="off" value="{{ $data->no_telp_pelanggan_alt ?? old('telp_pelanggan_alt') }}">
            <span>(optional)</span>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="email" class="color-theme form-label-always-active">Email</label>
            <input name="email" type="text" class="form-control rounded-xs" id="email" placeholder="Email" autocomplete="off" value="{{ $data->email ?? old('email') }}" required>
            <span>(required)</span>
          </div>
        </div>
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="vendor_name" class="color-theme form-label-always-active">Vendor Name</label>
            <input name="vendor_name" type="text" class="form-control rounded-xs" id="vendor_name" placeholder="Vendor Name" autocomplete="off" value="{{ $data->vendor_name ?? old('vendor_name') }}" required>
            <span>(required)</span>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="no_ktp" class="color-theme form-label-always-active">No.Ktp</label>
            <input name="no_ktp" type="text" class="form-control rounded-xs" id="no_ktp" placeholder="No.Ktp" autocomplete="off" value="{{ $data->no_ktp ?? old('no_ktp') }}" required>
            <span>(required)</span>
          </div>
        </div>
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="tgl_lahir" class="color-theme form-label-always-active">Tgl.Lahir</label>
            <input name="tgl_lahir" type="text" class="form-control rounded-xs" id="tgl_lahir" placeholder="Tgl.Lahir" autocomplete="off" value="{{ $data->tgl_lahir ?? old('tgl_lahir') }}" required>
            <span>(required)</span>
          </div>
        </div>
      </div>
      
      <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
        <i class="bi bi-textarea font-13"></i>
        <label for="alamat_pelanggan" class="color-theme form-label-always-active">Alamat Instalasi</label>
        <textarea name="alamat_pelanggan" class="form-control rounded-xs" id="alamat_pelanggan" placeholder="Alamat Pelanggan" autocomplete="off" required>{{$data->alamat_pelanggan ?? old('alamat_pelanggan')}}</textarea>
        <span>(required)</span>
      </div>
      
      <div class="row">
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="kelurahan" class="color-theme form-label-always-active">Kelurahan</label>
            <input name="kelurahan" type="text" class="form-control rounded-xs" id="kelurahan" placeholder="Kelurahan" autocomplete="off" value="{{ $data->kelurahan ?? old('kelurahan') }}" required>
            <span>(required)</span>
          </div>
        </div>
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="kecamatan" class="color-theme form-label-always-active">Kecamatan</label>
            <input name="kecamatan" type="text" class="form-control rounded-xs" id="kecamatan" placeholder="Kecamatan" autocomplete="off" value="{{ $data->kecamatan ?? old('kecamatan') }}" required>
            <span>(required)</span>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="kota" class="color-theme form-label-always-active">Kota</label>
            <input name="kota" type="text" class="form-control rounded-xs" id="kota" placeholder="Kota" autocomplete="off" value="{{ $data->kota ?? old('kota') }}" required>
            <span>(required)</span>
          </div>
        </div>
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="service" class="color-theme form-label-always-active">Service</label>
            <select name="service" class="form-select rounded-xs" id="service" required>
              <option value="">Select</option>
              <option value="FIBER 20">FIBER 20</option>
              <option value="FIBER 50">FIBER 50</option>
              <option value="FIBER 100">FIBER 100</option>
              <option value="FIBER PRO 100">FIBER PRO 100</option>
            </select>
            <span>(required)</span>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="jenis_bangunan" class="color-theme form-label-always-active">Jenis Bangunan</label>
            <input name="jenis_bangunan" type="text" class="form-control rounded-xs" id="jenis_bangunan" placeholder="Jenis Bangunan" autocomplete="off" value="{{ $data->jenis_bangunan ?? old('jenis_bangunan') }}" required>
            <span>(required)</span>
          </div>
        </div>
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="building_status" class="color-theme form-label-always-active">Building Status</label>
            <select name="building_status" class="form-select rounded-xs" id="building_status" required>
              <option value="">Select</option>
              <option value="PEMILIK">PEMILIK</option>
              <option value="SEWA">SEWA</option>
            </select>
            <span>(required)</span>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="install_date" class="color-theme form-label-always-active">Install date</label>
            <input name="install_date" type="text" class="form-control rounded-xs" id="install_date" placeholder="Install date" autocomplete="off" value="{{ $data->install_date ?? old('install_date') }}" required>
            <span>(required)</span>
          </div>
        </div>
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="jam" class="color-theme form-label-always-active">Jam</label>
            <select name="jam" class="form-select rounded-xs" id="jam" required>
              <option value="">Select</option>
              <option value="09.00-11.00">09.00-11.00</option>
              <option value="11.00-13.00">11.00-13.00</option>
              <option value="13.00-15.00">13.00-15.00</option>
              <option value="15.00-17.00">15.00-17.00</option>
            </select>
            <span>(required)</span>
          </div>
        </div>
      </div>
      
      
      <div class="row">
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="router" class="color-theme form-label-always-active">Router</label>
            <select name="router" class="form-select rounded-xs" id="router" required>
              <option value="0">0</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
            <span>(required)</span>
          </div>
        </div>
        <div class="col-6">
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="stb" class="color-theme form-label-always-active">STB</label>
            <select name="stb" class="form-select rounded-xs" id="stb" required>
              <option value="0">0</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
            <span>(required)</span>
          </div>
        </div>
      </div>
      <?php
        $photos = ["rumah","ktp","formulir"];
        $relationId = $data->relation_id ?? 'default_relation_id';
      ?>

      <div class="row text-center mb-3">
        @foreach($photos as $p)
          <?php

            $path = "/storage/".$relationId."/evidence_".$p;
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
          <div class="col text-center photos">
            <div class="form-custom input-photos">
              <img id="evidence_{{$p}}" src="{{ $thumb }}" class="rounded-l evidence_show" />
              <p>Photo {{ ucfirst($p) }}</p>
            </div>
            <input type="file" name="evidence_{{$p}}" class="upload_file d-none" accept="image/*" required>
            <a href="#" class="btn gradient-blue shadow-bg shadow-bg-s btn-camera"><i class="bi-camera-fill"></i></a>
          </div>
        @endforeach
        
      </div>
      <!-- <h4>Upload Foto Rumah</h4>
      <p class="mb-0">
          Use image with geotag.
      </p>
      <div class="file-data mb-3">
        <img id="image-data" src="/mobile/images/empty.png" class="img-fluid rounded-s" alt="img">
        <p class="mb-0" id="result"></p>
        <span class="upload-file-name d-block text-center" data-text-before="<i class='bi bi-check-circle-fill color-green-dark pe-2'></i> Image:" data-text-after=" is ready.">
        </span>
        <div>
          <input id="imageInput" type="file" name="evidence" class="upload-file" accept="image/*" required>
          <p class="color-theme btn btn-full btn-m rounded-s gradient-mint border-green-dark shadow-bg shadow-bg-xs no-click">Upload Image</p>
        </div>
      </div> -->
      <!-- 
      <div class="divider mt-4"></div> -->
      @if($data && $data->status_id>=1)
        @if($data->status_id == 1 && session('auth') && in_array(session('auth')->role_user, [1, 4]))
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="status" class="color-theme form-label-always-active">Status</label>
            <select name="status" class="form-select rounded-xs" id="status" required>
              <option value="">Select</option>
              <option value="2">Approve</option>
            </select>
          </div>
          <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
            <i class="bi bi-textarea font-13"></i>
            <label for="catatan" class="color-theme form-label-always-active">Catatan</label>
            <textarea name="catatan" class="form-control rounded-xs" id="catatan" placeholder="Catatan" autocomplete="off"></textarea>
          </div>
        @endif
        @if($data->status_id==2 && session('auth') && in_array(session('auth')->role_user, [1, 5]))
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="status" class="color-theme form-label-always-active">Status</label>
            <select name="status" class="form-select rounded-xs" id="status" required>
              <option value="">Select</option>
              <option value="3">Approve</option>
            </select>
          </div>
          <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
            <i class="bi bi-textarea font-13"></i>
            <label for="catatan" class="color-theme form-label-always-active">Catatan</label>
            <textarea name="catatan" class="form-control rounded-xs" id="catatan" placeholder="Catatan" autocomplete="off"></textarea>
          </div>
        @endif
        @if($data->status_id > 2 && session('auth') && in_array(session('auth')->role_user, [1, 2]))
          <div class="form-custom form-label form-border mb-3 bg-transparent">
            <label for="status" class="color-theme form-label-always-active">Status</label>
            <select name="status" class="form-select rounded-xs" id="status" required>
              <option value="">Select</option>
              <option value="7">Problem Input</option>
              <option value="4">Problem Install</option>
              <option value="5">Proses Install</option>
              <option value="6">Online</option>
            </select>
          </div>
          <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
            <i class="bi bi-textarea font-13"></i>
            <label for="catatan" class="color-theme form-label-always-active">Catatan</label>
            <textarea name="catatan" class="form-control rounded-xs" id="catatan" placeholder="Catatan" autocomplete="off"></textarea>
          </div>
        @endif
      @endif
      <div class="form-check form-check-custom">
        <input name="t_c" class="form-check-input" type="checkbox" name="type" value="1" id="c2a" required>
        <label class="form-check-label font-12" for="c2a">I agree with the <a href="#">Terms and Conditions</a>.</label>
        <i class="is-checked color-highlight font-13 bi bi-check-circle-fill"></i>
        <i class="is-unchecked color-highlight font-13 bi bi-circle"></i>
      </div>
      <a id="button_submit" href="#" class="btn btn-full gradient-highlight shadow-bg shadow-bg-s mt-4">Save</a>
    </form>
    <div class="progress mt-3" id="progress-container" style="display: none;">
      <div
        class="progress-bar"
        id="progress-bar"
        role="progressbar"
        style="width: 0%"
        aria-valuenow="0"
        aria-valuemin="0"
        aria-valuemax="100"
      ></div>
    </div>

  </div>
</div>
@if(count($logs))
  <div class="card card-style">
    <div class="content">
      <h4>Log History</h4>
      <div class="mt-3"></div>
      <table class="table color-theme ">
        <tr>
          <th>#</th>
          <th>Status</th>
          <th>Catatan</th>
          <th>Update By</th>
          <th>Date</th>
        </tr>
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
@endif
@endif
@endsection

@section('offcanvas')
@endsection
@section('js')
  <script src="/mobile/plugins/rolldate/dist/rolldate.min.js"></script>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  @if(Session::has('alerts'))
    <script type="text/javascript">
      var autoActivates = new bootstrap.Offcanvas(document.getElementsByClassName('alert-auto-activate')[0])
      autoActivates.show();
    </script>
  @endif
  <script src="https://cdn.jsdelivr.net/npm/exifr/dist/lite.umd.js"></script>

  <script type="text/javascript">
    $(document).ready(function () {
      var data_pelanggan = <?= json_encode($data); ?>;
      
      const markerClusterGroup = L.markerClusterGroup();
      let map, marker, markerHomepass;
      let sector = <?= json_encode($sector); ?>;
      let koordinatPelanggan = '';
      let selectedIsp = '';
      let selectedPaket = '';
      let selectedOdp = '';

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

      if (data_pelanggan) {
          koordinatPelanggan = data_pelanggan.koordinat_pelanggan;
          selectedPaket = data_pelanggan.paket_id;
          selectedOdp = data_pelanggan.odp_id;
          $('#isp').val(data_pelanggan.isp_id).trigger('change');
          $('#service').val(data_pelanggan.service).trigger('change');
          $('#building_status').val(data_pelanggan.building_status).trigger('change');
          $('#jam').val(data_pelanggan.jam).trigger('change');
          $('#router').val(data_pelanggan.router).trigger('change');
          $('#stb').val(data_pelanggan.stb).trigger('change');
          $('#paket').append(`<option value="${data_pelanggan.paket_id}" selected>${data_pelanggan.paket_name}</option>`);
          $('#odp').append(`<option value="${data_pelanggan.odp_id}" selected>${data_pelanggan.odp_name}</option>`);
          console.log(data_pelanggan.paket_id);
      }else{
        getDeviceLocation();
      }
      handleCoordinateInput();
      // Define marker sizes
      
      new Rolldate({
          el: '#tgl_lahir',
          format: 'YYYY-MM-DD',
          beginYear: 1945,
          lang: {
              title: 'Select Tgl Lahir',
              cancel: 'Cancel',
              confirm: 'Confirm',
          },
          confirm: function (date) {
              console.log('Selected date:', date);
          }
      });

      new Rolldate({
          el: '#install_date',
          format: 'YYYY-MM-DD',
          lang: {
              title: 'Select Tgl Install',
              cancel: 'Cancel',
              confirm: 'Confirm',
          },
          confirm: function (date) {
              console.log('Selected date:', date);
          }
      });

      function checkAndSubmit() {
          if (koordinatPelanggan && selectedIsp) {
              $.post('/ajax/get_odp', {
                  koordinat: koordinatPelanggan,
                  id_isp: selectedIsp
              })
              .done(function (response) {

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
                        deleteAllMarkerHomepass();
                        response.homepassed.forEach(function (hp) {
                          $homepassSelect.append(
                              `<option value="${hp.id_homepass}">${hp.id_homepass} (${hp.distance_in_meters} m)</option>`
                          );
                          addOrUpdateMarker(hp.latitude, hp.longitude, hp.id_homepass, hp.id_homepass);
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


      

      function getDeviceLocation() {
              if (navigator.geolocation) {
                  navigator.geolocation.getCurrentPosition(function (position) {
                      let latitude = position.coords.latitude;
                      let longitude = position.coords.longitude;
                      $('#koordinat_pelanggan').val(latitude + ',' + longitude);
                      $('#map').show();
                      updateMap(latitude, longitude);
                  }, function (error) {
                      alert('Error getting device location: ' + error.message);
                  });
              } else {
                  alert('Geolocation is not supported by your browser.');
              }
         
      }

      function updateMap(latitude, longitude) {
          if (!map) {

              // Add the cluster group to the map
              map.addLayer(markerClusterGroup);
              map = L.map('map').setView([latitude, longitude], 17);
              sector.forEach(function (polygonData) {
                  var polygonCoordinates = JSON.parse(polygonData.polygons);
                  var latLngs = polygonCoordinates.map(coord => [parseFloat(coord[0]), parseFloat(coord[1])]);
                  L.polygon(latLngs, { color: 'blue', fillColor: '#f2f2f2', fillOpacity: 0.5 }).addTo(map);
              });
              L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                  attribution: '&copy; OpenStreetMap contributors'
              }).addTo(map);
              map.on('click', function (e) {
                  let lat = e.latlng.lat;
                  let lng = e.latlng.lng;
                  if (marker) {
                      marker.setLatLng([lat, lng]);
                  } else {
                      marker = L.marker([lat, lng]).addTo(map).bindPopup('Koordinat Pelanggan').openPopup();
                  }
                  koordinatPelanggan = lat + ',' + lng;
                  $('#koordinat_pelanggan').val(lat + ',' + lng);
                  checkAndSubmit();
              });
          } else {
              map.setView([latitude, longitude], 17);
          }

          if (marker) {
              marker.setLatLng([latitude, longitude]);
          } else {
              marker = L.marker([latitude, longitude]).addTo(map).bindPopup('Koordinat Pelanggan').openPopup();
          }
          koordinatPelanggan = latitude + ',' + longitude;
          checkAndSubmit();
      }

      function addOrUpdateMarker(lat, lng, markerId, popupText) {
          const markerSizes = {
              small: [20, 32],
              medium: [30, 48],
              large: [40, 64]
          };

          // Get the size dimensions
          const [iconWidth, iconHeight] = markerSizes['small'];

          // Create a custom icon
          const customIconHome = L.icon({
              iconUrl: `/images/location_home.png`, // Replace with your marker icon URL
              iconSize: [iconWidth, iconHeight], // Size of the icon
              iconAnchor: [iconWidth / 2, iconHeight], // Anchor point
              popupAnchor: [0, -iconHeight / 2] // Popup position relative to the icon
          });

          if (markerHomepass[markerId]) {
              // Update existing marker
              markerHomepass[markerId]
                  .setLatLng([lat, lng])
                  .setIcon(customIconHome)
                  .setPopupContent(popupText)
                  .openPopup();
          } else {
              // Add new marker
              const newMarker = L.marker([lat, lng], { icon: customIconHome }).bindPopup(popupText);
              markerClusterGroup.addLayer(newMarker); // Add marker to cluster group
              markerHomepass[markerId] = newMarker;
          }
      }

      function deleteAllMarkerHomepass() {
          // Remove all markers from the cluster group
          markerClusterGroup.clearLayers();
          // Clear the markerHomepass object
          markerHomepass = {};
      }

      function handleCoordinateInput() {
          let koordinat = $('#koordinat_pelanggan').val();
          let coords = koordinat.split(',').map(item => parseFloat(item.trim()));
          if (coords.length === 2 && !isNaN(coords[0]) && !isNaN(coords[1])) {
              $('#map').show();
              updateMap(coords[0], coords[1]);
          }
      }

      $('#koordinat_pelanggan').on('paste', function () {
          setTimeout(handleCoordinateInput, 100);
      }).on('blur', handleCoordinateInput);

      

      $('.btn-camera').on('click', function (e) {
          e.preventDefault();
          $(this).closest('.photos').find('.upload_file').click();
      });

      $('input[type=file]').on('change', function () {
          let file = this.files[0];
          let wrapper = $(this).closest('.photos').find('.evidence_show')[0];
          if (file) {
              let reader = new FileReader();
              reader.onload = function (event) {
                  wrapper.src = event.target.result;
              };
              reader.readAsDataURL(file);
          }
      });
  });

  </script>
  <script type="text/javascript">
    $(document).ready(function () {
      // Extend jQuery Validation to include a regex rule

      $.validator.addMethod("regexp", function (value, element, param) {
          return this.optional(element) || param.test(value);
      }, "Invalid format.");

      // Initialize validation on the form
      $("#form").validate({
          errorElement: "div",
          errorContainer: $(".invalid-feedback"),
          success: function(label) {
              label.text("ok!").addClass("d-none");
          },
          rules: {
              // Koordinat Pelanggan (latitude, longitude)
              'koordinat_pelanggan': {
                  required: true, // Field is required
                  regexp: /^-?([1-8]?\d(\.\d+)?|90(\.0+)?),-?(1[0-7]\d(\.\d+)?|180(\.0+)?|\d{1,2}(\.\d+)?)$/, // Regex for latitude, longitude without spaces
              },
              // Nama Pelanggan
              'nama_pelanggan': {
                  required: true, // Field is required
                  minlength: 2 // Minimum length of 2 characters
              },
              'email': {
                  required: true, // Field is required
                  minlength: 2 // Minimum length of 2 characters
              },
              'paket': {
                  required: true, // Field is required
                  minlength: 1 // Minimum length of 2 characters
              },
              'odp': {
                  required: true, // Field is required
                  minlength: 1 // Minimum length of 2 characters
              },
              // Telepon Pelanggan (phone number validation)
              'telp_pelanggan': {
                  required: true, // Field is required
                  digits: true, // Must be digits only
              },
              // Alamat Pelanggan
              'alamat_pelanggan': {
                  required: true, // Field is required
                  minlength: 5 // Minimum length of 5 characters
              },
              // Evidence (file upload validation)
              'evidence': {
                  required: true, // File upload is required
              }
          },
          messages: {
              'koordinat_pelanggan': {
                  required: "Please enter coordinates.",
                  regex: "Coordinates must be in the format 'latitude, longitude'. Example: -3.317217955165058,114.58523699702049"
              },
              'nama_pelanggan': {
                  required: "Nama pelanggan is required.",
                  minlength: "Nama pelanggan must be at least 2 characters long."
              },
              'email': {
                  required: "Email is required.",
                  minlength: "Email must be at least 2 characters long."
              },
              'paket': {
                  required: "Paket is required.",
                  minlength: "Paket must be at least 2 characters long."
              },
              'odp': {
                  required: "odp is required.",
                  minlength: "odp must be at least 2 characters long."
              },
              'telp_pelanggan': {
                  required: "Telephone number is required.",
                  digits: "Please enter a valid phone number.",
                  minlength: "Telephone number must be at least 10 digits.",
                  maxlength: "Telephone number cannot exceed 13 digits."
              },
              'alamat_pelanggan': {
                  required: "Alamat pelanggan is required.",
                  minlength: "Alamat pelanggan must be at least 5 characters long."
              },
              'evidence': {
                  required: "Please upload an evidence file.",
                  extension: "Only JPG, JPEG, and PNG files are allowed.",
                  filesize: "File size must be less than 5MB."
              }
          }
      });

      var button_submit = document.querySelector("#button_submit");
      button_submit.addEventListener("click", function(e) {
        e.preventDefault();
        if ($("#form").valid()) {
            button_submit.style.display = "none";
            $("#form").submit();
        }else{
          alert('Ada inputan blm terisi!');
        }
      });
    });
  </script>
@endsection
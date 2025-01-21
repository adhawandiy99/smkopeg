@extends('mobile')

@section('css')
<style type="text/css">
  #search_result {
    max-height: 400px; /* Set the maximum height */
    overflow-y: auto;  /* Enable vertical scrolling */
    overflow-x: hidden; /* Optional: Hide horizontal scrollbar if not needed */
    border: 1px solid #ddd; /* Optional: Add border for better visual separation */
  }
</style>
@endsection

@section('tittle', 'Order List')

@section('content')
<div class="mt-3"></div>
<div class="card card-style">
  <div class="content">
    @php
      $no = 0;
    @endphp
    @foreach($data as $d)
      @if($no)
        <div class="divider my-2 opacity-75"></div>
      @endif
      <a href="/form_order/{{ $d->id_master_order }}" class="d-flex py-1 mb-2">
        <div class="align-self-center">
          <h5 class="pt-1 mb-n1">{{ $d->nama_pelanggan }}</h5>
          <p class="mb-0 font-11 opacity-70">{{ $d->create_at }}</p>
        </div>
        <div class="align-self-center ms-auto text-end">
          <h4 class="pt-1 mb-n1">{{ $d->isp_name }}</h4>
          <p class="mb-0 font-11 opacity-70">{{ $status[$d->status_id]->nama_status }}</p>
        </div>
      </a>
      @php
        $no++;
      @endphp
    @endforeach
  </div>
</div>
@endsection

@section('offcanvas')
<div id="input_wo" class="offcanvas offcanvas-bottom offcanvas-detached rounded-m" aria-hidden="true">
  <div class="menu-size">
    <div class="content">
      <a href="#" class="d-flex py-1 pb-4">
        <div class="align-self-center ps-1">
          <h5 class="pt-1 mb-n1">Input WO</h5>
          <p class="mb-0 font-11 opacity-70 nama_pelanggan"></p>
        </div>
        <div class="align-self-center ms-auto text-end">
          <h4 class="pt-1 font-14 mb-n1 color-yellow-dark">Need WO progress PS</h4>
          <p class="mb-0 font-11 id_transaksi"></p>
        </div>
      </a>
      <div class="form-custom form-label form-icon mt-3 position-relative">
        <i class="bi bi-person-circle font-14"></i>
        <input type="text" name="q" class="form-control rounded-xs" id="q" placeholder="type at least 5 words">
        <label for="q" class="form-label-always-active color-theme font-11 form-label-active">Search Customer Name</label>

        <a href="#" id="search" class="btn btn-s btn-full btn-link position-absolute top-0 end-0 mt-2 me-2 gradient-green">Search</a>
      </div>
      <form id="form" method="post" action="/input_pi">
        <input name="id_master_order" id="hidden_id_master_order" type="hidden" />
        <div class="list-group list-custom list-group-m rounded-xs" id="search_result">
          
        </div>
      </form>
      <div class="row mt-4">
        <div class="col-6">
          <a href="#" id="submit_input_wo" class="btn btn-s btn-full gradient-green shadow-bg shadow-bg-xs">Save</a>
        </div>
        <div class="col-6">
          <a href="#" data-bs-dismiss="offcanvas" class="btn btn-s btn-full gradient-blue shadow-bg shadow-bg-xs">Close</a>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="order_detil" class="offcanvas offcanvas-bottom offcanvas-detached rounded-m" aria-hidden="true">
  <div class="menu-size">
    <div class="d-flex mx-3 mt-3 py-1">
      <div class="align-self-center">
        <h1 class="mb-0">Order Detail</h1>
      </div>
      <div class="align-self-center ms-auto">
        <a href="#" class="ps-4 shadow-0 me-n2" data-bs-dismiss="offcanvas">
          <i class="bi bi-x color-red-dark font-26 line-height-xl"></i>
        </a>
      </div>
    </div>
    <div class="divider divider-margins mt-3 mb-2"></div>
    <div class="content mt-0">
      <div class="d-flex">
        <h5 class="mb-0 font-600 font-14">ID Transaksi</h5>
        <h5 id="id_transaksi" class="mb-0 ms-auto font-700 font-14"></h5>
      </div>
      <div class="divider my-2"></div>
      <div class="d-flex">
        <h5 class="mb-0 font-600 font-14">Nama</h5>
        <h5 id="nama_pelanggan" class="mb-0 ms-auto font-600 font-14"></h5>
      </div>
      <div class="divider my-2"></div>
      <div class="d-flex">
        <h5 class="mb-0 font-600 font-14">Alamat</h5>
        <h5 id="alamat_pelanggan" class="mb-0 ms-auto font-600 font-14"></h5>
      </div>
      <div class="divider my-2"></div>
      <div class="d-flex">
        <h5 class="mb-0 font-600 font-14">Telp</h5>
        <h5 id="telp_pelanggan" class="mb-0 ms-auto font-600 font-14"></h5>
      </div>
      <div class="divider my-2"></div>
      <div class="d-flex">
        <h5 class="mb-0 font-600 font-14">Koordinat</h5>
        <h5 id="koordinat_pelanggan" class="mb-0 ms-auto font-600 font-14"></h5>
      </div>
      <div class="divider my-2"></div>
      <div class="d-flex">
        <h5 class="mb-0 font-600 font-14">Date</h5>
        <h5 id="date" class="mb-0 ms-auto font-600 font-14"></h5>
      </div>
      <div class="divider my-2"></div>
      <div class="d-flex">
        <h5 class="mb-0 font-600 font-14">Status</h5>
        <h5 id="status" class="mb-0 ms-auto font-700 font-14"></h5>
      </div>
      <div class="divider my-2"></div>
      <div class="d-flex">
        <h5 class="mb-0 font-600 font-14">Report Date</h5>
        <h5 id="report_date" class="mb-0 ms-auto font-600 font-14"></h5>
      </div>
      <div class="divider my-2"></div>
        <div class="row mt-5">
          <div class="col-12">
            <a href="#" data-bs-dismiss="offcanvas" class="btn btn-s btn-full gradient-blue shadow-bg shadow-bg-xs">Close</a>
          </div>
        </div>
    </div>

  </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
  $(document).ready(function () {
  });
</script>
@endsection
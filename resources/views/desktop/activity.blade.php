@extends('desktop')
@section('css')

@endsection
@section('tittle', 'ORDER LIST')
@section('content')
	
<div class="col-xl">
  <div class="card card-xl-stretch mb-5 mb-xl-8">
    <div class="card-header border-0 pt-5">
      <h3 class="card-title align-items-start flex-column">
        <span class="card-label fw-bolder fs-3 mb-1">{{ strtoupper(str_replace('_', ' ', Request::segment(1))) }}</span>
        <!-- <span class="text-muted mt-1 fw-bold fs-7">Over 500 members</span> -->
      </h3>
      <div class="card-toolbar">
        <!-- <a href="/starting/form" class="btn btn-sm btn-light btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click to add LOPs">
          <i class="ki-duotone ki-plus fs-2"></i> Input Order
        </a> -->
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table align-middle table-row-dashed fs-6 gy-1 dataTable no-footer" id="kt_subscriptions_table">
          <thead>
            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
              <th>#</th>
              <th>ID Transaksi</th>
              <th>Nama Calang</th>
              <th>No. Telp.</th>
              <th>Koordinat</th>
              <th>TL</th>
              <th>SPV</th>
              <th>Status</th>
              <th>Date Input</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          	@php
			  $no = 0;
			@endphp
            @foreach($data as $l)
            	<tr>
	              <td>{{ ++$no }}</td>
	              <td>{{ $l->relation_id }}</td>
	              <td>{{ $l->nama_pelanggan }}</td>
	              <td>{{ $l->no_telp_pelanggan }}</td>
	              <td>{{ $l->koordinat_pelanggan }}</td>
	              <td>{{ $l->tl_nik }} : {{ $l->tl_name }}</td>
	              <td>{{ $l->spv_nik }} : {{ $l->spv_name }}</td>
	              <td>{{ $status[$l->status_id]->nama_status }}</td>
	              <td>{{ $l->create_at }}</td>
	              <td class="text-end">
	              	<!--(!$l->workorder && $l->status == 5) -->
		                <a href="/form_order/{{ $l->id_master_order }}" class="btn btn-icon btn-flex btn-light-primary w-30px h-30px me-3 button_single">
		                  <i class="ki-duotone ki-notepad-edit fs-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Update Status">
		                    <span class="path1"></span>
		                    <span class="path2"></span>
		                  </i>
		                </a>
	                <!--  -->
	                <!-- <a class="btn btn-icon btn-flex btn-light-primary w-30px h-30px me-3 button_single" data-bs-id_master_order="{{ $l->id_master_order }}" data-bs-lop_name="{{ $l->relation_id }}" data-bs-toggle="modal" data-bs-target="#modal_detil">
	                  <i class="ki-duotone ki-eye fs-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Detail Order">
	                    <span class="path1"></span>
	                    <span class="path2"></span>
	                    <span class="path3"></span>
	                  </i>
	                </a> -->
	              </td>
	            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
@section('modal')
<!--   <div class="modal fade" tabindex="-1" id="modal_pi">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Form Input Wo PI <span class="id_transaksi"></span> <span class="nama_pelanggan"></span></h5>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <span class="svg-icon svg-icon-2x"></span>
          </div>
        </div>
        <div class="modal-body">
          <form id="form" method="post" action="/input_pi">
          	<input name="id_master_order" id="hidden_id_master_order" type="hidden" />
            <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
			  <label class="d-flex align-items-center fs-6 fw-bold mb-2">
			    <span class="required">Nama Pelanggan</span>
			  </label>

			  <div class="input-group">
			    <input type="text" class="form-control form-control-solid" placeholder="Input at least 5 characters" name="q" id="q">
			    <button type="button" class="btn btn-primary" id="search">Search</button>
			  </div>

			  <div class="fv-plugins-message-container invalid-feedback"></div>
			</div>
			<div class="list-group list-custom list-group-m rounded-xs overflow-auto" id="search_result" style="max-height: 300px;">
          
		</div>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="submit">Submit</button>
        </div>
      </div>
    </div>
  </div> -->
@endsection
@section('js')
<script type="text/javascript">
	$(document).ready(function () {
		var data = <?= json_encode($data); ?>;
		$('#modal_pi').on('shown.bs.modal', function(e) {
			var triggerElement = $(e.relatedTarget);
      var idMasterOrder = triggerElement.data('bs-id_master_order');
      console.log('ID Master Order:', idMasterOrder);
      $(".id_transaksi").text(data[idMasterOrder].relation_id);
      $("#hidden_id_master_order").val(data[idMasterOrder].id_master_order);
      $(".nama_pelanggan").text(data[idMasterOrder].nama_pelanggan);
		});
		$('#search').click(function(e){
			var q = $('#q').val();

      if (q.length < 5) {
        alert("Please enter at least 5 characters.");
        return false; // Prevent further execution
      }
      var param = {
        table: 'wmcr_source_bima',
        method: 'getAllCondition',
        condition: JSON.stringify({ Customer_Name: '%'+q+'%' }) // Ensure condition is JSON encoded
      };
      var url = 'https://wmpro.tomman.app/API/get?' + $.param(param);
      $.get(url, function(response) {
        // Handle the success response here
        if(response.data && response.data.length){
          $.each(response.data, function(index, item) {
            var listItem = `
            <a href="#" class="list-group-item d-flex align-items-center" data-trigger-switch="switch-${index}">
					    <i class="bi color-blue-dark bi-gear-fill fs-4 me-2"></i>
					    <div class="flex-grow-1">
				        <strong>${item.Customer_Name || 'List Item ' + (index + 1)}</strong>
				        <span class="text-muted">${(item.SC_Order_No_Track_ID_CSRM_No ? item.SC_Order_No_Track_ID_CSRM_No.split('~')[0] : 'List item description')}</span>
					    </div>
					    <div class="form-check form-switch">
				        <input type="radio" name="wo" value="${item.Workorder}" class="form-check-input" id="switch-${index}">
				        <label class="form-check-label" for="switch-${index}">
				        </label>
					    </div>
						</a>
						`;
            // Append the list item to a container
            $('#search_result').append(listItem);
          });
        }else{
          alert("no data found.");
          return false; // Prevent further execution
        }
        console.log(response);
      })
      .fail(function(error) {
        // Handle the error response here
        alert("Error ajax:", error);
      });

			
		});
		$('#submit').click(function(e){
			e.preventDefault();
      $("#form").submit();
		});
	});
</script>
@endsection
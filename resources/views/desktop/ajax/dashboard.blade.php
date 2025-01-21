<div class="row g-5 mb-5">
	<div class="col-lg-12">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr class="fw-bold fs-6 text-gray-800">
						<th class="text-center">#</th>
						<th class="text-center">ID</th>
						<th class="text-center">Date</th>
						<th class="text-center">GSM 1</th>
						<th class="text-center">GSM 2</th>
						<th class="text-center">Nama Pelanggan</th>
						<th class="text-center">ISP</th>
						<th class="text-center">Paket</th>
						<th class="text-center">ODP</th>
						<th class="text-center">Alamat</th>
						<th class="text-center">Status Rekon</th>
					</tr>
				</thead>
				<tbody>
					@foreach($data as $no => $d)
						<tr>
							<td class="align-middle">{{ ++$no }}</td>
							<td class="align-middle">{{ $d->relation_id }}</td>
							<td class="align-middle">{{ $d->create_at }}</td>
							<td class="align-middle">{{ $d->no_telp_pelanggan }}</td>
							<td class="align-middle">{{ $d->telp_pelanggan_alt }}</td>
							<td class="align-middle">{{ $d->nama_pelanggan }}</td>
							<td class="align-middle">{{ $d->isp_name }}</td>
							<td class="align-middle">{{ $d->paket_name }}</td>
							<td class="align-middle">{{ $d->odp_name }}</td>
							<td class="align-middle">{{ $d->alamat_pelanggan }}</td>
							<td>
								@if($d->status_id == 6)
								<select name="status_rekon" class="form-select status_rekon" data-control="select2" data-placeholder="Status Rekon" data-allow-clear="true" data-hide-search="true" data-order_id="{{ $d->id_master_order }}">
				                    <option></option>
				                    <option value="1" {{ $d->status_rekon == 1?'selected':'' }}>Approve</option>
				                    <option value="2" {{ $d->status_rekon == 2?'selected':'' }}>Hold</option>
				                    <option value="3" {{ $d->status_rekon == 3?'selected':'' }}>Reject</option>
			                  	</select>
			                  	@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('.status_rekon').change(function(){
			let orderId = $(this).data('order_id');
			let status_rekon = $(this).val();
			$.post('/ajax/update_status_rekon', { order_id: orderId , status_rekon: status_rekon})
            .done(function (response) {
                if(!response.success){
                	alert(response.message);
                }
            }).fail(function (error) {
                alert('Error updating data:', error.message);
            });

		});
	});
</script>
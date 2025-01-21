@extends('desktop')
@section('css')

@endsection
@section('tittle', 'Update Status Batch')
@section('content')
<div class="col-xl">
  <div class="card card-xl-stretch mb-5 mb-xl-8">
  	<div class="card-body">
  		<form id="form" class="needs-validation" method="post" novalidate>
        <div class="row g-3">
      		<div class="col-6">
            <div class="mb-3 fv-row">
              <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
              <select name="status" class="form-select" data-control="select2" data-placeholder="Select Status" data-allow-clear="true" data-hide-search="true" id="status">
                <option></option>
                <option value="rekon_1">Rekon Approve</option>
                <option value="rekon_2">Rekon Hold</option>
                <option value="rekon_3">Rekon Reject</option>
                <option value="curn_1">Curn/Cabut</option>
              </select>
              <div class="invalid-feedback">Please provide a Status.</div>
            </div>
          </div>
          <div class="col-6">
            <div class="mb-3 fv-row">
              <label for="tgl_status" class="form-label">Tgl Status <span class="text-danger">*</span></label>
              <input name="tgl_status" type="text" class="form-control" id="tgl_status" placeholder="Status Date" autocomplete="off" value="{{ $data->tgl_status ?? old('tgl_status') }}">
              <div class="invalid-feedback">Please provide a Status Date.</div>
            </div>
          </div>
        </div>
        <div class="col">
    			<div class="mb-3 fv-row">
			        <label for="paste" class="form-label">
			            Paste Excel
			            <span class="text-danger">*</span>
			        </label>
			        <textarea name="paste" class="form-control" id="paste" placeholder="ID Transaksi" autocomplete="off" required>{{ $data->paste ?? old('paste') }}</textarea>
			        <div class="invalid-feedback">Please provide a valid paste from excel.</div>
			    </div>
			    
			    <button type="submit" id="button_submit" class="btn btn-full btn-success">Submit</button>
			  </div> 
			</form>
  	</div>
  </div>
</div>
@endsection
@section('modal')
@endsection
@section('js')
<script type="text/javascript">
  $("#tgl_status").flatpickr();
</script>
@endsection
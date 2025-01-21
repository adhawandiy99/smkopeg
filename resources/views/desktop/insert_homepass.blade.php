@extends('desktop')
@section('css')

@endsection
@section('tittle', 'Insert Homepass')
@section('content')
<div class="col-xl">
  <div class="card card-xl-stretch mb-5 mb-xl-8">
  	<div class="card-body">
  		<form id="form" class="needs-validation" method="post" novalidate>
    		<div class="col">
          <div class="mb-3 fv-row">
            <label for="isp" class="form-label">ISP <span class="text-danger">*</span></label>
            <select name="isp" class="form-select" data-control="select2" data-placeholder="Select ISP" data-allow-clear="true" data-hide-search="true" id="isp">
              <option></option>
              @foreach($isp as $t)
                <option value="{{$t->id_isp}}">{{$t->nama_isp}}</option>
              @endforeach
            </select>
            <div class="invalid-feedback">Please provide an ISP.</div>
          </div>
    			<div class="mb-3 fv-row">
			        <label for="paste" class="form-label">
			            Paste Homepass
			            <span class="text-danger">*</span>
			        </label>
			        <textarea name="paste" class="form-control" id="paste" placeholder="homepass_id|homepass_koordinat|region|sub_region|provinsi|kota|kecamatan|kelurahan|kode_pos|resident_name|nama_jalan_|no_rumah_gedung|unit|resident_category|homepass_status|resident_type" autocomplete="off" required>{{ $data->paste ?? old('paste') }}</textarea>
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
@endsection
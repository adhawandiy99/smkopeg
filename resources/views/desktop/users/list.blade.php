@extends('desktop')
@section('css')

@endsection
@section('tittle', 'Users')
@section('content')
<div class="col-xl">
  @if(session('auth')->role_user == 1)
  	<div class="card shadow-lg">
      <div class="card-body">
  		  <div class="table-responsive">
  		    <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="kt_subscriptions_table">
  		      <thead>
  		        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
  		          <th>#</th>
  		          <th>Nik</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Chat ID</th>
                <th>State</th>
                <th>Actions</th>
  		        </tr>
  		      </thead>
  		      <tbody>
              @foreach($list as $no => $l)
                <tr>
                  <td>{{ ++$no }}</td>
                  <td>{{ $l->username }}</td>
                  <td>{{ $l->name }}</td>
                  <td>{{ $l->email }}</td>
                  <td>{{ $l->phone }}</td>
                  <td>{{ $l->chat_id }}</td>
                  <td>{{ $l->status_user ? 'Active':'Suspend' }}</td>
                  <td class="text-end">
                    <a href="/user/{{ $l->id_user }}" class="btn btn-icon btn-flex btn-light-primary w-30px h-30px me-3 button_single">
                      <i class="ki-duotone ki-notepad-edit fs-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Single Update">
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
            <div class="fw-semibold fs-6 text-gray-500 mb-7">Only Superuser role.</div>
            <!--end::Text-->
            <!--begin::Illustration-->
            <div class="mb-3">
              <img src="/assets/media/auth/agency.png" class="mw-100 mh-300px theme-light-show" alt="">
              <img src="/assets/media/auth/agency-dark.png" class="mw-100 mh-300px theme-dark-show" alt="">
            </div>
            <!--end::Illustration-->
            <!--begin::Link-->
            <div class="mb-0">
              <a href="/" class="btn btn-sm btn-primary">Home</a>
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
@endsection
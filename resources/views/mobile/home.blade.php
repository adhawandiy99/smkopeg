@extends('mobile')

@section('css')
@endsection

@section('tittle', 'Home')

@section('content')
<?php
  $witel = $role = '';
?>
<div class="card card-style">
  <div class="content">
    <h1>Hello, {{ session('auth')->name }}</h1>
    <div class="d-flex">
      <div class="align-self-center">
        <i class="bi bi-arrow-right-circle-fill font-24 color-blue-dark font-24 color-green-dark"></i>
      </div>
      <div class="align-self-center me-auto ms-1">
        <h3>Role</h3>
      </div>
      <div class="text-end">
        <h3>{{ session('auth')->role_user?$roles[session('auth')->role_user]->role:'Not Set' }}</h3>
      </div>
    </div>
    <div class="d-flex">
      <div class="align-self-center">
        <i class="bi bi-arrow-right-circle-fill font-24 color-blue-dark font-24 color-green-dark"></i>
      </div>
      <div class="align-self-center me-auto ms-1">
        <h3>Status</h3>
      </div>
      <div class="text-end">
        <h3>{{ session('auth')->status_user == '1'?'Active':'Suspend' }}</h3>
      </div>
    </div>
  </div>
</div>
<div class="card card-style">
  <div class="content">
    

    <div class="d-flex">
      <div class="align-self-center me-auto ms-1">
        <h1>January</h1>
      </div>
      <div class="text-end">
        <h5>2025</h5>
      </div>
    </div>
    <div class="d-flex">
      <div class="align-self-center">
        <i class="bi bi-arrow-right-circle-fill font-24 color-red-dark font-24"></i>
      </div>
      <div class="align-self-center me-auto ms-1">
        <h5>Estimasi Pendapatan</h5>
      </div>
      <div class="text-end">
        <h5>$150.55</h5>
      </div>
    </div>
    <div class="d-flex">
      <div class="align-self-center">
        <i class="bi bi-arrow-right-circle-fill font-24 color-blue-dark font-24"></i>
      </div>
      <div class="align-self-center me-auto ms-1">
        <h5>Estimasi Fee</h5>
      </div>
      <div class="text-end">
        <h5>$150.55</h5>
      </div>
    </div>
    <div class="d-flex">
      <div class="align-self-center">
        <i class="bi bi-arrow-right-circle-fill font-24 color-green-dark font-24"></i>
      </div>
      <div class="align-self-center me-auto ms-1">
        <h5>Final Fee</h5>
      </div>
      <div class="text-end">
        <h5>$150.55</h5>
      </div>
    </div>
  </div>
</div>
@endsection

@section('offcanvas')
@endsection
@section('js')
@endsection

@extends('layouts.app')

@section('content')
@if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif
<form action="{{action('DevelopersController@update',$developers->id)}}" method="post" class="form-horizontal" enctype="multipart/form-data">
  @csrf
  @method('PUT')
<div class="container">
    <div style="padding: 10pt">
      <h2>
        Edit Developers
      </h2>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-2">
        <label class="control-label">First Name</label>
      </div>
      <div class="col-lg-9">
        <div class="form-group">
          <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $developers->first_name }}">
        </div>
      </div>
      <div class="col-lg-2">
        <label class="control-label">Last Name</label>
      </div>
      <div class="col-lg-9">
        <div class="form-group">
          <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $developers->last_name }}">
        </div>
      </div>
      <div class="col-lg-2">
        <label class="control-label">Email</label>
      </div>
      <div class="col-lg-9">
        <div class="form-group">
          <input type="text" class="form-control" id="email" name="email" value="{{ $developers->email }}" type="email">
        </div>
      </div>
      <div class="col-lg-2">
        <label class="control-label">Phone Number</label>
      </div>
      <div class="col-lg-9">
        <div class="form-group">
          <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $developers->phone_number }}">
        </div>
      </div>
      <div class="col-lg-2">
        <label class="control-label">Address</label>
      </div>
      <div class="col-lg-9">
        <div class="form-group">
          <input type="text" class="form-control" id="address" name="address" value="{{ $developers->address }}">
        </div>
      </div>
      <div class="col-lg-2">
        <label class="control-label">Upload Avatar</label>
      </div>
      <div class="col-lg-9">
        <strong class="pull-left" style="color:red">(Uploaded file must be in PNG)</strong><br>
      </div>
      <div class="col-lg-2">
      </div>
      <div class="col-lg-9">
        <input type="file" name="avatar" id="avatar" data-height="100" data-allowed-file-extensions="png PNG JPG jpg"/>
      </div>
    </div>
    <br>
    <div class="row justify-content-center">
      <div class="col-lg-2">
        <br>
      </div>
      <div class="col-lg-9">
        <input type="submit" value="Submit" class="btn btn-primary">
      </div>
    </div>
</div>
</form>
@endsection


@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="card-body text-left">
      <button style="margin-bottom: 10px" class="btn btn-danger delete_all" data-url="{{ url('developersDeleteAll') }}">Delete Selected</button>
    </div>
    <div class="card-body text-left">
      <h2>
        List of Developers
      </h2>
    </div>
    <div class="card-body text-right">
      <a href="{{ URL::to('developers/create') }}" class="btn btn-w-m btn-primary text-center"><i class="fas fa-sign-in-alt"></i>Create New</a href="">
    </div>

  </div>
  <table class="table table-bordered mb-5">
      <thead>
          <tr class="table-success">
              <th scope="col"><input type="checkbox" class="form-control" id="master"></th>
              <th scope="col">No.</th>
              <th scope="col">First Name</th>
              <th scope="col">Last Name</th>
              <th scope="col">Phone Number</th>
              <th scope="col">Address</th>
              <th scope="col">Email</th>
              <th scope="col" style="width: 10%"></th>
          </tr>
      </thead>
      <tbody>
          @foreach($developers as $key => $data)
          <tr id="tr_{{$data->id}}">
              <th width="50px"><input type="checkbox" class="form-control" id="sub_chk" data-id="{{$data->id}}"></th>
              <th scope="row">{{ $key+1 }}</th>
              <td>{{ $data->first_name }}</td>
              <td>{{ $data->last_name }}</td>
              <td>{{ $data->phone_number }}</td>
              <td>{{ $data->address }}</td>
              <td>{{ $data->email }}</td>
              <td>
                <a href="developers/{{$data->id}}/edit" class="btn btn-w-m btn-primary text-center" style="border-color: #ffffff00;" data-toggle="tooltip" data-original-title="Edit" title="Edit">
                  <i class="fa fa-edit"></i></a>
                <a href="developers/{{$data->id}}/destroy" id="delete" class="btn btn-w-m btn-danger text-center" style="border-color: #ffffff00;"  data-toggle="tooltip" data-original-title="Delete" title="Delete">
                  <i class="fa fa-trash"></i></a>
              </td>
          </tr>
          @endforeach
      </tbody>
  </table>
</div>
<div class="d-flex justify-content-center">
  {!! $developers->links() !!}
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
   $(document).on("click", "#delete", function (event) {
    event.preventDefault();
    const url = $(this).attr('href');
    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
      })
      .then((willDelete) => {
      if (willDelete) {
          event.preventDefault();
          window.location.href = url;
      }
    });
  });
@if(session('success'))
  swal("Deletion Success", "{{ session('success') }}","success");
@endif

@if(session('status'))
  swal("Success", "{{ session('status') }}","success");
@endif
</script>

<script>
  $(document).ready(function () {
      $('#master').on('click', function(e) {
        if($(this).is(':checked',true))
        {
          $(".form-control").prop('checked', true);
        } else {
          $(".form-control").prop('checked',false);
        }
      });
      $('.delete_all').on('click', function(e) {
        var allVals = [];
        $(".form-control:checked").each(function() {
            allVals.push($(this).attr('data-id'));
        });
        if(allVals.length <=0){
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please Select Row!',
          });
        }
        else {
          var check = swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                event.preventDefault();
                var join_selected_values = allVals.join(",");
            $.ajax({
                url: $(this).data('url'),
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: 'ids='+join_selected_values,
                success: function (data) {
                  if (data['success']) {
                      $(".form-control:checked").each(function() {
                          $(this).parents("tr").remove();
                      });
                      swal("Deletion Success", "{{ session('success') }}","success");
                  } else if (data['error']) {
                    Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Something went wrong!',
                    });
                  } else {
                    Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Something went wrong!',
                    });
                  }
                },
                error: function (data) {
                    alert(data.responseText);
                }
              });
              $.each(allVals, function( index, value ) {
                $('table tr').filter("[data-row-id='" + value + "']").remove();
              });
            }
          });
          if(check == true){
            $.each(allVals, function( index, value ) {
                $('table tr').filter("[data-row-id='" + value + "']").remove();
            });
          }
        }
      });
    });
</script>
@endpush

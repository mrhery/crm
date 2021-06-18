@extends('layouts.app')

@section('title')
    Sales Tracking
@endsection

<style>
  .card {
    overflow: hidden;
  }

  .card-block .rotate {
    z-index: 8;
    float: right;
    height: 100%;
  }

  .card-block .rotate i {
    color: rgba(20, 20, 20, 0.15);
    position: absolute;
    left: 0;
    left: auto;
    right: -10px;
    bottom: 0;
    display: block;
    -webkit-transform: rotate(-44deg);
    -moz-transform: rotate(-44deg);
    -o-transform: rotate(-44deg);
    -ms-transform: rotate(-44deg);
    transform: rotate(-44deg);
  }

  
</style>

@include('layouts.navbar')
@section('content')
@include('layouts.sidebar')
<div class="row py-4">     
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="card-header" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
          <a href="{{ url('viewbypackage') }}/{{ $product->product_id }}/{{ $package->package_id }}"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> 
          / <a href="/trackprogram">Customer</a> / <a href="{{ url('trackpackage') }}/{{ $product->product_id }}"> {{ $product->name }} </a> 
          / <a href="{{ url('viewbypackage') }}/{{ $product->product_id }}/{{ $package->package_id }}">{{ $package->name }}</a> / <b>Updated Participant</b>
        </div>
  
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">{{ $package->name }}</h1>

          <div class="btn-group">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#newcustomer">
              <i class="fas fa-plus pr-1"></i> New Participant
            </button>
            <!-- Modal -->
            <div class="modal fade" id="newcustomer" tabindex="-1" role="dialog" aria-labelledby="newcustomerLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Customer</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="{{ url('new-particpant/save') }}/{{ $product->product_id }}/{{ $package->package_id }}" method="POST"> 
                  @csrf
                    <div class="form-group row px-4">
                        <label for="ic" class="col-sm-4 col-form-label">IC No.</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" name="ic" placeholder="950101012036" maxlength="12" required>
                        </div>
                    </div>
                    <div class="form-group row px-4">
                        <label for="name" class="col-sm-4 col-form-label">First Name</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" name="first_name" placeholder="John" required>
                        </div>
                    </div>
                    <div class="form-group row px-4">
                        <label for="name" class="col-sm-4 col-form-label">Last Name</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" name="last_name" placeholder="Doe" required>
                        </div>
                    </div>
                    <div class="form-group row px-4">
                        <label for="name" class="col-sm-4 col-form-label">Tel No.</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" name="phoneno" placeholder="+60123456789" value="+60" required>
                        </div>
                    </div>
                    <div class="form-group row px-4">
                        <label for="name" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                        <input type="email" class="form-control" name="email" placeholder="example@gmail.com" required>
                        </div>
                    </div>

                    <div class='col-md-12 text-right px-4'>
                        <button type='submit' class='btn btn-success'> <i class="fas fa-save pr-1"></i> Save </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <a href="{{ url('import-participant') }}/{{ $product->product_id }}/{{ $package->package_id }}" class="btn btn-sm btn-outline-dark"><i class="fas fa-upload pr-1"></i> Import Participant</a>
          </div>
        </div>

        <div class="row">
            <div class="col-md-9">
                
                @if ($message = Session::get('update-paid'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-bs-dismiss="alert">×</button>	
                    <strong>{{ $message }}</strong>
                </div>
                @endif
                
                @if ($message = Session::get('search-error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-bs-dismiss="alert">×</button>	
                    <strong>{{ $message }}</strong>
                </div>
                @endif

                @if ($message = Session::get('export-paid'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-bs-dismiss="alert">×</button>	
                    <strong>{{ $message }}</strong>
                </div>
                @endif

                <!-- Search box ---------------------------------------------------------->
                {{-- <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Enter IC Number" title="Type in a name"> --}}
                <form action="{{ url('paid-ticket/search') }}/{{ $product->product_id }}/{{ $package->package_id }}" method="GET" class="needs-validation" novalidate>
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Enter IC Number" name="search" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </div>
                </form>

                <!-- Show success payment in table ----------------------------------------------->
                {{-- <div class="float-right">{{$payment->links()}}</div>    --}}
                @if(isset($details))
                <table class="table table-hover" id="successTable">
                    <thead>
                    <tr class="header">
                        <th>#</th>
                        <th>IC No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th><i class="fas fa-cogs"></i></th>
                    </tr>
                    </thead>
                    <tbody> 
                    @foreach ($ticket as $key => $tickets)
                    @foreach ($student as $students)   
                    @if ($tickets->ic == $students->ic)
                    @if ($product->product_id == $tickets->product_id)  
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $students->ic }}</td>
                        <td>{{ $students->first_name }} {{ $students->last_name }}</td>
                        <td>{{ $students->email }}</td>
                        <td>
                            <a class="btn btn-dark" href="{{ url('paid-ticket/view') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $tickets->ticket_id }}"><i class="fas fa-chevron-right"></i></a>

                            @if(Auth::user()->role_id == 'ROD003' || Auth::user()->role_id == 'ROD004')
                            @else
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $tickets->payment_id }}"><i class="fas fa-trash-alt"></i></button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{ $tickets->payment_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    Are you sure you want to delete this payment ?
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a class="btn btn-danger" href="{{ url('delete-paid') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $tickets->ticket_id }}">Delete</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endif
                    @endif
                    @endforeach
                    @endforeach
                    </tbody>
                </table>
                @endif

                {{-- <div class="float-right pt-3">{{$ticket->links()}}</div> --}}
                <table class="table table-hover" id="successTable">
                    <thead>
                    <tr class="header">
                    <th>#</th>
                    <th>IC No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Ticket Type</th>
                    <th><i class="fas fa-cogs"></i></th>
                    </tr>
                    </thead>
                    <tbody> 
                    @foreach ($ticket as $key => $tickets)
                    @foreach ($student as $students)   
                    @if ($tickets->ic == $students->ic)
                    @if ($product->product_id == $tickets->product_id)  
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $students->ic }}</td>
                        <td>{{ $students->first_name }} {{ $students->last_name }}</td>
                        <td>{{ $students->email }}</td>
                        <td>{{ $tickets->ticket_type }}</td>
                        <td>
                            <a class="btn btn-dark" href="{{ url('view/ticket') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $tickets->ticket_id }}"><i class="fas fa-chevron-right"></i></a>
                        </td>
                    </tr>
                    @endif
                    @endif
                    @endforeach
                    @endforeach
                    </tbody>
                </table>  
            </div>
            
            <!-- Show data in cards --------------------------------------------------->
            <div class="col-md-3">
                <div class="pb-2">
                    <div class="card border-0 gradient-1 shadow text-center">
                        <h6 class="pt-3">Paid Ticket</h6>
                        <b class="display-6 pb-3">{{ number_format($paidticket) }}</b>
                    </div>
                </div>
                
                <div class="py-2">
                    <div class="card border-0 gradient-2 shadow text-center">
                        <h6 class="pt-3">Free Ticket</h6>
                        <b class="display-6 pb-3">{{ number_format($freeticket) }}</b>
                    </div>
                </div>
            </div> 
        
        </div>
    </main>
  </div>
</div>

<script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
</script>

<!-- Enable function for search payment ------------------------------------->
<script>
  function myFunction() 
  {
    var input, filter, table, tr, td, i, txtValue;

    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("successTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) 
    {
      td = tr[i].getElementsByTagName("td")[1];
      
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }       
    }
  }
</script>

@endsection

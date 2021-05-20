@extends('layouts.app')

@section('title')
    Sales Tracking
@endsection

@include('layouts.navbar')
@section('content')
@include('layouts.sidebar')

<div class="row py-4">
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">   
     
    <div class="card-header" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
      <a href="/dashboard"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <b>Manage Customer</b>
    </div>
   
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Customer</h1>
        {{-- <a href="select-event" class="btn btn-dark"><i class="fas fa-plus pr-1"></i> New Customer</a> --}}
    </div> 

    <div class="row">
      <div class="col-md-12 "> 
          
        <!-- Search box ---------------------------------------------------------->
        <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Please Enter Event Name" title="Type in a name">
        
        <div class="float-right pt-3">{{$product->links()}}</div>
        <br>
        
        <!-- View event details in table ----------------------------------------->
        <table class="table table-hover" id="myTable">
          <thead>
            <tr class="header">
              <th>#</th>
              <th style="width:12%">Event Date</th>
              <th>Event Name</th>
              <th class="text-center"><i class="fas fa-cogs"></i></th>
            </tr>
          </thead>
          <tbody> 
            @foreach ($product as $key => $products)
            <tr>
              <td>{{ $product->firstItem() + $key }}</td>
              <td>{{ date('d/m/Y', strtotime($products->created_at)) }}</td>
              <td>{{ $products->name }}</td>
              <td class="text-center">
                <a class="btn btn-light" href="{{ url('trackpackage') }}/{{ $products->product_id }}"><i class="fas fa-eye"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>     

      </div>
                
      {{-- <div class="col-md-3">
        <div class="card mb-4 text-center">
          <div class="card-body pt-4">
            <i class="fas fa-user-tie fa-3x" style="color:rgb(69, 91, 139)"></i>
            <h3 class="pt-4">{{$totalcust}}</h3>
          </div>
          <div class="card-footer">
            <h6>Total Customers</h6>
          </div>
        </div>

        <div class="card mb-4 text-center">
          <div class="card-body pt-4">
            <i class="fa fa-ticket-alt fa-3x" style="color:rgb(69, 139, 69)"></i>
            <h3 class="pt-4">{{$totalpay}}</h3>
          </div>
          <div class="card-footer">
            <h6>Total Payments</h6>
          </div>
        </div>

      </div> --}}
    </div>
       
  </main>
</div>

<!-- Enable function for search data ------------------------------------->
<script>
  function myFunction() 
  {
    var input, filter, table, tr, td, i, txtValue;

    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) 
    {
      td = tr[i].getElementsByTagName("td")[2];
      
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
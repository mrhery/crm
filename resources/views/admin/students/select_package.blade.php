@extends('layouts.app')

@section('title')
    Select Package
@endsection

@include('layouts.navbar')
@section('content')
@include('layouts.sidebar')

<div class="row py-4">
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">   
     
    <div class="card-header" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
      <a href="/dashboard"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <a href="/trackprogram">Manage Customer</a> 
      / <b> New Customer</b>
    </div>
   
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">New Customer</h1>
    </div> 

    <div class="row">
      <div class="col-md-12 "> 
          
        <!-- Search box ---------------------------------------------------------->
        <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Please Enter Event Name" title="Type in a name">
        
        <div class="float-right pt-3">{{$package->links()}}</div>
        <br>
        
        <!-- View event details in table ----------------------------------------->
        <table class="table table-hover" id="myTable">
          <thead>
            <tr class="header">
              <th>#</th>
              <th style="width:12%">Event Name</th>
              <th>Price</th>
              <th class="text-center"><i class="fas fa-cogs"></i></th>
            </tr>
          </thead>
          <tbody> 
            @foreach ($package as $key => $packages)
            <tr>
              <td>{{ $package->firstItem() + $key }}</td>
              <td>{{ $packages->name }}</td>
              <td>{{ $packages->price }}</td>
              <td class="text-center">
                <a class="btn btn-light" href="{{ url('select-package') }}/{{ $products->product_id }}"><i class="fas fa-chevron-right"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>     

      </div>
                
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
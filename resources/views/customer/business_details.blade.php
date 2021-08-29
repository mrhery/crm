@extends('layouts.app')

@section('title')
    Customer Business Details
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

/* Bootstrap 4 text input with search icon */

</style>

@section('content')
    <div class="col-md-12 pt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Customer Business Details</li>
            </ol>
        </nav>

        <div class="">
          <div class="input-group mb-3">
            <form action="{{ url('customer_details') }}" class="input-group" method="GET">
              {{-- <input type="text" class="form-control" aria-label="Text input with segmented dropdown button"> --}}
              <input type="text" class="form-control" name="search" value="{{ request()->query('search') ? request()->query('search') : '' }}" placeholder="Search name and IC number">
              <div class="input-group-append">
                <select class="custom-select" id="inputGroupSelect02" name="price">
                  <option selected value="">Price</option>
                  <option value="100">RM100</option>
                  <option value="500">RM500</option>
                  <option value="1000">RM1000</option>
                  <option value="1500">RM1500</option>
                  <option value="5000">RM5000</option>
                </select>
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        {{-- <script>
          $(document).ready( function() {
          $('.dropdown-toggle').dropdown();
          });
        </script> --}}

        {{-- <div class="wrapper">
            <div class="search_box">
                <div class="dropdown">
                    <div class="default_option">All</div>  
                    <ul>
                      <li>All</li>
                      <li>Recent</li>
                      <li>Popular</li>
                    </ul>
                </div>
                <div class="search_field">
                  <input type="text" class="input" placeholder="Search">
                  <i class="fas fa-search"></i>
              </div>
            </div>
        </div> --}}

        {{-- <div class="">
          <div class="row searchFilter" >
     <div class="col-sm-12" >
      <div class="input-group" >
       <input id="table_filter" type="text" class="form-control" aria-label="Text input with segmented button dropdown" >
       <div class="input-group-btn" >
        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><span class="label-icon" >Category</span> <span class="caret" >&nbsp;</span></button>
        <div class="dropdown-menu dropdown-menu-right" >
           <ul class="category_filters" >
            <li >
             <input class="cat_type category-input" data-label="All" id="all" value="" name="radios" type="" ><label for="all" >All</label>
            </li>

            <li >
             <input type="radio" name="radios" id="Design" value="Design" ><label class="category-label" for="Design" >Design</label>
            </li>

            <li >
             <input type="radio" name="radios" id="Marketing" value="Marketing" ><label class="category-label" for="Marketing" >Marketing</label>
            </li>

            <li >
             <input type="radio" name="radios" id="Programming" value="Programming" ><label class="category-label" for="Programming" >Programming</label>
            </li>

            <li >
             <input type="radio" name="radios" id="Sales" value="Sales" ><label class="category-label" for="Sales" >Sales</label>
            </li>

            <li >
             <input type="radio" name="radios" id="Support" value="Support" ><label class="category-label" for="Support" >Support</label>
            </li>
           </ul>
        </div>
        <button id="searchBtn" type="button" class="btn btn-secondary btn-search" ><span class="glyphicon glyphicon-search" >&nbsp;</span> <span class="label-icon" >Search</span></button>
       </div>
      </div>
     </div>
  </div>
        </div> --}}

        {{-- <div class="input-group">
          <form action="{{ url('customer_details') }}" class="input-group" method="GET">
            <select class="selectpicker">
              <option>Mustard</option>
              <option>Ketchup</option>
              <option>Barbecue</option>
            </select>
            <input type="text" class="form-control" name="search" value="{{ request()->query('search') ? request()->query('search') : '' }}" placeholder="Search name and IC number">
            <div class="input-group-append">
              <button class="btn btn-secondary" type="button">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </form>
        </div> --}}


        {{-- <div class="main">
          <div class="input-group">
            <form action="{{ url('customer_details') }}" class="input-group" method="GET">
              <select class="selectpicker">
                <option>Mustard</option>
                <option>Ketchup</option>
                <option>Relish</option>
              </select>
              <input type="text" class="form-control" name="search" value="{{ request()->query('search') ? request()->query('search') : '' }}" placeholder="Search name and IC number">
              <div class="input-group-append">
                <button class="btn btn-secondary" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </div>
            </form>
          </div>
        </div> --}}
        

        <div class="col-md-12 pt-3 table-responsive">
          {{-- <form action="{{ url('customer_details') }}" class="input-group" method="GET">
              <input type="text" class="form-control" name="search" value="{{ request()->query('search') ? request()->query('search') : '' }}" placeholder="Search name and IC number">
          </form> --}}
        </div>
    </div>
@endsection
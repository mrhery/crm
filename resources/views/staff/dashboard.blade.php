@if (Session::get('role_id') == 'ROD005')

@extends('layouts.app')

@section('title')
Staff Dashboard
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
{{-- @include('staff.navbar') --}}
@section('content')

<div class="col-md-12">
    <h2>dasdasdasdasdasdasdsa</h2>
</div>
@endsection

@endif
@extends('layouts.temp')

@section('title')
Pendaftaran Pembeli
@endsection

{{-- Custom button css ----------------------------}}
<style>
    .button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 32px 16px;
    border-radius: 5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 5px;
    transition-duration: 0.4s;
    cursor: pointer;
    }
    .button4 {
    background-color: #f3f3f3;
    color: #202020;
    border: 1px #e7e7e7 solid;
    width: 250px;
    }

    .button4:hover {background-color: #e7e7e7;}
</style>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 px-3 py-5 text-center">
            <img src="/assets/images/logo.png" style="max-width:200px">
            <h1 class="display-4 text-dark px-4 pt-3">{{ $product->name }}</h1>
        </div>

        <div class="col-md-12 d-flex justify-content-center pb-5">
            <form action="{{ url('store4') }}/{{ $product->product_id }}/{{ $package->package_id }}" method="POST">
                @csrf
                <div class="card w-100 shadow">
                    <div class="card-header bg-dark text-white">Langkah 4/5: Pilih Jenis Pembayaran</div>
  
                    <div class="card-body">
  
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="px-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group row">
                            <div class="col-md-12 px-5">
                                {{-- <button type="submit" class="button button4" name="pay_method" value="{{ $card ?? '' }}">
                                    <i class="far fa-credit-card fa-3x"></i>
                                    <br><br>Kad Debit/Kredit
                                </button> --}}
                            
                                <button type="submit" class="button button4" name="pay_method" value="{{ $fpx ?? '' }}">
                                    <i class="fas fa-university fa-3x"></i>
                                    <br><br>FPX
                                </button>
                            </div>
                        </div>
  
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <a href="{{ url('pengesahan-pembelian') }}/{{ $product->product_id }}/{{ $package->package_id }}" class="btn btn-circle btn-lg btn-outline-dark"><i class="fas fa-arrow-left" style="padding-top:35%"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
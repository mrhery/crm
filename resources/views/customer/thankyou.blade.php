@extends('layouts.app')

@section('title')
  Terima Kasih
@endsection

<style>
  body {
    background-color:rgb(233, 233, 233)!important ; 
  }

</style>

@section('content')
<div class="row">
  <div class="col-md-12 px-5 py-4">
    <div class="text-center">
        <h3 class="display-4">Terima Kasih!</h3>
        <h3 class="display-4">Pembelian anda telah berjaya.</h3>
        {{-- <div class="py-3" style="font-size: 24px; color: green;">
          <i class="far fa-check-circle fa-8x text-center"></i>
        </div> --}}
        
        <div class="py-4">
          <iframe src="https://player.vimeo.com/video/531964255?color=ffffff&title=0&byline=0&portrait=0&badge=0" width="320" height="180" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
        </div>
 
        <hr>
        
        <p class="lead"> Pengesahan pembelian akan dihantar kepada emel yang telah didaftarkan dalam masa 48 Jam. Terima kasih kerana menunggu. </p>
        <p class="lead py-1">
          Jika terdapat sebarang pertanyaan, sila <a href="https://momentuminternet.com/contactus/" class="link-primary">hubungi kami.</a><br><br>
          {{-- <a class="btn btn-dark py-3 px-4" href="{{ url('updateform')}}/{{$product->product_id}}/{{$package->package_id}}/{{$student->stud_id}}/{{$payment->payment_id}}" role="button">Kemaskini</a> --}}
        </p>

    </div>
  </div>
</div>
@endsection
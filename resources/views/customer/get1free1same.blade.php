@extends('layouts.temp')

@section('title')
Kemaskini Peserta
@endsection

@section('content')

{{-- ------ Style to remove arrow in number input -------- --}}
<style>
  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
  }

  /* Firefox */
  input[type=number] {
  -moz-appearance: textfield;
  }
</style>

{{-- Phone country code css -----------------------}}

{{-- <link rel="stylesheet" href="{{ URL::asset('assets/css/intlTelInput.css') }}" />

<style>
    .iti-flag {background-image: url(cover_images/flags.png);}

    @media (-webkit-min-device-pixle-ratio: 2), (min-resolution: 192dpi){
        .iti-flag {background-image: url(image/flag@2x.png);}
    }
</style> --}}

<div class="container">
  <div class="row">
    <div class="col-md-12 px-3 py-5 text-center">
      <img src="/assets/images/logo.png" style="max-width:200px">
      <h1 class="display-4 text-dark px-4 pt-3">{{ $product->name }}</h1>
    </div>

    <div class="col-md-12 d-flex justify-content-center pb-5">
      <form id="msform" name="frm" action="{{ url('get1free1same') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $student->stud_id }}/{{ $payment->payment_id }}" method="post" onsubmit="return checkForm(this);">
      @csrf

      <div class="card w-100">
        <div class="card-header bg-dark text-white text-center">Maklumat Pembeli</div>
  
        <div class="card-body">

          <div class="form-group row text-left px-4">
            <div class="col-md-6 pb-3">
              No. Kad Pengenalan/Passport:<br>
              <strong>{{$student->ic}}</strong>
              <input type="hidden" id="ic1" name="ic" class="form-control pb-2" value="{{ $student->ic }}" disabled>
            </div>

            <div class="col-md-6 pb-3">
              Nama Pembeli:<br>
              <strong>{{$student->first_name }}</strong> <strong>{{$student->last_name}}</strong>
              <input type="hidden" id="first_Name1" name="first_name" class="form-control pb-2" value="{{ $student->first_name }}" disabled>
              <input type="hidden" id="last_Name1" name="last_name" class="form-control pb-2" value="{{ $student->last_name }}" disabled>
            </div>

            <div class="col-md-6 pb-3">
              Emel:<br>
              <strong>{{$student->email }}</strong>
              <input type="hidden" id="email1" name="email" class="form-control pb-2" value="{{ $student->email }}" disabled>
            </div>

            <div class="col-md-6 pb-3">
              No. Tel:<br>
              <strong>{{$student->phoneno}}</strong>
                  <input type="hidden" id="phoneno1" name="phoneno" class="form-control pb-2" value="{{ $student->phoneno }}" disabled>
            </div>
            
          </div>

          {{-- <table class="table table-borderless text-left">
            <tr>
                <td class="w-50">No. Kad Pengenalan / Passport</td>
                <td>:</td>
                <td>
                  <strong>{{$student->ic}}</strong>
                  <input type="hidden" id="ic1" name="ic" class="form-control pb-2" value="{{ $student->ic }}" disabled>
                </td>
            </tr>
            <tr>
                <td class="w-50">Nama Pembeli</td>
                <td>:</td>
                <td class="text-break">
                  <strong>{{$student->first_name }}</strong> <strong>{{$student->last_name}}</strong>
                  <input type="hidden" id="first_Name1" name="first_name" class="form-control pb-2" value="{{ $student->first_name }}" disabled>
                  <input type="hidden" id="last_Name1" name="last_name" class="form-control pb-2" value="{{ $student->last_name }}" disabled>
                </td>
            </tr>
            <tr>
                <td class="w-50">Emel</td>
                <td>:</td>
                <td class="text-break">
                  <strong>{{$student->email }}</strong>
                  <input type="hidden" id="email1" name="email" class="form-control pb-2" value="{{ $student->email }}" disabled>
                </td>
            </tr>
            <tr>
                <td class="w-50">No. Telefon</td>
                <td>:</td>
                <td>
                  <strong>{{$student->phoneno}}</strong>
                  <input type="hidden" id="phoneno1" name="phoneno" class="form-control pb-2" value="{{ $student->phoneno }}" disabled>
                </td>
            </tr>
          </table> --}}

          <div class="py-2">
            <a class="btn btn-dark" href="{{ url('exportInvoice')}}/{{$product->product_id}}/{{$package->package_id}}/{{$student->stud_id}}/{{$payment->payment_id}}"><i class="fas fa-download pr-2"></i>Invois</a>
            <a class="btn btn-dark" href="{{ url('exportReceipt')}}/{{$product->product_id}}/{{$package->package_id}}/{{$student->stud_id}}/{{$payment->payment_id}}"><i class="fas fa-download pr-2"></i>Resit</a>
          </div>
        </div>

      </div>

      <br>

      <div class="card w-100">
        <div class="card-header bg-dark text-white text-center">Maklumat Peserta</div>
  
        <div class="card-body">
          {{-- Start Paid Ticket --}}
          <div class="col-md-12 mx-auto text-right">
            <h4>Tiket {{$package->name}} #1</h4>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="check1" onchange="copyTextValue(this);" >
              <label class="form-check-label" for="flexCheckDefault">
                Sila tandakan ruangan ini jika pembeli adalah peserta
              </label>
            </div>
            <hr>
          </div>

          <div class="form-group row text-left px-4">
            <div class="col-md-12 pb-2">
                <label for="description">No. Kad Pengenalan/Passport:</label>
                <input id="ic2" class="form-control pb-2" type="text" name="ic" placeholder="Tanpa '-' cth. 91042409**** / A********" maxlength="12" required>
            </div>

            <div class="col-md-6 pb-2">
                <label for="title">Nama Pertama:</label>
                <input type="text" id="first_Name2" name="first_name" class="form-control pb-2" placeholder="Mohammad" aria-label="First name" required>
            </div>
            <div class="col-md-6 pb-2">
                <label for="title">Nama Akhir:</label>
                <input type="text" id="last_Name2" name="last_name" class="form-control pb-2" placeholder="Ali" aria-label="Last name" required>
            </div>

            <div class="col-md-6 pb-2">
                <label for="description">Emel:</label>
                <input id="email2" class="form-control pb-2" type="email" name="email" placeholder="cth. example@gmail.com" required>
            </div>
            
            <div class="col-md-6 pb-2">
                <label for="description">No. Telefon:</label><br>
                <input id="phoneno2" class="form-control pb-2" type="tel" name="phoneno" placeholder="Tanpa '-' cth. 01123456789" required>
            </div>
          </div>
          {{-- End Paid Ticket --}}

          {{-- Start Free Ticket --}}
          <div class="col-md-12 mx-auto text-right">
            <hr>
            <h4>Tiket {{$package->name}} (Free) #2</h4>
            <hr>
          </div>

          <div class="form-group row text-left px-4">
            <div class="col-md-12 pb-2">
                <label for="description">No. Kad Pengenalan/Passport:</label>
                <input class="form-control pb-2" type="text" name="ic_free1" placeholder="Tanpa '-' cth. 91042409**** / A********" maxlength="12" required>
            </div>

            <div class="col-md-6 pb-2">
                <label for="title">Nama Pertama:</label>
                <input type="text" name="firstname_free1" class="form-control pb-2" placeholder="Mohammad" aria-label="First name" required>
            </div>
            <div class="col-md-6 pb-2">
                <label for="title">Nama Akhir:</label>
                <input type="text" name="lastname_free1" class="form-control pb-2" placeholder="Ali" aria-label="Last name" required>
            </div>

            <div class="col-md-6 pb-2">
                <label for="description">Emel:</label>
                <input class="form-control pb-2" type="email" name="email_free1" placeholder="cth. example@gmail.com" required>
            </div>
            
            <div class="col-md-6 pb-2">
                <label for="description">No. Telefon:</label><br>
                <input class="form-control pb-2" type="tel" name="phoneno_free1" placeholder="Tanpa '-' cth. 01123456789" required>
            </div>
          </div>
          {{-- End Free Ticket --}}
          
        </div>

        <div class="card-footer">
          <div class="col-md-12">
            <div class="pull-right">
              {{-- <input type="submit" name="myButton" class="btn btn-dark" value="Simpan"/> --}}
              <input type="submit" name="myButton" class="btn btn-dark" value="Hantar"/>
            </div>
          </div>
        </div>
      </div>

      </form>
    </div>

  </div>
</div>

{{-- Triggered duplicate window ---------------------------------------------------------------------------------------------}}
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/Duplicate.js') }}"></script>
<script>
  $(document).ready(function () {

    if (window.IsDuplicate()) {

      alert("This is duplicate window\n\n Closing...");
      window.close();

    }
  });
</script>
{{-- End Triggered duplicate window -----------------------------------------------------------------------------------------}}

{{-- Phone country code -----------------------------------------------------------------------------------------------------}}
{{-- <script type="text/javascript" src="{{ URL::asset('assets/js/intlTelInput.js') }}"></script>

<script type="text/javascript" src="{{ URL::asset('assets/js/cleave.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/test.js') }}"></script>

<script>
    var input = document.querySelector('#input-phone');
    var iti = window.intlTelInput (input,  {
        utilsScript:'js/utils.js'
    }); 
</script>
<script>
    var input2 = document.querySelector("#input-phoneno"."{{ $phonecode++ }}");
    var iti = window.intlTelInput (input2,  {
        utilsScript:'js/utils.js'
    }); 
</script>  --}}
{{-- End Phone country code -------------------------------------------------------------------------------------------------}}

{{-- Checkbox copy details --------------------------------------------------------------------------------------------------}}
<script>
  function copyTextValue(bf) {
  var text1 = bf.checked ? document.getElementById("first_Name1").value : '';
  document.getElementById("first_Name2").value = text1;

  var text1 = bf.checked ? document.getElementById("last_Name1").value : '';
  document.getElementById("last_Name2").value = text1;

  var text2 = bf.checked ? document.getElementById("ic1").value : '';
  document.getElementById("ic2").value = text2;

  var text3 = bf.checked ? document.getElementById("email1").value : '';
  document.getElementById("email2").value = text3;

  var text4 = bf.checked ? document.getElementById("phoneno1").value : '';
  document.getElementById("phoneno2").value = text4;
}
</script>
{{-- End Checkbox copy details ---------------------------------------------------------------------------------------------}}

{{-- Disabled multiple submission on payment --------------------------------------------------------------------------------}}
<script type="text/javascript">

  function checkForm(form) // Submit button clicked
  {
      form.myButton.disabled = true;
      form.myButton.value = "Wait...";
      return true;
  }

</script>
{{-- End Disabled multiple submission on payment ----------------------------------------------------------------------------}}

@endsection
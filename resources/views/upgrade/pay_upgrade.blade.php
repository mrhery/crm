@extends('layouts.temp')

@section('title')
Upgrade Pakej
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
        <div class="col-md-12 px-3 pt-5 pb-3 text-center border-bottom">
            <img src="/assets/images/logo.png" style="max-width:150px">
            <h1 class="text-dark px-4 pt-3">{{ $product->name }}</h1>
        </div>

        <div class="col-md-12 py-3">
            <form action="" method="POST">
                @csrf
  
                {{-- <div class="w-50 px-3 py-3 pt-md-4 pb-md-4 mx-auto text-center">
                    <h1 class="font-weight-bold">{{ $product->name }}</h1>
                    <p class="lead">Hai! Sila buat pilihan di bawah untuk upgrade pakej.</p>
                </div> --}}
                <div class="container text-center">
                    <div class="row">
                        <div class="col-auto pb-4 d-block mx-auto">
                            <div class="pricing-item bg-white py-4 px-4" style=" box-shadow: 0px 0px 30px -7px rgba(0,0,0,0.29); border-radius: 5px;">
                                <div class="pb-2" style="letter-spacing: 2px">
                                    <h4>{{ $current_package->name }} <i class="fas fa-arrow-right"></i> New Package</h4>
                                </div>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Pakej</th>
                                            <th>Harga</th>
                                            <th>Kuantiti</th>
                                            <th>Jumlah Bayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $package->name }}</td>
                                            <td>
                                                {{ $package->price }}
                                                <input type="hidden" id="price" name="price" value="{{ $package->price }}" disabled>
                                            </td>
                                            <td>
                                                <select id="quantity" name="quantity" onchange="calculateAmount(this.value)" value="{{ $payment->quantity ?? '' }}" class="form-control w-75" required>
                                                <option value="" disabled selected>-</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" id="totalprice" name="totalprice" value="{{ $payment->totalprice ?? '' }}" style="border: none; outline-width: 0;" readonly>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                {{-- <div class="py-2">
                                    <p style="text-decoration: line-through;">RM{{ $current_package->price }}</p>
                                    <span id="price"></span>
                                </div> --}}
                                <div class="form-group row">
                                    <div class="col-md-12 px-5">
                                        <button type="submit" class="button button4" name="pay_method" value="{{ $stripe ?? '' }}">
                                            <i class="far fa-credit-card fa-3x"></i>
                                            <br>Kad Debit/Kredit
                                        </button>
                                    
                                        <button type="submit" class="button button4" name="pay_method" value="{{ $billplz ?? '' }}">
                                            <i class="fas fa-university fa-3x"></i>
                                            <br>FPX
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                    
            </form>
        </div>
    </div>
</div>



<script>
    var x = '{{ $current_package->price }}';
    var y = '{{ $current_package->price }}';
    var z = x - y;
    document.getElementById("price").innerHTML = z;
    console.log(x);
</script>

<script>
function calculateAmount(val) {
        
    var prices = document.getElementById("price").value;
    var total_price = val * prices;

    /*display the result*/
    var divobj = document.getElementById('totalprice');
    divobj.value = total_price;

    var totallagi = document.getElementById('total_lagi');
    totallagi.value = total_price;

    document.getElementById('total_lah').innerHTML = total_price;

}
</script>
@endsection
@extends('layouts.email')

@section('content')
    <table style="border: none; cellpadding: 0; cellspacing: 0;" class="body">
      <tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">
            {{-- <span class="preheader">Subscribe to Coloured.com.ng mailing list</span> --}}
            <table class="main">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper">
                  <table style="border: none; cellpadding: 0; cellspacing: 0;" >
                    <tr>
                      <td>
                        <h3>Tahniah! Anda telah berjaya menaik taraf pakej.</h3>
                        <table style="border: none; cellpadding: 0; cellspacing: 0;" class="btn btn-primary">
                          <tbody>
                            <tr>
                                <td>Assalamualaikum & Salam Sejahtera Tuan/Cik/Puan,<br><br>
                                Terima Kasih kerana berminat untuk menyertai:</td>
                            </tr>
                            <tr>
                                <td>
                                  <b>Program</b> : {{ $product_name }}<br>
                                  <b>Tarikh</b> : {{ $date_from }} - {{ $date_to }}<br>
                                  <b>Waktu</b> : {{ $time_from }} - {{ $time_to}}<br>
                                  <b>Order ID</b> : {{ $payment_id }}
                                </td>
                            </tr>
                            <hr>
                            <tr>
                              <td class="align-center">
                                <table style="border: none; cellpadding: 0; cellspacing: 0;" >
                                  <tbody>
                                  <tr>
                                      <td>Sila klik pada butang di bawah untuk kemaskini maklumat peserta dan mendapatkan resit pembayaran</td>
                                  </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                            <tr>
                                <td class="align-center">
                                  <table style="width: 100%; border: none; cellpadding: 0; cellspacing: 0;" >
                                    <tbody>
                                      <tr>
                                      <td> <a href="{{ url('updateform') }}/{{ $productId }}/{{ $packageId }}/{{ $student_id }}/{{ $payment_id }}" class="btn btn-primary py-3 px-4">Kemaskini</a> </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                            </tr>
                            <hr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Sekiranya ada sebarang pertanyaan atau perlukan bantuan, anda boleh hubungi di talian - 0108048800</p>
                        </td>
                    </tr>
                    <tr>
                      <td>Terima Kasih
                        <br><br><br>
                          Salam Kejayaan<br>
                          <b>Team Momentum</b>
                      </td>
                    </tr>
                    
                  </table>
                </td>
              </tr>

            <!-- END MAIN CONTENT AREA -->
            </table>

            <br>     
            <p>If you received this email by mistake, simply delete it. You won't be subscribed if you don't click the confirmation link above.</p>


            <!-- START FOOTER -->
            <div class="footer">
              <table style="border: none; cellpadding: 0; cellspacing: 0;" >
                {{-- <tr>
                  <td class="content-block">
                    <span class="apple-link">Coloured.com.ng | Feminism | Culture | Law | Feminists Rising</span>
                    <br> Don't like these emails? <a href="#">Unsubscribe</a>.
                  </td>
                </tr> --}}
                <tr>
                  <td class="content-block powered-by">
                    MOMENTUM INTERNET (1079998-A) © 2020 ALL RIGHTS RESERVED​
                  </td>
                </tr>
              </table>
            </div>
            <!-- END FOOTER -->
            
          <!-- END CENTERED WHITE CONTAINER -->
          </div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
@endsection
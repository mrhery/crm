@extends('layouts.app')

@section('title')
    Offer
@endsection

@include('layouts.navbar')
@section('content')
@include('layouts.sidebar')
<div class="row py-4">     
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      
      <div class="card-header" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
        <a href="/dashboard"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="dashboard">Dashboard</a> / <b>Offer</b>
      </div>

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Offer</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                {{-- <a href="add-offer" type="button" class="btn btn-sm btn-outline-secondary"><i class="fas fa-plus pt-1"></i> Add New Offer</a> --}}
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#newoffer">
                    <i class="fas fa-plus pr-1"></i> New Offer
                </button>
                <!-- Modal -->
                <div class="modal fade" id="newoffer" tabindex="-1" role="dialog" aria-labelledby="newofferLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title" id="exampleModalLabel">Create New Offer</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ url('new-offer/save') }}" method="POST"> 
                        @csrf
                            <div class="form-group row px-4">
                                <label for="name" class="col-sm-4 col-form-label">Offer Name</label>
                                <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" >
                                </div>
                            </div>
                                                
                            <div class='col-md-12 text-right px-4'>
                                <button type='submit' class='btn btn-success'> <i class="fas fa-save pr-1"></i> Save </button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      
      @if ($message = Session::get('add-success'))
      <div class="alert alert-success alert-block">
          <button type="button" class="close" data-bs-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
      </div>
      @endif
      
      @if ($message = Session::get('update-success'))
      <div class="alert alert-info alert-block">
          <button type="button" class="close" data-bs-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
      </div>
      @endif

      @if ($message = Session::get('delete'))
      <div class="alert alert-danger alert-block">
          <button type="button" class="close" data-bs-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
      </div>
      @endif

      <div class="float-right pt-3">{{$offers->links()}}</div>
      @if(count($offers) > 0)
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col" style="width: 10%">#</th>
            <th scope="col" style="width: 35%">Offer</th>
            <th scope="col" style="width: 15%"><i class="fas fa-cogs"></i></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($offers as $key => $offer)                        
            <tr>
                <td>{{ $offers->firstItem() + $key  }}</td>
                <td>{{ $offer->name  }}</td>
              <td>
                <a class="btn btn-primary" href="{{ url('update-offer') }}/{{ $offer->offer_id }}"><i class="fas fa-edit"></i> Update</a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $offer->offer_id }}"><i class="fas fa-trash-alt"></i> Delete</button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal{{ $offer->offer_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Are you sure you want to delete this event ?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a class="btn btn-danger" href="{{ url('delete-offer') }}/{{ $offer->offer_id }}">Delete</a>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>    
          @endforeach
        </tbody>
      </table>
      @else
        <p>There are no offer to display.</p>
      @endif
    </main>
  </div>
</div>
@endsection
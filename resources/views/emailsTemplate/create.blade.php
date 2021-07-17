@extends('layouts.app')

@section('title')
    Package 
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 pt-3">
            <div class="card">
            
                <div class="card-header py-2" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
                    <a href=""><i class="bi bi-arrow-left"></i></a> &nbsp; <a href="dashboard">...</a> / <a href="/product">Event</a> / <a href="">Package</a> / <b>Create Email Template</b>
                </div>
        
                
                
                <div class="card-body">

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h2 class="h2">Create Email Template</h2>
                    </div>
                    <!-- Add package form ---------------------------------------------------->
                    <form class="row g-3 px-3" action="" method="POST" id="dynamic_form" enctype="multipart/form-data"> 
                        @csrf
                        <div class='row my-3'>
                            <div class='col-md-6'>         
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input name="name" type="text" class="form-control" required>
                                </div>
                            </div>
                    
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label for="name">Title</label>
                                    <input name="title" type="text" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label for="name">Date</label>
                                    <input name="date" type="date" class="form-control" required>
                                </div>
                            </div>

                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label for="name">Content</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                            
                        <div class='col-md-8 pt-3'>
                            <button type='submit' class='btn btn-primary'> <i class="bi bi-save pr-2"></i>Submit </button>
                        </div>
                        
                    </form>
                </div>
            </div>

            
        </div>
    </div>
    
@endsection
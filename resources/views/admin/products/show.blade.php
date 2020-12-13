@extends('layouts.app')

@section('content')
    
<div class="card">
    <div class="card-header">
      <h3 class="card-title"> {{$product->title}} </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
      <table class="table table-condensed">
        <tr>
            <div>
                Description
            </div>
            <div>
                {{$product->description}}
            </div>
        </tr>
        
        <tr>
            <div>
                price
            </div>
            <div>
                {{$product->price}}
            </div>
        </tr>

        <tr>
            <div>
                images
            </div>
            <div>
                @foreach($product->images as $image)
                <div style="display: inline-block">
                {{ $app['url']->to('/').$image }}
                </div>
                @endforeach
            </div>
        </tr>

        <tr>
            <div>
                Category
            </div>
            <div>
                {{$product->category->name}}
            </div>
        </tr>

      </table>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->

@endsection
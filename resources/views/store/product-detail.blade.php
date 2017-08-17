@extends('store.default-layout')
<!--  -->
@section('title', $product->name)
<!-- Content Start -->
@section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <h1>{{$product->name}}</h1>
    <img src="{{$product->featured_image->url}}" alt="{{$product->name}}">
    <div><h3>Price: </h3><span>{{$product->price}}</span></div>
    <div><h3>In Stock: </h3><span>{{$product->in_stock}}</span></div>
    @if ($product->brand)
    <div><h3>Brand: </h3><img src="{{$product->brand->logo->url}}" alt=""></div>
    @endif
    
    <h3>Images List</h3>
    @foreach ($product->product_images as $i)
        <img src="{{$i->url}}" alt="{{$i->name}}">
    @endforeach
    <h3>Description</h3>
    <div class="product-description">{!! $product->description_html !!}</div>
    <pre>{{dump($product)}}</pre>
@endsection
<!-- Content End -->
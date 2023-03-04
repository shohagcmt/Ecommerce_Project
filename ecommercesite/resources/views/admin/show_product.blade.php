<!DOCTYPE html>
<html lang="en">
  <head>
  <style type="text/css">
.font_size
{
	text-align: center;
	font-size: 40px;
	padding-top: 20px;
}
.center
{
margin: auto;
width: 70%;
border: 2px solid white;
text-align: center;
margin-top: 40px;
}
.th_color
{
	background:skyblue;
}
.th_deg
{
	padding:20px;
}
.img_size
{
	width:99px;
	height:80px;
}	

</style>

    <!-- Required meta tags -->
    @include('admin.css')
  </head>
  <body>
    <div class="container-scroller">
      
      <!-- partial:partials/_sidebar.html -->
        @include('admin.sidebar')
      <!-- partial -->
      @include('admin.header')
        <!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">

         @if(session()->has('message'))
       <div class="alert alert-success">
        {{session()->get('message')}}
        <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">x</button>
        </div>
        @endif

   <h1 class="font_size">All Products</h1>
   <table class="center table-bordered">
	<thead>
	<tr class="th_color">
		<th class="th_deg">Product title</th>
		<th class="th_deg">Description</th>
		<th class="th_deg">Quantity</th>
		<th class="th_deg">Catagory</th>
		<th class="th_deg">Price</th>
		<th class="th_deg">Discount Price</th>
		<th class="th_deg">Product Image</th>
		<th class="th_deg">Delete</th>
		<th class="th_deg">Edit</th>
	</tr>  
	</thead>
	@foreach($product as $product)
	<tbody>
	<tr>
		<td>{{$product->title}}</td>
		<td>{{$product->description}}</td>
		<td>{{$product->quantity}}</td>
		<td>{{$product->catagory}}</td>
		<td>{{$product->price}}</td>
		<td>{{$product->discount_price}}</td>

		<td>
		<img class="img_size" src="/product/{{$product->image}}">
		</td>

		<td> <a onclick="return confirm('Are you Sure To Delete This')" class="btn btn-danger" 
		href="{{url('/delete_product',$product->id)}}">Delete</a></td>
		<td> <a class="btn btn-success" href="{{url('/update_product',$product->id)}}">Edit</a></td>
	</tr>
  </tbody> 
   @endforeach
  </table>

     </div>
 </div>     
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.scripte') 
    <!-- End custom js for this page -->
  </body>
</html>
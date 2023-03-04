<section class="product_section layout_padding">
         <div class="container">
            <div class="heading_container heading_center">
              
               <br>
               <!--search option-->
               <div>
                 <form action="{{url('/search_product')}}" method="GET">
                   <input style="width: 500px" type="text" name="search" placeholder="Search for Something">
                   <input type="submit" value="search">
                 </form>
               </div>
                <!--search end option-->
            </div>

            @if(session()->has('message'))
            <div class="alert alert-success">
              <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">x</button>
              {{session()->get('message')}}
            </div>
            @endif

            <div class="row">
               @foreach($Product as $Products)
               <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="box">
                     <div class="option_container">
                        <div class="options">
                           <a href="{{url('/product_details',$Products->id)}}" class="option1">
                           Product Details
                           </a>
                           <!-- ADD Card-->
                           <form action="{{url('/add_card',$Products->id)}}" method="post"> 
                            @csrf
                              <div class="row">
                                <div class="col-md-4">
                                <input type="number" name="quantity" value="1" min="1" style="width:100px">
                                </div>
                                <div class="col-md-4">
                                <input type="submit" value="Add To Card">
                                </div>
                             </div>
                           </form>

                        </div>
                     </div>
                     <div class="img-box">
                        <img src="product/{{$Products->image}}" alt="">
                     </div>
                     <div class="detail-box">
                        <h5>
                          {{$Products->title}}
                        </h5>
                        <!--Discount Check-->
                        @if($Products->discount_price!=null)
                        <h6 style="color:red">
                        Discount Price
                        <br>
                        ${{$Products->discount_price}}
                        </h6>

                        <h6 style="text-decoration:line-through; color:blue">
                        Price
                        <br>
                        ${{$Products->price}}
                        </h6>

                        @else
                        <h6 style="color:blue">
                        Price
                        <br>
                        ${{$Products->price}}
                        </h6>

                        @endif
                        
                     </div>
                  </div>
               </div>
               @endforeach
                <!-- Next page Option-->
               <span style="padding-top:20px;">
               {!!$Product->withQueryString()->links('pagination::bootstrap-5')!!}
              </span>
              
            
          
         </div>
      </section>
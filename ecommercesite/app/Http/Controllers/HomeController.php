<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Carts;
use App\Models\Order;
use App\Models\Reply;
use Session;
use Stripe;
use App\Models\Comment;
class HomeController extends Controller
{
    //auth
    public function redirect(){
        $usertype =Auth::user()->usertype;
        if($usertype=='1'){
            //Dashbord jono total count
            $total_product=Product::all()->count();
            $total_Order=Order::all()->count();
            $total_User=User::all()->count();

            $order=Order::all();
            $total_revenue=0;
            foreach($order as $order)
            {
                $total_revenue=$total_revenue +  $order->price; 
            }
            
            $total_delivered=Order::where('delivery_status','=','delivered')->get()->count();
            $total_processing=Order::where('delivery_status','=','processing')->get()->count();
            // end Dashbord jono total count
           return view('admin.home',compact('total_product','total_Order','total_User','total_revenue','total_delivered','total_processing'));
        }
        else{
            $Product=Product::paginate(9);
            $comment=Comment::orderby('id','desc')->limit(3)->get();
            $reply=Reply::orderby('id','desc')->limit(3)->get();
            return view('home.userpage',compact('Product','comment','reply'));
           
        }

    }

    public function index(){
        //$Product=json_decode(Product::orderBy('id','desc')->limit(3)->get());
        $Product=Product::paginate(9);
        $comment=Comment::orderby('id','desc')->get();
        $reply=Reply::orderby('id','desc')->limit(3)->get();
        //return view('home.userpage',['Product'=>$Product]);
        return view('home.userpage',compact('Product','comment','reply'));
    }

    public function product_details($id){
        $Product=Product::find($id);
        return view('home.product_details',compact('Product'));

    }
 
    public function add_card(Request $request,$id){
       //add card login Test
       if(Auth::id()){
        $user=Auth::User();
        //dd($user);
        $userid=$user->id;
        $Product=Product::find($id);

        $product_exist_id=Carts::where('product_id','=',$id)->where('user_id','=',$userid)->get('id')->first();
        if($product_exist_id){
            $cart=Carts::find($product_exist_id)->first();
            $quantity=$cart->quantity;
            $cart->quantity=$quantity+$request->quantity;

            if($Product->discount_price!=null)
            {
                $cart->price=$Product->discount_price * $cart->quantity;
            }
            else {
                $cart->price=$Product->price * $cart->quantity;
            }

            $cart->save();
            return redirect()->back()->with('message','Product Added Successfully');

        }
        else
         {
            $cart=new Carts;
            //test all data show
            $cart->name=$user->name;
            $cart->email=$user->email;
            $cart->phone=$user->phone;
            $cart->address=$user->address;
            $cart->user_id=$user->id;
    
            $cart->product_title=$Product->title;
            if($Product->discount_price!=null)
            {
                $cart->price=$Product->discount_price * $request->quantity;
            }
            else {
                $cart->price=$Product->price * $request->quantity;
            }
            
            $cart->image=$Product->image;
            $cart->product_id=$Product->id;
            $cart->quantity=$request->quantity;
            $cart->save();
            return redirect()->back()->with('message','Product Added Successfully');
        }

       
        }

        else
        {
            return redirect('login');
        }
        
    }

    public function show_cart(){
        if(Auth::id())
        {
            $id=Auth::User()->id;
            $cart=Carts::where('user_id','=',$id)->get();
            return view ('home.show_cart',compact('cart'));    
        }
        else
        {
            return redirect('login');
            
        }
        
    }

    public function remove_card($id){
        $cart=Carts::find($id);
        $cart->delete();
        return redirect()->back();
    }

    //cash on delivery section
    public function cash_order(){
        $id=Auth::user()->id;
        $data=Carts::where('user_id','=',$id)->get();

        foreach($data as $data){
            $order= new Order;
            $order->name=$data->name;
            $order->email=$data->email;
            $order->phone=$data->phone;
            $order->address=$data->address;
            $order->user_id=$data->user_id;

            $order->product_title=$data->product_title;
            $order->price=$data->price;
            $order->quantity=$data->quantity;
            $order->image=$data->image;
            $order->product_id=$data->product_id;

            $order->payment_status='cash on delivery';
            $order->delivery_status='processing';

            $order->save();

            $card_id=$data->id;
            $cart=Carts::find($card_id);
            $cart->delete();
          }
         return redirect()->back()->with('message','We have Received your Order. We will connect with you soon...');
  
    }

    public function stripe($totalprice){
         return view('home.stripe',compact('totalprice')); 
    }
    
    //paid section
    public function stripePost(Request $request,$totalprice)
    {
        
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => $totalprice* 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thanks for payment ." 
        ]);
        //  Stripe end
        $id=Auth::user()->id;
        $data=Carts::where('user_id','=',$id)->get();

        foreach($data as $data){
            $order= new Order;
            $order->name=$data->name;
            $order->email=$data->email;
            $order->phone=$data->phone;
            $order->address=$data->address;
            $order->user_id=$data->user_id;

            $order->product_title=$data->product_title;
            $order->price=$data->price;
            $order->quantity=$data->quantity;
            $order->image=$data->image;
            $order->product_id=$data->product_id;

            $order->payment_status='paid';
            $order->delivery_status='processing';

            $order->save();

            $card_id=$data->id;
            $cart=Carts::find($card_id);
            $cart->delete();
          }
      // Stripe 2nd end
        Session::flash('success', 'Payment successful!');
              
        return back();
    }

    public function show_order(){
        if(Auth::id())
        {
            $id=Auth::user()->id;
            $order=Order::where('user_id','=',$id)->get();
            return view('home.order',compact('order'));
        }
        else
        {
            return redirect('login');
        }

    }

    public function cencle_order($id){
        $order=Order::find($id);
        $order->delivery_status='you cencle the order';
        $order->save();
        return redirect()->back();

    }

    public function add_comment(Request $request){
        if(Auth::id()){
            $comment=new Comment;
            $comment->name=Auth::User()->name;
            $comment->user_id =Auth::User()->id;
            $comment->comment=$request->comment;
            $comment->save();
            return redirect()->back();

        }
        else
        {
            return redirect('login');
            
        }


    }

    public function add_reply(Request $request){
        if(Auth::id()){
        $reply=new Reply;
        $reply->name=Auth::User()->name;
        $reply->user_id=Auth::User()->id;
        $reply->comment_id=$request->commentId;
        $reply->reply=$request->replay;
        $reply->save();
        return redirect()->back();
        }
        else
        {
            return redirect('login');
            
        }

    }

    public function product_search(Request $request){
        $search_text=$request->search;
        $Product=Product::where('title','LIKE',"%$search_text%")->orwhere('catagory','LIKE',"$search_text")->paginate(9);
        $comment=Comment::orderby('id','desc')->limit(3)->get();
        $reply=Reply::orderby('id','desc')->limit(3)->get();
        return view('home.userpage',compact('Product','comment','reply'));
        

    }

    public function all_product(){
        $Product=Product::paginate(9);
        $comment=Comment::orderby('id','desc')->limit(3)->get();
        $reply=Reply::orderby('id','desc')->limit(3)->get();
        return view('home.all_product',compact('Product','comment','reply'));
        
    }
   //all product search jono
    public function search_product(Request $request){
        $search_text=$request->search;
        $Product=Product::where('title','LIKE',"%$search_text%")->orwhere('catagory','LIKE',"$search_text")->paginate(9);
        $comment=Comment::orderby('id','desc')->limit(3)->get();
        $reply=Reply::orderby('id','desc')->limit(3)->get();
        return view('home.all_product',compact('Product','comment','reply'));
        

    }
 
    
}





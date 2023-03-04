<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="images/favicon.png" type="">
      <title>Famms - Fashion HTML Template</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="{{asset('home/css/bootstrap.css')}}" />
      <!-- font awesome style -->
      <link href="{{asset('home/css/font-awesome.min.css')}}" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="{{asset('home/css/style.css')}}" rel="stylesheet" />
      <!-- responsive style -->
      <link href="{{asset('home/css/responsive.css')}}" rel="stylesheet" />
   </head>
   <body>
      <div class="hero_area">
         <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->
         <!-- slider section -->
         @include('home.slider')
         <!-- end slider section -->
      </div>
      <!-- why section -->
      @include('home.why')
     <!-- end why section -->
      
      <!-- arrival section -->
      @include('home.new_arrival')   
      <!-- end arrival section -->
      
      <!-- product section -->
      @include('home.product')
      <!-- end product section -->

      <!--Comment and replay system starts here-->
      <div style="text-align: center; padding-bottom: 30px;">
         <h1 style="font-size:30px; text-align: center;padding-top: 20px;padding-bottom: 20px;">Comments</h1>
         <form action="{{url('/add_comment')}}" method="Post">
            @csrf
            <textarea style="height: 150px; width: 600px" placeholder=
            "Comment samething here" name="comment"></textarea>
            <br>
            <input type="submit" class="btn btn-primary" value="Comment">
         </form>
      </div>

     

      <div style="padding-left: 20%;">
         <h1 style="font-size: 20px; padding-bottom: 20px;">All Comments</h1>
      @foreach($comment as $comment)
         <div>
            <b>{{$comment->name}}</b>
            <p>{{$comment->comment}}</p>
            <a style="color: blue;" href="javascript::void(0);" onclick="replay(this)" data-commentid="{{$comment->id}}">Reply</a>
         </div>
         <!--next reply -->
         @foreach($reply as $rep)
         @if($rep->comment_id==$comment->id)
        <div style="padding-left: 3%; padding-bottom: 10px;">
           <b>{{$rep->name}}</b>
           <p>{{$rep->reply }}</p>
           <a style="color: blue;" href="javascript::void(0);" onclick="replay(this)" data-commentid="{{$comment->id}}">Reply</a>
        </div> 
        @endif
         @endforeach
        <!--next end reply-->
      @endforeach
        
        <!--Replay Textbox-->
         <div style="display: none;" class="replayDiv">
            <form action="{{url('add_reply')}}" method="Post">
               @csrf
            <input type="text" id="commentId" name="commentId" hidden="">
            <textarea style="height: 100px; width: 500px;" name="replay" placeholder="write something here"></textarea>
            <br>
           <button type="submit" class="btn btn-warning">Reply</button>
            <a href="javascript::void(0);" class="btn btn-primary" onclick="replay_close(this)">Close</a>
            </form>
         </div>
      </div>
      <!--Replay end Textbox-->
       <!--Comment and replay system end here-->

      <!-- subscribe section -->
      @include('home.subscribe')
      <!-- end subscribe section -->
      <!-- client section -->
      @include('home.client')
      <!-- end client section -->
      <!-- footer start -->
      @include('home.footer')
      <!-- footer end -->
      <div class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>
         
            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
         
         </p>
      </div>
      <!--Comment  script frist-->
      <script type="text/javascript">
          function replay(caller){
            document.getElementById('commentId').value=$(caller).attr('data-commentid');
            $('.replayDiv').insertAfter($(caller));
            $('.replayDiv').show();

          } 

           function replay_close(caller){
            $('.replayDiv').hide();  

          } 
      </script>
       <!--Comment  script end-->
      <script>
        document.addEventListener("DOMContentLoaded", function(event) { 
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
    </script>
      <!--Comment section end-->
      <!-- jQery -->
      <script src="{{asset('home/js/jquery-3.4.1.min.js')}}"></script>
      <!-- popper js -->
      <script src="{{asset('home/js/popper.min.js')}}"></script>
      <!-- bootstrap js -->
      <script src="{{asset('home/js/bootstrap.js')}}"></script>
      <!-- custom js -->
      <script src="{{asset('home/js/custom.js')}}"></script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   </body>
</html>
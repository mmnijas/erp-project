
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Twitter -->
        <meta name="twitter:site" content="">
        <meta name="twitter:creator" content="">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="">
        <meta name="twitter:description" content="">
        <meta name="twitter:image" content="">
        <!-- Facebook -->
        <meta property="og:url" content="http://themepixels.me/bracketplus">
        <meta property="og:title" content="">
        <meta property="og:description" content="">
        <meta property="og:image" content="">
        <meta property="og:image:secure_url" content="">
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="600">
        <!-- Meta -->
        <meta name="description" content="">
        <meta name="author" content="ThemePixels">
        <title>EASYSTORE | Login Page</title>
        <!-- vendor css -->
        <link href="https://test.easystore.online/template/app/lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <link href="https://test.easystore.online/template/app/lib/ionicons/css/ionicons.min.css&quot; rel=&quot;stylesheet">
        <!-- Bracket CSS -->
        <link rel="stylesheet" href="https://test.easystore.online/template/app/css/bracket.css">
    </head>
    <body>
        <div class="row no-gutters flex-row-reverse ht-100v">
            <div class="col-md-6 bg-gray-200 d-flex align-items-center justify-content-center">
                <div class="login-wrapper wd-250 wd-xl-350 mg-y-30">
                    <form action="{{route('login')}}" method="post">
                        @csrf
                        <h4 class="tx-inverse tx-center">Admin Sign In</h4>
                        <p class="tx-center mg-b-60">Welcome back my friend! Please sign in.</p>
                        <div class="form-group ">
                            <input type="text" name="username" class="form-control" value="" placeholder="Enter your username">
                                                    </div>
                        <!-- form-group -->
                        <div class="form-group ">
                            <input type="password" name="password" class="form-control" value=""  placeholder="Enter your password">
                                                        <a href="" class="tx-info tx-12 d-block mg-t-10">Forgot password?</a>
                        </div>
                        <!-- form-group -->
                        <button type="submit" onClick="$(this).text('Please Wait..')" class="btn btn-danger btn-block">Sign In</button>
                        <!-- <div class="mg-t-60 tx-center">Not yet a member? <a href="" class="tx-info">Sign Up</a></div> -->
                    </form> 
                </div>
                <!-- login-wrapper -->
            </div>
            <!-- col -->
            <div class="col-md-6 bg-br-primary d-flex align-items-center justify-content-center" style="background-image: url({{asset('zencare/zen-bg-2.svg')}});background-size: cover;">
                <img src="{{asset('zencare/zen_1_light.png')}}" class="brand-logo" alt="EASYSTORE" style="position: absolute;top: 30px;left: 30px;max-width: 200px;">
                <div class="wd-250 wd-xl-450 mg-y-30">
                    <div class="signin-logo tx-28 tx-bold"><span class="tx-normal">ZENCARE OFFICE AUTOMATION</div>
                    <div class="tx-green mg-b-60">TECHNOLOGY DRIVEN ERP</div>
                    <h5 class="">Why ZENCARE?</h5>
                    <p class="">ZenCare is a multipurpose office management system. You can use it to manage projects, clients, invoices, support tickets, estimates, team and many other purposes. It is suitable for different types of organizations, freelancers and individual users. ZenCare is fast and easy to use. It contains all essential tools to manage your business.</p>
                    <p class="tx-green-6 mg-b-60"></p>
                    <a target="_blank" href="https://easystore.online" class="btn btn-outline-light bd bd-green bd-2 pd-x-25 tx-uppercase tx-12 tx-spacing-2 tx-medium">WEBSITE</a>
                    <a href="https://test.easystore.online/vendor-login" class="btn btn-outline-light bd bd-green bd-2 pd-x-25 tx-uppercase tx-12 tx-spacing-2 tx-medium">VENDOR</a>
                </div>
                <!-- wd-500 -->
            </div>
        </div>
        <!-- row -->
        <script src="https://test.easystore.online/template/app/lib/jquery/jquery.min.js"></script>
  <script src="https://test.easystore.online/template/app/lib/jquery-ui/ui/widgets/datepicker.js"></script>
  <script src="https://test.easystore.online/template/app/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://test.easystore.online/js/jquery.validate.js"></script>
    </body>
</html>
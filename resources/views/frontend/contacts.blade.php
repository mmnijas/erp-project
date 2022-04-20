@include('frontend.layouts.header')
        <!--WELCOME SLIDER AREA-->
        <section class="service-top-area" style="background-image: url('img/contactbanner.jpg'); background-repeat: no-repeat; text-align: center;  padding: 221px 0px 69px 0px;">
            <div class="container">
            <div class="row">
            <div class="col-md-12">
            <div class="ec-mini-title">
            <h1> Contact</h1>
            </div>
            <div class="ec-breadcrumb">
            <ul>
            <li><a href="index.html">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right" style="color:#ffffff"></i></li>
            <li>Contact</li>
            </ul>
            </div>
            </div>
            </div>
            </div>
            </section>
            
            <section class="contact-area padding-top" id="contact">
                    <div class="contact-form-area">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <div class="contact-details-content wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                                        <h2>Reach <b style="color:#0066cc">Us</b></h2><img src="img/line.png" id="linecnt">
                                        <p>There are many variations of passages of Lorem Ipsum available, but the et majori have suffered alteration in some form, by injected humour, Domised words which don't look even slightly believable. If you are going to use a pas of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        <div class="contact-address-details">
                                            <div class="single-contact">
                                                <div class="contact-icon">
                                                    <i class="fa fa-map-marker"></i>
                                                </div>
                                                <div class="contact-details">
                                                    <h5>Address</h5>
                                                    <p>{{$settings->address}}</p>
                                                </div>
                                            </div>
                                            <div class="single-contact">
                                                <div class="contact-icon">
                                                    <i class="fa fa-phone"></i>
                                                </div>
                                                <div class="contact-details">
                                                    <h5>Phone</h5>
                                                    <p>{{$settings->phone}}</p>
                                                </div>
                                            </div>
                                            <div class="single-contact">
                                                <div class="contact-icon">
                                                    <i class="fa fa-map-marker"></i>
                                                </div>
                                                <div class="contact-details">
                                                    <h5>Email</h5>
                                                    <p>{{$settings->support_mail}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <div class="contact-form mb50 wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                                        <h2>Send Message</h2>
                                        <form action="process.php" id="contact-form" method="post">
                                            <div class="form-group" id="name-field">
                                                <div class="form-input">
                                                    <input type="text" class="form-control" id="form-name" name="form-name" placeholder="Name.." required="">
                                                </div>
                                            </div>
                                            <div class="form-group" id="email-field">
                                                <div class="form-input">
                                                    <input type="email" class="form-control" id="form-email" name="form-email" placeholder="Email.." required="">
                                                </div>
                                            </div>
                                            <div class="form-group" id="phone-field">
                                                <div class="form-input">
                                                    <input type="text" class="form-control" id="form-phone" name="form-phone" placeholder="Subject..">
                                                </div>
                                            </div>
                                            <div class="form-group" id="message-field">
                                                <div class="form-input">
                                                    <textarea class="form-control" rows="6" id="form-message" name="form-message" placeholder="Your Message Here..." required=""></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit">Send Message</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <iframe src="{{$settings->map}}"  style="border:0;width: 100%;height: 300px;" allowfullscreen="" loading="lazy"></iframe></div>
                            </div>
                        </div>
                          
                    </div>
                </section>
                <!--INFO AREA END-->
        
@include('frontend.layouts.footer')
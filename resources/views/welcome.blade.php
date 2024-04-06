<x-app-layout>

    <body data-bs-spy="scroll" data-bs-target=".navbar-nav">
    <!-- Spinner Start -->
    <div id="spinner"
         class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow border-top border-5 border-primary sticky-top p-0"
         dir="rtl">
        <a href="#Home" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 200px;">
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse" style="margin-left: 1rem;">
            <div class="navbar-nav p-4 p-lg-0">
                <a href="#Home" class="nav-item nav-link active">{{ __("Home") }}</a>
                <a href="#About" class="nav-item nav-link">{{ __("About") }}</a>
                <a href="#Services" class="nav-item nav-link">{{ __("Services") }}</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ __("Pages") }}</a>
                    <div class="dropdown-menu fade-up m-0">
                        <a href="#Pricing" class="dropdown-item">{{ __("Calculate Your Shipping Cost") }}</a>
                        <a href="#Features" class="dropdown-item">{{ __("Features") }}</a>
                    </div>
                </div>
                <a href="#Contact" class="nav-item nav-link">{{ __("Contact Us") }}</a>
            </div>
            <div class="d-flex align-items-center me-auto p-lg-0 gap-3 ">
                <a href="/user/login" class="btn btn-primary py-2 px-4 me-4 rounded-3"
                   style="height: fit-content;">{{ __("Login") }}</a>
                <a href="/user/register" class="btn btn-secondary py-2 px-4 rounded-3"
                   style="height: fit-content;">{{ __("Register") }}</a>

                <!-- Language Switcher Button -->

                <form action="{{ route('language.switch') }}" method="POST" class="d-inline-block">
                    @csrf
                    <div class="input-group">
                        <label for="languageSelect" class="visually-hidden">Language</label>
                        <select name="language" onchange="this.form.submit()"
                                class="form-select rounded-start bg-light text-dark border-0" id="languageSelect">
                            <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>English</option>
                            <option value="ar" {{ app()->getLocale() === 'ar' ? 'selected' : '' }}>العربية</option>
                        </select>
                    </div>
                </form>


                <!-- End Language Switcher Button -->
            </div>
        </div>
    </nav>

    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0 pb-5" id="Home" dir="ltr">
        <div class="owl-carousel header-carousel position-relative mb-5">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid flip" src="{{asset('img/carousel-1.jpg')}}">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                     style="background: rgba(6, 3, 21, .5);">
                    <div class="container">
                        <div class="row justify-content-start" dir="{{ App::getLocale() == 'en' ? 'ltr' : 'rtl' }}">
                            <div class="col-10 col-lg-8">
                                <h5 class="text-white text-uppercase mb-3 animated slideInDown">{{__("Reliable delivery and accurate tracking")}}</h5>
                                <h1 class="display-3 text-white animated slideInDown mb-4">{{__('We are the optimal shipping journey')}}</h1>
                                <p class="fs-5 fw-medium text-white mb-4 pb-2">
                                    {{__("We are a shipping and tracking company that specializes in providing fast and efficient shipping solutions to our customers across the country We aim to meet the needs of our customers by providing high-quality and reliable shipping services")}}</p>
                                <a href="/user/login"
                                   class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">{{__('Sign In')}}</a>
                                <a href="#Pricing" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">
                                    {{__('Calculate the cost of your shipment')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--            <div class="owl-carousel-item position-relative">--}}
            {{--                <img class="img-fluid" src="img/carousel-2.jpg" alt="">--}}
            {{--                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"--}}
            {{--                     style="background: rgba(6, 3, 21, .5);">--}}
            {{--                    <div class="container">--}}
            {{--                        <div class="row justify-content-start">--}}
            {{--                            <div class="col-10 col-lg-8">--}}
            {{--                                <h5 class="text-white text-uppercase mb-3 animated slideInDown">Transport & Logistics--}}
            {{--                                    Solution</h5>--}}
            {{--                                <h1 class="display-3 text-white animated slideInDown mb-4">#1 Place For Your <span--}}
            {{--                                        class="text-primary">Transport</span> Solution</h1>--}}
            {{--                                <p class="fs-5 fw-medium text-white mb-4 pb-2">Vero elitr justo clita lorem. Ipsum dolor at sed stet sit diam no. Kasd rebum ipsum et diam justo clita et kasd rebum sea elitr.</p>--}}
            {{--                                <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read--}}
            {{--                                    More</a>--}}
            {{--                                <a href="" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Free--}}
            {{--                                    Quote</a>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>
    </div>
    <!-- Carousel End -->


    <!-- About Start -->
    <div class="container-fluid overflow-hidden py-5 px-lg-0" id="About"
    >
        <div class="container about py-5 px-lg-0">
            <div class="row g-5 mx-lg-0">
                <div class="col-lg-6 ps-lg-0 wow fadeInLeft" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute img-fluid w-100 h-100" src="img/about.jpg"
                             style="object-fit: cover;" alt="">
                    </div>
                </div>
                <div class="col-lg-6 about-text wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class=" text-uppercase mb-3">{{__('About Us')}}</h6>
                    <h1 class="text-primary mb-5">{{__("We make your shipping journey a unique and reliable experience")}}</h1>
                    <p class="mb-5">
                        {{__("We provide you with fast and efficient transportation and logistics solutions We are here to ensure that we provide the best services with high efficiency and on time")}}

                    </p>
                    <div class="row g-4 mb-5">
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                            <x-calculation-icon/>
                            <h5>{{__("Pre-calculate the cost of the shipment")}}</h5>
                            <p class="m-0">{{__("We provide you with the ability to easily calculate the cost of your shipment through our website by entering your shipment data")}}</p>
                        </div>
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                            <x-car-icon/>
                            <h5>{{__("Delivery on time")}}</h5>
                            <p class="m-0">{{__("We guarantee that shipments are delivered on time You can count on us to ensure that your order arrives on time without delay")}}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Fact Start -->
    <div class="container-xxl py-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h1 class="mb-5 text-primary">{{__("Your shipment is our commitment")}}</h1>
                    <p class="mb-5">{{__("Our carefully designed website provides you with an easy experience to easily track status around the clock")}}</p>
                    <div class="d-flex align-items-center">
                        <x-call-icon/>
                        <div class="px-4">
                            <h6>{{__("keep in touch")}}</h6>
                            <h3 class="text-primary m-0" dir="ltr">+218 0911111111</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-4 align-items-center">
                        <div class="col-sm-6">
                            <div class="bg-primary p-4 mb-4 wow fadeIn" style="border-radius: 30px"
                                 data-wow-delay="0.3s">

                                <x-users-icon/>
                                <h2 class="text-white mb-2" data-toggle="counter-up">{{$customers}}</h2>
                                <p class="text-white mb-0">{{__("Happy Customers")}}</p>
                            </div>
                            <div class=" p-4 wow fadeIn" style="border-radius: 30px; background-color: #4ac8ff"
                                 data-wow-delay="0.5s">
                                <x-shiping-car/>
                                <h2 class="text-white mb-2" data-toggle="counter-up">{{$completedPackages}}</h2>
                                <p class="text-white mb-0">{{__('Completed shipments')}}</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class=" p-4 wow fadeIn"
                                 style="border-radius: 30px; background-color: #fadd02" data-wow-delay="0.7s">
                                <x-stars-icon/>
                                <h2 class="text-white mb-2" data-toggle="counter-up">{{$avgRating}}</h2>
                                <p class="text-white mb-0">{{__('Customer reviews')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fact End -->


    <!-- Service Start -->
    <div class="container-xxl py-5" id="Services">
        <div class="container py-5">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class=" text-uppercase">{{__('Our services')}}</h6>
                <h1 class="text-primary mb-5">{{__("Explore our services")}}</h1>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item p-4">
                        <div class="overflow-hidden mb-4">
                            <img class="img-fluid" src="img/service-1.jpg" alt="">
                        </div>
                        <h4 class="mb-3">{{__("Air Shipping")}}</h4>
                        <p>{{__("Our Air Shipping services provide fast and reliable transportation of goods as quickly and efficiently as possible")}}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item p-4">
                        <div class="overflow-hidden mb-4">
                            <img class="img-fluid" src="img/service-2.jpg" alt="">
                        </div>
                        <h4 class="mb-3">{{__("Sea Shipping")}}</h4>
                        <p>{{__("We offer a comprehensive range of Sea Shipping services for all types of full container loads and combined cargo shipments")}}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item p-4">
                        <div class="overflow-hidden mb-4">
                            <img class="img-fluid" src="img/service-3.jpg" alt="">
                        </div>
                        <h4 class="mb-3">{{__("Land Shipping")}}</h4>
                        <p>{{__("We provide flexible and efficient Land Shipping services to ensure that your shipment arrives as quickly as possible and with the highest level of quality")}}</p>
                    </div>
                </div>
                <!-- Add the remaining service items similarly -->
            </div>
        </div>
        {{--        <div class="container py-5">--}}
        {{--            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">--}}
        {{--                <h6 class="text-secondary text-uppercase">Our Services</h6>--}}
        {{--                <h1 class="mb-5">Explore Our Services</h1>--}}
        {{--            </div>--}}
        {{--            <div class="row g-4">--}}
        {{--                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">--}}
        {{--                    <div class="service-item p-4">--}}
        {{--                        <div class="overflow-hidden mb-4">--}}
        {{--                            <img class="img-fluid" src="img/service-1.jpg" alt="">--}}
        {{--                        </div>--}}
        {{--                        <h4 class="mb-3">Air Freight</h4>--}}
        {{--                        <p>Stet stet justo dolor sed duo. Ut clita sea sit ipsum diam lorem diam.</p>--}}
        {{--                        <a class="btn-slide mt-2" href=""><i class="fa fa-arrow-right"></i><span>Read More</span></a>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">--}}
        {{--                    <div class="service-item p-4">--}}
        {{--                        <div class="overflow-hidden mb-4">--}}
        {{--                            <img class="img-fluid" src="img/service-2.jpg" alt="">--}}
        {{--                        </div>--}}
        {{--                        <h4 class="mb-3">Ocean Freight</h4>--}}
        {{--                        <p>Stet stet justo dolor sed duo. Ut clita sea sit ipsum diam lorem diam.</p>--}}
        {{--                        <a class="btn-slide mt-2" href=""><i class="fa fa-arrow-right"></i><span>Read More</span></a>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.7s">--}}
        {{--                    <div class="service-item p-4">--}}
        {{--                        <div class="overflow-hidden mb-4">--}}
        {{--                            <img class="img-fluid" src="img/service-3.jpg" alt="">--}}
        {{--                        </div>--}}
        {{--                        <h4 class="mb-3">Road Freight</h4>--}}
        {{--                        <p>Stet stet justo dolor sed duo. Ut clita sea sit ipsum diam lorem diam.</p>--}}
        {{--                        <a class="btn-slide mt-2" href=""><i class="fa fa-arrow-right"></i><span>Read More</span></a>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">--}}
        {{--                    <div class="service-item p-4">--}}
        {{--                        <div class="overflow-hidden mb-4">--}}
        {{--                            <img class="img-fluid" src="img/service-4.jpg" alt="">--}}
        {{--                        </div>--}}
        {{--                        <h4 class="mb-3">Train Freight</h4>--}}
        {{--                        <p>Stet stet justo dolor sed duo. Ut clita sea sit ipsum diam lorem diam.</p>--}}
        {{--                        <a class="btn-slide mt-2" href=""><i class="fa fa-arrow-right"></i><span>Read More</span></a>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">--}}
        {{--                    <div class="service-item p-4">--}}
        {{--                        <div class="overflow-hidden mb-4">--}}
        {{--                            <img class="img-fluid" src="img/service-5.jpg" alt="">--}}
        {{--                        </div>--}}
        {{--                        <h4 class="mb-3">Customs Clearance</h4>--}}
        {{--                        <p>Stet stet justo dolor sed duo. Ut clita sea sit ipsum diam lorem diam.</p>--}}
        {{--                        <a class="btn-slide mt-2" href=""><i class="fa fa-arrow-right"></i><span>Read More</span></a>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.7s">--}}
        {{--                    <div class="service-item p-4">--}}
        {{--                        <div class="overflow-hidden mb-4">--}}
        {{--                            <img class="img-fluid" src="img/service-6.jpg" alt="">--}}
        {{--                        </div>--}}
        {{--                        <h4 class="mb-3">Warehouse Solutions</h4>--}}
        {{--                        <p>Stet stet justo dolor sed duo. Ut clita sea sit ipsum diam lorem diam.</p>--}}
        {{--                        <a class="btn-slide mt-2" href=""><i class="fa fa-arrow-right"></i><span>Read More</span></a>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>
    <!-- Service End -->


    <!-- Feature Start -->
    <div class="container-fluid overflow-hidden py-5 px-lg-0" id="Features">
        <div class="container feature py-5 px-lg-0">
            <div class="row g-5 mx-lg-0">
                <div class="col-lg-6 feature-text wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class=" text-uppercase mb-3">{{__("Our features")}}</h6>
                    <h1 class="text-primary mb-5">{{__("Take advantage of our diverse services - everything you need in one place")}}</h1>
                    <div class="d-flex mb-5 wow fadeInUp" data-wow-delay="0.3s">
                        {{--                        <i class="fa fa-globe text-primary fa-3x flex-shrink-0"></i>--}}
                        <x-signature-icon/>
                        <div class="mx-4">
                            <h5>{{__("Digital Signature")}}</h5>
                            <p class="mb-0">{{__("Digital Signature is easy and effective for confirming receipt of your shipment")}}</p>
                        </div>
                    </div>
                    <div class="d-flex mb-5 wow fadeIn" data-wow-delay="0.5s">
                        <x-car-icon-w/>
                        <div class="mx-4">
                            <h5>{{__("Fast Shipping")}}</h5>
                            <p class="mb-0">{{__("Enjoy fast and high-quality shipping services, no need to wait")}}</p>
                        </div>
                    </div>
                    <div class="d-flex mb-0 wow fadeInUp" data-wow-delay="0.7s">
                        <x-call-icon/>
                        <div class="mx-4">
                            <h5>{{ __("24/7 Phone Support") }}</h5>
                            <p class="mb-0">{{ __("We're here to assist you anytime You can call us around the clock for support and assistance") }}</p>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6 pe-lg-0 wow fadeInRight" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute img-fluid w-100 h-100" src="img/feature.jpg"
                             style="object-fit: cover;" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End -->


    <!-- Pricing Start -->
    <div class="container-xxl " id="Pricing">
        <div class="container ">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="mb-5 text-primary">{{__("Calculate the cost of your shipment")}}</h1>
            </div>

            <div id="iframe-container" style="padding: 20px; overflow: hidden;">
                <iframe id="dynamic-iframe" src="{{ route('calculator') }}" title="description"
                        style="width: 100%; border: none;"></iframe>
            </div>

            <script>
                // Wait for the iframe content to load
                window.onload = function () {
                    // Get the iframe and its document
                    var iframe = document.getElementById('dynamic-iframe');
                    var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;

                    // Set the height of the iframe to match the height of its content
                    iframe.style.height = iframeDocument.documentElement.scrollHeight + 'px';
                };
            </script>


        </div>
    </div>
    <!-- Pricing End -->

    {{--  Fqa start  --}}
    <!-- FAQ 1 - Bootstrap Brain Component -->
    <section class=" py-3 py-md-5" dir="ltr">
        <div class="container">
            <div class="row gy-5 gy-lg-0 align-items-lg-center">
                <div class="col-12 col-lg-6">
                    <img class="img-fluid rounded" loading="lazy" src="./assets/img/faq-img-1.png"
                         alt="How can we help you?">
                </div>
                <div class="col-12 col-lg-6">
                    <div class="row justify-content-xl-end">
                        <div class="col-12 col-xl-11">
                            <h2 class="h1 mb-3 text-primary">{{__("How can we help you?")}}</h2>
                            <p class="lead fs-4  mb-5">{{__("We hope you have found an answer to your question. If you need any help, please search your query on our Support Center or contact us via email.")}}</p>
                            <div class="accordion accordion-flush" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne"
                                                aria-controls="collapseOne">
                                            {{__('What services does ShipLink company offer?')}}
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                         aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>{{__('ShipLink company offers air,sea and land shipping in addition to extra services such as fast shipping and insurance.')}}</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                            {{__('What is the difference between actual weight and volumetric weight?')}}
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                         aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            {{__('Actual weight is the weight of the package while volumetric weight takes into consideration the dimensions of the package. For example, if you order a tall vase, the volumetric package weight will be calculated based on the Length x Width x Height divided by 5000.
When your package is received at our facility, we calculate both the actual weight of the package and its volumetric weight; the larger figure will be applied to your package. This procedure is followed by all airlines and freight forwarding companies.')}}
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                aria-expanded="false" aria-controls="collapseThree">
                                          {{__('What are the items that cannot be shipped?')}}
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                         aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>{{__("Since ShipLink is following the country's civil defense regulations, we do not ship the following items:")}}</p>
                                            <ul>
                                                <li>{{__('Illegal items')}}</li>
                                                <li>{{__("Explosives")}}
                                                </li>
                                                <li>{{__('Living tissues')}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{--  Fqa end  --}}

    <!-- Quote Start -->
    <div class="container-xxl py-5" id="Contact">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class=" text-uppercase mb-3">{{ __("Contact Us") }}</h6>
                    <h1 class="mb-5 text-primary">{{ __("Contact Us Now!") }}</h1>
                    <p class="mb-5 ">{{ __("We are here to help and answer your inquiries, feel free to contact us for support") }}</p>
                    <div class="d-flex align-items-center">
                        <x-call-icon/>
                        <div class="px-4">
                            <h6>{{ __("Call for any inquiry!") }}</h6>
                            <h3 class="text-primary m-0" dir="ltr">+218 0911111111</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="bg-light text-center p-5 wow fadeIn" data-wow-delay="0.5s">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{session('success')}}
                            </div>
                        @endif
                        <form action="{{route('contact.store')}}" method="post">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <input type="text" class="form-control border-0" placeholder="{{ __("Full Name") }}"
                                           style="height: 55px;" name="name" required>
                                </div>
                                <div class="col-12">
                                    <input type="email" class="form-control border-0"
                                           placeholder="{{ __("Email Address") }}"
                                           style="height: 55px;" name="email" required>
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control border-0"
                                           placeholder="{{ __("Phone Number") }}"
                                           style="height: 55px;" name="phone" required>
                                </div>
                                <div class="col-12">
                                <textarea class="form-control border-0" placeholder="{{ __("Your Message") }}"
                                          name="message"
                                          required></textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">{{ __("Send") }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 wow fadeIn" data-wow-delay="0.1s" id="footer"
         style="margin-top: 6rem;">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">{{ __("Address") }}</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>{{ __("Tripoli, Libya") }}</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+218 0911111111</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@shiplink.ly</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">{{ __("Services") }}</h4>
                    <a class="btn btn-link" href="">{{ __("Air Shipping") }}</a>
                    <a class="btn btn-link" href="">{{ __("Sea Shipping") }}</a>
                    <a class="btn btn-link" href="">{{ __("Land Shipping") }}</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">{{ __("Quick Links") }}</h4>
                    <a class="btn btn-link" href="#About">{{ __("About Us") }}</a>
                    <a class="btn btn-link" href="#Contact">{{ __("Contact Us") }}</a>
                    <a class="btn btn-link" href="#Services">{{ __("Our Services") }}</a>
                    <a class="btn btn-link" href="#Pricing">{{ __("Calculate Your Shipping Cost") }}</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">{{ __("Subscribe") }}</h4>
                    <p>{{ __("You can create a new account to use our services in more than one place") }}</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Email">
                        <a href="/user/register" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">
                            {{ __("Register") }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">ShipLink.ly</a>, {{ __("All Right Reserved.") }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-0 back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('lib/counterup/counterup.min.js')}}"></script>
    <script src="{{asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('js/main.js')}}"></script>
    </body>
</x-app-layout>



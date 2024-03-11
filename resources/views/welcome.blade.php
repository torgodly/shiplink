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
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow border-top border-5 border-primary sticky-top p-0">
        <a href="#Home" class="navbar-brand  d-flex align-items-center px-4 px-lg-5">
            {{--            <h2 class="mb-2 text-white">ShipLink</h2>--}}
            {{--            <x-app-logo class="ms-2" />--}}
            <img src="{{asset('images/logo.png')}}" width="300">
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav me-auto p-4 p-lg-0">
                <a href="#Home" class="nav-item nav-link active">الرئيسية</a>
                <a href="#About" class="nav-item nav-link">حول</a>
                <a href="#Services" class="nav-item nav-link">خدمات</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">صفحات</a>
                    <div class="dropdown-menu fade-up m-0">
                        <a href="#Pricing" class="dropdown-item">خطط التسعير</a>
                        <a href="#Features" class="dropdown-item">الميزات</a>
                        {{--                        <a href="#Free_Quote" class="dropdown-item">عرض سعر مجاني</a>--}}
                        {{--                        <a href="#Team" class="dropdown-item">فريقنا</a>--}}
                        {{--                        <a href="#Testimonial" class="dropdown-item">الشهادات</a>--}}
                    </div>
                </div>
                <a href="#Contact" class="nav-item nav-link">اتصل بنا</a>
            </div>
            <h4 class="m-0 pe-lg-5 d-none d-lg-block"><i class="fa fa-headphones text-primary me-3"></i>+218 0911111111
            </h4>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0 pb-5" id="Home">
        {{--        <div class="owl-carousel header-carousel position-relative mb-5">--}}
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="{{asset('img/carousel-1.jpg')}}" alt="">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                 style="background: rgba(6, 3, 21, .5);">
                <div class="container">
                    <div class="row justify-content-start" dir="rtl">
                        <div class="col-10 col-lg-8">
                            <h5 class="text-white text-uppercase mb-3 animated slideInDown">حلول النقل
                                واللوجستيات</h5>
                            <h1 class="display-3 text-white animated slideInDown mb-4">#1 مكان لحلولك في <span
                                    class="text-primary">اللوجستيات</span></h1>
                            <p class="fs-5 fw-medium text-white mb-4 pb-2">توفر حلولنا مزيجًا مثاليًا من الكفاءة والموثوقية لتلبية احتياجاتك في النقل واللوجستيات. نحن نهتم بكل تفاصيل عملك لضمان وصول سلس وفعال لبضائعك.</p>
                            <a href="/user/login" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">تسجيل</a>
                            <a href="#Pricing" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">احسب
                                سعر
                                شحنتك</a>
                        </div>
                    </div>
                </div>
            </div>
            {{--            </div>--}}
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
    <div class="container-fluid overflow-hidden py-5 px-lg-0" id="About">
        <div class="container about py-5 px-lg-0">
            <div class="row g-5 mx-lg-0">
                <div class="col-lg-6 ps-lg-0 wow fadeInLeft" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute img-fluid w-100 h-100" src="img/about.jpg"
                             style="object-fit: cover;" alt="">
                    </div>
                </div>
                <div class="col-lg-6 about-text wow fadeInUp" data-wow-delay="0.3s" dir="rtl">
                    <h6 class="text-secondary text-uppercase mb-3">معلومات عنا</h6>
                    <h1 class="mb-5">حلول النقل واللوجستيات السريعة</h1>
                    <p class="mb-5">نقدم حلولاً سريعة وفعالة للنقل واللوجستيات. معنا، ستجد الحلا الأمثل لتلبية احتياجاتك. نحن هنا لتوفير أفضل الخدمات بكفاءة عالية وبوقت دقيق.</p>
                    <div class="row g-4 mb-5">
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                            <i class="fa fa-globe fa-3x text-primary mb-3"></i>
                            <h5>تغطية عالمية</h5>
                            <p class="m-0">نحن نغطي العديد من الوجهات حول العالم. اعتماداً على احتياجاتك، سنوصل شحناتك إلى أي مكان ترغب فيه.</p>
                        </div>
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                            <i class="fa fa-shipping-fast fa-3x text-primary mb-3"></i>
                            <h5>تسليم في الوقت المحدد</h5>
                            <p class="m-0">نحن نضمن تسليم الشحنات في الوقت المحدد. يمكنك الاعتماد علينا لضمان وصول طلبك في الوقت المناسب دون تأخير.</p>
                        </div>
                    </div>
                    <a href="#" class="btn btn-primary py-3 px-5">استكشاف المزيد</a>
                </div>

            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Fact Start -->
    <div class="container-xxl py-5">
        <div class="container py-5" dir="rtl">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="text-secondary text-uppercase mb-3">بعض الحقائق</h6>
                    <h1 class="mb-5">#1 مكان لإدارة جميع شحناتك</h1>
                    <p class="mb-5">توفر خدمتنا حلولًا فعالة لإدارة جميع شحناتك بكل سهولة ويسر. نحن هنا لتوفير أفضل الخدمات لتلبية احتياجات عملك.</p>
                    <div class="d-flex align-items-center">
                        <i class="fa fa-headphones fa-2x flex-shrink-0 bg-primary p-3 text-white"></i>
                        <div class="pe-4">
                            <h6>اتصل لأي استفسار!</h6>
                            <h3 class="text-primary m-0" dir="ltr">+218 0911111111</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-4 align-items-center">
                        <div class="col-sm-6">
                            <div class="bg-primary p-4 mb-4 wow fadeIn" data-wow-delay="0.3s">
                                <i class="fa fa-users fa-2x text-white mb-3"></i>
                                <h2 class="text-white mb-2" data-toggle="counter-up">1234</h2>
                                <p class="text-white mb-0">عملاء سعداء</p>
                            </div>
                            <div class="bg-secondary p-4 wow fadeIn" data-wow-delay="0.5s">
                                <i class="fa fa-ship fa-2x text-white mb-3"></i>
                                <h2 class="text-white mb-2" data-toggle="counter-up">1234</h2>
                                <p class="text-white mb-0">شحنات مكتملة</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="bg-success p-4 wow fadeIn" data-wow-delay="0.7s">
                                <i class="fa fa-star fa-2x text-white mb-3"></i>
                                <h2 class="text-white mb-2" data-toggle="counter-up">1234</h2>
                                <p class="text-white mb-0">تقييمات العملاء</p>
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
        <div class="container py-5" dir="rtl">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-secondary text-uppercase">خدماتنا</h6>
                <h1 class="mb-5">استكشف خدماتنا</h1>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item p-4">
                        <div class="overflow-hidden mb-4">
                            <img class="img-fluid" src="img/service-1.jpg" alt="">
                        </div>
                        <h4 class="mb-3">شحن جوي</h4>
                        <p>توفر خدمتنا شحن جوي سريع وموثوق. اكتشف كيف يمكننا مساعدتك في نقل بضائعك بأمان وسرعة.</p>
                        <a class="btn-slide mt-2" href=""><i class="fa fa-arrow-left"></i><span>اقرأ المزيد</span></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item p-4">
                        <div class="overflow-hidden mb-4">
                            <img class="img-fluid" src="img/service-2.jpg" alt="">
                        </div>
                        <h4 class="mb-3">شحن بحري</h4>
                        <p>نحن نقدم خدمات شحن بحري موثوقة وفعالة. تعرف على خيارات الشحن البحري التي نقدمها لتلبية احتياجاتك.</p>
                        <a class="btn-slide mt-2" href=""><i class="fa fa-arrow-left"></i><span>اقرأ المزيد</span></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item p-4">
                        <div class="overflow-hidden mb-4">
                            <img class="img-fluid" src="img/service-3.jpg" alt="">
                        </div>
                        <h4 class="mb-3">شحن بري</h4>
                        <p>نقدم خدمات شحن بري موثوقة وفعالة. اعرف المزيد عن خدمات النقل البري التي نقدمها لعملائنا.</p>
                        <a class="btn-slide mt-2" href=""><i class="fa fa-arrow-left"></i><span>اقرأ المزيد</span></a>
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
                <div class="col-lg-6 feature-text wow fadeInUp" data-wow-delay="0.1s" dir="rtl">
                    <h6 class="text-secondary text-uppercase mb-3">ميزاتنا</h6>
                    <h1 class="mb-5">نحن شركة لوجستية موثوقة منذ عام 1990</h1>
                    <div class="d-flex mb-5 wow fadeInUp" data-wow-delay="0.3s">
                        <i class="fa fa-globe text-primary fa-3x flex-shrink-0"></i>
                        <div class="me-4">
                            <h5>خدمة عالمية</h5>
                            <p class="mb-0">نقدم خدماتنا حول العالم، نحن هنا لضمان وصول شحناتك إلى أي مكان في العالم بسرعة وأمان.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-5 wow fadeIn" data-wow-delay="0.5s">
                        <i class="fa fa-shipping-fast text-primary fa-3x flex-shrink-0"></i>
                        <div class="me-4">
                            <h5>تسليم في الوقت المحدد</h5>
                            <p class="mb-0">نحن نلتزم بتقديم خدمات التسليم في الوقت المحدد، لتأكيد وصول شحناتك إلى وجهتها في الوقت المناسب.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-0 wow fadeInUp" data-wow-delay="0.7s">
                        <i class="fa fa-headphones text-primary fa-3x flex-shrink-0"></i>
                        <div class="me-4">
                            <h5>دعم هاتفي على مدار الساعة</h5>
                            <p class="mb-0">نحن هنا لمساعدتك في أي وقت، يمكنك الاتصال بنا على مدار الساعة للحصول على الدعم والمساعدة.</p>
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
    <div class="container-xxl py-5" id="Pricing">
        <div class="container py-5">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                {{--                <h6 class="text-secondary text-uppercase">Pricing Plan</h6>--}}
                <h1 class="mb-5">احسب تكلفة شحنتك</h1>
            </div>
            {{--            <div class="row g-4">--}}
            {{--                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">--}}
            {{--                    <div class="price-item">--}}
            {{--                        <div class="border-bottom p-4 mb-4">--}}
            {{--                            <h5 class="text-primary mb-1">Basic Plan</h5>--}}
            {{--                            <h1 class="display-5 mb-0">--}}
            {{--                                <small class="align-top"--}}
            {{--                                       style="font-size: 22px; line-height: 45px;">$</small>49.00<small--}}
            {{--                                    class="align-bottom" style="font-size: 16px; line-height: 40px;">/ Month</small>--}}
            {{--                            </h1>--}}
            {{--                        </div>--}}
            {{--                        <div class="p-4 pt-0">--}}
            {{--                            <p><i class="fa fa-check text-success me-3"></i>HTML5 & CSS3</p>--}}
            {{--                            <p><i class="fa fa-check text-success me-3"></i>Bootstrap v5</p>--}}
            {{--                            <p><i class="fa fa-check text-success me-3"></i>FontAwesome Icons</p>--}}
            {{--                            <p><i class="fa fa-check text-success me-3"></i>Responsive Layout</p>--}}
            {{--                            <p><i class="fa fa-check text-success me-3"></i>Cross-browser Support</p>--}}
            {{--                            <a class="btn-slide mt-2" href=""><i--}}
            {{--                                    class="fa fa-arrow-right"></i><span>Order Now</span></a>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">--}}
            {{--                    <div class="price-item">--}}
            {{--                        <div class="border-bottom p-4 mb-4">--}}
            {{--                            <h5 class="text-primary mb-1">Standard Plan</h5>--}}
            {{--                            <h1 class="display-5 mb-0">--}}
            {{--                                <small class="align-top"--}}
            {{--                                       style="font-size: 22px; line-height: 45px;">$</small>99.00<small--}}
            {{--                                    class="align-bottom" style="font-size: 16px; line-height: 40px;">/ Month</small>--}}
            {{--                            </h1>--}}
            {{--                        </div>--}}
            {{--                        <div class="p-4 pt-0">--}}
            {{--                            <p><i class="fa fa-check text-success me-3"></i>HTML5 & CSS3</p>--}}
            {{--                            <p><i class="fa fa-check text-success me-3"></i>Bootstrap v5</p>--}}
            {{--                            <p><i class="fa fa-check text-success me-3"></i>FontAwesome Icons</p>--}}
            {{--                            <p><i class="fa fa-check text-success me-3"></i>Responsive Layout</p>--}}
            {{--                            <p><i class="fa fa-check text-success me-3"></i>Cross-browser Support</p>--}}
            {{--                            <a class="btn-slide mt-2" href=""><i--}}
            {{--                                    class="fa fa-arrow-right"></i><span>Order Now</span></a>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.7s">--}}
            {{--                    <div class="price-item">--}}
            {{--                        <div class="border-bottom p-4 mb-4">--}}
            {{--                            <h5 class="text-primary mb-1">Advanced Plan</h5>--}}
            {{--                            <h1 class="display-5 mb-0">--}}
            {{--                                <small class="align-top"--}}
            {{--                                       style="font-size: 22px; line-height: 45px;">$</small>149.00<small--}}
            {{--                                    class="align-bottom" style="font-size: 16px; line-height: 40px;">/ Month</small>--}}
            {{--                            </h1>--}}
            {{--                        </div>--}}
            {{--                        <div class="p-4 pt-0">--}}
            {{--                            <p><i class="fa fa-check text-success me-3"></i>HTML5 & CSS3</p>--}}
            {{--                            <p><i class="fa fa-check text-success me-3"></i>Bootstrap v5</p>--}}
            {{--                            <p><i class="fa fa-check text-success me-3"></i>FontAwesome Icons</p>--}}
            {{--                            <p><i class="fa fa-check text-success me-3"></i>Responsive Layout</p>--}}
            {{--                            <p><i class="fa fa-check text-success me-3"></i>Cross-browser Support</p>--}}
            {{--                            <a class="btn-slide mt-2" href=""><i--}}
            {{--                                    class="fa fa-arrow-right"></i><span>Order Now</span></a>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <iframe src="http://shiplink.test/calculator" title="description" style=" height: 100vh"
                    width="100%"></iframe>


        </div>
    </div>
    <!-- Pricing End -->


    <!-- Quote Start -->
    <div class="container-xxl py-5" id="Contact">
        <div class="container py-5">
            <div class="row g-5 align-items-center" dir="rtl">
                <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="text-secondary text-uppercase mb-3">اتصل بنا</h6>
                    <h1 class="mb-5">اتصل بنا الآن!</h1>
                    <p class="mb-5">نحن هنا لتقديم المساعدة والإجابة على استفساراتك، لا تتردد في الاتصال بنا للحصول على الدعم.</p>
                    <div class="d-flex align-items-center">
                        <i class="fa fa-headphones fa-2x flex-shrink-0 bg-primary p-3 text-white"></i>
                        <div class="pe-4">
                            <h6>اتصل لأي استفسار!</h6>
                            <h3 class="text-primary m-0" dir="ltr">+218 0911111111</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="bg-light text-center p-5 wow fadeIn" data-wow-delay="0.5s">
                        <form action="/submit_contact_form" method="post">
                            <div class="row g-3">
                                <div class="col-12">
                                    <input type="text" class="form-control border-0" placeholder="الاسم الكامل"
                                           style="height: 55px;" name="name" required>
                                </div>
                                <div class="col-12">
                                    <input type="email" class="form-control border-0" placeholder="البريد الإلكتروني"
                                           style="height: 55px;" name="email" required>
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control border-0" placeholder="رقم الجوال"
                                           style="height: 55px;" name="phone" required>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control border-0" placeholder="رسالتك" name="message"
                                              required></textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">إرسال</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Quote End -->


    <!-- Team Start -->
    {{--    <div class="container-xxl py-5" id="Team">--}}
    {{--        <div class="container py-5">--}}
    {{--            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">--}}
    {{--                <h6 class="text-secondary text-uppercase">Our Team</h6>--}}
    {{--                <h1 class="mb-5">Expert Team Members</h1>--}}
    {{--            </div>--}}
    {{--            <div class="row g-4">--}}
    {{--                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">--}}
    {{--                    <div class="team-item p-4">--}}
    {{--                        <div class="overflow-hidden mb-4">--}}
    {{--                            <img class="img-fluid" src="img/team-1.jpg" alt="">--}}
    {{--                        </div>--}}
    {{--                        <h5 class="mb-0">Full Name</h5>--}}
    {{--                        <p>Designation</p>--}}
    {{--                        <div class="btn-slide mt-1">--}}
    {{--                            <i class="fa fa-share"></i>--}}
    {{--                            <span>--}}
    {{--                                <a href=""><i class="fab fa-facebook-f"></i></a>--}}
    {{--                                <a href=""><i class="fab fa-twitter"></i></a>--}}
    {{--                                <a href=""><i class="fab fa-instagram"></i></a>--}}
    {{--                            </span>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">--}}
    {{--                    <div class="team-item p-4">--}}
    {{--                        <div class="overflow-hidden mb-4">--}}
    {{--                            <img class="img-fluid" src="img/team-2.jpg" alt="">--}}
    {{--                        </div>--}}
    {{--                        <h5 class="mb-0">Full Name</h5>--}}
    {{--                        <p>Designation</p>--}}
    {{--                        <div class="btn-slide mt-1">--}}
    {{--                            <i class="fa fa-share"></i>--}}
    {{--                            <span>--}}
    {{--                                <a href=""><i class="fab fa-facebook-f"></i></a>--}}
    {{--                                <a href=""><i class="fab fa-twitter"></i></a>--}}
    {{--                                <a href=""><i class="fab fa-instagram"></i></a>--}}
    {{--                            </span>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">--}}
    {{--                    <div class="team-item p-4">--}}
    {{--                        <div class="overflow-hidden mb-4">--}}
    {{--                            <img class="img-fluid" src="img/team-3.jpg" alt="">--}}
    {{--                        </div>--}}
    {{--                        <h5 class="mb-0">Full Name</h5>--}}
    {{--                        <p>Designation</p>--}}
    {{--                        <div class="btn-slide mt-1">--}}
    {{--                            <i class="fa fa-share"></i>--}}
    {{--                            <span>--}}
    {{--                                <a href=""><i class="fab fa-facebook-f"></i></a>--}}
    {{--                                <a href=""><i class="fab fa-twitter"></i></a>--}}
    {{--                                <a href=""><i class="fab fa-instagram"></i></a>--}}
    {{--                            </span>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.9s">--}}
    {{--                    <div class="team-item p-4">--}}
    {{--                        <div class="overflow-hidden mb-4">--}}
    {{--                            <img class="img-fluid" src="img/team-4.jpg" alt="">--}}
    {{--                        </div>--}}
    {{--                        <h5 class="mb-0">Full Name</h5>--}}
    {{--                        <p>Designation</p>--}}
    {{--                        <div class="btn-slide mt-1">--}}
    {{--                            <i class="fa fa-share"></i>--}}
    {{--                            <span>--}}
    {{--                                <a href=""><i class="fab fa-facebook-f"></i></a>--}}
    {{--                                <a href=""><i class="fab fa-twitter"></i></a>--}}
    {{--                                <a href=""><i class="fab fa-instagram"></i></a>--}}
    {{--                            </span>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <!-- Team End -->


    <!-- Testimonial Start -->
    {{--    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s" id="Testimonial">--}}
    {{--        <div class="container py-5">--}}
    {{--            <div class="text-center">--}}
    {{--                <h6 class="text-secondary text-uppercase">Testimonial</h6>--}}
    {{--                <h1 class="mb-0">Our Clients Say!</h1>--}}
    {{--            </div>--}}
    {{--            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">--}}
    {{--                <div class="testimonial-item p-4 my-5">--}}
    {{--                    <i class="fa fa-quote-right fa-3x text-light position-absolute top-0 end-0 mt-n3 me-4"></i>--}}
    {{--                    <div class="d-flex align-items-end mb-4">--}}
    {{--                        <img class="img-fluid flex-shrink-0" src="img/testimonial-1.jpg"--}}
    {{--                             style="width: 80px; height: 80px;">--}}
    {{--                        <div class="ms-4">--}}
    {{--                            <h5 class="mb-1">Client Name</h5>--}}
    {{--                            <p class="m-0">Profession</p>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>--}}
    {{--                </div>--}}
    {{--                <div class="testimonial-item p-4 my-5">--}}
    {{--                    <i class="fa fa-quote-right fa-3x text-light position-absolute top-0 end-0 mt-n3 me-4"></i>--}}
    {{--                    <div class="d-flex align-items-end mb-4">--}}
    {{--                        <img class="img-fluid flex-shrink-0" src="img/testimonial-2.jpg"--}}
    {{--                             style="width: 80px; height: 80px;">--}}
    {{--                        <div class="ms-4">--}}
    {{--                            <h5 class="mb-1">Client Name</h5>--}}
    {{--                            <p class="m-0">Profession</p>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>--}}
    {{--                </div>--}}
    {{--                <div class="testimonial-item p-4 my-5">--}}
    {{--                    <i class="fa fa-quote-right fa-3x text-light position-absolute top-0 end-0 mt-n3 me-4"></i>--}}
    {{--                    <div class="d-flex align-items-end mb-4">--}}
    {{--                        <img class="img-fluid flex-shrink-0" src="img/testimonial-3.jpg"--}}
    {{--                             style="width: 80px; height: 80px;">--}}
    {{--                        <div class="ms-4">--}}
    {{--                            <h5 class="mb-1">Client Name</h5>--}}
    {{--                            <p class="m-0">Profession</p>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>--}}
    {{--                </div>--}}
    {{--                <div class="testimonial-item p-4 my-5">--}}
    {{--                    <i class="fa fa-quote-right fa-3x text-light position-absolute top-0 end-0 mt-n3 me-4"></i>--}}
    {{--                    <div class="d-flex align-items-end mb-4">--}}
    {{--                        <img class="img-fluid flex-shrink-0" src="img/testimonial-4.jpg"--}}
    {{--                             style="width: 80px; height: 80px;">--}}
    {{--                        <div class="ms-4">--}}
    {{--                            <h5 class="mb-1">Client Name</h5>--}}
    {{--                            <p class="m-0">Profession</p>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <!-- Testimonial End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 wow fadeIn" data-wow-delay="0.1s"
         style="margin-top: 6rem;">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Address</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Services</h4>
                    <a class="btn btn-link" href="">Air Freight</a>
                    <a class="btn btn-link" href="">Sea Freight</a>
                    <a class="btn btn-link" href="">Road Freight</a>
                    <a class="btn btn-link" href="">Logistic Solutions</a>
                    <a class="btn btn-link" href="">Industry solutions</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Our Services</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Newsletter</h4>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">
                            SignUp
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                        </br>Distributed By <a class="border-bottom" href="https://themewagon.com" target="_blank">ThemeWagon</a>
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



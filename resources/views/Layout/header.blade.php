<!-- Start Left menu area -->
<div class="left-sidebar-pro">
	<nav id="sidebar" class="">
		<div class="sidebar-header">
			<a href="index.html"><img class="main-logo" src="{{ asset('webassets/img/logo/logo.png')}}" alt="" /></a>
			<strong><a href="index.html"><img src="{{ asset('webassets/img/logo/logosn.png')}}" alt="" /></a></strong>
		</div>
	</nav>
</div>
<!-- End Left menu area -->
<!-- Start Welcome area -->
<div class="all-content-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="logo-pro">
					<a href="index.html"><img class="main-logo" src="{{ asset('webassets/img/logo/logo.png')}}" alt="" /></a>
				</div>
			</div>
		</div>
	</div>
	<div class="header-advance-area">
		<div class="header-top-area">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="header-top-wraper">
							<div class="row">

								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<div class="header-right-info">
										<ul class="nav navbar-nav mai-top-nav header-right-menu">
											<li class="nav-item dropdown">
												<a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="educate-icon educate-message edu-chat-pro" aria-hidden="true"></i><span class="indicator-ms"></span></a>
												<div role="menu" class="author-message-top dropdown-menu animated zoomIn">
													<div class="message-single-top">
														<h1>الرسائل الواردة</h1>
													</div>
													<ul class="message-menu">
														<li>
															<a href="#">
																<div class="message-img">
																	<img src="{{ asset('webassets/img/contact/1.jpg')}}" alt="">
																</div>
																<div class="message-content">
																	<span class="message-date">إبريل 16</span>
																	<h2>محمد السيد </h2>
																	<p>برجاء مراجعة و إعتماد المشروع المرفق في أقرب وقت ممكن</p>
																</div>
															</a>
														</li>
														<li>
															<a href="#">
																<div class="message-img">
																	<img src="{{ asset('webassets/img/contact/4.jpg')}}" alt="">
																</div>
																<div class="message-content">
																	<span class="message-date">16 إبريل</span>
																	<h2>داليا عادل</h2>
																	<p>برجاء مراجعة و إعتماد المشروع المرفق في أقرب وقت ممكن</p>
																</div>
															</a>
														</li>
														<li>
															<a href="#">
																<div class="message-img">
																	<img src="{{ asset('webassets/img/contact/3.jpg')}}" alt="">
																</div>
																<div class="message-content">
																	<span class="message-date">16 إبريل</span>
																	<h2>ندا أحمد</h2>
																	<p>برجاء مراجعة و إعتماد المشروع المرفق في أقرب وقت ممكن</p>
																</div>
															</a>
														</li>
														<li>
															<a href="#">
																<div class="message-img">
																	<img src="{{ asset('webassets/img/contact/2.jpg')}}" alt="">
																</div>
																<div class="message-content">
																	<span class="message-date">16 إبريل</span>
																	<h2>خالد علي</h2>
																	<p>برجاء مراجعة و إعتماد المشروع المرفق في أقرب وقت ممكن</p>
																</div>
															</a>
														</li>
													</ul>
													<div class="message-view">
														<a href="#">رؤية جميع الرسائل</a>
													</div>
												</div>
											</li>
											<li class="nav-item">
												<a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="educate-icon educate-bell" aria-hidden="true"></i><span>{{auth()->user()->unreadNotifications()->count()}}</span></a>
												<div role="menu" class="notification-author dropdown-menu animated zoomIn">
													<div class="notification-single-top">
														<h1>الإشعارات</h1>
													</div>
													<ul class="notification-menu" style="direction: rtl; text-align:right">
														@foreach (Auth::user()->unreadNotifications as $Notification)
														<li >
															@if ($Notification->read_at == NULL)
															<a href="#">
																<div class="notification-content" style="">
																	<!-- <span class="notification-date">16 إبريل</span> -->
																	<h2>{{ $Notification->data['stock_id'] }}</h2>
																	<p>تم اضافه مخزن رقم</p>
																</div>
															</a>
															@endif
														</li>

														@endforeach

													</ul>
													<div class="notification-view">
														<a href="#">رؤية جميع الإشعارات</a>
													</div>
												</div>
											</li>
											<li class="nav-item">
												<a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
													<i class="fa fa-angle-down edu-icon edu-down-arrow"></i>
													<span class="admin-name">{{ Auth::user()->name }}</span>
													<img src="{{ asset('webassets/img/1.jpg')}}" alt="" />
												</a>
												<ul role="menu" class="dropdown-header-top author-log dropdown-menu animated zoomIn" style="text-align:right">
													<li>
														<a href="#"><span class="edu-icon edu-home-admin author-log-ic"></span>حسابي</a>
													</li>
													<li>
														<a href="#"><span class="edu-icon edu-user-rounded author-log-ic"></span>الصفحة الشخصية</a>
													</li>
													<li>
														<a href="#"><span class="edu-icon edu-money author-log-ic"></span>الظبط</a>
													</li>
													<li>
														<a href="#"><span class="edu-icon edu-settings author-log-ic"></span>الإعدادات</a>
													</li>
													<li>
														<a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
															<span class="edu-icon edu-settings author-log-ic"></span>تسجيل خروج
														</a>

														<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
															@csrf
														</form>

													</li>
												</ul>
											</li>
										</ul>
									</div>
								</div>
								<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
									<div class="header-top-menu tabl-d-n">
										<ul class="nav navbar-nav mai-top-nav">
											<li class="nav-item dropdown res-dis-nn">
												<a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span class="angle-down-topmenu"><i class="fa fa-angle-down"></i></span> التقارير </a>
												<div role="menu" class="dropdown-menu animated zoomIn">
													<a href="#" class="dropdown-item">التقارير</a>
													<a href="#" class="dropdown-item">التقارير</a>
													<a href="#" class="dropdown-item">التقارير</a>
													<a href="#" class="dropdown-item">التقارير</a>
													<a href="#" class="dropdown-item">التقارير</a>
												</div>
											</li>
											<li class="nav-item dropdown res-dis-nn">
												<a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span class="angle-down-topmenu"><i class="fa fa-angle-down"></i></span> الموارد البشرية الرئيسية </a>
												<div role="menu" class="dropdown-menu animated zoomIn">
													<a href="#" class="dropdown-item">الموارد البشرية الرئيسية</a>
													<a href="#" class="dropdown-item">الموارد البشرية الرئيسية</a>
													<a href="#" class="dropdown-item">الموارد البشرية الرئيسية</a>
													<a href="#" class="dropdown-item">الموارد البشرية الرئيسية</a>
													<a href="#" class="dropdown-item">الموارد البشرية الرئيسية</a>
												</div>
											</li>
											<li class="nav-item dropdown res-dis-nn">
												<a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"> <span class="angle-down-topmenu"><i class="fa fa-angle-down"></i></span> إيجاد الموارد البشرية</a>
												<div role="menu" class="dropdown-menu animated zoomIn">
													<a href="#" class="dropdown-item">إيجاد الموارد البشرية</a>
													<a href="#" class="dropdown-item">إيجاد الموارد البشرية</a>
													<a href="#" class="dropdown-item">إيجاد الموارد البشرية</a>
													<a href="#" class="dropdown-item">إيجاد الموارد البشرية</a>
													<a href="#" class="dropdown-item">إيجاد الموارد البشرية</a>
												</div>
											</li>
											<li class="nav-item dropdown res-dis-nn">
												<a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span class="angle-down-topmenu"><i class="fa fa-angle-down"></i></span> الماليات </a>
												<div role="menu" class="dropdown-menu animated zoomIn">
													<a href="#" class="dropdown-item">الماليات</a>
													<a href="#" class="dropdown-item">الماليات</a>
													<a href="#" class="dropdown-item">الماليات</a>
													<a href="#" class="dropdown-item">الماليات</a>
													<a href="#" class="dropdown-item">الماليات</a>
												</div>
											</li>
											<li class="nav-item dropdown res-dis-nn">
												<a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span class="angle-down-topmenu"><i class="fa fa-angle-down"></i></span> المخزون </a>
												<div role="menu" class="dropdown-menu animated zoomIn">
													<a href="{{route('items.index')}}" class="dropdown-item"> الأصناف </a>
													<a href="{{route('stocks.index')}}" class="dropdown-item"> المخازن </a>

													<a href="{{route('orders.index')}}" class="dropdown-item">أوامر البيع </a>
													<a href="{{route('approve-order.index')}}" class="dropdown-item">الموافقه على اوامر البيع </a>
													<a href="{{route('invoice.index')}}" class="dropdown-item">فواتير المبيعات </a>

												</div>
											</li>
											<li class="nav-item dropdown res-dis-nn">
												<a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span class="angle-down-topmenu"><i class="fa fa-angle-down"></i></span> الرئيسية </a>
												<div role="menu" class="dropdown-menu animated zoomIn">
													<a href="{{route('branch.index')}}" class="dropdown-item">الفروع </a>
													<a href="{{route('users.index')}}" class="dropdown-item">المستخدمين </a>
													<a href="{{route('item-category.index')}}" class="dropdown-item">التصنيفات </a>

												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Mobile Menu start -->
		<div class="mobile-menu-area">
			<div class="container">
				<div class="row" style="direction:rtl">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="mobile-menu">
							<nav id="dropdown">
								<ul class="mobile-menu-nav">
									<li>
										<a data-toggle="collapse" data-target="#Charts" href="#">الرئيسية <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
										<ul class="collapse dropdown-header-top">
											<li><a href="{{route('branch.index')}}" class="dropdown-item">الفروع</a></li>
											<li><a href="{{route('users.index')}}" class="dropdown-item">المستخدمين </a></li>

											<li><a href="{{route('item-category.index')}}" class="dropdown-item">التصنيفات</a></li>


										</ul>
									</li>
									<li>
										<a data-toggle="collapse" data-target="#demoevent" href="#">المخزون <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
										<ul id="demoevent" class="collapse dropdown-header-top">
											<a href="{{route('items.index')}}" class="dropdown-item"> الأصناف </a>
											<a href="{{route('stocks.index')}}" class="dropdown-item"> المخازن </a>
											<li><a href="{{route('orders.index')}}" class="dropdown-item">أوامر البيع </a></li>
											<li><a href="{{route('approve-order.index')}}" class="dropdown-item">الموافقه على اوامر البيع </a></li>
											<li><a href="{{route('invoice.index')}}" class="dropdown-item"> فواتير المبيعات </a></li>

										</ul>
									</li>
									<li>
										<a data-toggle="collapse" data-target="#demopro" href="#">الماليات <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
										<ul id="demopro" class="collapse dropdown-header-top">
											<li><a href="#" class="dropdown-item">الماليات</a></li>
											<li><a href="#" class="dropdown-item">الماليات</a></li>
											<li><a href="#" class="dropdown-item">الماليات</a></li>
											<li><a href="#" class="dropdown-item">الماليات</a></li>
											<li><a href="#" class="dropdown-item">الماليات</a></li>
										</ul>
									</li>
									<li>
										<a data-toggle="collapse" data-target="#democrou" href="#">إيجاد الموارد البشرية <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
										<ul id="democrou" class="collapse dropdown-header-top">
											<li><a href="#" class="dropdown-item">إيجاد الموارد البشرية</a></li>
											<li><a href="#" class="dropdown-item">إيجاد الموارد البشرية</a></li>
											<li><a href="#" class="dropdown-item">إيجاد الموارد البشرية</a></li>
											<li><a href="#" class="dropdown-item">إيجاد الموارد البشرية</a></li>
											<li><a href="#" class="dropdown-item">إيجاد الموارد البشرية </a></li>
										</ul>
									</li>
									<li>
										<a data-toggle="collapse" data-target="#demolibra" href="#"> الموارد البشرية الرئيسية <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
										<ul id="demolibra" class="collapse dropdown-header-top">
											<li><a href="#" class="dropdown-item">الموارد البشرية الرئيسية</a></li>
											<li><a href="#" class="dropdown-item">الموارد البشرية الرئيسية</a></li>
											<li><a href="#" class="dropdown-item">الموارد البشرية الرئيسية</a></li>
											<li><a href="#" class="dropdown-item">الموارد البشرية الرئيسية</a></li>
											<li><a href="#" class="dropdown-item">الموارد البشرية الرئيسية</a></li>
										</ul>
									</li>
									<li>
										<a data-toggle="collapse" data-target="#Charts" href="#">التقارير <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
										<ul class="collapse dropdown-header-top">
											<li><a href="#" class="dropdown-item">التقارير</a></li>
											<li><a href="#" class="dropdown-item">التقارير</a></li>
											<li><a href="#" class="dropdown-item">التقارير</a></li>
											<li><a href="#" class="dropdown-item">التقارير</a></li>
											<li><a href="#" class="dropdown-item">التقارير</a></li>
										</ul>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Mobile Menu end -->
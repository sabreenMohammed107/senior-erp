    @include('Layout.head')

<body>

    @include('Layout.header')

    <!-- container -->

    <div class="breadcome-area">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="breadcome-list">
								
                                    @yield('crumb')
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    @if(Session::has('flash_success'))
                <div class="col-lg-12" style="direction: rtl;">
                    <div class="alert alert-success">
                        <strong><i class="fa fa-check-circle"></i> {!! session('flash_success') !!}</strong>
                    </div>
                </div>
            @endif
            @if(Session::has('flash_danger'))
                <div class="col-lg-12" style="direction: rtl;">
                    <div class="alert alert-danger">
                        <strong><i class="fa fa-info-circle"></i> {!! session('flash_danger') !!}</strong>
                    </div>
                </div>
            @endif
            @if(Session::has('flash_info'))
                <div class="col-lg-12" style="direction: rtl;">
                    <div class="alert alert-info">
                        <strong><i class="fa fa-info-circle"></i> {!! session('flash_info') !!}</strong>
                    </div>
                </div>
            @endif
            @if(Session::has('flash_delete'))
                @section('script')
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
                @endsection
            @endif
    @yield('content')



    @yield('modal')




    @include('Layout.footer')

    @include('Layout.footerScripts')
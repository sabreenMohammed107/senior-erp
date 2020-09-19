@extends('Layout.web')



@section('crumb')

<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="breadcome-heading">
			<form action="{{route('branch.search')}}" method="POST" id="xx" class="sr-input-func">
				@csrf
				<input type="text" placeholder="...إبحث هنا" oninput="searching()" id="searchData" name="searchData" class="search-int form-control" style="text-align:right">
				<a onclick="document.getElementById('xx').submit()"><i class="fa fa-search"></i></a>
			</form>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<ul class="breadcome-menu">
			<li>
				<a href="#"></a> الشركات<span class="bread-slash"> / </span>
			</li>
			<li>
				<span class="bread-blod"> الفروع </span>
			</li>
		</ul>
	</div>
</div>

@endsection

@section('content')
<div class="courses-area">

	<div class="container-fluid">
		<a href="#" data-toggle="modal" data-target="#add" title="New" class="btn btn-primary waves-effect waves-light mg-b-15">إضافة فرع</a>
		<div id="result">
			@include('branch.result')
		</div>

	</div>
</div>

@endsection
@section('modal')
<!--Add Company-->
<div id="add" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header header-color-modal bg-color-2">
				<h4 class="modal-title" style="text-align:right">إضافة فرع جديد</h4>
				<div class="modal-close-area modal-close-df">
					<a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
				</div>
			</div>

			<form action="{{route('branch.store')}}" method="POST" class="dropzone dropzone-custom needsclick addcourse" id="demo1-upload">
				@csrf
				<div class="modal-body">

					<div class="message-content" style="text-align:right;">

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="review-content-section">
								<div id="dropzone1" class="pro-ad addcoursepro">
								<div class="row res-rtl"style="display: flex ;flex-direction: row-reverse ;">


										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="direction:rtl">
											{{-- <div class="form-group">
														<label class="">كود </label>
														<input name="code" type="text" class="form-control" placeholder="كود العميل" >
													</div>--}}
													<div class="form-group">
												<label class="">إسم الفرع عربي</label>
												<input name="ar_name" type="text" class="form-control" placeholder="إسم الفرع عربي">
											</div>
											<div class="form-group">
												<label class="">إسم الفرع إنجليزي</label>
												<input name="en_name" type="text" class="form-control" placeholder="إسم الفرع إنجليزي">
											</div>
											<div class="form-group res-mg-t-15">
												<label class="">كود بداية عميل</label>
												<input name="start_code" type="text" class="form-control" placeholder="كود البداية">
											</div>
											<div class="form-group res-mg-t-15">
												<label class="">كود نهاية عميل</label>
												<input name="end_code" type="text" class="form-control" placeholder="كود النهاية">
											</div>
											



											<div class="form-group">
												<label class="">ملاحظات</label>
												<textarea name="notes" placeholder="ملاحظات" style="max-height:100px"></textarea>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="direction:rtl">

										<div class="form-group">
												<label class="">تليفون الفرع</label>
												<input name="phone" type="text" class="form-control" placeholder="تليفون الفرع">
											</div>
											<div class="form-group">
												<label class="">موبايل1 الفرع</label>
												<input name="mobile1" type="text" class="form-control" placeholder="موبايل الفرع">
											</div>
											
											

											<div class="form-group">
												<label class="">البريد الالكترونى</label>
												<input name="email" type="text" class="form-control" placeholder="البريد الالكترونى">
											</div>
											<div class="form-group">
												<label class=""> موبايل 2الفرع</label>
												<input name="mobile2" type="text" class="form-control" placeholder="موبايل الفرع">
											</div>
											<div class="form-group">
												<label class="">العنوان</label>
												<textarea name="address" placeholder="العنوان" style="max-height:100px"></textarea>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer info-md">
					<a data-dismiss="modal" href="#">إلغــاء</a>
					<button type="submit">إضافة الفرع</button>
				</div>

		</div>
	</div>
</div>
<!--/Add Company-->
@endsection
@section('scripts')
<script>
	function searching() {
		var search = $('#searchData').val();

	
		$.ajax({
			type: 'POST',
			data: {
				searchData: search,
				"_token": "{{ csrf_token() }}",
			},
			url: "{{route('branch.search')}}",

			success: function(data) {
			
				$('#resultr').html(data);


			},
			error: function(request, status, error) {
				alert("error");
			}

		});
	}
</script>
@endsection
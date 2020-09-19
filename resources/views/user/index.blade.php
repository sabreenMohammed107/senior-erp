@extends('Layout.web')



@section('crumb')

<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="breadcome-heading">
			<form action="{{route('users.search')}}" method="POST" id="xx" class="sr-input-func">
@csrf
				<input type="text" placeholder="...إبحث هنا" oninput="searching()" id="searchData" name="searchData" class="search-int form-control" style="text-align:right">
				<a><i class="fa fa-search" onclick="document.getElementById('xx').submit()"></i></a>
			</form>

		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<ul class="breadcome-menu">
			<li>
				<a href="#"></a> الشركات<span class="bread-slash"> / </span>
			</li>
			<li>
				<span class="bread-blod"> المستخدمين </span>
			</li>
		</ul>
	</div>
</div>

@endsection

@section('content')
<div class="courses-area">

	<div class="container-fluid">

		<a href="{{ route('users.create') }}" title="New" class="btn btn-primary waves-effect waves-light mg-b-15">إضافة مستخدم </a>

		<div id="resultr">
			@include('user.result')
		</div>

	</div>
</div>
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
			url: "{{route('users.search')}}",

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
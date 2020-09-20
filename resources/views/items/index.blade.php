@extends('Layout.web')



@section('crumb')

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="breadcome-heading">
            <form action="{{route('items.search')}}" method="POST" id="xx" class="sr-input-func">
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
                <span class="bread-blod"> الاصناف </span>
            </li>
        </ul>
    </div>
</div>

@endsection

@section('content')
<div class="contacts-area mg-b-15">
    <div class="container-fluid">
        <div style="direction:rtl!important">
            <a class="btn btn-primary waves-effect waves-light mg-b-15" href="{{route('items.create')}}">إضافة صنف</a>
        </div>
        <div id="result">
            @include('items.result')
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
			url: "{{route('items.search')}}",

			success: function(data) {
			
				$('#result').html(data);


			},
			error: function(request, status, error) {
				alert("error");
			}

		});
	}
</script>
@endsection
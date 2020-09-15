@extends('Layout.web')

@section('style')
<!-- x-editor CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('webassets/css/editor/select2.css')}}">
<link rel="stylesheet" href="{{ asset('webassets/css/editor/datetimepicker.css')}}">
<link rel="stylesheet" href="{{ asset('webassets/css/editor/bootstrap-editable.css')}}">
<link rel="stylesheet" href="{{ asset('webassets/css/editor/x-editor-style.css')}}">
<!-- normalize CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('webassets/css/data-table/bootstrap-table.css')}}">
<link rel="stylesheet" href="{{ asset('webassets/css/data-table/bootstrap-editable.css')}}">
<!-- select2 CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('webassets/css/select2/select2.min.css')}}">
<!-- chosen CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('webassets/css/chosen/bootstrap-chosen.css')}}">
<style>
    .pagination-info {
        display: none !important;
    }

    .page-list {
        display: none !important;
    }

    .pagination ul li {
        float: right !important;
    }

    .search input:-ms-input-placeholder {
        color: white !important;
    }

    #table td,
    th {
        text-align: right
    }
</style>
@endsection
@section('crumb')


								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="breadcome-heading">
											
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<ul class="breadcome-menu">
											<li>
												<a href="#"></a> المبيعات<span class="bread-slash"> / </span>
											</li>
											<li>
												<span class="bread-blod"> الموافقة على المبيعات</span>
											</li>
										</ul>
									</div>
								</div>
						

@endsection

@section('content')

		<!-- Static Table Start -->
		<div class="data-table-area mg-b-15">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="sparkline13-list">
							<div class="sparkline13-hd">
								<div class="main-sparkline13-hd">
									<h1 style="direction:rtl">الموافقة على أوامر المبيعات</h1>
								</div>
							</div>
							<div class="sparkline13-graph">
								<div class="datatable-dashv1-list custom-datatable-overright" style="direction:rtl">
									<div class="chosen-select-single mg-b-20" style="direction:rtl;">
										<div class="row">
											<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12"></div>
												<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
													<div class="form-group">
														<div class="chosen-select-single mg-b-20">
															<label>الفرع </label>
															<select data-placeholder="Choose a Country..."  name="select_branch" class="chosen-select" tabindex="-1">
                                                                <option value="">Select</option>
                                                                @foreach($branches as $type)
																<option value="{{$type->id}}">{{$type->ar_name}}</option>
																@endforeach
															</select>
														</div>
													</div>
												</div>
											</div>
                                    </div>
                                    <div id="preIndex">
@include('approve-order.preIndex')
                                    </div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Static Table End -->
@endsection
@section('modal')

@endsection
@section('scripts')
<script>
    
    $(document).ready(function() {
  

        $('select[name="select_branch"]').on('change', function() {
            var branch = $(this).val();

          
            $.ajax({
                url: "{{route('dynamicApprovalOrder.fetch')}}",
                method: "get",
                data: {
                    branch_id: branch,

                },
                success: function(result) {
                    $('#table').bootstrapTable('destroy');

                    $('#preIndex').html(result);
                    $('#table').bootstrapTable()
					$('#branch').val(branch);
                
 
                }
            });

        });


    });

</script>
@endsection
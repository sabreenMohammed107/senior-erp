<div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
<?php
$counter=1;
?>
	@foreach($rows as $row)

	<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
		<div class="courses-inner res-mg-b-30">
			<img src="{{ asset('uploads/items/'.$row->image)}}" style="height: 200px;">
			<div class="courses-title">
				<h2 style="text-align:right"> {{$row->ar_name}}</h2>
			</div>
			<div class="course-des">
				<p><span><i class="fa fa-clock"></i></span> <b>الــكــــود {{$counter}}
: </b> {{$row->code}}</p>
				<p><span><i class="fa fa-clock"></i></span> <b>التصنيف : </b> {{$row->category->ar_name ?? ''}}</p>
				<p><span><i class="fa fa-clock"></i></span> <b>  مورد الصنف : </b> {{$row->person->name ?? ''}}</p>
				<p><span><i class="fa fa-clock"></i></span> <b>  تكلفة الصنف : </b> {{$row->item_total_cost}}</p>
				<p><span><i class="fa fa-clock"></i></span> <b>  كمية الصنف : </b> {{$row->item_total_qty}}</p>
			</div>
			<div class="product-buttons">
				<a href="{{ route('items.show',$row->id) }}"><button title="View" type="button" class="pd-setting-ed"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
				<a href="{{ route('items.edit',$row->id) }}"><button data-toggle="tooltip" title="Edit" class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
				<button data-toggle="modal" data-target="#del{{$row->id}}" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
			</div>
		</div>
	</div>
	<!--Delete Company-->
	<div id="del{{$row->id}}" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header header-color-modal bg-color-2">
					<h4 class="modal-title" style="text-align:right">حذف بيانات الصنف</h4>
					<div class="modal-close-area modal-close-df">
						<a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
					</div>
				</div>
				<div class="modal-body">
					<span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>
					<h2>{{$row->ar_name}}</h2>
					<h4>هل تريد حذف جميع بيانات الصنف ؟ </h4>
				</div>
				<div class="modal-footer info-md">
					<a data-dismiss="modal" href="#">إلغــاء</a>
					<form id="delete" style="display: inline;" action="{{ route('items.destroy', $row->id) }}" method="POST">
						@csrf
						@method('DELETE')
						<button type="submit">حذف</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!--/Delete Company-->
	<?php
  

    if ($counter == 4) {


?>
</div>
<div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;margin-top:20px">
<?php 
$counter =1;

}
$counter = $counter+1;

?>
	@endforeach

</div>

<div class="custom-pagination mg-b-15">
	<nav aria-label="Page navigation example">
		<ul class="pagination">
			{!! $rows->links() !!}
		</ul>
	</nav>
</div>
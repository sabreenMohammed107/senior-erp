<div class="row res-rtl"style="display: flex ;flex-direction: row-reverse ;">
@foreach($rows as $row)
<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="student-inner-std res-mg-b-30">
                            <div class="student-img">
                                <img src="{{ asset('uploads/users/'.$row->image)}}" alt="" style="height: 300px;"  />
                            </div>
                            <div class="student-dtl">
                                <h2>{{$row->name}}</h2>
                                <p class="dp">{{$row->job}}</p>
                                <p class="dp-ag">{{$row->code}} :<b> كود </b> </p>
								<br />
							<div class="product-buttons">
                            <a href="{{ route('users.show',$row->id) }}" ><button  title="View" type="button"   class="pd-setting-ed"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                            <a href="{{ route('users.edit',$row->id) }}" ><button data-toggle="tooltip" title="Edit"  class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
								<button data-toggle="modal" data-target="#del{{$row->id}}" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
							</div>
						</div>
                    </div>
</div>
                    
                    <!--Delete Company-->
		<div id="del{{$row->id}}" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header header-color-modal bg-color-2">
						<h4 class="modal-title" style="text-align:right">حذف بيانات المستخدم</h4>
						<div class="modal-close-area modal-close-df">
							<a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
						</div>
					</div>
					<div class="modal-body">
						<span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>
                        <h2>{{$row->name}}</h2>
						<h4>هل تريد حذف جميع بيانات المستخدم ؟  </h4>
					</div>
					<div class="modal-footer info-md">
						<a data-dismiss="modal" href="#">إلغــاء</a>
                        <form id="delete" style="display: inline;" action="{{ route('users.destroy', $row->id) }}" method="POST">
													@csrf
													@method('DELETE')
													<button type="submit">حذف</button>
												</form>
					</div>
				</div>
			</div>
		</div>
		<!--/Delete Company-->
                    @endforeach
				</div>
            
                
                <div class="custom-pagination mg-b-15">
					<nav aria-label="Page navigation example">
						<ul class="pagination">
                        {!! $rows->links() !!}
						</ul>
					</nav>
				</div>
				
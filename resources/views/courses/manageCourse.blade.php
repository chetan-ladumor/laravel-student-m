@extends('layouts.master')
@section('content')

@include('courses.popup.academic')
@include('courses.popup.program')
@include('courses.popup.level')
@include('courses.popup.shift')
@include('courses.popup.time')
@include('courses.popup.batch')
@include('courses.popup.group')
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-file-text-o"></i>Courses</h3>
		<ol class="breadcrumb">
			<li><i class="fa fa-home"></i><a href="">Home</a></li>
			<li><i class="icon_document_alt"></i>Course</li>
			<li><i class="fa fa-file-text-o"></i><a href=""></a>Manage Course</li>
		</ol>
	</div>
		
	<div class="row">
		<div class="col-lg-12">
			<section class="panel panel-default">
				<header class="panel-heading">
					Manage Course
				</header>
				
				<form class="form-horizontal" action="{{ route('postInsertclass') }}" id="frm-create-class">
					<input type="hidden" name="active" id="active" value="1">
					<input type="hidden" name="class_id" id="class_id">
					<div class="panel-body" style="border-bottom: 1px solid #ccc;">
						<div class="form-group">
							
							<div class="col-sm-3">
								<label for="academic-year">Academic Year</label>
								<div class="input-group">
									<select class="form-control" name="academic_id" id="academic_id">
										<option value="">Select Year</option>
										@foreach($academics as $key=>$y)
											<option value="{{ $y->academic_id }}">{{ $y->academic }}</option>
										@endforeach
									</select>
									<div class="input-group-addon">
										<span class="fa fa-plus" id="add-more-academic"></span>
									</div>
									
								</div>
							</div>

							{{------------------------------------}}

							<div class="col-sm-4">
								<label for="program">Course - Program</label>
								<div class="input-group">
									<select class="form-control" name="program_id" id="program_id">
										<option value="">Select Program</option>
										@foreach($programs as $key=>$y)
											<option value="{{ $y->program_id }}">{{ $y->program }}</option>
										@endforeach
									</select>
									<div class="input-group-addon">
										<span class="fa fa-plus" id="add-more-program"></span>
									</div>
									
								</div>
							</div>

							{{------------------------------------}}

							<div class="col-sm-5">
								<label for="level">Level</label>
								<div class="input-group">
									<select class="form-control" name="level_id" id="level_id">
										
									</select>
									<div class="input-group-addon">
										<span class="fa fa-plus" id="add-more-level"></span>
									</div>
									
								</div>
							</div>

							{{------------------------------------}}

							<div class="col-sm-3">
								<label for="shift">Shift</label>
								<div class="input-group">
									<select class="form-control" name="shift_id" id="shift_id">
										<option value="">Select Shift</option>
										@foreach($shifts as $shift)
											<option value="{{ $shift->shift_id }}">{{ $shift->shift }}</option>
										@endforeach	
									</select>
									<div class="input-group-addon">
										<span class="fa fa-plus" id="add-more-shift"></span>
									</div>
									
								</div>
							</div>

							{{------------------------------------}}

							<div class="col-sm-4">
								<label for="time">Time</label>
								<div class="input-group">
									<select class="form-control" name="time_id" id="time_id">
										<option value="">Select Time</option>
										@foreach($times as $t)
											<option value="{{ $t->time_id }}">{{ $t->time }}</option>
										@endforeach	
									</select>
									<div class="input-group-addon">
										<span class="fa fa-plus" id="add-more-time"></span>
									</div>
									
								</div>
							</div>

							{{------------------------------------}}

							<div class="col-sm-3">
								<label for="batch">Batch</label>
								<div class="input-group">
									<select class="form-control" name="batch_id" id="batch_id">
										<option value="">Select Batch</option>
										@foreach($batches as $b)
											<option value="{{ $b->batch_id }}">{{ $b->batch }}</option>
										@endforeach	
									</select>
									<div class="input-group-addon">
										<span class="fa fa-plus" id="add-more-batch"></span>
									</div>
									
								</div>
							</div>

							{{------------------------------------}}

							<div class="col-sm-2">
								<label for="group">Group</label>
								<div class="input-group">
									<select class="form-control" name="group_id" id="group_id">
										<option value="">Select Group</option>
										@foreach($groups as $g)
											<option value="{{ $g->group_id }}">{{ $g->groups }}</option>
										@endforeach	
									</select>
									<div class="input-group-addon">
										<span class="fa fa-plus" id="add-more-group"></span>
									</div>
									
								</div>
							</div>

							{{------------------------------------}}
							
							<div class="col-sm-3">
								<label for="startDate">Start Date</label>
								<div class="input-group">
									<input type="text" name="start_date" id="start_date" class="form-control" required>
									</input>
									<div class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</div>
								</div>
							</div>
							{{------------------------------------}}
							
							<div class="col-sm-4">
								<label for="endDate">End Date</label>
								<div class="input-group">
									<input type="text" name="end_date" id="end_date" class="form-control" required>
									</input>
									<div class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</div>
								</div>
							</div>

						</div>
					</div>

					<div class="panel-footer" align="center">
						<button type="submit" class="btn btn-primary btn-sm">Create Class</button>
						<button type="button" class="btn btn-success btn-sm btn-update-class">Update Class</button>
					</div>

				</form>

				{{-------------------List OF Available Classes----------------------}}

				<div class="panel panel-default">
					<div class="panel-heading">Class Information</div>
					<div class="panel-body" id="add-class-info">
						
					</div>
				</div>

			</section>
		</div>
	</div>
</div>

@endsection

@section('script')
	<script type="text/javascript">
		$("#start_date").datepicker({
			changeMonth:true,
			changeYear:true,
			dateFormat:'yy-mm-dd'
		});
		$("#end_date").datepicker({
			changeMonth:true,
			changeYear:true,
			dateFormat:'yy-mm-dd'
		});

		//show All inserted  class data by ajax call 
		getClassInfo();
		$('#academic_id').on('change', function (e) {
			getClassInfo();
		});
		
		$('#level_id').on('change', function (e) {
			getClassInfo();
		});
		
		$('#shift_id').on('change', function (e) {
			getClassInfo();
		});
		
		$('#time_id').on('change', function (e) {
			getClassInfo();
		});
		
		$('#batch_id').on('change', function (e) {
			getClassInfo();
		});
		
		$('#group_id').on('change', function (e) {
			getClassInfo();
		});

		//academic poup and save data
		$("#add-more-academic").on('click',function(){
			$("#academic-year-show").modal();
		});
		$(".btn-save-academic").on('click',function(){
			var academic=$("#new-academic").val();
			$.post( 
					"{{ route('postInsertAcademic') }}",
					{academic:academic},
					function(data){
						//console.log(data);
						$("#academic_id").append($("<option/>",{
							value:data.academic_id,
							text:data.academic,
						}));
						$("#new-academic").val("");
					} 
		    )
		});

		//program popup and save data
		$("#add-more-program").on('click',function(){
			$("#program-show").modal();
		});
		$(".btn-save-program").on('click',function(){
			var program = $("#program").val();
			var description =$("#program_description").val();
			$.post(
				" {{ route('postInsertProgram') }} ", 
				{program:program,description:description}, 
				function(data){
					$("#program_id").append($("<option/>",{
						value:data.program_id,
						text:data.program,
					}));
					$("#program").val("");
					$("#program_description").val("");
				}
			);
		});

		//manage level popup and save data
		$("#add-more-level").on('click',function(){
			//pass programs option in modal
			var programs=$('#program_id option');
			//console.log(options);
			var program = $("#frm-level-create").find("#program_id");
			$(program).empty();
			$.each(programs,function(i,pro){
				//program.append(pro);
				$(program).append($("<option/>",{
					value:$(pro).val(),
					text:$(pro).text(),
				}));	
			});
			$("#level-show").modal();
		});
		$("#frm-level-create").on('submit',function(e){

			e.preventDefault();
			var data=$(this).serialize();
			var url=$(this).attr('action');
			$.post(url, data, function(data){
				$("#level_id").empty();
				$("#level_id").append($("<option/>",{
					value:data.level_id,
					text:data.level,
				}));
				$("#level").val("");
				$("#description").val("");
			});
			$(this).trigger('reset');

			/*var level = $("#level").val();
			var level_description = $("#level_description").val();
			$.post(
				"{{ route('postInsertLevel') }}",
				 {level:level,description:description},
				 function(data){
				 	console.log(data);
				 	$("#level").val("");
				 	$("#level_description").val("");
				 }
			)*/
		});
		$("#frm-create-class #program_id").on('change',function(){
			//$("#level_id").empty();
			var program_id=$(this).val();
			$.get("{{ route('showLevel') }}", {program_id:program_id}, function(data){
				console.log(data);
				$("#level_id").empty();

				$.each(data,function(i,l){
					$("#level_id").append($('<option/>',{
						value:l.level_id,
						text:l.level,
					}));
				});

				getClassInfo();
				
			});
		});	

		//shift poup and save data
		$("#add-more-shift").on('click',function(){
			$("#shift-show").modal();
		});
		$("#frm-shift-create").on('submit',function(e){
			e.preventDefault();
			var data = $(this).serialize();
			$.post("{{ route('postInsertShift') }}", data, function(data){
				$("#shift_id").append($('<option/>',{
					value:data.shift_id,
					text:data.shift,
				}));
			});
			$(this).trigger('reset');
		});

		//Time popup and save data
		$("#add-more-time").on('click',function(){
			$("#time-show").modal();
		});
		$("#frm-time-create").on('submit',function(e){
			e.preventDefault();
			var data=$(this).serialize();
			$.post("{{ route('postInsertTime') }}", data, function(data){
				$("#time_id").append($('<option/>',{
					value:data.time_id,
					text:data.time,
				}));
			});
			$("#time_id").trigger('reset');	
		});

		//Batch popup and save data
		$("#add-more-batch").on('click',function(){
			$("#batch-show").modal();
		});
		$("#frm-batch-create").on('submit',function(e){
			e.preventDefault();
			var data=$(this).serialize();
			$.post("{{ route('postInsertBatch') }}", data, function(data){
				$("#batch_id").append($('<option/>',{
					value:data.batch_id,
					text:data.batch,

				}));
			});
			$("#batch_id").trigger('reset');	
		});


		//add group poup and save data
		$("#add-more-group").on('click',function(){
			$("#group-show").modal();
		});
		$("#frm-group-create").on('submit',function(e){
			e.preventDefault();
			var data=$(this).serialize();
			$.post("{{ route('postInsertGroup') }}", data, function(data){
				$("#group_id").append($('<option/>',{
					value:data.group_id,
					text:data.groups,

				}));
			});
			$("#group_id").trigger('reset');	
		});

		//add Class
		$("#frm-create-class").on('submit',function(e){
			e.preventDefault();
			var data=$(this).serialize();
			var url=$(this).attr('action');
			$.post(url, data, function(data){
				getClassInfo(data.academic_id);
				
			});
			$(this).trigger('reset')	
		});
		/*   Get class info */
		function getClassInfo()
		{
			var data = $('#frm-create-class').serialize();
			$.get("{{ route('getClassInformation') }}", data, function(data){
					$("#add-class-info").empty().append(data);
					MergeCommonRows($('#table-class-info'));
			});
		}

		/*delete class*/
		$(document).on('click','.delete-class',function(e){
			var class_id=$(this).val();
			$.post("{{ route('deleteClass') }}", {class_id:class_id}, function(data){
				getClassInfo($('#academic_id').val());
			})
		});

		/*Update class */
		$(document).on('click','#class-edit',function(e){
			var class_id=$(this).data('id');
			$.get("{{route('editClass')}}", {class_id:class_id}, function(data){
				$('#academic_id').val(data.academic_id);
				$('#level_id').val(data.level_id);
				$('#shift_id').val(data.shift_id);
				$('#time_id').val(data.time_id);
				$('#group_id').val(data.group_id);
				$('#batch_id').val(data.batch_id);
				$('#start_date').val(data.start_date);
				$('#end_date').val(data.end_date);
				$('#class_id').val(data.class_id);
			})
		});

		$('.btn-update-class').on('click',function(e){
			e.preventDefault();
			var data= $('#frm-create-class').serialize();
			$.post("{{ route('upadteClassInformation') }}", data, function(data){
				getClassInfo(data.academic_id);
			});
		});

		//==================== Merge Cells ====================
		function MergeCommonRows(table)
		{
			var firstColumnBrakes = [];
			
			$.each(table.find('th'), function (i)
			{
				var previous = null, cellToExtend = null, rowspan = 1;
				
				table.find("td:nth-child(" + i + ")").each(function (index, e)
				{
					var jthis = $(this), content = jthis.text();
					
					if (previous == content && content !== "" && $.inArray(index, firstColumnBrakes) === -1)
					{
						jthis.addClass('hidden');
						cellToExtend.attr("rowspan", (rowspan = rowspan+1));
					} else  {
						if (i === 1) firstColumnBrakes.push(index);
						rowspan = 1 ;
						previous = content;
						cellToExtend = jthis;
					}
				});
			});
			$('td.hidden').remove();
		}

	</script>
@endsection
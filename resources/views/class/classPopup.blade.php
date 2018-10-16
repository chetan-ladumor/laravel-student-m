<div class="modal fade" id="choose-academic" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-xs" role="document">
		<section class="panel panel-default">
			<header class="panel-heading">
				Choose Academic
			</header>
			
			<form class="form-horizontal" action="#" id="frm-view-class">
				
				<div class="panel-body" style="border-bottom: 1px solid #ccc;">
					<div class="form-group">
						
						<div class="col-sm-6">
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

						<div class="col-sm-6">
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

						<div class="col-sm-6">
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

						<div class="col-sm-6">
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

						<div class="col-sm-6">
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

						<div class="col-sm-3">
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

						

					</div>
				</div>

				<div class="panel-footer" align="center">
					<button type="submit" class="btn btn-primary btn-sm">Create Class</button>
					<button type="button" class="btn btn-success btn-sm btn-update-class">Update Class</button>
				</div>

			</form>

			{{-------------------List OF Available Classes----------------------}}

			<form action="#" method="get" id="frm-multi-class">
				<div class="panel panel-default">
					<div class="panel-heading">
						Class Information
						<button type="button" id="btn-go" class="btn btn-info btn-xs pull-right" style="margin-top: 5px;">Go</button>
					</div>
					<div class="panel-body" id="add-class-info" style="overflow-y: auto;height: 250px;">
						
					</div>
				</div>
			</form>
			

		</section>
	</div>
</div>
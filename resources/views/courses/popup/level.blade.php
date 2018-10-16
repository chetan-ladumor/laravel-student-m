<div class="modal" id="level-show" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">New Level</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('postInsertLevel') }}" method="post" id="frm-level-create">

				 @csrf
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<select class="form-control" id="program_id" name="program_id"></select>
						</div>
						<br>
						<div class="col-sm-12">
							<input type="text" name="level" id="level" class="form-control" placeholder="Level">
						</div>
						<br>
						<div class="col-sm-12">
							<input type="text" name="description" id="description" class="form-control" placeholder="Description">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary btn-save-level">Save</button>
				</div>

			</form>
		</div>
	</div>
</div>
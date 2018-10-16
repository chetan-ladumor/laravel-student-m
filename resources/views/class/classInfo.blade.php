<style type="text/css">
	.academic-detail {
		white-space: normal;
		width: 400px;
	}
	
	table tbody > tr > td {
		vertical-align: middle;
	}
</style>
<table class="table table-hover table-striped table-condensed table-bordered" id="table-class-info">
	<thead>
		<tr>
			<th>Program</th>
			<th>Level</th>
			<th>Shift</th>
			<th>Time</th>
			<th>Academic Detail</th>
			<th hidden="hidden">Action</th>
			<th>
				<input type="checkbox" id="chekAll">
			</th>
		</tr>
	</thead>
	<tbody>
		@foreach($classes as $class)
			<tr>
				<td>{{ $class->program }}</td>
				<td>{{ $class->level }}</td>
				<td>{{ $class->shift }}</td>
				<td>{{ $class->time }}</td>
				<td class="academic-detail">
					<a href="#" data-id="{{ $class->class_id }}" id="class-edit">
						<b>Academic: {{ $class->academic }}</b> / <br>
						Program: {{ $class->program }} /
						Level:   {{ $class->level }} /
						Shift:   {{ $class->shift }} /
						Time:    {{ $class->time }} /
						Batch:   {{ $class->batch }} /
						Group:   {{ $class->groups }} /
						Start Date: {{ date("d-M-y", strtotime($class->start_date)) }}  /
						End Date:   {{ date("d-M-y", strtotime($class->end_date)) }}
					</a>
				</td>
				<td style="vertical-align: middle;width: 50px" id="hidden">
					<button value="{{ $class->class_id }}" class="btn btn-danger btn-sm delete-class">Del</button>
				</td>
				<td>
					<input type="checkbox" name="chk[]" value="{{ $class->class_id }}" class="chk">
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
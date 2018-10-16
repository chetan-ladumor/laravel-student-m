<table class="table table-bordered table-hover table-striped table-condensed" id="student-info">
	
	<caption>{{ $classes[0]->program }}</caption>
	<thead>
		<tr>
			<th>#</th>
			<th>Student ID</th>
			<th>Name</th>
			<th>Sex</th>
			<th>Birth Date</th>
			<th>Program</th>
			<th>Level</th>
			<th>Shift</th>
			<th>Time</th>
			<th>Batch</th>
			<th>Group</th>
		</tr>
	</thead>
	<tbody>
		@foreach($classes as $key => $c)
			<tr>
				<td>{{ $key+1 }}</td>
				<td>{{ sprintf("%05d", $c->student_id) }}</td>
				<td>{{ $c->name }}</td>
				<td>{{ $c->sex }}</td>
				<td>{{ $c->dob }}</td>
				<td>{{ $c->program }}</td>
				<td>{{ $c->level }}</td>
				<td>{{ $c->shift }}</td>
				<td>{{ $c->time }}</td>
				<td>{{ $c->batch }}</td>
				<td>{{ $c->groups }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        $('#student-info').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });
    });
</script>
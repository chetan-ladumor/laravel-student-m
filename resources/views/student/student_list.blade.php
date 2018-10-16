@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><i class="fa fa-file-text-o"></i>Student List</h3>
			<ol class="breadcrumb">
				<li><i class="fa fa-home"></i><a href="#">Home</a></li>
				<li><i class="icon_document_alt"></i>Student</li>
				<li><i class="fa fa-file-text-o"></i>Student List</li>
			</ol>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-body">
			<form method="GET" id="form-search">
				<table>
					<tr>
						<td>
							<input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by ID or Name"/>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div class="panel-body">
			<table class="table table-bordered table-hover table-condensed table-striped" id="student-search-table">
				<thead>
					<th>N<sup>o</sup></th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Full Name</th>
					<th>Sex</th>
					<th>Birth Date</th>
					<th>Action</th>
				</thead>
				<tbody>
					@foreach($students as $key => $stu)
						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ $stu->first_name }}</td>
							<td>{{ $stu->last_name }}</td>
							<td>{{ $stu->full_name }}</td>
							<td>{{ $stu->sex }}</td>
							<td>{{ $stu->dob }}</td>
							<td>
								<a href="#">Edit</a>
								<a href="#">Delete</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="footer">
			{{ $students->render() }}
		</div>
	</div>

@endsection

@section('script')
	<script>
	</script>
@endsection
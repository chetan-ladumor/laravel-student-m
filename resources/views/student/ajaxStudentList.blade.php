@extends('layouts.master')
<!-- https://shareurcodes.com/blog/laravel%20datatables%20server%20side%20processing -->
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><i class="fa fa-file-text-o"></i>Student List</h3>
			<ol class="breadcrumb">
				<li><i class="fa fa-home"></i><a href="#">Home</a></li>
				<li><i class="icon_document_alt"></i>Student</li>
				<li><i class="fa fa-file-text-o"></i>Ajax Student List</li>
			</ol>
		</div>
	</div>
	<div class="panel panel-default">
		<!-- <div class="panel-body">
			<form method="GET" id="form-search">
				<table>
					<tr>
						<td>
							<input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by ID or Name"/>
						</td>
					</tr>
				</table>
			</form>
		</div> -->
		<div class="panel-body">
			<table class="table table-bordered table-hover table-condensed table-striped" id="ajax-student-search-table">
				<thead>
					<th>N<sup>o</sup></th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Full Name</th>
					<th>Sex</th>
					<th>Birth Date</th>
					<th>Action</th>
				</thead>
				
			</table>
		</div>
		
	</div>

@endsection

@section('script')
	<script>
		$(document).ready(function() {
			
		    $('#ajax-student-search-table').DataTable({
				   
				    "processing": true,
				    "serverSide": true,
				    "searching": true,
				    "ajax":{
		                        "url": "{{ route('showAjaxStudentInfo') }}",
		                        "dataType": "json",
		                        "type": "POST",
		                        "data":{ _token: "{{csrf_token()}}"}
		                    },
				    "columns": [
				                   { "data": "student_id" },
				                   { "data": "first_name" },
				                   { "data": "last_name" },
				                   {"data":"full_name"},
				                   { "data": "sex" },
				                   { "data": "dob" },
				                   { "data": "options" }
				               ]	
		    });
		} );
	</script>
@endsection
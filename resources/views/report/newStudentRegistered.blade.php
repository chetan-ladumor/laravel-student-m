@extends('layouts.master')

@section('title', 'New Student Registered Chart')

@section('content')
	{!! Charts::assets() !!}
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><i class="fa fa-file-text-o"></i> Student List</h3>
			<ol class="breadcrumb">
				<li><i class="fa fa-home"></i><a href="#">Home</a></li>
				<li><i class="icon_document_alt"></i>Reports /</li>
				<li><i class="fa fa-file-text-o"></i>New Student Registered</li>
			</ol>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-body" style="padding-bottom: 4px;">
			{!! $chart->render() !!}
		</div>
	</div>
@endsection

@section('script')
	
@endsection
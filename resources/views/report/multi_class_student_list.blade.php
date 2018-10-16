@extends('layouts.master')

@section('title', 'Student Report')

@section('content')
	<style type="text/css">
		caption {
			height:50px;
			font-size: 20px;
			font-weight: bold;
		}
	</style>

	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><i class="fa fa-file-text-o"></i> Student List</h3>
			<ol class="breadcrumb">
				<li><i class="fa fa-home"></i><a href="#">Home</a></li>
				<li><i class="icon_document_alt"></i>Reports /</li>
				<li><i class="fa fa-file-text-o"></i>Student List</li>
			</ol>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<b><i class="fa fa-apple"></i> Student Information</b>
			<a href="#" class="pull-right" id="show-class-info">
				<i class="fa fa-plus"></i>
			</a>
		</div>
		<div class="panel-body" style="padding-bottom: 4px;">
			<p style="text-align: center;font-size: 20px;font-weight: bold;">Student Report</p>
			<div class="show-student-info"></div>
		</div>
	</div>

	@include('class.classPopup')
@endsection

@section('script')
	<script type="text/javascript">
		$("#show-class-info").on('click',function(e){
			e.preventDefault();
			getClassInfo();
			$("#choose-academic").modal();
		});
		
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

		$("#frm-view-class #program_id").on('change',function(){
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

		/*   Get class info */
		function getClassInfo()
		{
			var data = $('#frm-view-class').serialize();
			$.get("{{ route('getClassInformation') }}", data, function(data){
					$("#add-class-info").empty().append(data);
					$('td#hidden').addClass('hidden');
					$('th#hidden').addClass('hidden');
					MergeCommonRows($('#table-class-info'));
			});
		}

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


		/////////////////////////////////////////////////

		$(document).on('click', '#btn-go', function (e) {
			e.preventDefault();
			getClassInfo();
			data = $('#frm-multi-class').serialize();
			
			$.get("{{ route('showStudentMultiClassInformation') }}", data, function (data) {
				$('.show-student-info').empty().append(data);
				
			});
		});

		$(document).on('click','#chekAll',function(){
			$(':checkbox.chk').prop('checked',this.checked);
		});

	</script>
@endsection
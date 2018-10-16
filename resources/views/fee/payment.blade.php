@extends('layouts.master')

@section(('style'))
	{{ Html::style('css/studentsManage/payment.css') }}
@endsection

@section('content')
	@include('fee.create_fee')
	<div class="panel panel-default">
		<div class="panel-heading">
			
			<div class="col-md-3">
				<form method="GET" class="search-payment" action="{{ route('showStudentPayment') }}">
					<input class="form-control" name="student_id" placeholder="Student ID" type="text" value="{{ $student_id }}" />
				</form>
			</div>
			
			<div class="col-md-3">
				<label class="eng-name">Name: <b class="student-name">{{ $status->first_name . " " . $status->last_name }}</b></label>
			</div>
			<div class="col-md-3"></div>
			
			<div class="col-md-3" style="text-align: right;">
				<label class="date-invoice">Date: <b>{{ date('d-M-Y') }}</b></label>
			</div>
			
			<div class="col-md-3" style="text-align: right;">
				<label class="invoice-number">Receipt Number<sup>0</sup>: <b>{{ sprintf('%05d',$nextReceipt+1) }}</b></label>
			</div>

	    </div>
	    <form action="{{  count($paidStudentFees) != 0 ?  route('payRemainingFee') : route('savePayment') }}" method="post" id="frm-payment">
	    	@csrf
			<div class="panel-body">
				<table style="margin-top: -12px;">
					<caption class="academicDetail">
						Academic: {{ $status->academic }} /
						Program: {{ $status->program }} /
			            Level: {{ $status->level }} /
			            Shift: {{ $status->shift }} /
			            Time:  {{ $status->time }} /
			            Batch: {{ $status->batch }} /
			            Group: {{ $status->groups }}
		            </caption>
					<thead>
						<tr>
							<th>Program</th>
							<th>Level</th>
							<th>School Fee($)</th>
							<th>Amount($)</th>
							<th>Dis(%)</th>
							<th>Paid($)</th>
							<th>Amount Lack($)</th>
						</tr>
					</thead>
					<tr>
						<td>
							<select id="program_id" name="program_id" class="d">
								<option value="">Select</option>
								@foreach($programs as $p)
									<option value="{{ $p->program_id }}" {{ $p->program_id == $status->program_id ? 'selected' :null}} >{{ $p->program }}</option>
								@endforeach
							</select>
						</td>
						<td>
							<select id="Level_ID" class="d">
								<option value="">Select</option>
								@foreach($levels as $l)
									<option value="{{ $l->level_id }}" {{ $l->level_id == $status->level_id ? 'selected' :null}} >{{ $l->level }}</option>
								@endforeach
							</select>
						</td>
						<td>
							<div class="input-group">
								<span class="input-group-addon create-fee" title="Create Fee" style="cursor: pointer;color: blue;padding: 0px 3px; border-right: none;">($)
								</span>
								<input type="text" name="fee" id="Fee" value="{{ $schoolFee->amount or null }}" readonly />
              				</div>
							
							<input type="hidden" name="fee_id" value="{{ $schoolFee->fee_id or null }}" id="FeeId" />
							<input type="hidden" name="student_id" value="{{ $student_id }}" id="student_id" />
							<input type="hidden" name="level_id" value="{{ $status->level_id }}" id="LevelId" />
							<input type="hidden" name="user_id" value="{{ Auth::id() }}" id="user_id" />
							<input type="hidden" name="transact_date" value="{{ date('Y-m-d H:i:s') }}" id="transacdate" />
							<input type="hidden" name="s_fee_id" id="s_fee_id">
						</td>
						<td>
							<input type="text" name="amount" id="Amount" required class="d" />
						</td>
						<td>
							<input type="text" name="discount" id="Discount" class="d" />
						</td>
						<td>
							<input type="text" name="paid" id="Paid" />
						</td>
						<td>
							<input type="text" name="lack" id="Lack"  disabled />
						</td>
					</tr>
					<thead>
						<tr>
							<th colspan="2">Remark</th>
							<th colspan="2">Description</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							
							<td colspan="2">
								<input type="text" name="remark" id="remark"  />
							</td>
							<td colspan="5">
								<input type="text" name="descrption" id="description" />
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		
			<div class="panel-footer" align="center">
				<input type="submit" name="btn-go" id="btn-go" class="btn btn-success btn-payment" value="{{ count($paidStudentFees) !=0 ? 'Pay Remaining Fee' : 'Pay Amount'  }}">
				<input type="button" onclick="this.form.reset()" class="btn btn-danger btn-reset pull-right" value="Reset">
			</div>
		</form>
	@if(count($paidStudentFees) != 0 )
		@include('fee.list.student_fee_list');
		<input type="hidden" value="0" id="disabled">
	@endif
		

</div>
@endsection

@section('script')
	@include('fee.script.calculate')
	@include('fee.script.payment')
@endsection
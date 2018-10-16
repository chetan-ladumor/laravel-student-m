<div class="accordian-body collapse" id="demo{{ $key }}">
	<table class="table-hover">
		<thead>
		<tr>
			<th style="text-align: center;">#</th>
			<th>Transaction Date</th>
			<th>Cashier</th>
			<th>Paid ($)</th>
			<th>Remark</th>
			<th>Description</th>
			<th style="text-align: center;">Action</th>
		</tr>
		</thead>
		<tbody>

			@foreach($studentTransactions->where('s_fee_id',$studentFee->s_fee_id) as $key => $transact)
				<tr>
					<td style="text-align: center;">{{$key+1}}</td>
					<td>{{$transact->transact_date}}</td>
					<td>{{$transact->name}}</td>
					<td>{{number_format($transact->paid,2)}}</td>
					<td>{{$transact->remark}}</td>
					<td>{{$transact->descrption}}</td>
					<td style="text-align: center; width: 112px;">
						<a href="#" class="btn btn-primary btn-xs"><i class="fa fa-edit" title="Edit"></i></a>
						<a href="{{ route('deleteTransaction',$transact->transact_id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o" title="Delete"></i></a>
						<a href="{{ route('printInvoince',['receipt_id'=>$transact->where('transact_id',$transact->transact_id)->value('receipt_id')]) }}" target="_blank" class="btn btn-info btn-xs"><i class="fa fa-print" title="Print"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
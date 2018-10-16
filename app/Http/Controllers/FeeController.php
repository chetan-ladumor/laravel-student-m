<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Academic;
use App\Program;
use App\Level;
use App\Shift;
use App\Time;
use App\Batch;
use App\Group;
use App\MyClass;
use App\Student;
use App\Status;
use App\Fee;
use App\FeeType;
use App\StudentFee;
use App\Transaction;
use App\Receipt;
use App\ReceiptDetail;
use DB;


class FeeController extends Controller
{
    public function getPayment()
    {
    	return view('fee.searchPayment');
    }

    public function student_status($student_id)
    {
    	return Status::join('students','students.student_id','=','statuses.student_id')
    				 ->join('classes','classes.class_id','=','statuses.class_id')
    				 ->join('academics','academics.academic_id','=','classes.academic_id')
    				 ->join('shifts','shifts.shift_id','=','classes.shift_id')
    				 ->join('times','times.time_id','=','classes.time_id')
    				 ->join('groups','groups.group_id','=','classes.group_id')
    				 ->join('batches','batches.batch_id','=','classes.batch_id')
    				 ->join('levels','levels.level_id','=','classes.level_id')
    				 ->join('programs','programs.program_id','=','levels.program_id')
    				 ->where('statuses.student_id',$student_id);
    }

    public function show_school_fee($level_id)
    {
    	return Fee::join('academics', 'academics.academic_id', '=', 'fees.academic_id')
			        ->join('levels', 'levels.level_id', '=', 'fees.level_id')
			        ->join('programs', 'programs.program_id', '=', 'levels.program_id')
			        ->join('feetypes', 'feetypes.fee_type_id', '=', 'fees.fee_type_id')
			        ->where('levels.level_id', $level_id)
			        ->orderBy('fees.amount', 'DESC');
    }

    public function payment($viewName,$student_id)
    {
    	
    	$status=$this->student_status($student_id)->first();
    	$programs=Program::where('program_id',$status->program_id)->get();
    	$levels=Level::where('program_id',$status->program_id)->get();
    	$schoolFee=$this->show_school_fee($status->level_id)->first();
    	$receipt_id=ReceiptDetail::where('student_id',$student_id)->get();//->max('receipt_id');
    	$paidStudentFees=$this->studentPaidFees($student_id)->get();//dd($paidStudentFees);
    	$studentTransactions=$this->readStudentTransaction($student_id)->get();//dd($studentTransactions);
    	$nextReceipt=Receipt::max('receipt_id');
    	$feeTypes = FeeType::all();

    	return view($viewName,compact('status','programs','levels','schoolFee','receipt_id','paidStudentFees','studentTransactions','feeTypes','nextReceipt'))->with('student_id',$student_id);
    }

    public function showStudentPayment(Request $request)
    {
    	$student_id=$request->student_id;
    	return $this->payment('fee.payment',$student_id);
    }

    //**********************************************///

    public function proceedToPay($student_id)
    {
    	return $this->payment('fee.payment',$student_id);
    }

    public function savePayment(Request $request)
    {
    	$studentFee = StudentFee::create($request->all());

    	//$transaction=Transaction::create($request->all());

    	$transaction = Transaction::create([
    				'fee_id'        => $request->fee_id,
    				'transact_date' => $request->transact_date,
    				'user_id'       => $request->user_id,
    				'student_id'    => $request->student_id,
    				's_fee_id'      => $studentFee->s_fee_id,
    				'paid'          => $request->paid,
    				'remark'        => $request->remark,
    				'descrption'   => $request->descrption
    	]);

    	$receipt_id = Receipt::autoNumber();
    	ReceiptDetail::create([
    			'receipt_id'=>$receipt_id,
    			'student_id'=>$request->student_id,
    			'transact_id'=>$transaction->transact_id,
    	]);

    	return back();

    }

    public function getRemainingFeeToPay(Request $request)
    {
    	if($request->ajax())
    	{
    		$getStudentRemainingFee=StudentFee::join('levels','levels.level_id','=','studentfees.level_id')
    				  ->join('programs','programs.program_id','=','levels.program_id')
    				  ->join('fees','fees.fee_id','=','studentfees.fee_id')
    				  ->join('students','students.student_id','=','studentfees.student_id')
    				  ->select(
    				  			'levels.level_id',
    				  			'levels.level',
    				  			'programs.program_id',
    				  			'programs.program',
    				  			'fees.fee_id',
    				  			'students.student_id',
    				  			'studentfees.s_fee_id',
    				  			'fees.amount as school_fee',
    				  			'studentfees.amount as student_amount',
    				  			'studentfees.discount'
    				  )
    				  ->where('studentfees.s_fee_id',$request->s_fee_id)
    				  ->first();
    				  
    		return response($getStudentRemainingFee);		  
    	}
    }

    public function payRemainingFee(Request $request)
    {
    	
    	$transaction = Transaction::create($request->all());
    	//dd($transaction);
    	if( $transaction->count() !=0 )
    	{
    		$receipt_id = Receipt::autoNumber();
    		ReceiptDetail::create([
    				'receipt_id'=>$receipt_id,
    				'student_id'=>$transaction->student_id,
    				'transact_id'=>$transaction->transact_id,
    		]);
    		return back();
    	} 
  
    }

    //********************Read payment data**************************///
    //read particular student's payment fees 
    public function studentPaidFees($student_id)
    {
    	return StudentFee::join('fees','fees.fee_id','=','studentfees.fee_id')
    					 ->join('students','students.student_id','=','studentfees.student_id')
    					 ->join('levels','levels.level_id','=','studentfees.level_id')
    					 ->join('programs','programs.program_id','=','levels.program_id')
    					 ->select(
    					 			'levels.level_id',
    					 			'levels.level',
    					 			'programs.program',
    					 			'fees.amount as school_fee',
    					 			'students.student_id',
    					 			'studentfees.s_fee_id',
    					 			'studentfees.amount as student_amount',
    					 			'studentfees.discount'

    					 )
    					 ->where('students.student_id',$student_id);
    	//call this function in payment function					 
    }

    public function readStudentTransaction($student_id)
    {
    	return ReceiptDetail::join('receipts', 'receipts.receipt_id', '=', 'receiptdetails.receipt_id')
    				->join('students', 'students.student_id', '=', 'receiptdetails.student_id')
    				->join('transactions', 'transactions.transact_id', '=', 'receiptdetails.transact_id')
    				->join('fees', 'fees.fee_id', '=', 'transactions.fee_id')
    				->join('users', 'users.id', '=', 'transactions.user_id')
    				->where('students.student_id', $student_id);
    }






    //********************Create Fee**************************///

    public function createFee(Request $request)
    {
    	if($request->ajax())
    	{
    		return response(Fee::create($request->all()) );
    	}
    }




    //********************Print Invoice**************************///

    public function printInvoince($receipt_id)
    {
    	$invoice = ReceiptDetail::join('receipts', 'receipts.receipt_id', '=', 'receiptdetails.receipt_id')
    		->join('transactions', 'transactions.transact_id', '=', 'receiptdetails.transact_id')
    		->join('students', 'students.student_id', '=', 'receiptdetails.student_id')
    		->join('fees', 'fees.fee_id', '=', 'transactions.fee_id')
    		->join('users', 'users.id', '=', 'transactions.user_id')
    		->join('levels', 'levels.level_id', '=', 'fees.level_id')
    		->join('programs', 'programs.program_id', '=', 'levels.program_id')
    		->where('receipts.receipt_id', $receipt_id)
    		->select(
    			'students.student_id',
				'students.first_name',
				'students.last_name',
				'students.sex',
				'users.name',
				'fees.amount AS school_fee',
				'transactions.transact_date',
				'transactions.paid',
				'receipts.receipt_id',
				'transactions.s_fee_id',
				'levels.level_id'
			)
    		->first();

    	$status = MyClass::join('levels', 'levels.level_id', '=', 'classes.level_id')
    				    ->join('shifts', 'shifts.shift_id', '=', 'classes.shift_id')
    					->join('times', 'times.time_id', '=', 'classes.time_id')
    					->join('batches', 'batches.batch_id', '=', 'classes.batch_id')
    					->join('groups', 'groups.group_id', '=', 'classes.group_id')
    					->join('academics', 'academics.academic_id', '=', 'classes.academic_id')
    					->join('programs', 'programs.program_id', '=', 'levels.program_id')
    					->join('statuses', 'statuses.class_id', '=', 'classes.class_id')
    					->where('levels.level_id', $invoice->level_id)
    	                ->where('statuses.student_id', $invoice->student_id)
    					->select(DB::raw('CONCAT("Program: ", programs.program,
	                                    " / Level: ", levels.level,
	                                    " / Shift: ", shifts.shift,
	                                    " / Time: ", times.time,
	                                    " / Group: ", groups.groups,
	                                    " / Batch:", batches.batch,
	                                    " / Academic: ", academics.academic,
	                                    " / Start Date: ", classes.start_date,
	                                    " / End Date: ", classes.end_date
	                                    ) As detail')
    					)
    					->first();

    		$studentFee = StudentFee::where('s_fee_id', $invoice->s_fee_id)->first();
    		$totalPaid  = Transaction::where('s_fee_id', $invoice->s_fee_id)->sum('paid');
    				
    		return view('invoice.invoice', compact('invoice', 'status', 'totalPaid', 'studentFee'));			


    }


    //*********************Delete Transaction****************************************

    public function deleteTransaction($transaction_id)
    {
    	Transaction::destroy($transaction_id);
    	return back();
    }


    //8888888888888888888888show level (payment page header value change on course change)

     public function showLevelStudent(Request $request)
    {
	    $status = MyClass::join('levels', 'levels.level_id', '=', 'classes.level_id')
				    ->join('shifts', 'shifts.shift_id', '=', 'classes.shift_id')
				    ->join('times', 'times.time_id', '=', 'classes.time_id')
				    ->join('batches', 'batches.batch_id', '=', 'classes.batch_id')
				    ->join('groups', 'groups.group_id', '=', 'classes.group_id')
				    ->join('academics', 'academics.academic_id', '=', 'classes.academic_id')
				    ->join('programs', 'programs.program_id', '=', 'levels.program_id')
				    ->join('statuses', 'statuses.class_id', '=', 'classes.class_id')
				    ->where('levels.level_id', $request->level_id)
				    ->where('statuses.student_id', $request->student_id)
				    ->select(DB::raw('CONCAT("Academic: ", academics.academic,
                        " / Program: ", programs.program,
                        " / Level: ", levels.level,
                        " / Shift: ", shifts.shift,
                        " / Time: ", times.time,
                        " / Group: ", groups.groups,
                        " / Batch:", batches.batch) As detail'))
		                  ->first();
      return response($status);
    }

    public function changeInvoiceId(Request $request)
    {
    	$invoice_id=Transaction::join('receiptdetails','receiptdetails.transact_id','=','transactions.transact_id')
    	->where('transactions.s_fee_id',$request->s_fee_id)
    	->where('transactions.student_id',$request->student_id)
    	->first();
    	return response($invoice_id);
    }




}

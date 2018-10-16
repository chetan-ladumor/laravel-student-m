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
use App\StudentFee;
use App\Transaction;
use Charts;
//use App\Charts\NewStudentRegistered;
use DB;

use App\User;

class ReportController extends Controller
{
    public function getStudentList()
    {
    	$programs=Program::all();
    	$academics=Academic::orderBy('academic_id','DESC')->get();
    	$shifts=Shift::all();
    	$times=Time::all();
    	$batches=Batch::all();
    	$groups=Group::all();
    	$student_id=Student::max('student_id');
    	return view('report.student_list',compact('programs','academics','shifts','times','batches','groups'));
    }

    public function showStudentInformation(Request $request)
    {
    	$classes=$this->getStudntInfo($request->class_id)
                      ->select(DB::raw(
                                        'students.student_id,
                                          CONCAT(students.first_name," ",students.last_name) as name,
                                          (CASE WHEN students.sex=0 THEN "Male" ELSE "Female" END) as sex,
                                            students.dob,
                                            CONCAT(programs.program," / ",levels.level,
                                            " / ", shifts.shift," / ",times.time,
                                            " / Start-(",classes.start_date,
                                            " / ", classes.end_date, ")") as program'
                                        )
                                )
                      ->where('classes.class_id',$request->class_id)
                      ->get();
    	return view('report.student_information',compact('classes'));
    }

    private function getStudntInfo()
    {
    	return Status::join('classes', 'classes.class_id', '=', 'statuses.class_id')
    				  ->join('students', 'students.student_id', '=', 'statuses.student_id')
    		          ->join('levels', 'levels.level_id', '=', 'classes.level_id')
    		          ->join('programs', 'programs.program_id', '=', 'levels.program_id')
    				  ->join('academics', 'academics.academic_id', '=', 'classes.academic_id')
    				  ->join('shifts', 'shifts.shift_id', '=', 'classes.shift_id')
					  ->join('times', 'times.time_id', '=', 'classes.time_id')
					  ->join('batches', 'batches.batch_id', '=', 'classes.batch_id')
					  ->join('groups', 'groups.group_id', '=', 'classes.group_id');
    }




    //***************************  Multi class student lists  ****************************

    public function getMultiClassStudentList()
    {
    	$programs=Program::all();
    	$academics=Academic::orderBy('academic_id','DESC')->get();
    	$shifts=Shift::all();
    	$times=Time::all();
    	$batches=Batch::all();
    	$groups=Group::all();
    	$student_id=Student::max('student_id');
    	return view('report.multi_class_student_list',compact('programs','academics','shifts','times','batches','groups'));
    }

    public function showStudentMultiClassInformation(Request $request)
    {
        if($request->ajax())
        {

            if(!empty($request['chk']))
            {
                $classes=$this->getStudntInfo($request->class_id)
                              ->select(DB::raw(
                                                'students.student_id,
                                                  CONCAT(students.first_name," ",students.last_name) as name,
                                                  (CASE WHEN students.sex=0 THEN "Male" ELSE "Female" END) as sex,
                                                    students.dob,
                                                    programs.program,
                                                    levels.level,
                                                    shifts.shift,
                                                    times.time,
                                                    batches.batch,
                                                    groups.groups
                                                    '
                                                )
                                        )
                              ->whereIn('classes.class_id',$request['chk'])
                              ->get();
            }
            
            return view('report.multi_class_student_information',compact('classes'));
        }
        // $classes=$this->getStudntInfo($request->class_id);
        // 
    }


    //************************ FEE REPORT  **********************************

    public function show_fee_report()
    {
        return view('fee.fee_report');
    }

    public function get_fee_report(Request $request)
    {
        if($request->ajax())
        {
            $fees=$this->feeInfo()->select(

                                        'users.name',
                                        'students.student_id',
                                        'students.first_name',
                                        'students.last_name',
                                        'fees.amount as school_fee',
                                        'studentfees.amount as student_fee',
                                        'studentfees.discount',
                                        'transactions.transact_date',
                                        'transactions.paid'
                                    )
                                    ->whereDate('transactions.transact_date', '>=', $request->from)
                                    ->whereDate('transactions.transact_date', '<=', $request->to)
                                    ->orderBy('students.student_id')
                                    ->get();
            return view('fee.fee_list',compact('fees'));
        }
    }

    public function feeInfo()
    {
        return Transaction::join('fees','fees.fee_id','=','transactions.fee_id')
                   ->join('students','students.student_id','=','transactions.student_id')
                   ->join('studentfees','studentfees.s_fee_id','=','transactions.s_fee_id')
                   ->join('users','users.id','=','transactions.user_id');  
    }


    //new student registered chart

    public function new_student_registered_chart()
    {
        $students = Student::where(DB::raw("(DATE_FORMAT(dateregistered,'%Y'))"),date('Y'))
        ->select('dateregistered AS created_at')
        ->get();
        
       /* $chart = Charts::database($students, 'bar', 'highcharts')
                        ->title("Monthly new Register Users")
                        ->elementLabel("Total Users")
                        ->dimensions(1000, 500)
                        ->responsive(false)
                        ->groupByMonth(date('Y'), true);*/
         $chart = Charts::database($students, 'donut', 'highcharts')
                        ->title("Monthly new Register Users")
                        ->elementLabel("Total Users")
                        ->dimensions(1000, 500)
                        ->responsive(false)
                        //->groupByMonth(date('Y'), true);
                        ->groupByDay();                

        // $chart = new NewStudentRegistered;
        // $chart->labels(['New Student Registered']);
        // $chart->dataset('My dataset 1', 'bar', [1, 2, 3, 4]);

        return view('report.newStudentRegistered',compact('chart'));
    }
   

}

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
use File;
use Storage;
use App\FileUpload;
use DB;

class StudentController extends Controller
{
    public function showStudentRegistrationForm()
    {
    	$programs=Program::all();
    	$academics=Academic::orderBy('academic_id','DESC')->get();
    	$shifts=Shift::all();
    	$times=Time::all();
    	$batches=Batch::all();
    	$groups=Group::all();
    	$student_id=Student::max('student_id');
    	return view('student.register_student',compact('programs','academics','shifts','times','batches','groups','student_id'));
    }

    public function insertStudent(Request $request)
    {
    	//return $request->all();
    	$student = new Student();

    	$student->first_name = $request->first_name;
    	$student->last_name  = $request->last_name;
    	$student->sex = $request->sex;
    	$student->dob = $request->dob;
    	$student->email = $request->email;
    	$student->rac = $request->rac;
    	$student->status = $request->status;
    	$student->nationality = $request->nationality;
    	$student->national_card = $request->national_card;
    	$student->passport = $request->passport;
    	$student->phone = $request->phone;
    	$student->village = $request->village;
    	$student->commune = $request->commune;
    	$student->district = $request->district;
    	$student->province = $request->province;
    	$student->current_address = $request->current_address;
    	$student->dateregistered = $request->dateregistered;
    	$student->user_id = $request->user_id;
    	//$student->photo = $request->photo;
    	$student->photo = FileUpload::photo($request, 'photo');

    	if($student->save())
    	{
    		
    		$student_id = $student->student_id;

    		// Save student id in the given class
    		Status::create([
    				'student_id' => $student_id,
    				'class_id'   => $request->class_id,
    				//'user_id'    => $request->user_id
    		]);
    		//return back();
    	    return redirect()->route('proceedToPay', ['student_id' => $student_id]);
    	}
    }

    public function showStudentInfo(Request $request)
    {
        $students=[];
        if($request->has('search'))
        {
            $students=Student::where('student_id',"LIKE","%".$request->search."%")
                             ->Orwhere('first_name',"LIKE", "%".$request->search."%")
                             ->Orwhere('last_name',"LIKE","%".$request->search."%")
                             ->select(DB::raw(
                                'student_id,
                                 first_name,
                                 last_name,
                                CONCAT(first_name," ",last_name) AS full_name,
                                ( CASE WHEN sex=0 THEN "M" ELSE "F" END) AS sex,
                                dob'
                             ))
                             ->paginate(2)
                             ->appends('search',$request->search);
        }
        else
        {
            $students=Student::select(DB::raw(
                                'student_id,
                                 first_name,
                                 last_name,
                                CONCAT(first_name," ",last_name) AS full_name,
                                ( CASE WHEN sex=0 THEN "M" ELSE "F" END) AS sex,
                                dob'
                             ))
                             ->paginate(2);
        }
        return view('student.student_list',compact('students'));
    }

    public function ShowAjaxStudentView()
    {
        return view('student.ajaxStudentList');
    }

    public function showAjaxStudentInfo(Request $request)
    {
    
       
       /* $students=Student::select(DB::raw(
                                'student_id,
                                 first_name,
                                 last_name,
                                CONCAT(first_name," ",last_name) AS full_name,
                                ( CASE WHEN sex=0 THEN "M" ELSE "F" END) AS sex,
                                dob'
                             ))
                             ->get();*/

        $columns = array( 
                                    0 =>'student_id', 
                                    1 =>'first_name',
                                    2=> 'last_name',
                                    3=> 'full_name',
                                    4=>'sex',
                                    5=>'dob',
                                    6=> 'student_id',
                                );
          
                $totalData = Student::count();
                    
                $totalFiltered = $totalData; 

                $limit = $request->input('length');
                $start = $request->input('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');
                    
                if(empty($request->input('search.value')))
                {            
                    $posts = Student::offset($start)
                                 ->limit($limit)
                                 ->select(DB::raw(
                                    'student_id,
                                     first_name,
                                     last_name,
                                    CONCAT(first_name," ",last_name) AS full_name,
                                    ( CASE WHEN sex=0 THEN "M" ELSE "F" END) AS sex,
                                    dob'
                                ))
                                ->orderBy($order,$dir)
                                ->get();
                }
                else {
                    
                    $search = $request->input('search.value'); 

                    $posts =  Student::where('student_id','LIKE',"%{$search}%")
                                    ->orWhere('first_name', 'LIKE',"%{$search}%")
                                    ->orWhere('last_name', 'LIKE',"%{$search}%")
                                    ->offset($start)
                                    ->limit($limit)
                                     ->select(DB::raw(
                                        'student_id,
                                         first_name,
                                         last_name,
                                        CONCAT(first_name," ",last_name) AS full_name,
                                        ( CASE WHEN sex=0 THEN "M" ELSE "F" END) AS sex,
                                        dob'
                                    ))
                                    ->orderBy($order,$dir)
                                    ->get();

                    $totalFiltered = Student::where('student_id','LIKE',"%{$search}%")
                                     ->orWhere('first_name', 'LIKE',"%{$search}%")
                                     ->orWhere('last_name', 'LIKE',"%{$search}%")
                                     ->count();
                }

                $data = array();
                if(!empty($posts))
                {
                    foreach ($posts as $post)
                    {
                        $show =  route('showAjaxStudentInfo',$post->id);
                        $edit =  route('showAjaxStudentInfo',$post->id);

                        $nestedData['student_id'] = $post->student_id;
                        $nestedData['first_name'] = $post->first_name;
                        $nestedData['last_name'] = $post->last_name;
                        $nestedData['full_name'] = $post->full_name;
                        $nestedData['sex'] = $post->sex;
                        $nestedData['dob'] = $post->dob;
                        $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                                  &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
                        $data[] = $nestedData;

                    }
                }
                  
                $json_data = array(
                            "draw"            => intval($request->input('draw')),  
                            "recordsTotal"    => intval($totalData),  
                            "recordsFiltered" => intval($totalFiltered), 
                            "data"            => $data   
                            );
                    
                echo json_encode($json_data);                      
       
        //return view('student.ajaxStudentList',compact('students'));
    }

}

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
class CourseController extends Controller
{
    public function __construct()
    {
    	$this->middleware('web');
    }

    public function getManageCourse()
    {
    	$programs=Program::all();
    	$academics=Academic::orderBy('academic_id','DESC')->get();
    	$shifts=Shift::all();
    	$times=Time::all();
    	$batches=Batch::all();
    	$groups=Group::all();
    	return view('courses.manageCourse',compact('programs','academics','shifts','times','batches','groups') );
    }

    public function postInsertAcademic(Request $request)
    {
    	if($request->ajax())
    	{
    		return response( Academic::create( $request->all() ) );
    	}
    }

    public function postInsertProgram(Request $request)
    {
    	if($request->ajax())
    	{
    		return response( Program::create( $request->all() ) );
    	}
    }
    public function postInsertLevel(Request $request)
    {
    	if($request->ajax())
    	{
    		return response( Level::create( $request->all() ) );
    	}
    }

    public function showLevel(Request $request)
    {
    	if($request->ajax())
    	{
    		return response(Level::where('program_id',$request->program_id)->get());
    	}
    }

    public function postInsertShift(Request $request)
    {
    	if($request->ajax())
    	{
    		return response( Shift::create( $request->all() ) );
    	}
    }

    public function postInsertTime(Request $request)
    {
    	if($request->ajax())
    	{
    		return response( Time::create( $request->all() ) );
    	}
    }

    public function postInsertBatch(Request $request)
    {
    	if($request->ajax())
    	{
    		return response( Batch::create( $request->all() ) );
    	}
    }

    public function postInsertGroup(Request $request)
    {
    	if($request->ajax())
    	{
    		return response( Group::create( $request->all() ) );
    	}
    }

    public function postInsertClass(Request $request)
    {
    	if($request->ajax())
    	{
    		return response( MyClass::create( $request->all() ) );
    	}
    }

    // ======================= Class data ==================

    public function getClassInformation(Request $request)
    {
        $critearea = [];
        if($request->academic_id != ""  && $request->program_id=="")
        {
            $critearea = array('academics.academic_id'=>$request->academic_id);
        }else if(
            $request->academic_id != "" && 
            $request->program_id && 
            $request->level_id &&
            $request->shift_id    == "" &&
            $request->time_id     == "" &&
            $request->batch_id    == "" &&
            $request->group_id    == ""
        )

        {
            $critearea = array(
                                'academics.academic_id'=>$request->academic_id,
                                'programs.program_id'=>$request->program_id,
                                'levels.level_id'=>$request->level_id,
                         );
        }
        else if(
                $request->academic_id != "" &&
                $request->program_id != "" &&
                $request->level_id != "" &&
                $request->shift_id    != "" &&
                $request->time_id    != "" &&
                $request->batch_id   != "" &&
                $request->group_id != ""
        )
        {
            $critearea = [
                'academics.academic_id' => $request->academic_id,
                'programs.program_id'   => $request->program_id,
                'levels.level_id'       => $request->level_id,
                'shifts.shift_id'       => $request->shift_id,
                'times.time_id'         => $request->time_id,
                'batches.batch_id'      => $request->batch_id,
                'groups.group_id'       => $request->group_id
            ];
        }
    	$classes=$this->classInformation($critearea)->get();
    	return view('class.classInfo',compact('classes'));	
    }

	public function classInformation($critearea)

	{ 
	    return  MyClass::join('academics','academics.academic_id','=','classes.academic_id')
 							->join('levels','levels.level_id','=','classes.level_id')
 							->join('programs','programs.program_id','=','levels.program_id')
 							->join('shifts','shifts.shift_id','=','classes.shift_id')
 							->join('times','times.time_id','=','classes.time_id')
 							->join('batches','batches.batch_id','=','classes.batch_id')
 							->join('groups','groups.group_id','=','classes.group_id')
                            ->where($critearea)
 							->orderBy('classes.class_id','DESC');
 		//dump($classes);
 		//return view('class.classInfo',compact('classes'));					

	} 

	/*Delete class*/
	public function deleteClass(Request $request)
	{
		if($request->ajax())
		{
			MyClass::destroy($request->class_id);
		}
	}

	/*Edit class*/

	public function editClass(Request $request)
	{
		if($request->ajax())
		{
			return response(MyClass::find($request->class_id));
		}
	} 

	public function upadteClassInformation(Request $request)
	{
		if($request->ajax())
		{
			return response(MyClass::updateOrCreate(['class_id'=>$request->class_id],$request->all()));
		}
	}  
}

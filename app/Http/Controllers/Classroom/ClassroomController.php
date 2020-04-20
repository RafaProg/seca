<?php

namespace App\Http\Controllers\Classroom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClassroomRequest;
use App\Model\Classroom;
use App\Model\Internship;
use Exception;

class ClassroomController extends Controller
{
    private $classroom;

    public function __construct(Classroom $classroom)
    {
        $this->classroom = $classroom;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('classroom.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $numberClassroom = $this->classroom->count();
        
        if ($numberClassroom > 0) {
            return view('classroom.register-classroom', compact('numberClassroom'));
        }

        return view('classroom.register-classroom', compact('numberClassroom'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassroomRequest $request)
    {
        try {
            $numClassroom = $request->numberClassroom;
            
            $result = $this->classroom->count();

            if ($result > 0) {   
                foreach ($this->classroom->all() as $classroom) {
                    $classroom->delete();
                }
            }

            for ($i = 1; $i <= $numClassroom; $i++) {
                $result = $this->classroom->create([
                    'id' => $i,
                    'classroom' => 'Sala ' . $i,
                    'first_order' => false
                ]);
            }

            return redirect()->route('classroom.index');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function showConfigReleaseClassroom()
    {
        try {
            $classroom = $this->classroom->where('first_order', true)->first();
            
            if (!$classroom) {
                $classroom = "Não há ordem de liberação previamente configurada.";
            }
            
            $date = date('d/m/Y');

            return view('classroom.config-release', compact('classroom', 'date'));
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function updateRelease(Request $request){
        try {
            $oldClassroom =  $this->classroom->where('first_order', true)->first();
            
            if ($oldClassroom) {
                $oldClassroom->update(['first_order' => false]);
            }

            $classroom = $request->numberClassroom;
            $classroom = 'Sala ' . $classroom;

            $classroom = $this->classroom->where('classroom', $classroom)->first();
            
            if ($classroom) {
                $classroom->update(['first_order' => true]);
            } else {
                //
            }

            return redirect()->route('classroom.config-release');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function showConfigInternship(Request $request)
    {
        try {
            $classrooms = $this->classroom->with('internship')->simplePaginate(12);
            
            if ($request->has('page')) {
                if (!$classrooms->count()) {
                    return response()->json([
                        'msg' => 'Não há mais salas para serem exibidas!'
                    ], 204);
                }
                return view('classroom.config-internship-add', compact('classrooms'));
            }

            return view('classroom.config-internship', compact('classrooms'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function storeConfigInternship(Request $request)
    {
        try {
            $classrooms = $request->except(['_token']);
            
            $internship = new Internship();

            $internship->truncate();

            if (count($classrooms) > 0) {
                foreach ($classrooms as $key => $classroom) {
                    if (!($key == 'firstOrder')) {
                        $this->classroom->find($classroom)->internship()->updateOrCreate(
                            [ 'classroom_id'     => $classroom ],
                            [
                                'is_in_internship' => true,
                                'first_order'      => false 
                            ]
                        );
                    }

                    if ($key == 'firstOrder'
                        &&
                        !($internship->where('classroom_id', $classroom)->first()->first_order == 1)
                        ) {
                        $internship->where('classroom_id', $classroom)->update([ 
                            'is_in_internship' => true,
                            'first_order' => true
                        ]);
                    }
                }

                return redirect()->route('classroom.config-internship');
            } else {
                return 'Mostrar mensagem de validação!';
            }

            //return response()->json($request->all());
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
}

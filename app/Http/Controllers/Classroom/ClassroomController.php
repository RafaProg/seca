<?php

namespace App\Http\Controllers\Classroom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClassroomRequest;
use App\Model\Classroom;
use App\Model\Internship;
use App\Model\Release;
use Exception;

class ClassroomController extends Controller
{
    private $classroom;
    private $release;

    public function __construct(Classroom $classroom, Release $release)
    {
        $this->classroom = $classroom;
        $this->release = $release;
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
                $this->classroom->where('id', '>', 0)->delete();
            }

            for ($i = 1; $i <= $numClassroom; $i++) {
                $result = $this->classroom->create([
                    'id' => $i,
                    'classroom' => 'sala ' . $i,
                ]);
                
                $result = $this->classroom->where('id', $i)->first()->release()->create([
                    'id' => $i,
                    'release_order' => $i,
                ]);
            }

            return redirect()->route('classroom.index');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the view for configuration release order.
     */
    public function showConfigReleaseClassroom()
    {
        try {   
            $releases = $this->release->orderBy('release_order', 'asc')->with('classroom')->get();
            
            return view('classroom.test-config-release', compact('releases'));
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * update configuration release order.
     */
    public function updateRelease(Request $request){
        try {
            $classrooms = $request->classrooms;
            
            if (!$classrooms) {
                return redirect()->route('classroom.config-release');
            }

            $classrooms = json_decode($classrooms);
            
            if (is_array($classrooms) || is_object($classrooms)) {
                if (count($classrooms) === $this->classroom->count()) {
                    foreach ($classrooms as $classroom) {
                        $classroom->classroom = mb_substr(ucfirst($classroom->classroom), 0, 4) . 
                                                ' ' . mb_substr($classroom->classroom, 4);
    
                        $cr = $this->classroom->where('classroom', $classroom->classroom)
                                                                ->with('release')->first();
    
                        $cr->release->update([
                            'release_order' => $classroom->newPosition
                        ]);
                    }
                }
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

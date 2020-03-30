<?php

namespace App\Http\Controllers;

use App\Resume;
use Illuminate\Http\Request;
use App\Http\Requests\ResumesRequest;


class ResumeController extends Controller
{
    
    protected $user;
 
    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    public function index(Request $request)
    
    {
        $resumes =  $this->user->resumes()->get();
        return response()->json([
            "resumes" => $resumes
        ], 200);
    }

    public function show($id)
    {
        $resume = $this->user->resumes()->find($id);
        if (!$resume) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, resume with id ' . $id . ' cannot be found'
            ], 400);
        }
        return response()->json([
            "resume" => $resume
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3',
            'desciption' => 'required|string|min:5',
        ]);
        $resume = new Resume();
        $resume->name = $request->name;
        $resume->desciption = $request->desciption;
        if ($this->user->resumes()->save($resume)){
            $resumes =  $this->user->resumes()->get();
            return response()->json([
                'success' => true,
                'resumes' => $resumes,
            ],200);
        } else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, resume could not be added'
            ], 500);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3',
            'desciption' => 'required|string|min:5',
        ]);
        $resume = $this->user->resumes()->find($id)->fill($request->all())->save();
        if ($resume){
            $resumes =  $this->user->resumes()->get();
            return response()->json([
                'success' => true,
                'resumes' => $resumes,
            ],200);
        } else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, resume could not be updated'
            ], 500);
    }
    
    public function destroy($id)
    {
        $resume = $this->user->resumes()->find($id);
        if (!$resume) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, resume with id ' . $id . ' cannot be found'
            ], 400);
        }
    
        if ($resume->delete()) {
            $resumes =  $this->user->resumes()->get();
            return response()->json([
                'success' => true,
                'resumes' => $resumes
            ]);
        } else 
            return response()->json([
                'success' => false,
                'message' => 'Resume could not be deleted'
            ], 500);
    }

}

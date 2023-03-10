<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ProjectRequest;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class ProjectController extends Controller
{
    private $projectRepository, $categoryRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProjectRepositoryInterface $projectRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $RS_Results = $this->projectRepository->all();
        // dd($RS_Results);

        return view('projects.index', compact('RS_Results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $RS_Result_Cats = $this->categoryRepository->all();

        return view('projects.create-edit', compact('RS_Result_Cats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        // Retrieve the validated input data...
        $request->validated();

        $response = $this->projectRepository->store($request);

        Session::flash('messageType', $response['messageType']);
        Session::flash('message', $response['message']);

        return Redirect::route('projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $RS_Row = $this->projectRepository->getById($id);
        // dd($RS_Row->statuses[0]->projectIssues[0]->title);

        return view('projects.show', compact('RS_Row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $RS_Result_Cats = $this->categoryRepository->all();
        $RS_Row = $this->projectRepository->getByID($id);

        return view('projects.create-edit', compact('RS_Result_Cats', 'RS_Row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $id)
    {
        // Retrieve the validated input data...
        $request->validated();

        $response = $this->projectRepository->update($request, $id);

        Session::flash('messageType', $response['messageType']);
        Session::flash('message', $response['message']);

        return Redirect::route('projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->projectRepository->delete($id);

        Session::flash('messageType', $response['messageType']);
        Session::flash('message', $response['message']);

        return Redirect::back();
    }
}

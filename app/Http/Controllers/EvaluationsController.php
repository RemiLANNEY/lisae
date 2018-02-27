<?php

namespace App\Http\Controllers;

use App\Repositories\EvaluationsRepository;
use Illuminate\Http\Request;
use DB;
use App\Evaluations;


class EvaluationsController extends Controller
{
	protected $evalRepository;
	protected $nbrPerPage = 4;
	
	public function __construct(EvaluationsRepository $evalRepository)
	{
		$this->middleware('auth');
		$this->evalRepository = $evalRepository;
		
	}
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    	$evals = $this->evalRepository->getPaginate($this->nbrPerPage);
    	$links = $evals->render();
    	return view('eval.index', compact('evals', 'links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    	return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    	$inputs = array_merge($request->all());
    	$candidat = $inputs['id_etudiant'];
    	
    	if($this->evalRepository->store($inputs))
    	{
    		return redirect(route('candidat.show',  $candidat))->withOk("L'évaluation a bien été créée.");
    	}
    	else
    	{
    		return redirect(route('candidat.show',  $candidat))->with('error', ['L\'évaluation n\'a pas été créée']);
    	}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    	$this->evalRepository->update($id, $request->all());
    	return redirect(route('candidat.show', $request->candidat))->withOk("L'évaluation a été modifiée.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function formEditEval(Request $request){
    	$candidat = $request->candidat;
    	
    	$id_eval = $request->id;
    	$eval = DB::table('evaluations')->where('id', $id_eval)->get();
    	$eval= $eval->first();
    	$candidat = $request->candidat;
    	return view('eval.edit', compact('eval', 'candidat'));
    }
    
    public function destroyEval(Request $request)
    {
    	$id = $request->id;
    	$candidat = $request->candidat;
    	$this->evalRepository->destroy($id);
    	return redirect(route('candidat.show', $request->candidat))->withOk("L'évaluation a été supprimée.");
    }
}

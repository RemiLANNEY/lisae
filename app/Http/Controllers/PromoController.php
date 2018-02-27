<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PromoRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use DB;
use PDF;

class PromoController extends Controller
{

	protected $promoRepository;

	protected $nbrPerPage = 4;

	public function __construct(PromoRepository $promoRepository)
	{
		$this->middleware('auth');
		//$this->middleware('admin', ['only' => 'destroy']);

		$this->promoRepository = $promoRepository;
	}

	public function index()
	{
		$promo = $this->promoRepository->getPaginate($this->nbrPerPage);
		$links = $promo->render();

		return view('promo.liste', compact('promo', 'links'));
	}

	public function create()
	{
		return view('promo.create');
	}

	public function store(Request $request)
	{
		$inputs = array_merge($request->all());
		
		if(!isset($inputs['description']) || empty($inputs['description']) ){
			$inputs['description'] = " ";
		}

		if($this->promoRepository->store($inputs))
		{
			return redirect(route('promo.index'))->withOk("La promo a bien été créée.");
		}
		else 
		{
			return redirect(route('promo.create'))->with('error', ['La promo n\a pas été créée']);
		}		
	}

	public function destroy($id)
	{
		$this->promoRepository->destroy($id);

		return redirect(route('promo.index'))->withOk("La promo a bien été supprimée.");;
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
		$promo = $this->promoRepository->getById($id);
		return view('promo.edit',  compact('promo'));
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
		$this->promoRepository->update($id, $request->all());
		return redirect(route('promo.index'))->withOk("La promo " . $request->input('titre') . " a été modifié.");
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
		Auth::user()->promo_id = intval($id);
		session(['promo_id' => intval($id)]);
		$promo = $this->promoRepository->getById($id);
		session(['nom_promo' => $promo->titre]);
		return redirect()->back()->with("information", "La promo " . $promo->titre . " a été selectionnée");
		//return view('promo.show');
	}
	
	public function trombi(){
		$promo = $this->promoRepository->getById(session("promo_id"));	
		$etudiants = DB::table('candidats')->where([['promo_id', session('promo_id')],['liste', session('liste')]] )->orderby('Nom', 'asc')->get();
		$trombi = array();
		$extImg = ["jpg", "png", "gif", "tif", "jpeg", "bmp", "pct"];
		foreach($etudiants as $etudiant){
			$array = array();
			$exist = false;
			foreach($extImg as $ext){
				$array['id'] = $etudiant->id;
				$array['name'] = ucfirst(strtolower($etudiant->Prenom))." ".strtoupper($etudiant->Nom);
				if(file_exists(storage_path("app")."/portrait/".$etudiant->id.".".$ext)){
					$exist = true;
					$array["src"] = '../storage/app/portrait/'.$etudiant->id.'.'.$ext;
				//<img alt="{{ ucfirst(strtolower($etudiant->Prenom)) }} {{ strtoupper($etudiant->Nom) }}" src="{{ '../storage/app/portrait/'.$etudiant->id.'.'.$ext }}" class="portrait"
				}
			}
			if(!$exist)
				$array["src"] = "images/no_visage.png";
			$trombi[] = $array;
		}
		
		return view('promo.trombi',  compact('promo', 'trombi'));
	}

	public function selec(){
		$candidats = DB::table("candidats")->where("candidats.promo_id", session("promo_id"))->get();

		$return = [];

		foreach($candidats as $candidat){
			$evaluation = DB::table("selections")->select(DB::raw('avg(pre_admin) as pre_admin, avg(pre_motiv) as pre_motiv, avg(pre_techn) as pre_techn, avg(admin) as admin, avg(motiv) as motiv, avg(techn) as techn'))->where("id_candidats", $candidat->id);
			if ($evaluation->count()>0) {
				# code...
				$evals = $evaluation->first();
				$premoyenne = ($evals->pre_admin + $evals->pre_motiv + $evals->pre_techn) / 3;
				$moyenne = ($evals->admin + $evals->motiv + $evals->techn) / 3;
				
				if($premoyenne >= 1) {
					$return[] = array("id" => $candidat->id, "Nom" => ucfirst(strtolower($candidat->Prenom))." ".strtoupper($candidat->Nom), "email" => strtolower($candidat->Email), "preselection" => $premoyenne, "selection" => $moyenne, "sexe" => $candidat->Sexe, "ville" => $candidat->CP);
				} 
			}
			
		}

		return view('selection.position', compact('return'));
	}

	public function display(){
		$candidats = DB::table("candidats")->where("candidats.promo_id", session("promo_id"))->get();

		$return = [];

		foreach($candidats as $candidat){
			$evaluation = DB::table("selections")->select(DB::raw('avg(pre_admin) as pre_admin, avg(pre_motiv) as pre_motiv, avg(pre_techn) as pre_techn, avg(admin) as admin, avg(motiv) as motiv, avg(techn) as techn'))->where("id_candidats", $candidat->id);
			if ($evaluation->count()>0) {
				# code...
				$evals = $evaluation->first();
				$premoyenne = ($evals->pre_admin + $evals->pre_motiv + $evals->pre_techn) / 3;
				$moyenne = ($evals->admin + $evals->motiv + $evals->techn) / 3;
				
				$return[] = array("id" => $candidat->id, "Nom" => ucfirst(strtolower($candidat->Prenom))." ".strtoupper($candidat->Nom), "preselection" => $premoyenne, "selection" => $moyenne);
			}
			
		}

		return json_encode($return);
	}

	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdfview(Request $request)
    {
        if(session('liste') == "attente")  
            $liste =  DB::table('candidats')
                    ->where('promo_id', session('promo_id'))
                    ->whereIn('liste', ['attente', 'candidat'])
                    ->orderby('Nom', 'asc'); 
        else
            $liste =  DB::table('candidats')->where([['liste', session('liste')], ['promo_id', session('promo_id')]] )->orderby('Nom', 'asc');
        
        view()->share('liste',$liste->get());
        // Set extra option
    	PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
    	// pass view file
        $pdf = PDF::loadView('promo.liste');
        // download pdf
        return $pdf->download('liste.pdf');

    
    }
}
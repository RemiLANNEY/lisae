<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CandidatRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Input;
use Excel;
use DB;
use App\Candidat;
use Validator;

class CandidatController extends Controller
{
    //
	protected $candidatRepository;
	
	protected $nbrPerPage = 0;
	
	public function __construct(CandidatRepository $candidatRepository)
	{
		$this->middleware('auth');
		$this->middleware('ajax', ['only' => 'updateAjax']);	
		$this->candidatRepository = $candidatRepository;
	}
	
	public function index()
	{
		//$candidat = $this->candidatRepository->getPaginate($this->nbrPerPage);
		//$links = $candidat->render();
	
		return view('candidat.trombi'/*, compact('candidat', 'links')*/);
	}
	
	public function create()
	{
		return view('candidat.create');
	}
	
	public function store(PostRequest $request)
	{
		$inputs = array_merge($request->all(), ['users_id' => $request->user()->id]);
	
		$this->candidatRepository->store($inputs);
	
		return redirect(route('candidat.index'));
	}
	
	public function destroy($id)
	{
		$this->candidatRepository->destroy($id);
	
		return redirect()->back();
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
		$candidat = $this->candidatRepository->getById($id);
		
		//$dobt = explode("-",$candidat->Date_de_naissance);
		//$dob = $dobt[2]."/".$dobt[1]."/".$dobt[0];
		//$candidat->Date_de_naissance = $dob;
		$extImg = ["jpg", "png", "gif", "tif", "jpeg", "bmp", "pct"];
		return view('candidat.edit',  compact('candidat', 'extImg'));
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
		$this->candidatRepository->update($id, $request->all());
		return redirect(route('candidat.show',$id))->withOk("Le candidat a été modifié.");
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function Selec(Request $request, $id)
	{
		//
		//$this->candidatRepository->update($id, $request->all());
		//return redirect(route('candidat.show',$id))->withOk("Le candidat a été modifié.");

		$selection = DB::table('selections')->where( [['id_candidats', $id], ["users_id", Auth::user()->id]] );
		if($selection->count() == 0){
			//si l'utilisateur n'a jamais voté
			DB::table('selections')->insert([
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s"),
				'id_candidats' => $id,
				'users_id' => Auth::user()->id,
				'pre_admin' => $request->pre_admin,
				'pre_motiv' => $request->pre_motiv,
				'pre_techn' => $request->pre_techn,
				'admin' => $request->admin,
				'motiv' => $request->motiv,
				'techn' => $request->techn
			]);
		} else {
			$selection->update([
				'updated_at' => date("Y-m-d H:i:s"),
				'pre_admin' => $request->pre_admin,
				'pre_motiv' => $request->pre_motiv,
				'pre_techn' => $request->pre_techn,
				'admin' => $request->admin,
				'motiv' => $request->motiv,
				'techn' => $request->techn
			]);
		}

		return redirect(route('candidat.show',$id))->withOk("Votre avis a été pris en compte, merci !");
	}

	/**

     * Get a validator for an incoming registration request.

     *

     * @param  array  $data

     * @return \Illuminate\Contracts\Validation\Validator

     */

    protected function validator(array $data)

    {

        return Validator::make($data, [

            'Commentaires' => 'required'

        ]);

    }
	public function updateAjax(Request $request, $id)
	{
		//

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        
    	$this->candidatRepository->update($id, $request->all());		
    	$candidat = $this->candidatRepository->getById($id);
		return $candidat->Commentaires;
        
	}
	public function display(Request $request, $id)
	{
		//		
        $candidat = $this->candidatRepository->getById($id);

		//if($candidat->Commentaires != $request->Commentaires){
			return $candidat->Commentaires;
   //      } else {
			// return "]]}}@@@@{{[[";
   //      }
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	
	private function calendarAbsRet($id){
		$now = date("Y-m-d");
		$month = date("m", strtotime($now));
		$year = date("Y", strtotime($now));
		
		$retards = array();
		$absences = array();
		
		foreach(DB::table("absences")->where("id_etudiant", $id)->orderby("date", "ASC")->get() as $absence){
			$absences[]= $absence->date;
		}
		foreach(DB::table("retards")->where("id_etudiant", $id)->orderby("date", "ASC")->get() as $retard){
			$retards[]= $retard->date;
		}
		
		$current_month = strtotime($year."-".$month."-1");
		$prev_month = strtotime("last month", $current_month);
		$next_month = strtotime("next month", $current_month);
		$nb_prev_month = date("t", $prev_month);
		$first_jour = date("N", $current_month);
		$ligne = 0;
		
		$arraytemp = ["link" => "", "value" => "", "class" => ""];
		$arraytemp["link"] = "";
		$arraytemp["class"] = "";
		$arraytemp["value"] = date("W",$current_month);
		$tablesCalendar[$ligne][]=$arraytemp;
		
		$row = 0;
		$init = $nb_prev_month - $first_jour + 2;
		$fin = $nb_prev_month+1;
		
		
		
		for($i=$init; $i<$fin; $i++){	
			$arraytemp["class"] = "otherMonth";
			$arraytemp["value"] = $i;
			if(in_array($year."-".$prev_month."-".$i, $retards) || in_array($year."-".$prev_month."-0".$i, $retards)){
				$arraytemp["value"] .= ' <i class="fa fa-clock-o"></i>';
			}
			if(in_array($year."-".$prev_month."-".$i, $absences) || in_array($year."-".$prev_month."-0".$i, $absences)){
				$arraytemp["value"] .= ' <i class="fa fa-eye-slash"></i>';
			}
			$tablesCalendar[$ligne][] = $arraytemp;
			$row++;
		}
		for($i=1; $i<=date("t", $current_month); $i++)
		{
			if($row == 7){
				$row = 0;
				$ligne++;
				$arraytemp["class"] = "";
				$arraytemp["value"] = date("W",strtotime($i."-".$month."-".$year));
				$tablesCalendar[$ligne][] = $arraytemp;
			}			
			$arraytemp["class"] = "selectDate";
			if((date("d") == $i || date("d") == "0".$i) && date("m") == $month && date("Y")== $year)
				$arraytemp["class"] .= " redDate";
			$arraytemp["value"] = $i;
			if(in_array($year."-".$month."-".$i, $retards) || in_array($year."-".$month."-0".$i, $retards)){
				$arraytemp["value"] .= ' <i class="fa fa-clock-o"></i>';
			}
			if(in_array($year."-".$month."-".$i, $absences) || in_array($year."-".$month."-0".$i, $absences)){
				$arraytemp["value"] .= ' <i class="fa fa-eye-slash"></i>';
			}
			$tablesCalendar[$ligne][] = $arraytemp;
			
			$row++;
		}
		for($i = 1; $i < 8-$row; $i++)
		{
			$arraytemp["class"] = "otherMonth";
			$arraytemp["value"] = $i;
			if(in_array($year."-".$next_month."-".$i, $retards) || in_array($year."-".$next_month."-0".$i, $retards)){
				$arraytemp["value"] .= ' <i class="fa fa-clock-o"></i>';
			}
			if(in_array($year."-".$next_month."-".$i, $absences) || in_array($year."-".$next_month."-0".$i, $absences)){
				$arraytemp["value"] .= ' <i class="fa fa-eye-slash"></i>';
			}
			$tablesCalendar[$ligne][] = $arraytemp;
		}
		return $tablesCalendar;
	}
	
	public function show($id)
	{
		$candidat = $this->candidatRepository->getById($id);
		
		$dobt = explode("-",$candidat->Date_de_naissance);
		$dob = $dobt[2]."/".$dobt[1]."/".$dobt[0];
		$candidat->Date_de_naissance = $dob;
		$extImg = ["jpg", "png", "gif", "tif", "jpeg", "bmp", "pct"];
		
		$reponsesSelection = DB::table('selectionCandidats')->join('questions', 'questions.id', '=', 'selectionCandidats.id_question')->where( 'selectionCandidats.id_candidats', $candidat->id )->orderby('id_question', 'asc')->get();

		$selection = DB::table('selections')->where( [['id_candidats', $candidat->id], ["users_id", Auth::user()->id]] )->first();

		$selection_promo = DB::table("selections")->join("candidats", "selections.id_candidats", "=", "candidats.id")->select(DB::raw('avg(pre_admin) as pre_admin, avg(pre_motiv) as pre_motiv, avg(pre_techn) as pre_techn, avg(admin) as admin, avg(motiv) as motiv, avg(techn) as techn'))->where("candidats.promo_id", $candidat->promo_id)->first();

		$selections_moy = DB::table('selections')->where('id_candidats', $candidat->id);
		$selections = ['pre_admin' => 0, 'pre_motiv' => 0, 'pre_techn' => 0, 'admin' => 0, 'motiv' => 0, 'techn' => 0];
		if($selections_moy->count() > 0) {
			foreach($selections_moy->get() as $ligne){
				$selections['pre_admin'] += $ligne->pre_admin;
				$selections['pre_motiv'] += $ligne->pre_motiv;
				$selections['pre_techn'] += $ligne->pre_techn;
				$selections['admin'] += $ligne->admin;
				$selections['motiv'] += $ligne->motiv;
				$selections['techn'] += $ligne->techn;
			}
			
			foreach($selections as $key => $value){
				$selections[$key] = round($value/$selections_moy->count());
			}
		}
		
		$evals = DB::table('evaluations')->where("id_etudiant", $id)->orderby('updated_at', 'DESC')->get();
		
		$days = ["decal", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi", "dimanche"];
		$months = ["decal", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "aout", "septembre", "octobre", "novembre", "décembre"];
		
		foreach ($evals as $eval){
			$temp = $eval->updated_at;
			$eval->updated_at = $days[date("N", strtotime($temp))]." ";
			$eval->updated_at .= date("d", strtotime($temp))." ";
			$eval->updated_at .= $months[date("n", strtotime($temp))]." ";
			$eval->updated_at .= date("Y - H:i", strtotime($temp));
		}
		
		
		//on recupère les retards
		// -7 jours
		$lastWeek = date("Y-m-d", strtotime("-7 day"));
		$lastMonth = date("Y-m-d", strtotime("-30 day"));
		$retard = DB::table("retards")->where("id_etudiant", $id)->orderby("date", "ASC")->get();
		$retardsSem = DB::table("retards")->where([["id_etudiant", $id],["date",">=","$lastWeek"]])->orderby("date", "ASC")->get();
		$absence = DB::table("absences")->where("id_etudiant", $id)->orderby("date", "ASC")->get();
		$absencesSem = DB::table("absences")->where([["id_etudiant", $id],["date",">=","$lastMonth"]])->orderby("date", "ASC")->get();
		$temp=array();
		foreach($absence as $abs){
			$temp['id'] = $abs->id;
			$temp['date'] = ucfirst($days[date("N", strtotime($abs->date))]." ".date("d", strtotime($abs->date))." ".$months[date("n", strtotime($abs->date))]." ".date("Y", strtotime($abs->date)));
			$temp['motif'] = $abs->motif;
			$temp['justif'] = $abs->justif;
 			if($abs->date > $lastMonth)
				$temp['class'] = "text-warning";
			else 
				$temp['class'] = "text-info";
			$absences[]=$temp;
		}
		$temp=array();
		foreach($retard as $ret){
			$temp['id'] = $ret->id;
			$temp['date'] = ucfirst($days[date("N", strtotime($ret->date))]." ".date("d", strtotime($ret->date))." ".$months[date("n", strtotime($ret->date))]." ".date("Y", strtotime($ret->date)));
			$temp['motif'] = $ret->motif;
			if($ret->date > $lastWeek)
				$temp['class'] = "text-warning";
			else
				$temp['class'] = "text-info";
			$retards[]=$temp;
		}
		$calendrier["content"] = $this->calendarAbsRet($id);
		$calendrier["month"] = $months[date("n")];
		$calendrier["year"] = date("Y");
		$docAdminExt = $this->JustifAccepted;
		return view('candidat.show',  compact('candidat', 'extImg', 'reponsesSelection', 'evals', 'retards','retard','retardsSem', 'absences', 'absence', 'absencesSem', 'calendrier', 'docAdminExt', 'selection', 'selections', 'selection_promo'));
	}
	
	/**
	 * Import un fichier dans la bdd
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function import()
	{
		//
		return view('candidat.import');
	}
	
	private function formatDate($date, $sep = "/", $newsep = "-", $reverse = true){
		$temp = explode($sep, $date);
		if($reverse && sizeof($temp) == 3){
			$t = $temp[0];
			$temp[0] = $temp[2];
			$temp[2] = $t;
		}
		return implode($newsep, $temp);
	}
	
	/**
	 * Import un fichier dans la bdd
	 *
	 * @param  File  $csv
	 * @return \Illuminate\Http\Response
	 */
	public function insert(Request $request)
	{
		//
		
		if($request->hasFile("importFile"))
		{			
			$file = $request->importFile;
			//$file = Input::file("importFile");
			
			$error = "";
			if($file->getClientSize()>UploadedFile::getMaxFilesize()) {
				$error .= "Le fichier est trop volumineux.<br />";
			}
			if($file->getClientOriginalExtension() != "csv" && $file->getClientOriginalExtension() != "txt" && $file->getClientOriginalExtension() != "xls" && $file->getClientOriginalExtension() != "xlsx" && $file->getClientOriginalExtension() != "ods")
			{
				$error .= "Le fichier doit être de type : csv, txt, xls, xlsx, ou ods.<br />";
			}
			if($file->extension() !="txt"){
				$error .= "Le fichier n'est pas valide. <br />";
			}
			if(!$request->exists("promo_id") || empty($request->promo_id) || $request->promo_id==0)
			{
				$error.= "Merci de choisir une promo avant de valider.<br />";
			}
			
			if($error != "")
				return redirect('candidat/import')->with("error", $error);
			
			$file->store("csv");	
			$path = $file->storeAs("csv", "import.csv");
			
			// récupération de la première ligne
			$data = Excel::load(storage_path("app")."/".$path, function($reader) {	})->get();
			$champsCandidats = ['id', 'nom', 'prenom', 'sexe', 'date_de_naissance', 'nationalite', 'adresse', 'cp', 'ville', 'qpv', 'email', 'telephone', 'statut', 'num_pole_emploi', 'antenne_pole_emploi', 'num_secu', 'commentaires'];
			$colonneCsv = array();
			$boucle = true;
			if(!empty($data) && $data->count()){
				// on selectionne toutes les questions par leur noms de colonne
				$questions_exist = DB::table('questions')->get();
				foreach($data as $key => $value){
					// S'il s'agit de la première fois 
					if($boucle){
						// on recupère le nom de toutes les colonnes dans la variable $colonneCsv
						foreach($value as $col => $rep){
							if(!in_array($col, $champsCandidats))
								$colonneCsv[] = $col;
						}
						$newColonne = $colonneCsv;
						// après c'est plus la première fois donc on empeche l'action prochaine
						$boucle = false;
						
						// permet de récupérer le dernier id
						$max_id = 0;
						
						//on enleve les questions existentes
						foreach ($questions_exist as $quest)
						{
							if($max_id<$quest->id) $max_id = $quest->id;
							if(in_array($quest->colonne, $newColonne))
							{
								$keys = array_keys($newColonne, $quest->colonne);
								foreach($keys as $key){
									array_splice($newColonne, $key);
								}
							}
						}
						
						// on insert les nouvelles questions dans la table questions
						$insertQ = array();
						foreach($newColonne as $colonne)
						{
							$temp = array();
							$temp['code'] = "Q".++$max_id;
							$temp['colonne'] = $colonne;
							$temp['question'] = ucfirst(str_replace("_", " ", $colonne));
							
							$insertQ[] = $temp;
						}
						DB::table('questions')->insert($insertQ);
					}
					
					
					// on insert les candidats 
					$insertC = array();
					foreach($champsCandidats as $champ){
						$c = strtolower($champ);
						if($champ == "date_de_naissance")
							$insertC[$champ] = $this->formatDate($value->$c);
						else
							$insertC[$champ] = $value->$c;
					}
					$insertC['promo_id'] = $request->promo_id;
					$insertC['created_at'] = date("Y-m-d G:i:s");
					$insertC['updated_at'] = date("Y-m-d G:i:s");
					$id_candidat = DB::table('candidats')->insertGetId($insertC);
					
					//pour chaque question
					$insertR = array();
					$questions_exist = DB::table('questions')->get();
					foreach ($questions_exist as $quest)
					{
						//si la question est dans le csv 
						
						if(in_array($quest->colonne, $colonneCsv))
						{
							$temp = array();
							$temp['id_candidats'] = $id_candidat;
							$temp['id_question'] = $quest->id;
							$c = $quest->colonne;
							$temp['reponse'] = $value->$c;
							$insertR[] = $temp;
						}
					}
					DB::table('selectionCandidats')->insert($insertR);
				}
				
			}
			if(!empty($error)){
				return redirect('candidat/import')->with("error","Problème : ".$error."<br />".implode("<br />",$colonneCsv));
			} else {
				return redirect('candidat/import')->withOk("le fichier a bien été importés.");
			}
			
		}
		else
			return redirect('candidat/import')->with("error", "Un fichier est nécéssaire");
	}
	
	/**
	 * Import un fichier dans la bdd
	 *
	 * @param  File  $csv
	 * @return \Illuminate\Http\Response
	 */
	public function liste(Request $request)
	{
		//
		//session(['liste' => $request->principale]);
		if($request->exists("attente"))
			session(['liste' => "attente"]);
		elseif ($request->exists("negative"))
			session(['liste' => "negative"]);
		else
			session(['liste' => "principale"]);
		
		return redirect()->back()->with("information", "La liste " . session("liste"). " a été selectionnée");
		//return redirect('candidat/import')->withOk("la.");
	}
	
	/**
	 * upload l'image
	 *
	 * @param  File  $csv
	 * @return \Illuminate\Http\Response
	 */
	public function portrait(Request $request)
	{
		//
		//session(['liste' => $request->principale]);
		if($request->hasFile("portrait"))
		{
			$file = $request->portrait;
			//$file = Input::file("importFile");
			
			$error = "";
			if($file->getClientSize()>UploadedFile::getMaxFilesize()) {
				$error .= "Le fichier est trop volumineux.<br />";
			}
			if($file->getClientOriginalExtension() != "jpg" && $file->getClientOriginalExtension() != "gif" && $file->getClientOriginalExtension() != "png" && $file->getClientOriginalExtension() != "tiff")
			{
				$error .= "Le fichier doit être de type : jpg, png, gif, ou tiff.<br />";
			}
			if($error != "")
				return redirect(route('candidat.edit',$request->input("id")))->with("error", $error);
			
			$name = $request->input("id").".".$file->getClientOriginalExtension();
			$path = $file->storeAs("portrait", $name);
			return redirect(route('candidat.edit',$request->input("id")))->withOk("Le fichier a été uploadé avec succés");
		}
	}
	
	/**
	 * Update questions
	 *
	 * @param  File  $csv
	 * @return \Illuminate\Http\Response
	 */
	public function FormUpdateQuestion(Request $request){
		//
		$id_question = $request->id; 
		$question = DB::table('questions')->where('id', $id_question)->get();
		$question = $question->first();
		$candidat = $request->candidat;
		return view('candidat.updateQuestion', compact('question', 'candidat'));
	}
	
	
	/**
	 * Update questions
	 *
	 * @param  File  $csv
	 * @return \Illuminate\Http\Response
	 */
	public function updateQuestion(Request $request){
		//
		DB::table('questions')->where('id', $request->input('id'))->update(['question' => ucfirst($request->input('question'))]);
		return redirect(route('candidat.show', $request->input('candidat')))->withOk("Question modifiée");
	}

	public function docAdmin(Request $request){
		$errors = array();
		if($request->hasFile("cni") && !empty($request->cni)){
			$file = $request->cni;
			//$file = Input::file("importFile");
			
			$error = "";
			if($file->getClientSize()>UploadedFile::getMaxFilesize()) {
				$error .= "Le fichier est trop volumineux.<br />";
			}
			if(!in_array($file->getClientOriginalExtension(), $this->JustifAccepted))
			{
				$error .= "Le fichier doit être de type : ".implode(", ", $this->JustifAccepted).".<br />";
			}
			if($error == ""){
				$name = $request->id.".".$file->getClientOriginalExtension();
				$path = $file->storeAs("administratifs/cni", $name);	
			}
			else
			{
				$errors["cni"] = $error;
			}
		}
		if($request->hasFile("AssMaladie") && !empty($request->AssMaladie)){
			$file = $request->AssMaladie;
			//$file = Input::file("importFile");
			
			$error = "";
			if($file->getClientSize()>UploadedFile::getMaxFilesize()) {
				$error .= "Le fichier est trop volumineux.<br />";
			}
			if(!in_array($file->getClientOriginalExtension(), $this->JustifAccepted))
			{
				$error .= "Le fichier doit être de type : ".implode(", ", $this->JustifAccepted).".<br />";
			}
			if($error == ""){
				$name = $request->id.".".$file->getClientOriginalExtension();
				$path = $file->storeAs("administratifs/AssMaladie", $name);	
			}
			else
			{
				$errors["AssMaladie"] = $error;
			}
		}
		if($request->hasFile("AssuranceRespCivile") && !empty($request->AssuranceRespCivile)){
			$file = $request->AssuranceRespCivile;
			//$file = Input::file("importFile");
			
			$error = "";
			if($file->getClientSize()>UploadedFile::getMaxFilesize()) {
				$error .= "Le fichier est trop volumineux.<br />";
			}
			if(!in_array($file->getClientOriginalExtension(), $this->JustifAccepted))
			{
				$error .= "Le fichier doit être de type : ".implode(", ", $this->JustifAccepted).".<br />";
			}
			if($error == ""){
				$name = $request->id.".".$file->getClientOriginalExtension();
				$path = $file->storeAs("administratifs/AssuranceRespCivile", $name);	
			}
			else
			{
				$errors["AssuranceRespCivile"] = $error;
			}
		}
		if($request->hasFile("AttestaionSuiviDeFormation") && !empty($request->AttestaionSuiviDeFormation)){
			$file = $request->AttestaionSuiviDeFormation;
			//$file = Input::file("importFile");
			
			$error = "";
			if($file->getClientSize()>UploadedFile::getMaxFilesize()) {
				$error .= "Le fichier est trop volumineux.<br />";
			}
			if(!in_array($file->getClientOriginalExtension(), $this->JustifAccepted))
			{
				$error .= "Le fichier doit être de type : ".implode(", ", $this->JustifAccepted).".<br />";
			}
			if($error == ""){
				$name = $request->id.".".$file->getClientOriginalExtension();
				$path = $file->storeAs("administratifs/AttestaionSuiviDeFormation", $name);	
			}
			else
			{
				$errors["AssuranceRespCivile"] = $error;
			}
		}
		if($request->hasFile("JustifDomicile") && !empty($request->JustifDomicile)){
			$file = $request->JustifDomicile;
			//$file = Input::file("importFile");
			
			$error = "";
			if($file->getClientSize()>UploadedFile::getMaxFilesize()) {
				$error .= "Le fichier est trop volumineux.<br />";
			}

			if(!in_array($file->getClientOriginalExtension(), $this->JustifAccepted))
			{
				$error .= "Le fichier doit être de type : ".implode(", ", $this->JustifAccepted).".<br />";
			}
			if($error == ""){
				$name = $request->id.".".$file->getClientOriginalExtension();
				$path = $file->storeAs("administratifs/JustifDomicile", $name);	
			}
			else
			{
				$errors["JustifDomicile"] = $error;
			}
		}

		if(sizeof($errors) == 0){
			return redirect(route('candidat.show', $request->id))->withOk("Documents Uploadés avec succés");
		}
		else {
			$returnErrors = "";
			foreach($errors as $key => $value){
				$returnErrors .= "[".$key."] " .$value;
			}
			return redirect(route('candidat.show', $request->id))->with("error" , "Tous les documents n'ont pas été uploadé : ".$returnErrors);	
		}
	}



	public function clearPromo(Request $request, $id)
	{
		//
		DB::table('candidats')->where('promo_id', '=', $id)->delete();
		return redirect()->back()->with("information", "La Promo a été vidée");;
	}
}

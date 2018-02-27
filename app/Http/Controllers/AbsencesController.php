<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

use App\Repositories\AbsencesRepository;

use DB;
use App\Repositories\PromoRepository;
use App\Promo;

class AbsencesController extends Controller
{
	protected $absencesRepository;
	
	
	protected $nbrPerPage = 4;
	
	public function __construct(AbsencesRepository $absencesRepository)
	{
		$this->middleware('auth');
		$this->absencesRepository = $absencesRepository;

	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	private function prepareCalendar($date){
		$now = $date;
		$month = date("m", strtotime($now));
		$year = date("Y", strtotime($now));
		
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
			if($i<10){
				$arraytemp["link"] = route('absences.selectDate', $year."-".date("m",$prev_month)."-0".$i);
			} else {
				$arraytemp["link"] = route('absences.selectDate', $year."-".date("m",$prev_month)."-".$i);
			}
			
			$arraytemp["class"] = "otherMonth";
			$arraytemp["value"] = $i;
			$tablesCalendar[$ligne][] = $arraytemp;
			$row++;
		}
		for($i=1; $i<=date("t", $current_month); $i++)
		{
			if($row == 7){
				$row = 0;
				$ligne++;
				$arraytemp["link"] = "";
				$arraytemp["class"] = "";
				$arraytemp["value"] = date("W",strtotime($i."-".$month."-".$year));
				$tablesCalendar[$ligne][] = $arraytemp;
			}
			
			if($i<10){
				$arraytemp["link"] = route('absences.selectDate', $year."-".$month."-0".$i);
			} else {
				$arraytemp["link"] = route('absences.selectDate', $year."-".$month."-".$i);
			}
			
			$arraytemp["class"] = "selectDate";
            if(date("Y-m-d", strtotime($year."-".$month."-".$i)) == date("Y-m-d") || date("Y-m-d", strtotime($year."-".$month."-0".$i)) == date("Y-m-d")){
                $arraytemp["class"] .= " now";
            }
			$arraytemp["value"] = $i;
			$tablesCalendar[$ligne][] = $arraytemp;
			
			$row++;
		}
		for($i = 1; $i < 8-$row; $i++)
		{
			if($i<10){
				$arraytemp["link"] = route('absences.selectDate', $year."-".date("m",$next_month)."-0".$i);
			} else {
				$arraytemp["link"] = route('absences.selectDate', $year."-".date("m",$next_month)."-".$i);
			}
			$arraytemp["class"] = "otherMonth";
			$arraytemp["value"] = $i;
			$tablesCalendar[$ligne][] = $arraytemp;
		}
		return $tablesCalendar;
	}
	
	public function index()
    {
        //
    	$candidats = DB::table('candidats')->where([['candidats.promo_id', session("promo_id")],['candidats.liste', 'principale']] )->get();
    	$month = date("m");
    	$year = date("Y");
    	$now = date("Y-m-d");
    	$day = date("d");
    	$tablesCalendar = $this->prepareCalendar(date("Y-m-d"));
    	
        return view('absences.index', compact('now', 'candidats', 'month', 'year','day', 'tablesCalendar'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectDate($date)
    {
    	//
    	
    	$candidats = DB::table('candidats')->where([['candidats.promo_id', session("promo_id")],['candidats.liste', 'principale']] )->get();
    	$now = $date;
    	$month = date("m", strtotime($now));
    	$year = date("Y", strtotime($now));
    	$day = date("d", strtotime($now));
    	$tablesCalendar = $this->prepareCalendar($now);
    	return view('absences.index', compact('now', 'candidats', 'month', 'year','day','tablesCalendar'));
    }
    public function selectcal(Request $request)
    {
    	//
    	$candidats = DB::table('candidats')->where([['candidats.promo_id', session("promo_id")],['candidats.liste', 'principale']] )->get();
    	$now = $request->year."-".$request->month."-".$request->day;
    	$month = date("m", strtotime($now));
    	$year = date("Y", strtotime($now));
    	$day = date("d", strtotime($now));
    	$tablesCalendar = $this->prepareCalendar($now);
    	return view('absences.index', compact('now', 'candidats', 'month', 'year','day','tablesCalendar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    	
        $inputs=array();
        foreach($request->etudiants as $etudiants){
        	$temp = array();
        	$temp['id_etudiant'] = $etudiants;
        	$temp['date']=$request->date;
        	$motif = "motif_".$etudiants;
        	$justif = "justif_".$etudiants;
        	$temp['motif']=$request->$motif;
        	$candidats = DB::table("candidats")->where("id", $etudiants)->get();
        	$candidat = $candidats->first();
        	
        	
        	$error = "";
        	if($request->hasFile($justif)){
        		$file = $request->$justif;
	        	if(!in_array($file->getClientOriginalExtension(), $this->JustifAccepted))
	        	{
	        		$error .= "Le justificatif de ".$candidat->Prenom." ".$candidat->Nom." doit être de type : ".implode(", ", $fileAccepted).".<br />";
	        	}
	        	if($file->getClientSize()>UploadedFile::getMaxFilesize()) {
	        		
	        		$error .= "Le justificatif de ".$candidat->Prenom." ".$candidat->Nom." est trop volumineux.<br />";
	        	}
	        	
	        	if($error == ""){
	        		$nameFile = $etudiants."-".time().".".$file->getClientOriginalExtension();
	        		$file->storeAs("Justificatifs",  $nameFile);
	        		$temp["justif"] = $nameFile;
	        	}
        	}
        	
        	$inputs[] = $this->absencesRepository->store($temp);
        	
        	
        }
        if(!in_array(false, $inputs))
        {
        	if($error != "")
        		return redirect(route('absences.index'))->with('error', $error);
        	else 
        		return redirect(route('absences.index'))->withOk("Les absences sont enregistrées.");
        }
        else
        {
        	return redirect(route('absences.index'))->with('error', 'Les abscences n\'ont pas été enregistrées');
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
    	$absence = $this->absencesRepository->getById($id);
    	return view('absences.edit',  compact('absence'));
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
    	
    	$absence = $this->absencesRepository->getById($id);
    	$error = "";
    	$return = "";
    	$name = "";
    	if($request->hasFile('justif')){
    		$file = $request->justif;
    		if(!in_array($file->getClientOriginalExtension(), $this->JustifAccepted))
    		{
    			$error .= "Le justificatif doit être de type : ".implode(", ", $this->JustifAccepted).".<br />";
    		}
    		if($file->getClientSize()>UploadedFile::getMaxFilesize()) {
    			
    			$error .= "Le justificatif de est trop volumineux.<br />";
    		}
    		
    		if($error == ""){
    			if(!empty($absence->justif)){
    				$exp = explode(".", $absence->justif);
    				unset($exp[sizeof($exp)-1]);
    				if(!unlink(storage_path("app")."/Justificatifs/".$absence->justif)){
    					$error .= "Impossible d'écraser l'ancien fichier";
    				}
    				$name = implode(".", $exp).".".$file->getClientOriginalExtension();
    			} else {
    				$name = $id."-".time().".".$file->getClientOriginalExtension();
    			}
   
    			$return .= $request->justif."<br />";
    			
    			    				
    			$absence->justif = $name;
    			//$return .= $request->justif."<br />";
    			$file->storeAs("Justificatifs", $name);
    		}
    	}
    	
    	$update['id']=$id;
    	$update['date']=$request->date;
    	$update['motif']=$request->motif;
    	$update['justif']=$absence->justif;
    	
    	$this->absencesRepository->update($id, $update);
    	if($error == "")
    		return redirect(route('candidat.show', $request->id_etudiant))->withOk("L'absence a été mis à jour ");
    	else 
    		return redirect(route('candidat.show', $request->id_etudiant))->with("error", "Erreur : ".$error);
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
    	$absence = $this->absencesRepository->getById($id);
    	$this->absencesRepository->destroy($id);
    	return redirect(route('candidat.show', $absence->id_etudiant))->withOk("L'absence a été supprimée.");
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPiece($id)
    {
    	//
    	$absence = $this->absencesRepository->getById($id);
    	$error = "";
    	if(!unlink(storage_path("app")."/Justificatifs/".$absence->justif)){
    		$error .= "Impossible de supprimer le fichier";
    	}
    
    	
    	if($error == ""){
    		$this->absencesRepository->update($id, ["justif" => null]);
    		return redirect(route('absences.edit', $id))->withOk("La pièce a été supprimée.");
    	}
    	else
    		return redirect(route('absences.edit', $id))->with("error", $error);
    	
    }
    /**
     * Tries le tableau 
     * 
     * @param $array de type array(array("etudiant"=>"", "nbAbsences"=>""))
     * @return \Illuminate\Http\Response
     */
   
    private function sortArray($array){
   		$tabEnOrdre = false;
    	$taille = sizeof($array);
    	while(!$tabEnOrdre){
    		$tabEnOrdre = true;
    		
    		for($i=0; $i<$taille-1 ; $i++){
    			if($array[$i]["nbAbsences"] < $array[$i+1]["nbAbsences"]){
    				$temp = $array[$i];
    				$array[$i] = $array[$i+1];
    				$array[$i+1] = $temp;
    				$tabEnOrdre= false;
    			}
    		}
    	}
    	
    	return $array;
    }
    
    /**
     * Créé des stats sur les absences
     *
     * @return \Illuminate\Http\Response
     */
    
    public function stats(){
    	$promoRepo = new PromoRepository(new Promo());
    	$promo = $promoRepo->getById(session("promo_id"));
    	
    	//on recupère les étudiants 
    	
    	$etudiants = DB::table("candidats")->where([["promo_id", $promo->id], ["liste", "principale"]])->orderby("Nom", "DESC")->get();
    	
    	//stats absences mois par mois
    	$exploded = explode("-", $promo->dateDebutPromo);
    	$month_deb = $exploded[1];
    	$year_deb = $exploded[0];
    	
    	$exploded = explode("-", $promo->dateFinPromo);
    	$month_fin = $exploded[1]+1;
    	$year_fin = $exploded[0];
    	
    	if($month_fin == 13) {
    		$month_fin = 1;
    		$year_fin++;
    	}
    	
    	$orwhere = array();
    	$absencesByEtud = array();
    	foreach($etudiants as $etudiant){
    		$orwhere[] = $etudiant->id;
    		
    		$nbAbs = DB::table("absences")->where("id_etudiant", $etudiant->id)->count();
    		if($nbAbs > 0)
    			$absencesByEtud[] = ["etudiant" => $etudiant, "nbAbsences" => $nbAbs];
    	}
    	
    	$absencesByEtud = $this->sortArray($absencesByEtud);
    	
    	$boucle = true;
    	$absencesByMonth = array();
    	//$year_deb != $year_fin && $month_deb != $month_fin 
    	while($boucle){
    		$key = date("m-Y", strtotime($year_deb."-".$month_deb."-1"));
    		$absencesByMonth[$key] = DB::table("absences")->whereMonth('date', $month_deb)->whereYear('date', $year_deb)->whereIn("id_etudiant", $orwhere)->count();
    		if($month_deb == 12) { 
    			$month_deb = 1; 
    			$year_deb++;
    		}
    		else { 
    			$month_deb++; 
    		}
    		
    		if($month_fin == $month_deb && $year_fin == $year_deb){
    			$boucle = false;
    		}
    	}
    	
    	//stats le plus absents
    	
    	
    	return view('absences.stats',  compact('absencesByMonth', 'absencesByEtud'));
    }
}

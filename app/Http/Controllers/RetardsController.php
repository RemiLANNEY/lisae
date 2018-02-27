<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\RetardsRepository;
use DB;
use App\Repositories\PromoRepository;
use App\Promo;

class RetardsController extends Controller
{
	protected $retardsRepository;
	
	
	protected $nbrPerPage = 4;
	
	public function __construct(RetardsRepository $retardsRepository)
	{
		$this->middleware('auth');
		$this->retardsRepository = $retardsRepository;
		
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
				$arraytemp["link"] = route('retards.selectDate', $year."-".date("m",$prev_month)."-0".$i);
			} else {
				$arraytemp["link"] = route('retards.selectDate', $year."-".date("m",$prev_month)."-".$i);
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
				$arraytemp["link"] = route('retards.selectDate', $year."-".$month."-0".$i);
			} else {
				$arraytemp["link"] = route('retards.selectDate', $year."-".$month."-".$i);
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
				$arraytemp["link"] = route('retards.selectDate', $year."-".date("m",$next_month)."-0".$i);
			} else {
				$arraytemp["link"] = route('retards.selectDate', $year."-".date("m",$next_month)."-".$i);
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
    	
        return view('retards.index', compact('now', 'candidats', 'month', 'year','day', 'tablesCalendar'));
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
    	return view('retards.index', compact('now', 'candidats', 'month', 'year','day','tablesCalendar'));
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
    	return view('retards.index', compact('now', 'candidats', 'month', 'year','day','tablesCalendar'));
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
        	$temp['motif']=$request->$motif;
        	
        	$inputs[] = $this->retardsRepository->store($temp);
        }
        if(!in_array(false, $inputs))
        {
        	return redirect(route('retards.index'))->withOk("les retards sont enregistrées.");
        }
        else
        {
        	return redirect(route('retards.index'))->with('error', ['les retards n\'ont pas été enregistrées']);
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
    	$retard = $this->retardsRepository->getById($id);
    	return view('retards.edit',  compact('retard'));
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
    	$this->retardsRepository->update($id, $request->all());
    	return redirect(route('candidat.show', $request->id_etudiant))->withOk("Le retard a été mis à jour ");
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
    	$retard = $this->retardsRepository->getById($id);
    	$this->retardsRepository->destroy($id);
    	return redirect(route('candidat.show', $retard->id_etudiant))->withOk("Le retard a été supprimée.");
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
     * Créé des stats sur les retards
     *
     * @return \Illuminate\Http\Response
     */
    
    public function stats(){
    	$promoRepo = new PromoRepository(new Promo());
    	$promo = $promoRepo->getById(session("promo_id"));
    	
    	//on recupère les étudiants
    	
    	$etudiants = DB::table("candidats")->where([["promo_id", $promo->id], ["liste", "principale"]])->orderby("Nom", "DESC")->get();
    	
    	//stats retards mois par mois
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
    	$retardsByEtud = array();
    	foreach($etudiants as $etudiant){
    		$orwhere[] = $etudiant->id;
    		
    		$nbAbs = DB::table("retards")->where("id_etudiant", $etudiant->id)->count();
    		if($nbAbs > 0)
    			$retardsByEtud[] = ["etudiant" => $etudiant, "nbAbsences" => $nbAbs];
    	}
    	
    	$retardsByEtud = $this->sortArray($retardsByEtud);
    	
    	$boucle = true;
    	$retardsByMonth = array();
    	//$year_deb != $year_fin && $month_deb != $month_fin
    	while($boucle){
    		$key = date("m-Y", strtotime($year_deb."-".$month_deb."-1"));
    		$retardsByMonth[$key] = DB::table("retards")->whereMonth('date', $month_deb)->whereYear('date', $year_deb)->whereIn("id_etudiant", $orwhere)->count();
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
    	
    	
    	return view('retards.stats',  compact('retardsByMonth', 'retardsByEtud'));
    }
}

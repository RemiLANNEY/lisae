<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;
use DB;

class GeneralController extends Controller
{
    //
	public function index() {
		if(!session()->has('liste')) session(['liste' => "principale"]);
		if(!session()->has('promo_id')) session(['promo_id' => Auth::user()->promo_id]);
		$promo = DB::table("promos")->where("id", session('promo_id'))->first();
		return view("welcome", compact("promo"));
	}
	private function prepareAgenda($date){
		$agenda = array();
		
		$month = date("m", strtotime($date));
    	$year = date("Y", strtotime($date));
    	$now = date("Y-m-d", strtotime($date));
    	$day = date("d", strtotime($date));
    	$jour = date("N", strtotime($date));
    	$firstJourSemaine = $jour-1;
    	$lastJourSemaine = 8-$jour;
    	$minusHour = date("G", strtotime($date));
    	$minusMin = date("i", strtotime($date));
    	$plusHour = 24 - date("G", strtotime($date));
    	$plusMin = 60 - date("i", strtotime($date));

    	//$startDate = Carbon::create($year, $month, $day, 8)->subDays($firstJourSemaine);
    	//$endDate = Carbon::create($year, $month, $day, 21)->addDays($lastJourSemaine);
    	// $startDate = Carbon::createFromFormat('Y-m-d H', $year.'-'.$month.'-'.$day.' 8')->subDays($firstJourSemaine);
    	// $endDate = Carbon::createFromFormat('Y-m-d H', $year.'-'.$month.'-'.$day.' 21')->addDays($lastJourSemaine);

    	$startDate = Carbon::createFromDate($year, $month, $day)->subDays($firstJourSemaine);
    	//$startDate = $sd->subHours($minusHour)->subMinutes($minusMin);
    	$endDate = Carbon::createFromDate($year, $month, $day)->addDays($lastJourSemaine);
    	//$endDate = $ed->addHours($plusHour)->addMinutes($plusMin);

    	//$events = Event::get($startDate, $endDate);
		
		$semaineDays = array( "", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim");
		
		// $events = Event::get($startDate, $endDate);

		// $event = $events->first();
		
		//pour chaque jours de la semaine
		/*$event->startDateTime
		 *
		 *
		*/
		do{
			$agenda["&nbsp;"][] = date("d M Y" , strtotime($startDate));
			//$sd = $startDate;
			//$ed = $sd->addHours(12);
			//$events = Event::get($sd, $ed);
			//$event = $events->first();
			for($i=8; $i<=20; $i++){
				for($j=0; $j<60; $j+=30){
					//ici on rempli avec les events
					if($j==0){
						$agenda[$i."h0".$j][] = "";
					}
					else {
						$agenda[$i."h".$j][] = "";
					}
				}	
			}

			$startDate->addDays(1);
		} while($startDate != $endDate);

		

		return $agenda;
	}

	public function planning(){
		// get all future events on a calendar		

		$month = date("m");
    	$year = date("Y");
    	$now = date("Y-m-d");
    	$day = date("d");
    	$jour = date("N");
    	$firstJourSemaine = $jour;
    	$lastJourSemaine = 7-$jour;

    	$startDate = Carbon::createFromDate($year, $month, $day)->subDays($firstJourSemaine);
    	$endDate = Carbon::createFromDate($year, $month, $day)->addDays($lastJourSemaine);
		
		$agenda = $this->prepareAgenda($now);

		$numSemaine = date("W", strtotime($now));

		return view('planning.planning', compact("agenda", "numSemaine"));
	}

	public function selectcal(Request $request)
    {
    	//
    	$numSemaine = $request->numSemaine;
    	$firstLundi = explode("-", date("Y-m-d", strtotime("first monday ".($numSemaine-1)." week")));
    	$dimanche = explode("-", date("Y-m-d", strtotime( "first sunday ".$numSemaine." week")));

    	$startDate = Carbon::createFromDate($firstLundi[0], $firstLundi[1], $firstLundi[2]);
    	$endDate = Carbon::createFromDate($dimanche[0], $dimanche[1], $dimanche[2]);

    	$events = Event::get($startDate, $endDate);
		$agenda = $this->prepareAgenda(date("Y-m-d", strtotime("first monday ".($numSemaine-1)." week")));
		//echo date("Y-m-d", strtotime("first monday ".($numSemaine-1)." week"));
		return view('planning.planning',  compact('events', "agenda", "numSemaine"));
    }

    public function otherSemaine(Request $request){
    	$numSemaine = $request->numSemaine;
    	$firstLundi = explode("-", date("Y-m-d", strtotime("first monday ".($numSemaine-1)." week")));
    	$dimanche = explode("-", date("Y-m-d", strtotime( "first sunday ".$numSemaine." week")));

    	$startDate = Carbon::createFromDate($firstLundi[0], $firstLundi[1], $firstLundi[2]);
    	$endDate = Carbon::createFromDate($dimanche[0], $dimanche[1], $dimanche[2]);

    	$events = Event::get($startDate, $endDate);
		$agenda = $this->prepareAgenda(date("Y-m-d", strtotime("first monday ".($numSemaine-1)." week")));
		//echo date("Y-m-d", strtotime("first monday ".($numSemaine-1)." week"));
		return view('planning.planning',  compact('events', "agenda", "numSemaine"));
    }

    public function searchMotot(Request $request){
    	$search = $request->search;
    	$array_search = explode(" ", $search);
    	$extImg = ["jpg", "png", "gif", "tif", "jpeg", "bmp", "pct"];

    	$champ_search = ['Nom', 'Prenom', 'Date_de_naissance', 'Adresse', 'CP', 'Ville', 'Email', 'Telephone', 'Num_pole_emploi', 'Num_secu', 'Commentaires', "Sexe"];
    	$req = [];
    	foreach ($champ_search as $key => $value) {
    		# code...
    		foreach($array_search as $s){
    			$req[] = $value . " LIKE '%".$s."%'";	
    		}
    		
    	}

    	$research = DB::table("candidats")->where("promo_id", session("promo_id"))->whereRaw(implode(" OR ", $req));
    	$nb = $research->count();
    	$result = $research->get();

    	return view('search',  compact('search', "nb", 'result', 'extImg'));
    }
}

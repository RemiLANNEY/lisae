<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DB;


class StatsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
	 * Display a listing of the stats.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//

		$nbTotal = DB::table("candidats")->where([["liste", session("liste")],["promo_id", session("promo_id")]])->count();
		if(session("liste") == "attente"){
			$nbTotal += DB::table("candidats")->where([["liste", "candidat"],["promo_id", session("promo_id")]])->count();
		}
		$sexe["Homme"] = DB::table("candidats")->where([["liste", session("liste")],["promo_id", session("promo_id")], ["Sexe", "Homme"]])->count();
		if(session("liste") == "attente"){
			$sexe["Homme"] += DB::table("candidats")->where([["liste", "candidat"],["promo_id", session("promo_id")], ["Sexe", "Homme"]])->count();
		}
		$sexe["Femme"] = DB::table("candidats")->where([["liste", session("liste")],["promo_id", session("promo_id")], ["Sexe", "Femme"]])->count();
		if(session("liste") == "attente"){
			$sexe["Femme"] += DB::table("candidats")->where([["liste", "candidat"],["promo_id", session("promo_id")], ["Sexe", "Femme"]])->count();
		}
		$sexe["Autre"] = $nbTotal - $sexe["Homme"] - $sexe["Femme"];


		$qpv["Oui"] = DB::table("candidats")->where([["liste", session("liste")],["promo_id", session("promo_id")], ["QPV", "oui"]])->count();
		if(session("liste") == "attente"){
			$qpv["Oui"] += DB::table("candidats")->where([["liste", "candidat"],["promo_id", session("promo_id")], ["QPV", "oui"]])->count();
		}
		$qpv["Non"] = DB::table("candidats")->where([["liste", session("liste")],["promo_id", session("promo_id")], ["QPV", "non"]])->count();
		if(session("liste") == "attente"){
			$qpv["Non"] += DB::table("candidats")->where([["liste", "candidat"],["promo_id", session("promo_id")], ["QPV", "non"]])->count();
		}
		$qpv["Non renseigné"] = $nbTotal - $qpv["Oui"] - $qpv["Non"];
		
		//repartition par tranche d'âge
		/*
		 * 
		 * $sqlage25 = "SELECT COUNT(*) as tot_25 FROM `profil_etudiant` pe JOIN `selection_etudiant` se ON (pe.`id` = se.`id_profil_etudiant`) WHERE (Year(CURRENT_DATE) - Year(pe.`Date_de_naissance`) + (Format(pe.`Date_de_naissance`, \"mmdd\") > Format(CURRENT_DATE, \"mmdd\")) ) < 26 AND se.`Resultat` = ".$liste;
    	 * $sqlage35 = "SELECT COUNT(*) as tot_35 FROM `profil_etudiant` pe JOIN `selection_etudiant` se ON (pe.`id` = se.`id_profil_etudiant`) WHERE (Year(CURRENT_DATE) - Year(pe.`Date_de_naissance`) + (Format(pe.`Date_de_naissance`, \"mmdd\") > Format(CURRENT_DATE, \"mmdd\")) ) > 25 AND (Year(CURRENT_DATE) - Year(pe.`Date_de_naissance`) + (Format(pe.`Date_de_naissance`, \"mmdd\") > Format(CURRENT_DATE, \"mmdd\")) ) < 36 AND se.`Resultat` = ".$liste;
    	 * $sqlage45 = "SELECT COUNT(*) as tot_45 FROM `profil_etudiant` pe JOIN `selection_etudiant` se ON (pe.`id` = se.`id_profil_etudiant`) WHERE (Year(CURRENT_DATE) - Year(pe.`Date_de_naissance`) + (Format(pe.`Date_de_naissance`, \"mmdd\") > Format(CURRENT_DATE, \"mmdd\")) ) > 35 AND se.`Resultat` = ".$liste;
		 * 
		 */
		
		$m26ans = date("Y-m-d", strtotime("25 years ago"));
		$p35ans = date("Y-m-d", strtotime("35 years ago"));
		$age["-26 ans"] = DB::table("candidats")->where([["liste", session("liste")],["promo_id", session("promo_id")], ["date_de_naissance",">=", $m26ans]])->count();
		if(session("liste") == "attente"){
			$age["-26 ans"] += DB::table("candidats")->where([["liste", "candidat"],["promo_id", session("promo_id")], ["date_de_naissance",">=", $m26ans]])->count();
		}
		$age["26 ~ 35 ans"] = DB::table("candidats")->where([["liste", session("liste")],["promo_id", session("promo_id")], ["date_de_naissance","<", $m26ans], ["date_de_naissance",">=", $p35ans]])->count();
		if(session("liste") == "attente"){
			$age["26 ~ 35 ans"] += DB::table("candidats")->where([["liste", "candidat"],["promo_id", session("promo_id")], ["date_de_naissance","<", $m26ans], ["date_de_naissance",">=", $p35ans]])->count();
		}
		$age["+35 ans"] = DB::table("candidats")->where([["liste", session("liste")],["promo_id", session("promo_id")], ["date_de_naissance","<", $p35ans]])->count();
		if(session("liste") == "attente"){
			$age["+35 ans"] += DB::table("candidats")->where([["liste", "candidat"],["promo_id", session("promo_id")], ["date_de_naissance","<", $p35ans]])->count();
		}

		$dob = DB::table("candidats")->select("date_de_naissance")->where([["liste", session("liste")],["promo_id", session("promo_id")]])->get();
		$now = time();
		$ages = array();
		$moyenedage = 0;
		$nb = 0;
		foreach($dob as $value){
			$ageCandidat = new DateTime($value->date_de_naissance);
			$moyenedage += $ageCandidat->diff(new DateTime())->format('%Y');
			$nb++;
			if(array_key_exists($ageCandidat->diff(new DateTime())->format('%Y'), $ages)){
				$ages[$ageCandidat->diff(new DateTime())->format('%Y')] += 1; 
			} else {
				$ages[$ageCandidat->diff(new DateTime())->format('%Y')] = 1; 
			}
		}
		$moyenedage = round($moyenedage / $nb);
		ksort($ages);

		$candidats = DB::table("candidats")->where([["liste", session("liste")],["promo_id", session("promo_id")]])->get();
		$geo = ["CACPL" => 0, "Autres" => 0];
        $villesAgglo = array("06250", "06400", "06150", "06110", "06210", "06590");
		foreach($candidats as $candidat){
			if(in_array($candidat->CP, $villesAgglo)){
              $geo["CACPL"] += 1;
            } else {
              $geo["Autres"] += 1;
            }
		}

		//gestion des dîplomes
		$diplomes = ["sans diplôme" => 0, "brevet des collèges" => 0, "bac (dont équivalence bac)" => 0, "bac+2" => 0, "licence" => 0, "master" => 0];
		foreach($candidats as $candidat){
			$diplomesCand = DB::table("selectionCandidats")->where([['id_candidats', $candidat->id],['id_question', 9]])->first();
			$diplome = null;
			
			if(is_int(strpos($diplomesCand->reponse, ",")))
			{
				$diplome = explode(",", $diplomesCand->reponse);
			}
			elseif(is_int(strpos($diplomesCand->reponse, ";"))){
				$diplome = explode(";", $diplomesCand->reponse);
			}
			else {
				$diplome = explode("||||||", $diplomesCand->reponse);
			}

			foreach($diplome as $d){
				if(substr($d, 0, 1) == " ")
				{
					$key = substr($d, 1);
				}
				else 
				{
					$key = $d;
				}
				if(array_key_exists($key, $diplomes)){
					$diplomes[$key] += 1;
				} else {
					$diplomes[$key] = 1;
				}
			}
			
		}

		return view('stats.index', compact("sexe", "qpv", "age", "ages", "geo", "diplomes", "moyenedage"));
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
	 * Display a listing of the stats.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function docAdmin()
	{
		//
		$etatsDocAdmin = array();
		foreach (DB::table('candidats')->where([['liste', session('liste')], ['promo_id', session('promo_id')]] )->orderby('Nom', 'asc')->get() as $candidat ){
			$etatAssMaladie = "";
			$etatAssuranceRespCivile = "";
			$etatAttestationSuiviDeFormation = "";
			$etatJustifDomicile = "";
			$etatCNI = "";
			foreach($this->JustifAccepted as $ext){
				if(file_exists(storage_path("app")."/administratifs/AssMaladie/".$candidat->id.".".$ext)){
					$etatAssMaladie = "X";
				}
				if(file_exists(storage_path("app")."/administratifs/AssuranceRespCivile/".$candidat->id.".".$ext)){
					$etatAssuranceRespCivile = "X";
				}
				if(file_exists(storage_path("app")."/administratifs/AttestaionSuiviDeFormation/".$candidat->id.".".$ext)){
					$etatAttestationSuiviDeFormation = "X";
				}
				if(file_exists(storage_path("app")."/administratifs/JustifDomicile/".$candidat->id.".".$ext)){
					$etatJustifDomicile = "X";
				}
				if(file_exists(storage_path("app")."/administratifs/cni/".$candidat->id.".".$ext)){
					$etatCNI = "X";
				}
				$etatsDocAdmin[$candidat->id] = array("Nom" => $candidat->Nom, "Prenom" => $candidat->Prenom, "date_de_naissance" => $this->formatDate($candidat->Date_de_naissance, "-", "/"), "AssMaladie" => $etatAssMaladie, "AssuranceRespCivile" => $etatAssuranceRespCivile, "AttestaionSuiviDeFormation" => $etatAttestationSuiviDeFormation, "JustifDomicile" => $etatJustifDomicile, "cni" => $etatCNI);	
			}			
		}
		return view('stats.docAdmin', compact("etatsDocAdmin"));

	}
	
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Repositories\StructureRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use DB;

class StructureController extends Controller
{
    protected $structureRepository;

    protected $nbrPerPage = 4;

    public function __construct(StructureRepository $structureRepository)
    {
        $this->middleware('auth');
        //$this->middleware('admin', ['only' => 'destroy']);

        $this->structureRepository = $structureRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $structures = DB::table("structure")->where("users_id", Auth::user()->id)->orWhere("users_id", null)->orderby("nom", "ASC")->get();
        return view('structure.index', compact('structures'));
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
        $inputs = array_merge($request->all());

        if($request->visibilite == 0)
            $inputs['users_id'] = null;
        else
            $inputs['users_id'] = $request->visibilite;


        $error = "";
        if($request->hasFile('logo')){
            $file = $request->logo;
            if(!in_array($file->getClientOriginalExtension(), $this->LogoAccepted))
            {
                $error .= "Le logo de ".$request->nom."  doit être de type : ".implode(", ", $this->LogoAccepted).".<br />";
            }
            if($file->getClientSize()>UploadedFile::getMaxFilesize()) {
                
                $error .= "Le logo de ".$request->nom." est trop volumineux.<br />";
            }
            
            if($error == ""){
                $nameFile = $inputs['nom']."-".time().".".$file->getClientOriginalExtension();
                $file->storeAs("Logo",  $nameFile);
                $inputs["logo"] = $nameFile;
            }

        }

        if($this->structureRepository->store($inputs))
        {
            return redirect(route('structure.index'))->withOk("La structure a bien été créée.");
        }
        else 
        {
            return redirect(route('structure.index'))->with('error', 'La structure n\a pas été créée');
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
        $structures = DB::table("structure")->where("users_id", Auth::user()->id)->orWhere("users_id", null)->orderby("nom", "ASC")->get();
        $structure = DB::table("structure")->where('id', $id)->first();

        $contacts = DB::table("contacts")->join("structureContacts", "contacts.id", "=", "structureContacts.contacts_id")->where("structureContacts.structure_id", $id)->orderBy("contacts.nom", "ASC")->get();
        $compteur = 0;
        $histo = DB::table("histoContacts")->join("participantsStructure", "histoContacts.id", "=", "participantsStructure.contacts_id")->where("participantsStructure.structure_id", $id)->get();
        return view('structure.show', compact('structures', 'structure', 'contacts', 'compteur', 'histo'));
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
        $structures = DB::table("structure")->where("users_id", Auth::user()->id)->orWhere("users_id", null)->orderby("nom", "ASC")->get();
        $structure = DB::table("structure")->where('id', $id)->first();
        return view('structure.edit', compact('structures', 'structure'));
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
        $structure = $this->structureRepository->getById($id);
        //$inputs = array_merge($request->all());

        $error = "";
        $name = $structure->logo;
        if($request->hasFile('logo')){
            $file = $request->logo;
            if(!in_array($file->getClientOriginalExtension(), $this->LogoAccepted))
            {
                $error .= "Le logo de ".$request->nom."  doit être de type : ".implode(", ", $this->LogoAccepted).".<br />";
            }
            if($file->getClientSize()>UploadedFile::getMaxFilesize()) {
                
                $error .= "Le logo de ".$request->nom." est trop volumineux.<br />";
            }


            if($error == ""){
                if(!empty($structure->logo)){
                    $exp = explode(".", $structure->logo);
                    unset($exp[sizeof($exp)-1]);
                    if(!unlink(storage_path("app")."/Logo/".$structure->logo)){
                        $error .= "Impossible d'écraser l'ancien fichier";
                    }
                    $name = implode(".", $exp).".".$file->getClientOriginalExtension();
                } else {
                    $name = $request->nom."-".time().".".$file->getClientOriginalExtension();
                }
   
                //$return .= $request->justif."<br />";
                
                                    
                $structure->logo = $name;
                //$return .= $request->justif."<br />";
                $file->storeAs("Logo", $name);
            }
        }

        $inputs['nom'] = $request->nom;
        $inputs['adresse1'] = $request->adresse1;
        $inputs['adresse2'] = $request->adresse2;
        $inputs['cp'] = $request->cp;
        $inputs['ville'] = $request->ville;
        $inputs['tel'] = $request->tel;
        $inputs['email'] = $request->email;
        if($request->visibilite == 0)
            $inputs['users_id'] = null;
        else
            $inputs['users_id'] = $request->visibilite;
        if(strpos($request->site, "http://") === false && strpos($request->site, "https://") === false)
            $inputs['site'] = "http://".$request->site;
        else
            $inputs['site'] = $request->site;
        $inputs['typeStructure'] = $request->typeStructure;
        $inputs['notes'] = $request->notes;
        $inputs['logo'] = $name;

        if($this->structureRepository->update($id, $inputs))
        {
            return redirect(route('structure.show', $id))->withOk("La structure a bien été modifiée.");
        }
        else 
        {
            return redirect(route('structure.show', $id))->with('error', $error);
        } 
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
}

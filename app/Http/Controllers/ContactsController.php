<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Repositories\ContactsRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use DB;

class ContactsController extends Controller
{
    protected $contactsRepository;

    protected $nbrPerPage = 4;

    public function __construct(ContactsRepository $contactsRepository)
    {
        $this->middleware('auth');
        //$this->middleware('admin', ['only' => 'destroy']);

        $this->contactsRepository = $contactsRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $contactsData = DB::table("contacts")->where("contacts.users_id", Auth::user()->id)->orWhere("contacts.users_id", null)->orderby("contacts.nom", "ASC")->get();
        //->join("structureContacts", "contacts.id", "=", "structureContacts.contacts_id")->join("structure", "structure.id", "=", "structureContacts.structure_id")
        $contacts = [];
        foreach($contactsData as $contact){
            $temp = [];
            $temp["donnee"] = $contact;
            $entreprises = DB::table("structure")->join("structureContacts", "structure.id", "=", "structureContacts.structure_id")->where('structureContacts.contacts_id', $contact->id)->orderBy("structure.id", "ASC")->get();
            if(sizeof($entreprises)==0)
                $temp['entreprise'] = null;
            else {
                foreach($entreprises as $ent){
                    $temp['entreprise'][] = $ent->nom;
                }
            }
            $contacts[] = $temp;
        }

        $structures = DB::table("structure")->where("users_id", Auth::user()->id)->orWhere("users_id", null)->orderby("nom", "ASC")->get();
        return view("contacts.index", compact('contacts', 'structures'));
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



        if($this->contactsRepository->store($inputs))
        {
            $structures = DB::table("structure")->where("users_id", Auth::user()->id)->orWhere("users_id", null)->orderby("nom", "ASC")->get();
            $arrayStructure = array();
            $lastId = DB::table("contacts")->max('id');
            foreach($structures as $structure){
                if(isset($inputs['structure'.$structure->id]) && isset($inputs['Fonctionstructure'.$structure->id]))
                {
                    if(empty($inputs['Fonctionstructure'.$structure->id]))
                        $Fonctionstructure = null;
                    else 
                        $Fonctionstructure = $inputs['Fonctionstructure'.$structure->id];
                    $arrayStructure[] = ["structure_id" => $structure->id , "contacts_id" => $lastId, "fonction" => $Fonctionstructure];
                }    
            }
            if(DB::table('structureContacts')->insert($arrayStructure))
                return redirect(route('contacts.index'))->withOk("Le contact a bien été créée.");
            else
                return redirect(route('contacts.index'))->with('error', 'les fonctions n\'ont pas été ajoutée');
        }
        else 
        {
            return redirect(route('contacts.index'))->with('error', 'Le contact n\'a pas été créé');
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
        $contactsData = DB::table("contacts")->where("contacts.users_id", Auth::user()->id)->orWhere("contacts.users_id", null)->orderby("contacts.nom", "ASC")->get();
        //->join("structureContacts", "contacts.id", "=", "structureContacts.contacts_id")->join("structure", "structure.id", "=", "structureContacts.structure_id")
        $contacts = [];
        $contact["donnee"] = DB::table("contacts")->where("contacts.id", $id)->first();
        foreach($contactsData as $cont){
            $temp = [];
            $temp["donnee"] = $cont;
            $entreprises = DB::table("structure")->join("structureContacts", "structure.id", "=", "structureContacts.structure_id")->where('structureContacts.contacts_id', $cont->id)->orderBy("structure.id", "ASC")->get();



            if(sizeof($entreprises)==0)
                $temp['entreprise'] = null;
            else {
                foreach($entreprises as $ent){
                    $temp['entreprise'][] = $ent->nom;
                    if($cont->id == $contact["donnee"]->id)
                        $contact["entreprise"][] = $ent;
                }
            }

            $contacts[] = $temp;
        }

        $structures = DB::table("structure")->where("users_id", Auth::user()->id)->orWhere("users_id", null)->orderby("nom", "ASC")->get();

        return view("contacts.show", compact('contacts', 'structures', 'contact'));
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
        $contactsData = DB::table("contacts")->where("contacts.users_id", Auth::user()->id)->orWhere("contacts.users_id", null)->orderby("contacts.nom", "ASC")->get();
        //->join("structureContacts", "contacts.id", "=", "structureContacts.contacts_id")->join("structure", "structure.id", "=", "structureContacts.structure_id")
        $contacts = [];
        $contact["donnee"] = DB::table("contacts")->where("contacts.id", $id)->first();
        foreach($contactsData as $cont){
            $temp = [];
            $temp["donnee"] = $cont;
            $entreprises = DB::table("structure")->join("structureContacts", "structure.id", "=", "structureContacts.structure_id")->where('structureContacts.contacts_id', $cont->id)->orderBy("structure.id", "ASC")->get();



            if(sizeof($entreprises)==0)
                $temp['entreprise'] = null;
            else {
                foreach($entreprises as $ent){
                    $temp['entreprise'][] = $ent->nom;
                    if($cont->id == $contact["donnee"]->id)
                        $contact["entreprise"][$ent->id] = $ent;
                }
            }

            $contacts[] = $temp;
        }

        $structures = DB::table("structure")->where("users_id", Auth::user()->id)->orWhere("users_id", null)->orderby("nom", "ASC")->get();

        return view("contacts.edit", compact('contacts', 'structures', 'contact'));
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

        $inputs = array_merge($request->all());

        if($request->visibilite == 0)
            $inputs['users_id'] = null;
        else
            $inputs['users_id'] = $request->visibilite;



        if(!$this->contactsRepository->update($id, $inputs))
        {
            $structures = DB::table("structure")->where("users_id", $id)->orWhere("users_id", null)->orderby("nom", "ASC")->get();
            $arrayStructure = array();
            foreach($structures as $structure){
                if(isset($inputs['structure'.$structure->id]) && isset($inputs['Fonctionstructure'.$structure->id]))
                {
                    if(empty($inputs['Fonctionstructure'.$structure->id]))
                        $Fonctionstructure = null;
                    else 
                        $Fonctionstructure = $inputs['Fonctionstructure'.$structure->id];
                    $arrayStructure[] = ["structure_id" => $structure->id , "contacts_id" => $id, "fonction" => $Fonctionstructure];
                }    
            }

            $delete = DB::table('structureContacts')->where('contacts_id', $id)->delete();


            if(DB::table('structureContacts')->insert($arrayStructure))
                return redirect(route('contacts.show', $id))->withOk("Le contact a bien été modifié.");
            else
                return redirect(route('contacts.index'))->with('error', 'les fonctions n\'ont pas été ajoutée');
        }
        else 
        {
            return redirect(route('contacts.show', $id))->with('error', 'Le contact n\'a pas été modifié');
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
        $this->contactsRepository->destroy($id);
        DB::table('structureContacts')->where('contacts_id', $id)->delete();

        return redirect(route('contacts.index'))->withOk('Le contact a été supprimé');
    }
}

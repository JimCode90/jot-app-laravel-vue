<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Resources\Contact as ContactResource;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return ContactResource::collection(request()->user()->contacts);
    }

    public function store()
    {
        Contact::create($this->validateData());
    }

    public function show(Contact $contact)
    {
        if (request()->user()->isNot($contact->user)){
            return response([], 404);
        }
        return $contact;
    }

    public function update(Contact $contact)
    {

        $contact->update($this->validateData());
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
    }

    private function validateData(){
        return request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'birthday' => 'required',
            'company' => 'required',
        ]);

    }
}

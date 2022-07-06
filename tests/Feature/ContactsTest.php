<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactsTest extends TestCase
{
    use RefreshDatabase;


    protected $user;

    /** @test */
    public function se_puede_agregar_un_contacto()
    {

        $this->withoutExceptionHandling();

        $this->post('/api/contacts', $this->data());

        $contact = Contact::first();

        //$this->assertCount(1, $contact);
        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('05/14/1990', $contact->birthday);
        $this->assertEquals('ABC String', $contact->company);

    }

    /** @test */
    public function los_campos_son_obligatorios()
    {
        collect(['name', 'email', 'birthday', 'company'])
            ->each(function ($flied){
                $response = $this->post('/api/contacts',
                    array_merge($this->data(), [$flied => '']));

                $response->assertSessionHasErrors($flied);
                $this->assertCount(0, Contact::all());
            });
    }


    private function data()
    {
        return [
            'name' => 'Test Name',
            'email' => 'test@email.com',
            'birthday' => '05/14/1990',
            'company' => 'ABC String',
        ];
    }
}

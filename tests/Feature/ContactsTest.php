<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactsTest extends TestCase
{
    use RefreshDatabase;


//    protected $user;
    /** @test */
    public function un_usuario_no_autenticado_debe_ser_redirigido_para_iniciar_sesion()
    {
        $response = $this->post('/api/contacts', $this->data());
        $response->assertRedirect('/login');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function un_usuario_autenticado_puede_agregar_un_contacto()
    {

        $user = User::factory()->create();
        //$this->withoutExceptionHandling();

        $this->post('/api/contacts', $this->data(),[
           'api_token' =>  $user->api_token
        ]);

        $contact = Contact::first();

        //$this->assertCount(1, $contact);
        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('05/14/1990', $contact->birthday->format('m/d/Y'));
        $this->assertEquals('ABC String', $contact->company);

    }

    /** @test */
    public function los_campos_son_obligatorios()
    {
        collect(['name', 'email', 'birthday', 'company'])
            ->each(function ($flied) {
                $response = $this->post('/api/contacts',
                    array_merge($this->data(), [$flied => '']));

                $response->assertSessionHasErrors($flied);
                $this->assertCount(0, Contact::all());
            });
    }

    /** @test */
    public function el_email_debe_ser_un_email_valido()
    {
        $response = $this->post('/api/contacts',
            array_merge($this->data(), ['email' => 'NOT AN EMAIL']));

        $response->assertSessionHasErrors('email');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function birthdays_se_almacenan_correctamente()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/api/contacts',
            array_merge($this->data()));

        $this->assertCount(1, Contact::all());
        $this->assertInstanceOf(Carbon::class, Contact::first()->birthday);
        $this->assertEquals('05-14-1990', Contact::first()->birthday->format('m-d-Y'));
    }

    /** @test */
    public function se_puede_recuperar_un_contacto()
    {
        $contact = Contact::factory()->create();
        $response = $this->get('/api/contacts/' . $contact->id);
        $response->assertJson([
            'name' => true,
            'email' => true,
            'birthday' => true,
            'company' => true
        ]);

    }

    /** @test */
    public function un_contacto_puede_ser_actualizado()
    {
        $this->withoutExceptionHandling();
        $contact = Contact::factory()->create();
        $response = $this->patch('/api/contacts/' . $contact->id, $this->data());

        $contact = $contact->fresh();

        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('05/14/1990', $contact->birthday->format('m/d/Y'));
        $this->assertEquals('ABC String', $contact->company);
    }

    /** @test */
    public function un_contacto_puede_ser_eliminado()
    {
        $contact = Contact::factory()->create();
        $response = $this->delete('/api/contacts/' . $contact->id);
        $this->assertCount(0, Contact::all());
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

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Transfer;
use App\Mail\TransferReceived;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransfersTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Storage::fake();
    }

    protected function validParams($overrides = [])
    {
        return array_merge([
            'from_email' => 'john@example.com',
            'to_email' => 'susan@example.com',
            'title' => 'Vacation photos',
            'message' => 'Here I send you the photos',
            'file' => UploadedFile::fake()->image('prety-photo.jpg'),
        ], $overrides);
    }

    /** @test */
    public function a_guest_can_create_transfer()
    {
        Storage::fake();
        $this->assertEquals(0, Transfer::count());
        $uploadedFile = UploadedFile::fake()->image('prety-photo.jpg');

        $response = $this->post('/transfers', [
            'from_email' => 'john@example.com',
            'to_email' => 'susan@example.com',
            'title' => 'Vacation photos',
            'message' => 'Here I send you the photos',
            'file' => $uploadedFile,
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/');
        $transfer = Transfer::first();
        $this->assertEquals('john@example.com', $transfer->from_email);
        $this->assertEquals('susan@example.com', $transfer->to_email);
        $this->assertEquals('Vacation photos', $transfer->title);
        $this->assertEquals('Here I send you the photos', $transfer->message);
        $this->assertEquals('transfers/prety-photo.jpg', $transfer->file);
        Storage::assertExists('transfers/prety-photo.jpg');
    }

    /** @test */
    public function an_email_is_sent_to_recipient()
    {
        Storage::fake();
        Mail::fake();
        $this->assertEquals(0, Transfer::count());
        $uploadedFile = UploadedFile::fake()->image('prety-photo.jpg');

        $response = $this->post('/transfers', $this->validParams());

        $response->assertStatus(302)
            ->assertRedirect('/');
        $transfer = Transfer::first();
        Mail::assertSent(TransferReceived::class);
        Mail::assertSent(function (TransferReceived $mail) use ($transfer) {
            return $mail->transfer->id == $transfer->id;
        });
    }

    /** @test */
    public function from_email_is_required()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'from_email' => null,
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasErrors('from_email');
        $this->assertEquals(0, Transfer::count());
    }

    /** @test */
    public function from_email_should_be_an_email()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'from_email' => 'invalid-email-format',
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasErrors('from_email');
        $this->assertEquals(0, Transfer::count());
    }

    /** @test */
    public function to_email_is_required()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'to_email' => null,
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasErrors('to_email');
        $this->assertEquals(0, Transfer::count());
    }

    /** @test */
    public function to_email_should_be_an_email()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'to_email' => 'invalid-email-format',
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasErrors('to_email');
        $this->assertEquals(0, Transfer::count());
    }

    /** @test */
    public function title_is_required()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'title' => null,
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasErrors('title');
        $this->assertEquals(0, Transfer::count());
    }

    /** @test */
    public function title_should_has_at_least_3_characters()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'title' => 'ab',
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasErrors('title');
        $this->assertEquals(0, Transfer::count());
    }

    /** @test */
    public function message_is_optional()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'message' => null,
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasNoErrors();
        $this->assertEquals(1, Transfer::count());
    }

    /** @test */
    public function message_should_has_at_least_5_characters()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'message' => 'abcd',
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasErrors('message');
        $this->assertEquals(0, Transfer::count());
    }

    /** @test */
    public function file_is_required()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'file' => null,
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasErrors('file');
        $this->assertEquals(0, Transfer::count());
    }

    /** @test */
    public function file_should_be_a_file()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'file' => 'asdsadkaj',
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasErrors('file');
        $this->assertEquals(0, Transfer::count());
    }

    /** @test */
    public function file_should_be_max_2gb()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'file' => UploadedFile::fake()->create('photos.zip', 2097153),
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasErrors('file');
        $this->assertEquals(0, Transfer::count());
    }
}

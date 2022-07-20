<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class AuthorManagementTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function an_author_can_be_created() {
        $this->post('/authors', [
            'name' => 'Ariel',
            'dob' => '1983-10-23',
        ]);
        $authors = Author::all();
        $this->assertCount(1, $authors);

        $this->assertInstanceOf(Carbon::class, $authors->first()->dob);

        $this->assertEquals('1983-10-23', $authors->first()->dob->format('Y-m-d'));
    }

}

<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BookManagementTest extends TestCase {

//    use RefreshDatabase;
    use DatabaseMigrations;

    /** @test */
    public function a_book_can_be_added_to_the_library() {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', $this->data());

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_title_is_required() {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Ariel',
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_author_is_required() {
        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');
    }

    /** @test */
    public function a_book_can_be_updated() {
        $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author_id' => 'New Author',
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertSame(2, Book::first()->author_id);

        $response->assertRedirect($book->fresh()->path());
    }

    /** @test */
    public function a_book_can_be_deleted() {
        $this->post('/books', $this->data());

        $book = Book::first();

        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }

    /** @test */
    public function a_new_author_is_automaticaly_added() {
        $this->post('/books', [
            'title' => 'Cool Book Title',
            'author_id' => 'Ariel',
        ]);

        $book = Book::first();
        $author = Author::first();
        
        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }

    public function data(): array {
        return [
            'title' => 'Cool Book Title',
            'author_id' => 'Ariel',
        ];
    }
}

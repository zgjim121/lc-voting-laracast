<?php

namespace Tests\Feature;


use App\Livewire\CreateIdea;
use App\Models\Category;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateIdeaTest extends TestCase
{

    use RefreshDatabase;

    #[test] public function createIdeaFormDoesNotShowWhenLoggedOut()
    {
        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee('Please Login to create an idea');
        $response->assertDontSee('Let us know what you would like and we\'ll take a look over!');

    }

    #[test] public function createIdeaFormDoesShowWhenLoggedIn()
    {
        $response = $this->actingAs(User::factory()->create())->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertDontSee('Please Login to create an idea');
        $response->assertSee('Let us know what you would like and we\'ll take a look over!', false);

    }

    #[test] public function mainPageContainsCreateIdeaLivewireComponent()
    {
        $response = $this->actingAs(User::factory()->create())
            ->get(route('idea.index'))
            ->assertSeeLivewire('create-idea');
    }

    #[test] public function createIdeaFormValidationWorks()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateIdea::class)
            ->set('title', '')
            ->set('category', '')
            ->set('description', '')
            ->call('createIdea')
            ->assertHasErrors(['title', 'category', 'description'])
            ->assertSee('The title field is required.');
    }

    #[test] public function creatingAnIdeaWorksCorrectly()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        Livewire::actingAs($user)
            ->test(CreateIdea::class)
            ->set('title', 'My first Idea')
            ->set('category', $categoryOne->id)
            ->set('description', 'this is my first Idea')
            ->call('createIdea')
            ->assertRedirect('/');

        $response = $this->actingAs($user)->get(route('idea.index'));
        $response->assertSuccessful();
        $response->assertSee('My first Idea');

        $this->assertDatabaseHas('ideas', [
            'title' => 'My first Idea',
        ]);
    }

    #[test] public function creatingTwoIdeasWithSameTitleStillWorksButHasDifferentSlugs()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        Livewire::actingAs($user)
            ->test(CreateIdea::class)
            ->set('title', 'My first Idea')
            ->set('category', $categoryOne->id)
            ->set('description', 'this is my first Idea')
            ->call('createIdea')
            ->assertRedirect('/');


        $this->assertDatabaseHas('ideas', [
            'title' => 'My first Idea',
            'slug' => 'my-first-idea',
        ]);

        Livewire::actingAs($user)
            ->test(CreateIdea::class)
            ->set('title', 'My first Idea')
            ->set('category', $categoryOne->id)
            ->set('description', 'this is my first Idea')
            ->call('createIdea')
            ->assertRedirect('/');


        $this->assertDatabaseHas('ideas', [
            'title' => 'My first Idea',
            'slug' => 'my-first-idea-2',
        ]);
    }
}

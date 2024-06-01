<?php

namespace Tests\Feature;

use App\Models\Idea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;

    #[Test] public function listOfIdeasShowsOnMainPage()
    {
        $ideaOne = Idea::factory()->create([
            'title' => 'My First Idea',
            'description' => 'Description of my first Idea'
        ]);

        $ideaTwo = Idea::factory()->create([
            'title' => 'My Second Idea',
            'description' => 'Description of my second Idea'
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee($ideaOne->title);
        $response->assertSee($ideaOne->description);

        $response->assertSee($ideaTwo->title);
        $response->assertSee($ideaTwo->description);
    }

    #[Test] public function singleIdeaShowsCorrectlyOnTheShowPage()
    {
        $idea = Idea::factory()->create([
            'title' => 'My First Idea',
            'description' => 'Description of my first Idea'
        ]);


        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();

        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
    }

    #[test] public function ideasPaginationWorks()
    {
        Idea::factory(Idea::PAGINATION_COUNT + 1)->create();

        $ideaOne = Idea::find(1);
        $ideaOne->title = 'My First Idea';
        $ideaOne->save();

        $ideaEleven = Idea::find(11);
        $ideaEleven->title = 'My Eleventh Idea';
        $ideaEleven->save();

        $response = $this->get('/');
        $response->assertSee($ideaOne->title);
        $response->assertDontSee($ideaEleven->title);

        $response = $this->get('/?page=2');
        $response->assertSee($ideaEleven->title);
        $response->assertDontSee($ideaOne->title);
    }

    #[test] public function sameIdeaTitleDifferentSlugs()
    {
        $ideaOne = Idea::factory()->create([
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $ideaTwo = Idea::factory()->create([
            'title' => 'My First Idea',
            'description' => 'Another Description for my first idea',
        ]);

        $response = $this->get(route('idea.show', $ideaOne));

        $response->assertSuccessful();
        $this->assertTrue(request()->path() === 'ideas/my-first-idea');

        $response = $this->get(route('idea.show', $ideaTwo));

        $response->assertSuccessful();
        $this->assertNotTrue(request()->path() === 'ideas/my-first-idea-1');
    }
}

<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Idea;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;

class CreateIdea extends Component
{
    public $title;
    public $category;
    public $description;

    protected $rules = [
        'title' => 'required|min:4',
        'category' => 'required|integer',
        'description' => 'required|min:4',
    ];

    public function createIdea()
    {
        if (auth()->check()) {
            $this->validate();

            Idea::create([
                'user_id' => auth()->id(),
                'category_id' => $this->category,
                'status_id' => 1,
                'title' => $this->title,
                'description' => $this->description,
            ]);

            session()->flash('success_message', 'Idea Created Successfully');

            $this->reset();

            return redirect()->route('idea.index');
        }

        abort(Response::HTTP_FORBIDDEN);

    }

    public function render()
    {
        return view('livewire.create-idea', [
            'categories' => Category::all(),

        ]);
    }
}

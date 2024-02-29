<?php

namespace Sokeio\Comment\Livewire;


use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Component;
use Sokeio\Components\Concerns\WithTablePagination;

class Comments extends Component
{
    use WithTablePagination;

    public $classBox='p-4 bg-white rounded shadow-sm';
    public $model;

    public $users = [];

    public $showDropdown = false;

    protected $numberOfPaginatorsRendered = [];

    public $newCommentState = [
        'body' => ''
    ];

    protected $listeners = [
        'refresh' => '$refresh'
    ];

    protected $validationAttributes = [
        'newCommentState.body' => 'comment'
    ];

    /**
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application|null
     */
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application|null
    {
        $comments = $this->model
            ->comments()
            ->with('user', 'children.user', 'children.children')
            ->parent()
            ->latest()
            ->paginate(config('comment.pagination_count', 10), ['*'], $this->getPageName(), $this->getPage($this->getPageName()));
        return view('comment::comments', [
            'comments' => $comments
        ]);
    }

    /**
     * @return void
     */
    #[On('refresh')]
    public function postComment(): void
    {

        if (!isset($this->newCommentState['body']) || trim($this->newCommentState['body']) === '') {
            return;
        }
        $comment = $this->model->comments()->make($this->newCommentState);
        $comment->user()->associate(auth()->user());
        $comment->save();

        $this->newCommentState = [
            'body' => ''
        ];
        $this->users = [];
        $this->showDropdown = false;

        $this->resetPage();
        session()->flash('message', 'Comment Posted Successfully!');
    }
}

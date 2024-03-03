<?php

namespace Sokeio\Comment\Livewire;

use Livewire\Component;

class ViewCount extends Component
{
    public $model;
    public $count = 0;
    public $poll = 0;
    public $text = 'View';
    public function mount()
    {
        $this->loadView();
    }
    public function checkView()
    {
        $this->model->checkView();
        $this->loadView();
    }
    public function loadView()
    {
        $this->count = $this->model->viewCount();
    }
    public function render()
    {
        return view('comment::view-count');
    }
}

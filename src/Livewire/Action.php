<?php

namespace Sokeio\Comment\Livewire;

use Livewire\Component;

class Action extends Component
{
    public $model;
    public $type = 'like';
    public $text = '';
    public $icon = '';
    public $actionClass = '';
    public $unactionClass = '';
    public $actionIconClass = '';
    public $unactionIconClass = '';

    public $count;
    public function mount()
    {
        $this->count = $this->model->countActions($this->type);
        if ($type = $this->model->getTextIcon($this->type)) {
            if (isset($type['text']))
                $this->text = $type['text'];
            if (isset($type['icon']))
                $this->icon = $type['icon'];
            if (isset($type['actionClass']))
                $this->actionClass = $type['actionClass'];
            if (isset($type['unactionClass']))
                $this->unactionClass = $type['unactionClass'];
            if (isset($type['actionIconClass']))
                $this->actionIconClass = $type['actionIconClass'];
            if (isset($type['unactionIconClass']))
                $this->unactionIconClass = $type['unactionIconClass'];
        }
    }
    public function isAction()
    {
        return $this->model->isAction($this->type);
    }

    public function action()
    {
        if ($this->isAction()) {
            $this->model->removeAction($this->type);
            $this->count--;
        } else {
            $this->model->addAction($this->type);
            $this->count++;
        }
    }
    public function render()
    {
        if (!$this->count) {
            $this->count = 0;
        }
        return view('comment::action');
    }
}

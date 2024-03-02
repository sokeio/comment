<?php

namespace Sokeio\Comment\Livewire;

use Livewire\Component;

class Rate extends Component
{
    public $model;
    public $rateMax = 5;
    public $rate = 0;
    public $userRate = 0;
    public $rates = [];
    public $rateIcon = [
        'unRated' => 'bi bi-star',
        'halfRated' => 'bi bi-star-half text-warning',
        'rated' => 'bi bi-star-fill text-warning',
    ];
    public function mount()
    {
        $this->rateMax = $this->model->rateMax;
        if (isset($this->model->rateIcon['rated'])) {
            $this->rateIcon['rated'] = $this->model->rateIcon['rated'];
        }
        if (isset($this->model->rateIcon['halfRated'])) {
            $this->rateIcon['halfRated'] = $this->model->rateIcon['halfRated'];
        }
        if (isset($this->model->rateIcon['unRated'])) {
            $this->rateIcon['unRated'] = $this->model->rateIcon['unRated'];
        }
        $this->loadUserRate();
    }
    private function loadUserRate()
    {
        if ($this->model->rate != null) {
            $this->rates = $this->model->rate->rates ?? [];
            $this->userRate = $this->model->rate->getUserRateCurrent();
            $this->rate = $this->model->rate->rate;
        }
    }
    public function chooseRate($rate)
    {
        $this->model->changeRate($rate, $this->rateMax);
        if ($this->model->rate != null) {
            $this->rates = $this->model->rate->rates ?? [];
            $this->rate = $this->model->rate->rate;
            $this->userRate = $rate;
        }
    }
    public function render()
    {
        return view('comment::rate');
    }
}

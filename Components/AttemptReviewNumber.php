<?php

namespace Modules\Exam\Components;

use Illuminate\View\Component;

class AttemptReviewNumber extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $hasil;
    public function __construct($hasil)
    {
        $this->hasil = $hasil;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        // return view('exam::components.attempt-review-number');
    }
}

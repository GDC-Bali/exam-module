<?php

namespace Modules\Exam\Components;

use Illuminate\View\Component;

class AttemptReviewInfo extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $attempt, $hasil;
    public function __construct($attempt, $hasil)
    {
        $this->hasil = $hasil;
        $this->attempt = $attempt;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('exam::components.attempt-review-info');
    }
}

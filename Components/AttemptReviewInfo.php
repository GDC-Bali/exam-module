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
    public $attempt, $hasil, $type;
    public function __construct($attempt, $hasil, $type)
    {
        $this->hasil = $hasil;
        $this->attempt = $attempt;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        // return view('exam::components.attempt-review-info');
    }
}

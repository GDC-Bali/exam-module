<?php

namespace Modules\Exam\Components;

use Illuminate\View\Component;

class AttemptReviewContent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $attempt;
    public $group;

    public function __construct($attempt, $group)
    {
        $this->attempt = $attempt;
        $this->group = $group;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        // return view('exam::components.attempt-review-content');
    }
}

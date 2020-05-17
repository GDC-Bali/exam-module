<?php

namespace Modules\Exam\Components;

use Illuminate\View\Component;

class QuestionNumbers extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $totalquestions;

    public function __construct($totalquestions)
    {
        $this->totalquestions = $totalquestions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        // return view('exam::components.question-numbers');
    }
}

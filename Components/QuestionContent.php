<?php

namespace Modules\Exam\Components;

use Illuminate\View\Component;

class QuestionContent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $question;
    public $totalquestions;

    public function __construct($question, $totalquestions)
    {
        $this->question = $question;
        $this->totalquestions = $totalquestions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        // return view('exam::components.question-content');
    }
}

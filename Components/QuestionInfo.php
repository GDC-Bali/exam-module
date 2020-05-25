<?php

namespace Modules\Exam\Components;

use Illuminate\View\Component;

class QuestionInfo extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('exam::components.question-info');
    }
}

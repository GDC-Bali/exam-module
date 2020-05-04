<?php

namespace Modules\Exam\Components;

use Illuminate\View\Component;

class AnswerOption extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $options;

    public function __construct($options)
    {
        $this->options = $options;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('exam::components.answer-option');
    }
}

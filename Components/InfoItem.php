<?php

namespace Modules\Exam\Components;

use Illuminate\View\Component;

class InfoItem extends Component
{
    public $label;
    public $text;
    public $icon;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $text, $icon)
    {
        $this->label = $label;
        $this->text = $text;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('exam::components.info-item');
    }
}

<?php

namespace Modules\Exam\Components;

use Illuminate\View\Component;

class ButtonIcon extends Component
{
    public $type;
    public $text;
    public $icon;
    public $link;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type='button', $text, $icon, $link='')
    {
        $this->type = $type;
        $this->text = $text;
        $this->icon = $icon;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        // return view('exam::components.button-icon');
    }
}

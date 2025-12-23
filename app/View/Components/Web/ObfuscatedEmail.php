<?php

namespace App\View\Components\Web;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ObfuscatedEmail extends Component
{
    public $encryptedEmail;
    public $classes;

    /**
     * Create a new component instance.
     */
    public function __construct($email, $class = '')
    {
        // Encode email ke Base64 agar tidak terbaca bot di source code
        $this->encryptedEmail = base64_encode($email);
        $this->classes = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.web.obfuscated-email');
    }
}
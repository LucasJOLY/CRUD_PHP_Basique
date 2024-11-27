<?php
declare(strict_types=1);

namespace App\Template;

class TemplateEngine
{
    private string $layout; // Le chemin du layout global


    public function __construct()
    {
        $this->layout = __DIR__ . '/../View/layout.html.php';
    }


    public function render(string $template, array $variables = []): void
    {
        foreach ($variables as $name => $value) {
            $$name = $value;
        }
        ob_start();
        include $template;
        $content = ob_get_clean();
        include $this->layout;
    }
}

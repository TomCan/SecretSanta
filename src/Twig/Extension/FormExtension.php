<?php

namespace App\Twig\Extension;

use Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode;
use Symfony\Component\Form\FormRendererInterface;
use Symfony\Component\Form\FormView;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FormExtension extends AbstractExtension
{
    /*
     * This property is public so that it can be accessed directly from compiled
     * templates without having to call a getter, which slightly decreases performance.
     */
    public FormRendererInterface $renderer;

    public function __construct(FormRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('form_javascript',
                [$this, 'renderJavascript'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction('form_stylesheet', null, [
                'is_safe' => ['html'],
                'node_class' => SearchAndRenderBlockNode::class,
            ]),
        ];
    }

    /**
     * Render Function Form Javascript.
     */
    public function renderJavascript(FormView $view, $prototype = false): string
    {
        $block = $prototype ? 'javascript_prototype' : 'javascript';

        return $this->renderer->searchAndRenderBlock($view, $block);
    }
}

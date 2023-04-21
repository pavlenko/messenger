<?php

namespace PE\Component\Messenger\Template;

abstract class TemplateBase implements TemplateInterface
{
    protected string $subject;
    protected array $vars;
    protected ?string $tag;

    public function __construct(string $subject, array $vars, string $tag = null)
    {
        $this->subject = $subject;
        $this->vars    = $vars;
        $this->tag     = $tag;
    }

    public function substitute(string $template, array $vars): string
    {
        return preg_replace_callback('/{{\s*(?<var>\w+)\s*}}/', fn($m) => $vars[$m['var']] ?? '', $template);
    }
}
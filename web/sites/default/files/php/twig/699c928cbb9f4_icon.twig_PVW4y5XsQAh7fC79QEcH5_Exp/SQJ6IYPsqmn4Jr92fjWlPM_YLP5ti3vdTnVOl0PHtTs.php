<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* @mercury/components/icon/icon.twig */
class __TwigTemplate_d9fc72bf220566cead7563480f8b2c9d extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 9
        yield "
";
        // line 10
        $context["size_map"] = ["extra-extra-small" => 16, "extra-small" => 20, "small" => 24, "medium" => 32, "large" => 48, "extra-large" => 64];
        // line 18
        yield "
";
        // line 19
        $context["resolved_size"] = ((CoreExtension::getAttribute($this->env, $this->source, ($context["size_map"] ?? null), ($context["icon_size"] ?? null), [], "array", true, true, true, 19)) ? (Twig\Extension\CoreExtension::default((($_v0 = ($context["size_map"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess && in_array($_v0::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v0[($context["icon_size"] ?? null)] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["size_map"] ?? null), ($context["icon_size"] ?? null), [], "array", false, false, true, 19)), (($_v1 = ($context["size_map"] ?? null)) && is_array($_v1) || $_v1 instanceof ArrayAccess && in_array($_v1::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v1["small"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["size_map"] ?? null), "small", [], "array", false, false, true, 19)))) : ((($_v2 = ($context["size_map"] ?? null)) && is_array($_v2) || $_v2 instanceof ArrayAccess && in_array($_v2::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v2["small"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["size_map"] ?? null), "small", [], "array", false, false, true, 19))));
        // line 20
        yield "
<div class=\"min-w:";
        // line 21
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["resolved_size"] ?? null), "html", null, true);
        yield "\">
  ";
        // line 22
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\IconsTwigExtension']->getIconRenderable("phosphor",         // line 25
($context["icon"] ?? null), ["size" =>         // line 27
($context["resolved_size"] ?? null), "color" => ((        // line 28
array_key_exists("icon_color", $context)) ? (Twig\Extension\CoreExtension::default(($context["icon_color"] ?? null), "currentColor")) : ("currentColor")), "alt" => ((        // line 29
array_key_exists("alt", $context)) ? (Twig\Extension\CoreExtension::default(($context["alt"] ?? null), "")) : (""))]), "html", null, true);
        // line 32
        yield "
</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["icon_size", "icon", "icon_color", "alt"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "@mercury/components/icon/icon.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  67 => 32,  65 => 29,  64 => 28,  63 => 27,  62 => 25,  61 => 22,  57 => 21,  54 => 20,  52 => 19,  49 => 18,  47 => 10,  44 => 9,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "@mercury/components/icon/icon.twig", "/var/www/html/web/themes/contrib/mercury/components/icon/icon.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 10];
        static $filters = ["default" => 19, "escape" => 21];
        static $functions = ["icon" => 23];

        try {
            $this->sandbox->checkSecurity(
                ['set'],
                ['default', 'escape'],
                ['icon'],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}

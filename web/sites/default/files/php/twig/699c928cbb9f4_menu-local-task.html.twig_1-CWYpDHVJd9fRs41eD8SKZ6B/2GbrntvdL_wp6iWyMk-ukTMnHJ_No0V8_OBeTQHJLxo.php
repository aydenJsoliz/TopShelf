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

/* core/themes/claro/templates/navigation/menu-local-task.html.twig */
class __TwigTemplate_34256fdf1fe45abc6956388a6f039e02 extends Template
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
        // line 19
        $context["classes"] = ["tabs__tab", (((        // line 21
($context["level"] ?? null) == "primary")) ? ("js-tab") : ("")), (((($tmp =         // line 22
($context["is_active"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("is-active") : ("")), (((($tmp =         // line 23
($context["is_active"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("js-active-tab") : (""))];
        // line 26
        yield "<li";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [($context["classes"] ?? null)], "method", false, false, true, 26), "html", null, true);
        yield ">
  ";
        // line 27
        if ((isset($context["canvas_is_preview"]) && $context["canvas_is_preview"]) && array_key_exists("canvas_uuid", $context)) {
            if (array_key_exists("canvas_slot_ids", $context) && in_array("link", $context["canvas_slot_ids"], TRUE)) {
                yield \sprintf('<!-- canvas-slot-%s-%s/%s -->', "start", $context["canvas_uuid"], "link");
            } else {
                yield \sprintf('<!-- canvas-prop-%s-%s/%s -->', "start", $context["canvas_uuid"], "link");
            }
        }
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["link"] ?? null), "html", null, true);
        if ((isset($context["canvas_is_preview"]) && $context["canvas_is_preview"]) && array_key_exists("canvas_uuid", $context)) {
            if (array_key_exists("canvas_slot_ids", $context) && in_array("link", $context["canvas_slot_ids"], TRUE)) {
                yield \sprintf('<!-- canvas-slot-%s-%s/%s -->', "end", $context["canvas_uuid"], "link");
            } else {
                yield \sprintf('<!-- canvas-prop-%s-%s/%s -->', "end", $context["canvas_uuid"], "link");
            }
        }
        yield "
  ";
        // line 28
        if ((($context["is_active"] ?? null) && (($context["level"] ?? null) == "primary"))) {
            // line 29
            yield "    ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/drupal.reset-appearance"), "html", null, true);
            yield "
    <button class=\"reset-appearance tabs__trigger\" type=\"button\" aria-label=\"";
            // line 30
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Tabs display toggle"));
            yield "\" data-drupal-nav-tabs-trigger>
      <span class=\"hamburger-icon\" aria-hidden=\"false\">";
            // line 31
            yield from $this->load("@claro/../images/src/hamburger-menu.svg", 31)->unwrap()->yield($context);
            yield "</span>
      <span class=\"close-icon\" aria-hidden=\"true\">";
            // line 32
            yield from $this->load("@claro/../images/icons/002e9a/ex.svg", 32)->unwrap()->yield($context);
            yield "</span>
    </button>
  ";
        }
        // line 35
        yield "</li>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["level", "is_active", "attributes", "link"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "core/themes/claro/templates/navigation/menu-local-task.html.twig";
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
        return array (  93 => 35,  87 => 32,  83 => 31,  79 => 30,  74 => 29,  72 => 28,  54 => 27,  49 => 26,  47 => 23,  46 => 22,  45 => 21,  44 => 19,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "core/themes/claro/templates/navigation/menu-local-task.html.twig", "/var/www/html/web/core/themes/claro/templates/navigation/menu-local-task.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 19, "if" => 28, "include" => 31];
        static $filters = ["escape" => 26, "t" => 30];
        static $functions = ["attach_library" => 29];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if', 'include'],
                ['escape', 't'],
                ['attach_library'],
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

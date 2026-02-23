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

/* themes/contrib/mercury/templates/layout/html.html.twig */
class __TwigTemplate_5011029ddaee9a78821fc4f2478fe5bc extends Template
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
        // line 26
        $context["body_classes"] = [(((($tmp =         // line 27
($context["logged_in"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("user-logged-in") : ("")), (((($tmp =  !        // line 28
($context["root_path"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("path-frontpage") : (("path-" . \Drupal\Component\Utility\Html::getClass(($context["root_path"] ?? null))))), (((($tmp =         // line 29
($context["node_type"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (("page-node-type-" . \Drupal\Component\Utility\Html::getClass(($context["node_type"] ?? null)))) : ("")), (((($tmp =         // line 30
($context["db_offline"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("db-offline") : (""))];
        // line 32
        $context["html_classes"] = (((((array_key_exists("scheme", $context)) ? (Twig\Extension\CoreExtension::default(($context["scheme"] ?? null), "light")) : ("light")) == "dark")) ? (["dark"]) : ([]));
        // line 33
        yield "<!DOCTYPE html>
<html ";
        // line 34
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["html_attributes"] ?? null), "addClass", [($context["html_classes"] ?? null)], "method", false, false, true, 34), "html", null, true);
        yield ">
  <head>
    <head-placeholder token=\"";
        // line 36
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["placeholder_token"] ?? null), "html", null, true);
        yield "\">
    <title>
      ";
        // line 38
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->safeJoin($this->env, ($context["head_title"] ?? null), " | "));
        yield "
    </title>
    <css-placeholder token=\"";
        // line 40
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["placeholder_token"] ?? null), "html", null, true);
        yield "\">
    <js-placeholder token=\"";
        // line 41
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["placeholder_token"] ?? null), "html", null, true);
        yield "\">
    ";
        // line 42
        yield from $this->load("@mercury/includes/preload.twig", 42)->unwrap()->yield($context);
        // line 43
        yield "  </head>
  <body ";
        // line 44
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [($context["body_classes"] ?? null)], "method", false, false, true, 44), "html", null, true);
        yield ">
    ";
        // line 49
        yield "    <a href=\"#main-content\" class=\"visually-hidden focusable skip-link\">";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Skip to main content"));
        yield "</a>
    ";
        // line 50
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["page_top"] ?? null), "html", null, true);
        yield "
    ";
        // line 51
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["page"] ?? null), "html", null, true);
        yield "
    ";
        // line 52
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["page_bottom"] ?? null), "html", null, true);
        yield "
    <js-bottom-placeholder token=\"";
        // line 53
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["placeholder_token"] ?? null), "html", null, true);
        yield "\">
  </body>
</html>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["logged_in", "root_path", "node_type", "db_offline", "scheme", "html_attributes", "placeholder_token", "head_title", "attributes", "page_top", "page", "page_bottom"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/contrib/mercury/templates/layout/html.html.twig";
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
        return array (  104 => 53,  100 => 52,  96 => 51,  92 => 50,  87 => 49,  83 => 44,  80 => 43,  78 => 42,  74 => 41,  70 => 40,  65 => 38,  60 => 36,  55 => 34,  52 => 33,  50 => 32,  48 => 30,  47 => 29,  46 => 28,  45 => 27,  44 => 26,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/contrib/mercury/templates/layout/html.html.twig", "/var/www/html/web/themes/contrib/mercury/templates/layout/html.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 26, "include" => 42];
        static $filters = ["clean_class" => 28, "default" => 32, "escape" => 34, "safe_join" => 38, "t" => 49];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'include'],
                ['clean_class', 'default', 'escape', 'safe_join', 't'],
                [],
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

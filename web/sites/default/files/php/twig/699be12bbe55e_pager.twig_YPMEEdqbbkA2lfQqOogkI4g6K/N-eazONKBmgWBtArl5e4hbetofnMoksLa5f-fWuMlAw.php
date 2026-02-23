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

/* @mercury/includes/pager.twig */
class __TwigTemplate_f036f629770bed70e90a6c5df25b44d8 extends Template
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
        // line 1
        $context["classes"] = ["pager", "my-4", "font-medium"];
        // line 2
        yield "
";
        // line 3
        $context["ellipsis_container_classes"] = ["flex items-center justify-center rounded px-2 py-1.5"];
        // line 4
        yield "
";
        // line 5
        if ((($tmp = ($context["items"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 6
            yield "  <nav class=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::join(($context["classes"] ?? null), " "), "html", null, true);
            yield "\" role=\"navigation\" aria-labelledby=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["heading_id"] ?? null), "html", null, true);
            yield "\">
    ";
            // line 7
            if ((($context["pagination_heading_level"] ?? null) == "h1")) {
                // line 8
                yield "      <h1 id=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["heading_id"] ?? null), "html", null, true);
                yield "\" class=\"sr-only\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Pagination"));
                yield "</h1>
    ";
            } elseif ((            // line 9
($context["pagination_heading_level"] ?? null) == "h2")) {
                // line 10
                yield "      <h2 id=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["heading_id"] ?? null), "html", null, true);
                yield "\" class=\"sr-only\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Pagination"));
                yield "</h2>
    ";
            } elseif ((            // line 11
($context["pagination_heading_level"] ?? null) == "h3")) {
                // line 12
                yield "      <h3 id=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["heading_id"] ?? null), "html", null, true);
                yield "\" class=\"sr-only\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Pagination"));
                yield "</h3>
    ";
            } elseif ((            // line 13
($context["pagination_heading_level"] ?? null) == "h4")) {
                // line 14
                yield "      <h4 id=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["heading_id"] ?? null), "html", null, true);
                yield "\" class=\"sr-only\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Pagination"));
                yield "</h4>
    ";
            } elseif ((            // line 15
($context["pagination_heading_level"] ?? null) == "h5")) {
                // line 16
                yield "      <h5 id=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["heading_id"] ?? null), "html", null, true);
                yield "\" class=\"sr-only\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Pagination"));
                yield "</h5>
    ";
            } elseif ((            // line 17
($context["pagination_heading_level"] ?? null) == "h6")) {
                // line 18
                yield "      <h6 id=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["heading_id"] ?? null), "html", null, true);
                yield "\" class=\"sr-only\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Pagination"));
                yield "</h6>
    ";
            } else {
                // line 20
                yield "      <h2 id=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["heading_id"] ?? null), "html", null, true);
                yield "\" class=\"sr-only\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Pagination"));
                yield "</h2>
    ";
            }
            // line 22
            yield "    <ul class=\"flex list-none items-center justify-center gap-1\">
      ";
            // line 24
            yield "      ";
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "first", [], "any", false, false, true, 24)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 25
                yield "        <li>
          <a href=\"";
                // line 26
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "first", [], "any", false, false, true, 26), "href", [], "any", false, false, true, 26), "html", null, true);
                yield "\" title=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Go to first page"));
                yield "\" ";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->withoutFilter(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "first", [], "any", false, false, true, 26), "attributes", [], "any", false, false, true, 26), "href", "title"), "html", null, true);
                yield ">
            <span class=\"sr-only\">";
                // line 27
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("First page"));
                yield "</span>
            <span
              aria-hidden=\"true\"
              class=\"pager__list-item text-sm whitespace-nowrap hover:underline hover:decoration-1 hover:underline-offset-3 md:text-base\"
            >
              ";
                // line 32
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "first", [], "any", false, true, true, 32), "text", [], "any", true, true, true, 32)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "first", [], "any", false, false, true, 32), "text", [], "any", false, false, true, 32), t("« First"))) : (t("« First"))), "html", null, true);
                yield "
            </span>
          </a>
        </li>
      ";
            }
            // line 37
            yield "      ";
            // line 38
            yield "      ";
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "previous", [], "any", false, false, true, 38)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 39
                yield "        <li>
          <a
            href=\"";
                // line 41
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "previous", [], "any", false, false, true, 41), "href", [], "any", false, false, true, 41), "html", null, true);
                yield "\"
            title=\"";
                // line 42
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Go to previous page"));
                yield "\"
            rel=\"prev\"
            class=\"flex items-center justify-center gap-1 rounded pe-2 lg:pe-4\"
            ";
                // line 45
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->withoutFilter(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "previous", [], "any", false, false, true, 45), "attributes", [], "any", false, false, true, 45), "href", "title", "rel"), "html", null, true);
                yield "
          >
            <span class=\"sr-only\">";
                // line 47
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Previous page"));
                yield "</span>
            <i class=\"pager__icon ph ph-caret-left flex h-6 w-6 shrink-0 items-center justify-center px-2 text-2xl leading-none lg:px-4\"></i>
            <span
              class=\"pager__list-item text-sm whitespace-nowrap hover:underline hover:decoration-1 hover:underline-offset-3 md:text-base\"
              aria-hidden=\"true\"
            >
              ";
                // line 53
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "previous", [], "any", false, true, true, 53), "text", [], "any", true, true, true, 53)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "previous", [], "any", false, false, true, 53), "text", [], "any", false, false, true, 53), t("Previous"))) : (t("Previous"))), "html", null, true);
                yield "
            </span>
          </a>
        </li>
      ";
            }
            // line 58
            yield "      ";
            // line 59
            yield "
      ";
            // line 60
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["ellipses"] ?? null), "previous", [], "any", false, false, true, 60)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 61
                yield "        <li>
          <span class=\"";
                // line 62
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::join(($context["ellipsis_container_classes"] ?? null), " "), "html", null, true);
                yield "\" role=\"presentation\">
            <i class=\"pager__icon ph ph-caret-left h-6 w-6 shrink-0 text-2xl leading-none\"></i>
          </span>
        </li>
      ";
            }
            // line 67
            yield "      ";
            // line 68
            yield "      ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "pages", [], "any", false, false, true, 68));
            foreach ($context['_seq'] as $context["key"] => $context["item"]) {
                // line 69
                yield "        <li>
          ";
                // line 70
                if ((($context["current"] ?? null) == $context["key"])) {
                    // line 71
                    yield "            ";
                    $context["title"] = t("Current page");
                    // line 72
                    yield "            ";
                    $context["page_classes"] = "flex items-center justify-center aspect-square rounded px-2 lg:px-4 border border";
                    // line 73
                    yield "          ";
                } else {
                    // line 74
                    yield "            ";
                    $context["title"] = t("Go to page @key", ["@key" =>                     // line 76
$context["key"]]);
                    // line 79
                    yield "            ";
                    $context["page_classes"] = "hover:underline hover:decoration-1 hover:underline-offset-3 flex items-center justify-center aspect-square rounded px-2 lg:px-4";
                    // line 82
                    yield "          ";
                }
                // line 83
                yield "          <a href=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "href", [], "any", false, false, true, 83), "html", null, true);
                yield "\" title=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["title"] ?? null), "html", null, true);
                yield "\" class=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["page_classes"] ?? null), "html", null, true);
                yield "\" ";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->withoutFilter(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "attributes", [], "any", false, false, true, 83), "href", "title"), "html", null, true);
                yield ">
            <span class=\"sr-only\">";
                // line 84
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Page"));
                yield "</span>
            <span class=\"pager__list-item text-sm whitespace-nowrap md:text-base\">";
                // line 85
                if ((isset($context["canvas_is_preview"]) && $context["canvas_is_preview"]) && array_key_exists("canvas_uuid", $context)) {
                    if (array_key_exists("canvas_slot_ids", $context) && in_array("key", $context["canvas_slot_ids"], TRUE)) {
                        yield \sprintf('<!-- canvas-slot-%s-%s/%s -->', "start", $context["canvas_uuid"], "key");
                    } else {
                        yield \sprintf('<!-- canvas-prop-%s-%s/%s -->', "start", $context["canvas_uuid"], "key");
                    }
                }
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["key"], "html", null, true);
                if ((isset($context["canvas_is_preview"]) && $context["canvas_is_preview"]) && array_key_exists("canvas_uuid", $context)) {
                    if (array_key_exists("canvas_slot_ids", $context) && in_array("key", $context["canvas_slot_ids"], TRUE)) {
                        yield \sprintf('<!-- canvas-slot-%s-%s/%s -->', "end", $context["canvas_uuid"], "key");
                    } else {
                        yield \sprintf('<!-- canvas-prop-%s-%s/%s -->', "end", $context["canvas_uuid"], "key");
                    }
                }
                yield "</span>
          </a>
        </li>
      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['key'], $context['item'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 89
            yield "      ";
            // line 90
            yield "      ";
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["ellipses"] ?? null), "next", [], "any", false, false, true, 90)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 91
                yield "        <li>
          <span class=\"";
                // line 92
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::join(($context["ellipsis_container_classes"] ?? null), " "), "html", null, true);
                yield "\" role=\"presentation\">
            <i class=\"pager__icon ph ph-caret-right h-6 w-6 shrink-0 text-2xl leading-none\"></i>
          </span>
        </li>
      ";
            }
            // line 97
            yield "      ";
            // line 98
            yield "      ";
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "next", [], "any", false, false, true, 98)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 99
                yield "        <li>
          <a
            href=\"";
                // line 101
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "next", [], "any", false, false, true, 101), "href", [], "any", false, false, true, 101), "html", null, true);
                yield "\"
            title=\"";
                // line 102
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Go to next page"));
                yield "\"
            rel=\"next\"
            class=\"flex items-center justify-center gap-1 rounded ps-2 lg:ps-4\"
            ";
                // line 105
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->withoutFilter(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "next", [], "any", false, false, true, 105), "attributes", [], "any", false, false, true, 105), "href", "title", "rel"), "html", null, true);
                yield "
          >
            <span class=\"sr-only\">";
                // line 107
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Next page"));
                yield "</span>
            <span
              class=\"pager__list-item text-sm whitespace-nowrap hover:underline hover:decoration-1 hover:underline-offset-3 md:text-base\"
              aria-hidden=\"true\"
            >
              ";
                // line 112
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "next", [], "any", false, true, true, 112), "text", [], "any", true, true, true, 112)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "next", [], "any", false, false, true, 112), "text", [], "any", false, false, true, 112), t("Next"))) : (t("Next"))), "html", null, true);
                yield "
            </span>
            <i class=\"pager__icon ph ph-caret-right flex h-6 w-6 shrink-0 items-center justify-center px-2 text-2xl leading-none lg:px-4\"></i>
          </a>
        </li>
      ";
            }
            // line 118
            yield "      ";
            // line 119
            yield "      ";
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "last", [], "any", false, false, true, 119)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 120
                yield "        <li>
          <a href=\"";
                // line 121
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "last", [], "any", false, false, true, 121), "href", [], "any", false, false, true, 121), "html", null, true);
                yield "\" title=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Go to last page"));
                yield "\" ";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->withoutFilter(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "last", [], "any", false, false, true, 121), "attributes", [], "any", false, false, true, 121), "href", "title"), "html", null, true);
                yield ">
            <span class=\"sr-only\">";
                // line 122
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Last page"));
                yield "</span>
            <span
              aria-hidden=\"true\"
              class=\"pager__list-item text-sm whitespace-nowrap hover:underline hover:decoration-1 hover:underline-offset-3 md:text-base\"
            >
              ";
                // line 127
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "last", [], "any", false, true, true, 127), "text", [], "any", true, true, true, 127)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["items"] ?? null), "last", [], "any", false, false, true, 127), "text", [], "any", false, false, true, 127), t("Last »"))) : (t("Last »"))), "html", null, true);
                yield "
            </span>
          </a>
        </li>
      ";
            }
            // line 132
            yield "    </ul>
  </nav>
";
        }
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["items", "heading_id", "pagination_heading_level", "ellipses", "current"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "@mercury/includes/pager.twig";
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
        return array (  377 => 132,  369 => 127,  361 => 122,  353 => 121,  350 => 120,  347 => 119,  345 => 118,  336 => 112,  328 => 107,  323 => 105,  317 => 102,  313 => 101,  309 => 99,  306 => 98,  304 => 97,  296 => 92,  293 => 91,  290 => 90,  288 => 89,  264 => 85,  260 => 84,  249 => 83,  246 => 82,  243 => 79,  241 => 76,  239 => 74,  236 => 73,  233 => 72,  230 => 71,  228 => 70,  225 => 69,  220 => 68,  218 => 67,  210 => 62,  207 => 61,  205 => 60,  202 => 59,  200 => 58,  192 => 53,  183 => 47,  178 => 45,  172 => 42,  168 => 41,  164 => 39,  161 => 38,  159 => 37,  151 => 32,  143 => 27,  135 => 26,  132 => 25,  129 => 24,  126 => 22,  118 => 20,  110 => 18,  108 => 17,  101 => 16,  99 => 15,  92 => 14,  90 => 13,  83 => 12,  81 => 11,  74 => 10,  72 => 9,  65 => 8,  63 => 7,  56 => 6,  54 => 5,  51 => 4,  49 => 3,  46 => 2,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "@mercury/includes/pager.twig", "/var/www/html/web/themes/contrib/mercury/templates/includes/pager.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 1, "if" => 5, "for" => 68];
        static $filters = ["escape" => 6, "join" => 6, "t" => 8, "without" => 26, "default" => 32];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if', 'for'],
                ['escape', 'join', 't', 'without', 'default'],
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

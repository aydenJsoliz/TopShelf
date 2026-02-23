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

/* themes/contrib/mercury/templates/navigation/menu.html.twig */
class __TwigTemplate_8d4519fc0ddfccdb142d373dbd6689a1 extends Template
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
        // line 21
        $macros["menus"] = $this->macros["menus"] = $this;
        // line 22
        yield "
";
        // line 27
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($macros["menus"]->getTemplateForMacro("macro_menu_links", $context, 27, $this->getSourceContext())->macro_menu_links(...[($context["items"] ?? null), ($context["attributes"] ?? null), 0]));
        yield "

";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["_self", "items", "attributes", "menu_level", "v", "loop"]);        yield from [];
    }

    // line 29
    public function macro_menu_links($items = null, $attributes = null, $menu_level = null, ...$varargs): string|Markup
    {
        $macros = $this->macros;
        $context = [
            "items" => $items,
            "attributes" => $attributes,
            "menu_level" => $menu_level,
            "varargs" => $varargs,
        ] + $this->env->getGlobals();

        $blocks = [];

        return ('' === $tmp = implode('', iterator_to_array((function () use (&$context, $macros, $blocks) {
            // line 30
            yield "  ";
            $context["primary_nav_level"] = ("menu--level-" . (($context["menu_level"] ?? null) + 1));
            // line 31
            yield "  ";
            $macros["menus"] = $this;
            // line 32
            yield "  ";
            $context["menu_classes"] = Twig\Extension\CoreExtension::filter($this->env, Twig\Extension\CoreExtension::merge(((array_key_exists("menu_classes", $context)) ? (Twig\Extension\CoreExtension::default(($context["menu_classes"] ?? null), [])) : ([])), ["list-none", "gap-4", "flex", "flex-wrap", "p-0", "flex-row"]), function ($__v__) use ($context, $macros) { $context["v"] = $__v__; return  !Twig\Extension\CoreExtension::testEmpty(($context["v"] ?? null)); });
            // line 33
            yield "
  ";
            // line 34
            if ((($tmp = ($context["items"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 35
                yield "    <ul ";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", ["menu", ($context["menu_classes"] ?? null), ($context["primary_nav_level"] ?? null)], "method", false, false, true, 35), "html", null, true);
                yield ">
      ";
                // line 36
                $context["attributes"] = CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "removeClass", [($context["primary_nav_level"] ?? null)], "method", false, false, true, 36);
                // line 37
                yield "      ";
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(($context["items"] ?? null));
                $context['loop'] = [
                  'parent' => $context['_parent'],
                  'index0' => 0,
                  'index'  => 1,
                  'first'  => true,
                ];
                if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                    $length = count($context['_seq']);
                    $context['loop']['revindex0'] = $length - 1;
                    $context['loop']['revindex'] = $length;
                    $context['loop']['length'] = $length;
                    $context['loop']['last'] = 1 === $length;
                }
                foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                    // line 38
                    yield "        ";
                    if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 38), "isRouted", [], "any", false, false, true, 38) && (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 38), "routeName", [], "any", false, false, true, 38) == "<nolink>"))) {
                        // line 39
                        yield "          ";
                        $context["menu_item_type"] = "nolink";
                        // line 40
                        yield "        ";
                    } elseif ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 40), "isRouted", [], "any", false, false, true, 40) && (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 40), "routeName", [], "any", false, false, true, 40) == "<button>"))) {
                        // line 41
                        yield "          ";
                        $context["menu_item_type"] = "button";
                        // line 42
                        yield "        ";
                    } else {
                        // line 43
                        yield "          ";
                        $context["menu_item_type"] = "link";
                        // line 44
                        yield "        ";
                    }
                    // line 45
                    yield "
        ";
                    // line 46
                    $context["item_classes"] = ["menu__item", ("menu__item--" .                     // line 48
($context["menu_item_type"] ?? null)), ("menu__item--level-" . (                    // line 49
($context["menu_level"] ?? null) + 1)), (((($tmp = CoreExtension::getAttribute($this->env, $this->source,                     // line 50
$context["item"], "in_active_trail", [], "any", false, false, true, 50)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("menu__item--active-trail") : ("")), (((($tmp = CoreExtension::getAttribute($this->env, $this->source,                     // line 51
$context["item"], "below", [], "any", false, false, true, 51)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("menu__item--has-children") : (""))];
                    // line 53
                    yield "
        ";
                    // line 54
                    $context["link_classes"] = ["flex flex-row gap-y-4 items-center", "hover:underline hover:underline-offset-2 hover:opacity-80 duration-150", "[&_svg]:me-1", "menu__link", ("menu__link--" .                     // line 59
($context["menu_item_type"] ?? null)), ("menu__link--level-" . (                    // line 60
($context["menu_level"] ?? null) + 1)), (((($tmp = CoreExtension::getAttribute($this->env, $this->source,                     // line 61
$context["item"], "in_active_trail", [], "any", false, false, true, 61)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("menu__link--active-trail") : ("")), (((($tmp = CoreExtension::getAttribute($this->env, $this->source,                     // line 62
$context["item"], "below", [], "any", false, false, true, 62)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("menu__link--has-children") : (""))];
                    // line 64
                    yield "
        <li ";
                    // line 65
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "attributes", [], "any", false, false, true, 65), "addClass", [($context["item_classes"] ?? null)], "method", false, false, true, 65), "html", null, true);
                    yield ">
          ";
                    // line 71
                    yield "          ";
                    $context["aria_id"] = \Drupal\Component\Utility\Html::getId(((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 71) . "-submenu-") . CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, true, 71)));
                    // line 72
                    yield "
          ";
                    // line 73
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->getLink(CoreExtension::getAttribute($this->env, $this->source,                     // line 75
$context["item"], "title", [], "any", false, false, true, 75), CoreExtension::getAttribute($this->env, $this->source,                     // line 76
$context["item"], "url", [], "any", false, false, true, 76), ["class" =>                     // line 78
($context["link_classes"] ?? null)]), "html", null, true);
                    // line 81
                    yield "

          ";
                    // line 83
                    if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 83)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        // line 84
                        yield "            ";
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($macros["menus"]->getTemplateForMacro("macro_menu_links", $context, 84, $this->getSourceContext())->macro_menu_links(...[CoreExtension::getAttribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 84), ($context["attributes"] ?? null), (($context["menu_level"] ?? null) + 1)]));
                        yield "
          ";
                    }
                    // line 86
                    yield "        </li>
      ";
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                    if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                        --$context['loop']['revindex0'];
                        --$context['loop']['revindex'];
                        $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 88
                yield "    </ul>
  ";
            }
            yield from [];
        })(), false))) ? '' : new Markup($tmp, $this->env->getCharset());
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/contrib/mercury/templates/navigation/menu.html.twig";
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
        return array (  195 => 88,  180 => 86,  174 => 84,  172 => 83,  168 => 81,  166 => 78,  165 => 76,  164 => 75,  163 => 73,  160 => 72,  157 => 71,  153 => 65,  150 => 64,  148 => 62,  147 => 61,  146 => 60,  145 => 59,  144 => 54,  141 => 53,  139 => 51,  138 => 50,  137 => 49,  136 => 48,  135 => 46,  132 => 45,  129 => 44,  126 => 43,  123 => 42,  120 => 41,  117 => 40,  114 => 39,  111 => 38,  93 => 37,  91 => 36,  86 => 35,  84 => 34,  81 => 33,  78 => 32,  75 => 31,  72 => 30,  58 => 29,  49 => 27,  46 => 22,  44 => 21,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/contrib/mercury/templates/navigation/menu.html.twig", "/var/www/html/web/themes/contrib/mercury/templates/navigation/menu.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["import" => 21, "macro" => 29, "set" => 30, "if" => 34, "for" => 37];
        static $filters = ["filter" => 32, "merge" => 32, "default" => 32, "escape" => 35, "clean_id" => 71];
        static $functions = ["link" => 74];

        try {
            $this->sandbox->checkSecurity(
                ['import', 'macro', 'set', 'if', 'for'],
                ['filter', 'merge', 'default', 'escape', 'clean_id'],
                ['link'],
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

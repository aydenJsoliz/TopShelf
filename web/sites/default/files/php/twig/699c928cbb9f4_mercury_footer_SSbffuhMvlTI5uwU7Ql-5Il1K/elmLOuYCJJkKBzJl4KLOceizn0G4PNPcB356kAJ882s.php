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

/* mercury:footer */
class __TwigTemplate_337646d06b00e6a01f381d8b8a3be894 extends Template
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
            'footer_first' => [$this, 'block_footer_first'],
            'footer_last' => [$this, 'block_footer_last'],
            'footer_utility_first' => [$this, 'block_footer_utility_first'],
            'footer_utility_last' => [$this, 'block_footer_utility_last'],
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.mercury--footer"));
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "mercury:footer"));
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "mercury:footer"));
        // line 2
        $context["additional_classes"] = ((array_key_exists("footer_classes", $context)) ? (Twig\Extension\CoreExtension::default(($context["footer_classes"] ?? null), "")) : (""));
        // line 3
        if (is_iterable(($context["additional_classes"] ?? null))) {
            // line 4
            yield "  ";
            $context["additional_classes"] = Twig\Extension\CoreExtension::join(($context["additional_classes"] ?? null), " ");
        }
        // line 6
        yield "
";
        // line 7
        $context["footer_variants"] = Twig\Extra\Html\HtmlExtension::htmlCva(["flex", "flex-col"]);
        // line 8
        yield "
";
        // line 9
        $context["footer_top_variants"] = Twig\Extra\Html\HtmlExtension::htmlCva(["flex w-full flex-col justify-between gap-6 py-8 md:grid md:grid-cols-2 md:gap-6 [&_li]:text-lg", "border-t border-border"]);
        // line 12
        yield "
";
        // line 13
        $context["footer_first_col_variants"] = Twig\Extra\Html\HtmlExtension::htmlCva(["flex", "flex-col", "gap-6", "[&_.branding]:h-8"]);
        // line 14
        yield "
";
        // line 15
        $context["footer_last_col_variants"] = Twig\Extra\Html\HtmlExtension::htmlCva(["flex flex-col gap-2 md:mx-0 md:ms-auto md:w-xs lg:w-md", "[&_form]:flex [&_form]:flex-row [&_form]:gap-2 md:[&_form]:items-end"]);
        // line 18
        yield "
";
        // line 19
        $context["footer_bottom_variants"] = Twig\Extra\Html\HtmlExtension::htmlCva(["flex w-full flex-col gap-2 py-3 [&_li]:text-xs [&_li]:md:text-sm [&_li]:xl:text-md", "md:grid md:grid-cols-[minmax(0,2fr)_minmax(0,1fr)] md:gap-6 md:py-4", "border-t border-border"]);
        // line 28
        yield "
";
        // line 29
        $context["footer_bottom_col_variants"] = Twig\Extra\Html\HtmlExtension::htmlCva(["site-footer--bottom-col"], ["align" => ["left" => "", "right" => ["md:flex md:justify-end"]]]);
        // line 40
        yield "
<section class=\"site-footer container mx-auto px-4\">
  <div class=\"";
        // line 42
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["footer_variants"] ?? null), "apply", [[], ($context["additional_classes"] ?? null)], "method", false, false, true, 42), "html", null, true);
        yield "\">
    <div class=\"";
        // line 43
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["footer_top_variants"] ?? null), "apply", [[]], "method", false, false, true, 43), "html", null, true);
        yield "\">
      ";
        // line 44
        if (        $this->unwrap()->hasBlock("footer_first", $context, $blocks)) {
            // line 45
            yield "        <div class=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["footer_first_col_variants"] ?? null), "apply", [[]], "method", false, false, true, 45), "html", null, true);
            yield "\">
          ";
            // line 46
            yield from $this->unwrap()->yieldBlock('footer_first', $context, $blocks);
            // line 49
            yield "        </div>
      ";
        }
        // line 51
        yield "
      ";
        // line 52
        if (        $this->unwrap()->hasBlock("footer_last", $context, $blocks)) {
            // line 53
            yield "        <div class=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["footer_last_col_variants"] ?? null), "apply", [[]], "method", false, false, true, 53), "html", null, true);
            yield "\">
          ";
            // line 54
            yield from $this->unwrap()->yieldBlock('footer_last', $context, $blocks);
            // line 57
            yield "        </div>
      ";
        }
        // line 59
        yield "    </div>

    <div class=\"";
        // line 61
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["footer_bottom_variants"] ?? null), "apply", [[]], "method", false, false, true, 61), "html", null, true);
        yield "\">
      ";
        // line 62
        if (        $this->unwrap()->hasBlock("footer_utility_first", $context, $blocks)) {
            // line 63
            yield "        <div
          class=\"";
            // line 64
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source,             // line 65
($context["footer_bottom_col_variants"] ?? null), "apply", [["align" => "left"]], "method", false, false, true, 65), "html", null, true);
            // line 68
            yield "\"
        >
          ";
            // line 70
            yield from $this->unwrap()->yieldBlock('footer_utility_first', $context, $blocks);
            // line 73
            yield "        </div>
      ";
        }
        // line 75
        yield "
      ";
        // line 76
        if (        $this->unwrap()->hasBlock("footer_utility_last", $context, $blocks)) {
            // line 77
            yield "        <div
          class=\"";
            // line 78
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source,             // line 79
($context["footer_bottom_col_variants"] ?? null), "apply", [["align" => "right"]], "method", false, false, true, 79), "html", null, true);
            // line 82
            yield "\"
        >
          ";
            // line 84
            yield from $this->unwrap()->yieldBlock('footer_utility_last', $context, $blocks);
            // line 87
            yield "        </div>
      ";
        }
        // line 89
        yield "    </div>
  </div>
</section>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["footer_classes"]);        yield from [];
    }

    // line 46
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_footer_first(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 47
        yield "            ";
        // line 48
        yield "          ";
        yield from [];
    }

    // line 54
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_footer_last(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 55
        yield "            ";
        // line 56
        yield "          ";
        yield from [];
    }

    // line 70
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_footer_utility_first(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 71
        yield "            ";
        // line 72
        yield "          ";
        yield from [];
    }

    // line 84
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_footer_utility_last(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 85
        yield "            ";
        // line 86
        yield "          ";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "mercury:footer";
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
        return array (  238 => 86,  236 => 85,  229 => 84,  224 => 72,  222 => 71,  215 => 70,  210 => 56,  208 => 55,  201 => 54,  196 => 48,  194 => 47,  187 => 46,  178 => 89,  174 => 87,  172 => 84,  168 => 82,  166 => 79,  165 => 78,  162 => 77,  160 => 76,  157 => 75,  153 => 73,  151 => 70,  147 => 68,  145 => 65,  144 => 64,  141 => 63,  139 => 62,  135 => 61,  131 => 59,  127 => 57,  125 => 54,  120 => 53,  118 => 52,  115 => 51,  111 => 49,  109 => 46,  104 => 45,  102 => 44,  98 => 43,  94 => 42,  90 => 40,  88 => 29,  85 => 28,  83 => 19,  80 => 18,  78 => 15,  75 => 14,  73 => 13,  70 => 12,  68 => 9,  65 => 8,  63 => 7,  60 => 6,  56 => 4,  54 => 3,  52 => 2,  48 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "mercury:footer", "themes/contrib/mercury/components/footer/footer.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 2, "if" => 3, "block" => 46];
        static $filters = ["default" => 2, "join" => 4, "escape" => 42];
        static $functions = ["html_cva" => 7];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if', 'block'],
                ['default', 'join', 'escape'],
                ['html_cva'],
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

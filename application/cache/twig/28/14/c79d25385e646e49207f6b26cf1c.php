<?php

/* frr_temp/test/tutu.html */
class __TwigTemplate_2814c79d25385e646e49207f6b26cf1c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            '__internal_2814c79d25385e646e49207f6b26cf1c_1' => array($this, 'block___internal_2814c79d25385e646e49207f6b26cf1c_1'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<html>
<head>
<title>
HOLA
</title>
</head>
<body>
<h1>";
        // line 8
        if (isset($context["title"])) { $_title_ = $context["title"]; } else { $_title_ = null; }
        echo twig_escape_filter($this->env, $_title_, "html", null, true);
        echo "</h1>
";
        // line 9
        if (isset($context["navigation"])) { $_navigation_ = $context["navigation"]; } else { $_navigation_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_navigation_);
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 10
            echo "            <li><a href=\"";
            if (isset($context["item"])) { $_item_ = $context["item"]; } else { $_item_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_item_, "href"), "html", null, true);
            echo "\">";
            if (isset($context["item"])) { $_item_ = $context["item"]; } else { $_item_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_item_, "caption"), "html", null, true);
            echo "</a></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 12
        echo "
";
        // line 13
        echo twig_escape_filter($this->env, twig_upper_filter($this->env, (string) $this->renderBlock("__internal_2814c79d25385e646e49207f6b26cf1c_1", $context, $blocks)), "html", null, true);
        // line 16
        echo "
";
        // line 17
        $this->env->loadTemplate("welcome_message.php")->display($context);
        // line 18
        echo "</body>
</html>";
    }

    // line 13
    public function block___internal_2814c79d25385e646e49207f6b26cf1c_1($context, array $blocks = array())
    {
        // line 14
        echo "  This text becomes uppercase
";
    }

    public function getTemplateName()
    {
        return "frr_temp/test/tutu.html";
    }

    public function isTraitable()
    {
        return false;
    }
}

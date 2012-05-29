<?php

/* frr_temp/noticias/prueba.html */
class __TwigTemplate_42eb993bdc4ed7dee62f21340fda0611 extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<html>
<head>
<title>
PPPRUEBA
</title>
</head>
<body>


";
        // line 10
        if (isset($context["perro"])) { $_perro_ = $context["perro"]; } else { $_perro_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_perro_);
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        foreach ($context['_seq'] as $context["_key"] => $context["entrada"]) {
            if (isset($context["loop"])) { $_loop_ = $context["loop"]; } else { $_loop_ = null; }
            if (($this->getAttribute($_loop_, "index") < 4)) {
                // line 11
                echo "        <li>";
                if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_entrada_, "titulo"), "html", null, true);
                echo " - ";
                if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_entrada_, "nombre"), "html", null, true);
                echo " - ";
                if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_entrada_, "direccion"), "html", null, true);
                echo "</li>
    ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entrada'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 13
        echo "
</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "frr_temp/noticias/prueba.html";
    }

    public function isTraitable()
    {
        return false;
    }
}

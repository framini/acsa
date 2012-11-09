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
<style>
";
        // line 7
        $this->env->loadTemplate("frr_temp/css/estilo.css")->display($context);
        // line 8
        echo "</style>

</head>
<body>

<script>
";
        // line 14
        $this->env->loadTemplate("frr_temp/js/principal.js")->display($context);
        // line 15
        echo "</script>


<ul>
";
        // line 19
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["perro"]) ? $context["perro"] : null));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        foreach ($context['_seq'] as $context["_key"] => $context["entrada"]) {
            if (($this->getAttribute((isset($context["loop"]) ? $context["loop"] : null), "index") < 4)) {
                // line 20
                echo "        <li>";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "titulo"), "html", null, true);
                echo " - ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "nombre"), "html", null, true);
                echo " - ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "direccion"), "html", null, true);
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
        // line 22
        echo "</ul>
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

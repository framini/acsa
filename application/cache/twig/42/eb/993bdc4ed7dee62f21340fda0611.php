<?php

/* frr_temp/noticias/prueba.html */
class __TwigTemplate_42eb993bdc4ed7dee62f21340fda0611 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<html>
<head>
<title>
Prueba
</title>
<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"http://localhost/argc/index.php/css/estilo\" />

</head>
<body>
<a href=\"http://localhost/argc/\">Link</a>
<script src=\"http://localhost/argc/index.php/js/principal\"></script>
<script src=\"http://localhost/argc/index.php/js/p2\"></script>

<!-- <script src=\"http://localhost/argc/index.php/js/principal\"></script> -->




<ul>
";
        // line 20
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["perroxxx"]) ? $context["perroxxx"] : null));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        foreach ($context['_seq'] as $context["_key"] => $context["entrada"]) {
            if (($this->getAttribute((isset($context["loop"]) ? $context["loop"] : null), "index") < 4)) {
                // line 21
                echo "        <li>";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "titulo"), "html", null, true);
                echo " - ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "cuerpo_noticia"), "html", null, true);
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
        // line 23
        echo "</ul>



<script src=\"http://localhost/argc/index.php/js/p3\"></script>
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

    public function getDebugInfo()
    {
        return array (  68 => 23,  51 => 21,  40 => 20,  19 => 1,);
    }
}

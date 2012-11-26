<?php

/* frr_temp/main/home.html */
class __TwigTemplate_eaedaf390562f1b5be6e28fddc6888bb extends Twig_Template
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
        echo "<!DOCTYPE html>
<html lang=\"en\">
    <head>
        <meta charset=\"utf-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
        <title></title>
        <meta name=\"description\" content=\"\">
        <link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"http://localhost/argc/index.php/css/bootstrap\" />
        <link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"http://localhost/argc/index.php/css/custom\" />
    </head>
    <body>
        ";
        // line 12
        $this->env->loadTemplate("frr_temp/noticias/prueba.html")->display($context);
        // line 13
        echo "        <div class=\"container main-menu\">
            <div class=\"row\">
                <div class=\"navigation\">
                    <div class=\"navbar navbar-inverse\">
                      <div class=\"navbar-inner\">
                        <a class=\"brand\" href=\"#\">TDC/TDD 2012</a>
                        <ul class=\"nav\">
                          <li class=\"active\"><a href=\"#\">Home</a></li>
                          <li><a href=\"#\">Link</a></li>
                          <li><a href=\"#\">Link</a></li>
                        </ul>
                      </div>
                    </div>
                </div>
            </div><!---row-->
        </div><!--header container -->
        
        <div class=\"container\">
            <div id=\"wrapper\">
                <div class=\"row-fluid\">
        \t\t\t
                    <div class=\"hero-unit\">
\t\t\t\t\t\t";
        // line 35
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["contenido_home"]) ? $context["contenido_home"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["entrada"]) {
            // line 36
            echo "\t\t\t\t\t\t\t<h1> ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "titulo"), "html", null, true);
            echo " </h1>
\t\t\t\t\t\t\t<p> ";
            // line 37
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "contenido"), "html", null, true);
            echo " </p>
\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entrada'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 39
        echo "                      <!--<h1>Hello, world!</h1>
                      <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
                      <p><a class=\"btn btn-primary btn-large\">Learn more</a></p>-->
                    </div><!--hero unit-->
                    
                    
                    
                    <ul class=\"thumbnails\">
                    \t
                      ";
        // line 48
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["contenido_home_items"]) ? $context["contenido_home_items"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["entrada"]) {
            // line 49
            echo "                      \t";
            if ($this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "imagen_item")) {
                // line 50
                echo "\t                      <li class=\"span4\">
\t                        <div class=\"thumbnail\">
\t                          <img src=\"http://placehold.it/300x200\" alt=\"\">
\t                          <div class=\"caption\">
\t                            <h3>";
                // line 54
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "titulo"), "html", null, true);
                echo "</h3>
\t                            <p>";
                // line 55
                echo twig_escape_filter($this->env, Twig::longitud_max($this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "contenido"), 140), "html", null, true);
                echo "</p>
\t                          </div>
\t                        </div>
\t                      </li>
                      \t";
            }
            // line 60
            echo "                      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entrada'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 61
        echo "                    </ul>
                    
                </div>
            </div><!--wrapper-->
        </div><!--container main-->
        
    \t<script src=\"http://code.jquery.com/jquery-1.8.2.min.js\"></script>
        <script src=\"http://localhost/argc/index.php/js/bootstrap-min-js\"></script>
    </body>
</html>";
    }

    public function getTemplateName()
    {
        return "frr_temp/main/home.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  117 => 61,  111 => 60,  103 => 55,  99 => 54,  93 => 50,  90 => 49,  86 => 48,  75 => 39,  67 => 37,  62 => 36,  58 => 35,  34 => 13,  32 => 12,  19 => 1,);
    }
}

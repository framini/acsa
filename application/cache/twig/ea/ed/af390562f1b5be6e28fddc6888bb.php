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
    ";
        // line 3
        $this->env->loadTemplate("frr_temp/includes/head.html")->display($context);
        // line 4
        echo "    <body>
    
        ";
        // line 6
        $this->env->loadTemplate("frr_temp/includes/menu.html")->display($context);
        // line 7
        echo "        
        <div class=\"container\">
            <div id=\"wrapper\">
                <div class=\"row-fluid\">
        \t\t\t
                    <div class=\"hero-unit masthead\">
\t\t\t\t\t\t";
        // line 13
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["contenido_home"]) ? $context["contenido_home"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["entrada"]) {
            // line 14
            echo "\t\t\t\t\t\t\t<h1> ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "titulo"), "html", null, true);
            echo " </h1>
\t\t\t\t\t\t\t<p> ";
            // line 15
            echo $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "contenido");
            echo " </p>
\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entrada'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 17
        echo "                      <!--<h1>Hello, world!</h1>
                      <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
                      <p><a class=\"btn btn-primary btn-large\">Learn more</a></p>-->
                    </div><!--hero unit-->
                    
                    
                    
                    <ul class=\"thumbnails\">
                    \t
                      ";
        // line 26
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["contenido_home_items"]) ? $context["contenido_home_items"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["entrada"]) {
            // line 27
            echo "                      \t";
            if ($this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "imagen_item")) {
                // line 28
                echo "\t                      <li class=\"span4\">
\t                        <div class=\"thumbnail\">
\t                          <img src=\"http://placehold.it/300x200\" alt=\"\">
\t                          <div class=\"caption\">
\t                            <h3>";
                // line 32
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "titulo"), "html", null, true);
                echo "</h3>
\t                            <p>";
                // line 33
                echo twig_escape_filter($this->env, Twig::longitud_max($this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "contenido"), 140), "html", null, true);
                echo "</p>
                                <p class='center'><a href=\"";
                // line 34
                echo twig_escape_filter($this->env, Twig::url_sitio("articulos/item", $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "entry_id")), "html", null, true);
                echo "\" class=\"btn btn-small btn-primary\">ver más</a></p>
\t                          </div>
\t                        </div>
\t                      </li>
                      \t";
            }
            // line 39
            echo "                      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entrada'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 40
        echo "                    </ul>
                    
                </div>
            </div><!--wrapper-->
        </div><!--container main-->
        
        ";
        // line 46
        $this->env->loadTemplate("frr_temp/includes/footer.html")->display($context);
        // line 47
        echo "        
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
        return array (  112 => 47,  110 => 46,  102 => 40,  96 => 39,  88 => 34,  84 => 33,  80 => 32,  74 => 28,  71 => 27,  67 => 26,  56 => 17,  48 => 15,  43 => 14,  39 => 13,  31 => 7,  29 => 6,  25 => 4,  23 => 3,  19 => 1,);
    }
}

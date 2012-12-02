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
        if (isset($context["contenido_home"])) { $_contenido_home_ = $context["contenido_home"]; } else { $_contenido_home_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_contenido_home_);
        foreach ($context['_seq'] as $context["_key"] => $context["entrada"]) {
            // line 14
            echo "\t\t\t\t\t\t\t<h1> ";
            if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_entrada_, "titulo"), "html", null, true);
            echo " </h1>
\t\t\t\t\t\t\t<p> ";
            // line 15
            if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
            echo $this->getAttribute($_entrada_, "contenido");
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
                      ";
        // line 24
        if (isset($context["contenido_home_items"])) { $_contenido_home_items_ = $context["contenido_home_items"]; } else { $_contenido_home_items_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_contenido_home_items_);
        foreach ($context['_seq'] as $context["_key"] => $context["entrada"]) {
            // line 25
            echo "                      \t";
            if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
            if ($this->getAttribute($_entrada_, "imagen_item")) {
                // line 26
                echo "\t                      <li class=\"span4\">
\t                        <div class=\"thumbnail\">
\t                          <img src=\"http://placehold.it/300x200\" alt=\"\">
\t                          <div class=\"caption\">
\t                            <h3>";
                // line 30
                if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_entrada_, "titulo"), "html", null, true);
                echo "</h3>
\t                            <p>";
                // line 31
                if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
                echo twig_escape_filter($this->env, Twig::longitud_max($this->getAttribute($_entrada_, "contenido"), 140), "html", null, true);
                echo "</p>
                                <p class='center'><a href=\"";
                // line 32
                if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
                echo twig_escape_filter($this->env, Twig::url_sitio("main/item", $this->getAttribute($_entrada_, "entry_id")), "html", null, true);
                echo "\" class=\"btn btn-small btn-primary\">ver más</a></p>
\t                          </div>
\t                        </div>
\t                      </li>
                      \t";
            }
            // line 37
            echo "                      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entrada'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 38
        echo "                    </ul>
                    
                </div>
            </div><!--wrapper-->
        </div><!--container main-->
        
        ";
        // line 44
        $this->env->loadTemplate("frr_temp/includes/footer.html")->display($context);
        // line 45
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
        return array (  118 => 45,  116 => 44,  108 => 38,  102 => 37,  93 => 32,  88 => 31,  83 => 30,  77 => 26,  73 => 25,  68 => 24,  59 => 17,  50 => 15,  44 => 14,  39 => 13,  31 => 7,  29 => 6,  25 => 4,  23 => 3,  19 => 1,);
    }
}

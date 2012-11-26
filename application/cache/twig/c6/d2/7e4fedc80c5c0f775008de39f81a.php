<?php

/* frr_temp/articulos/item.html */
class __TwigTemplate_c6d27e4fedc80c5c0f775008de39f81a extends Twig_Template
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

                    
                        
                      ";
        // line 14
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["contenido_home_items"]) ? $context["contenido_home_items"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["entrada"]) {
            // line 15
            echo "                      \t";
            if ($this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "imagen_item")) {
                // line 16
                echo "                            <div class=\"page-header\">
                                <h1>";
                // line 17
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "titulo"), "html", null, true);
                echo "</h1>
                                <small><span class=\"label label-info\"><small>Por ";
                // line 18
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "autor"), "html", null, true);
                echo " el ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "entry_date"), "html", null, true);
                echo "</small></span></small>
                            </div>
                            
                            <img src=\"";
                // line 21
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "imagen_item"), "html", null, true);
                echo "\" class=\"img-rounded pull-left margin-right-bottom-10\">
                            <p> ";
                // line 22
                echo $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "contenido");
                echo " </p>
                      \t";
            }
            // line 24
            echo "                      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entrada'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 25
        echo "                    
                </div>
            </div><!--wrapper-->
        </div><!--container main-->
        
        ";
        // line 30
        $this->env->loadTemplate("frr_temp/includes/footer.html")->display($context);
        // line 31
        echo "        
    \t<script src=\"http://code.jquery.com/jquery-1.8.2.min.js\"></script>
        <script src=\"http://localhost/argc/index.php/js/bootstrap-min-js\"></script>
    </body>
</html>";
    }

    public function getTemplateName()
    {
        return "frr_temp/articulos/item.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  86 => 31,  84 => 30,  77 => 25,  71 => 24,  66 => 22,  62 => 21,  54 => 18,  50 => 17,  47 => 16,  44 => 15,  40 => 14,  31 => 7,  29 => 6,  25 => 4,  23 => 3,  19 => 1,);
    }
}

<?php

/* frr_temp/main/item.html */
class __TwigTemplate_5fd55f0e0ca81df5fcba6cd6ef24adad extends Twig_Template
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
                echo "                            <h2>";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "titulo"), "html", null, true);
                echo "</h2>
                            <p class=\"text-info\"><span class=\"label label-info\"><small>Por ";
                // line 17
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "autor"), "html", null, true);
                echo " el ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "entry_date"), "html", null, true);
                echo "</small></span></p>
                            <img src=\"";
                // line 18
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "imagen_item"), "html", null, true);
                echo "\" class=\"img-rounded pull-left margin-right-bottom-10\">
                            <p> ";
                // line 19
                echo $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "contenido");
                echo " </p>
                      \t";
            }
            // line 21
            echo "                      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entrada'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 22
        echo "                    
                </div>
            </div><!--wrapper-->
        </div><!--container main-->
        
        ";
        // line 27
        $this->env->loadTemplate("frr_temp/includes/footer.html")->display($context);
        // line 28
        echo "        
    \t<script src=\"http://code.jquery.com/jquery-1.8.2.min.js\"></script>
        <script src=\"http://localhost/argc/index.php/js/bootstrap-min-js\"></script>
    </body>
</html>";
    }

    public function getTemplateName()
    {
        return "frr_temp/main/item.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  82 => 28,  80 => 27,  73 => 22,  67 => 21,  62 => 19,  58 => 18,  52 => 17,  47 => 16,  44 => 15,  40 => 14,  31 => 7,  29 => 6,  25 => 4,  23 => 3,  19 => 1,);
    }
}

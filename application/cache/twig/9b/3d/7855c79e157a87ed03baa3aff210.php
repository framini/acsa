<?php

/* frr_temp/templates_base/item.html */
class __TwigTemplate_9b3d7855c79e157a87ed03baa3aff210 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'contenido' => array($this, 'block_contenido'),
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
        echo "    ";
        $this->displayBlock('head', $context, $blocks);
        // line 7
        echo "    <body>
    
        ";
        // line 9
        $this->env->loadTemplate("frr_temp/includes/menu.html")->display($context);
        // line 10
        echo "        <div class=\"container\">
            <div id=\"wrapper\">
                <div class=\"row-fluid\">

                    ";
        // line 14
        $this->displayBlock('contenido', $context, $blocks);
        // line 15
        echo "                    
                </div>
            </div><!--wrapper-->
        </div><!--container main-->
        ";
        // line 19
        $this->env->loadTemplate("frr_temp/includes/footer.html")->display($context);
        // line 20
        echo "        
        <script src=\"http://code.jquery.com/jquery-1.8.2.min.js\"></script>
        <script src=\"http://localhost/argc/index.php/js/bootstrap-min-js\"></script>
    </body>
</html>";
    }

    // line 4
    public function block_head($context, array $blocks = array())
    {
        // line 5
        echo "        <title>";
        $this->displayBlock('title', $context, $blocks);
        echo " - TDC/TDP 2012</title>
    ";
    }

    public function block_title($context, array $blocks = array())
    {
    }

    // line 14
    public function block_contenido($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "frr_temp/templates_base/item.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  75 => 14,  61 => 4,  53 => 20,  45 => 15,  43 => 14,  37 => 10,  31 => 7,  28 => 4,  26 => 3,  22 => 1,  98 => 35,  84 => 27,  78 => 24,  72 => 23,  68 => 21,  64 => 5,  58 => 17,  56 => 16,  51 => 19,  47 => 12,  38 => 5,  35 => 9,  29 => 2,);
    }
}

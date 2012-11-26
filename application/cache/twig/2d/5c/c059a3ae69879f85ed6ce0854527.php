<?php

/* frr_temp/templates_base/item2.html */
class __TwigTemplate_2d5cc059a3ae69879f85ed6ce0854527 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
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
        echo "        
        <div class=\"container\">
            <div id=\"wrapper\">
                <div class=\"row-fluid\">

                    ";
        // line 15
        $this->displayBlock('content', $context, $blocks);
        // line 16
        echo "                    
                </div>
            </div><!--wrapper-->
        </div><!--container main-->
        
        ";
        // line 21
        $this->env->loadTemplate("frr_temp/includes/footer.html")->display($context);
        // line 22
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

    // line 15
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "frr_temp/templates_base/item2.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  77 => 15,  66 => 5,  63 => 4,  55 => 22,  53 => 21,  46 => 16,  44 => 15,  37 => 10,  35 => 9,  31 => 7,  28 => 4,  26 => 3,  22 => 1,);
    }
}

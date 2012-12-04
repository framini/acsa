<?php

/* frr_temp/etster/item.html */
class __TwigTemplate_69300e5ad79ca535056b4ddbf4d345aa extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("frr_temp/templates_base/item.html");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'contenido' => array($this, 'block_contenido'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "frr_temp/templates_base/item.html";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        echo " ";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["contenido_home_items"]) ? $context["contenido_home_items"] : null), "", array(), "array"), "titulo"), "html", null, true);
        echo " ";
    }

    // line 4
    public function block_contenido($context, array $blocks = array())
    {
        // line 5
        echo "        
      
                        
      ";
        // line 8
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["contenido_home_items"]) ? $context["contenido_home_items"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["entrada"]) {
            // line 9
            echo "          ";
            if ($this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "imagen_item")) {
                // line 10
                echo "            <div class=\"page-header\">
                <h1>";
                // line 11
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "titulo"), "html", null, true);
                echo "</h1>
                <small><span class=\"label label-info\"><small>Por ";
                // line 12
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "autor"), "html", null, true);
                echo " el ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "entry_date"), "html", null, true);
                echo "</small></span></small>
            </div>
            
            <img src=\"";
                // line 15
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "imagen_item"), "html", null, true);
                echo "\" class=\"img-rounded pull-left margin-right-bottom-10\">
            <p> ";
                // line 16
                echo $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "contenido");
                echo " </p>
          ";
            }
            // line 18
            echo "      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entrada'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 19
        echo "      
";
    }

    public function getTemplateName()
    {
        return "frr_temp/etster/item.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  82 => 19,  76 => 18,  71 => 16,  67 => 15,  59 => 12,  55 => 11,  52 => 10,  49 => 9,  45 => 8,  40 => 5,  37 => 4,  29 => 2,);
    }
}

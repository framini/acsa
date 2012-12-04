<?php

/* frr_temp/noticias/item.html */
class __TwigTemplate_09decc9c0e93f7e30a1855e44c97d7ce extends Twig_Template
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
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["noticias"]) ? $context["noticias"] : null), "19", array(), "array"), "titulo"), "html", null, true);
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
        $context['_seq'] = twig_ensure_traversable((isset($context["noticias"]) ? $context["noticias"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["entrada"]) {
            // line 9
            echo "            <div class=\"page-header\">
                <h1>";
            // line 10
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "titulo"), "html", null, true);
            echo "</h1>
                <small><span class=\"label label-info\"><small>Por ";
            // line 11
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "autor"), "html", null, true);
            echo " el ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "entry_date"), "html", null, true);
            echo "</small></span></small>
            </div>
            
            <img src=\"";
            // line 14
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "imagen_item"), "html", null, true);
            echo "\" class=\"img-rounded pull-left margin-right-bottom-10\">
            <p> ";
            // line 15
            echo $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "cuerpo_noticia");
            echo " </p>
      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entrada'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 17
        echo "      
";
    }

    public function getTemplateName()
    {
        return "frr_temp/noticias/item.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  76 => 17,  68 => 15,  64 => 14,  56 => 11,  52 => 10,  49 => 9,  45 => 8,  40 => 5,  37 => 4,  29 => 2,);
    }
}

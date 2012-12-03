<?php

/* frr_temp/articulos/item.html */
class __TwigTemplate_c6d27e4fedc80c5c0f775008de39f81a extends Twig_Template
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
        if (isset($context["contenido_home_items"])) { $_contenido_home_items_ = $context["contenido_home_items"]; } else { $_contenido_home_items_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($_contenido_home_items_, "14", array(), "array"), "titulo"), "html", null, true);
        echo " ";
    }

    // line 4
    public function block_contenido($context, array $blocks = array())
    {
        // line 5
        echo "        
      
                        
      ";
        // line 8
        if (isset($context["articulos"])) { $_articulos_ = $context["articulos"]; } else { $_articulos_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_articulos_);
        foreach ($context['_seq'] as $context["_key"] => $context["entrada"]) {
            // line 9
            echo "          ";
            if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
            if ($this->getAttribute($_entrada_, "articulos_imagen")) {
                // line 10
                echo "            <div class=\"page-header\">
                <h1>";
                // line 11
                if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_entrada_, "titulo"), "html", null, true);
                echo "</h1>
                <small><span class=\"label label-info\"><small>Por ";
                // line 12
                if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_entrada_, "autor"), "html", null, true);
                echo " el ";
                if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_entrada_, "entry_date"), "html", null, true);
                echo "</small></span></small>
            </div>
            
            <img src=\"";
                // line 15
                if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_entrada_, "imagen_item"), "html", null, true);
                echo "\" class=\"img-rounded pull-left margin-right-bottom-10\">
            <p> ";
                // line 16
                if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
                echo $this->getAttribute($_entrada_, "articulos_contenido");
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
        return "frr_temp/articulos/item.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  90 => 19,  84 => 18,  78 => 16,  73 => 15,  63 => 12,  58 => 11,  55 => 10,  51 => 9,  46 => 8,  41 => 5,  38 => 4,  29 => 2,);
    }
}

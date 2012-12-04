<?php

/* frr_temp/noticias/index.html */
class __TwigTemplate_2816c1fda405b1fb760fde1ee997f3c0 extends Twig_Template
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
        echo " Listado de Noticias ";
    }

    // line 4
    public function block_contenido($context, array $blocks = array())
    {
        // line 5
        echo "          
      
      
      <div class=\"page-header\">
        <h1>Noticias</h1>
      </div>
                        
      ";
        // line 12
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["noticias"]) ? $context["noticias"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["entrada"]) {
            // line 13
            echo "          
            <div class=\"media well well-small\">
              <a class=\"pull-left\" href=\"#\">
                ";
            // line 16
            if ($this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "imagen_noticias")) {
                // line 17
                echo "                <img class=\"media-object\" src=\"";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "imagen_noticias"), "html", null, true);
                echo "\" width=\"120\" height=\"120\" />
                ";
            } else {
                // line 19
                echo "                <img class=\"media-object\" src=\"http://placehold.it/120x120\">
                ";
            }
            // line 21
            echo "              </a>
              <div class=\"media-body\">
                <h4 class=\"media-heading\"><a href=\"";
            // line 23
            echo twig_escape_filter($this->env, Twig::url_sitio("main/item", $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "entry_id")), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "titulo"), "html", null, true);
            echo "</a></h4>
                ";
            // line 24
            echo twig_escape_filter($this->env, Twig::longitud_max($this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "cuerpo_noticia"), 140), "html", null, true);
            echo "
                <div class=\"row\">
                    <div class=\"span12\">
                        <a class=\"btn btn-mini btn-info pull-right\" href=\"";
            // line 27
            echo twig_escape_filter($this->env, Twig::url_sitio("articulos/item", $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "entry_id")), "html", null, true);
            echo "\">ver más</a>
                    </div>
                </div>
                  
              </div>
            </div>
          
      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entrada'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 35
        echo "      
";
    }

    public function getTemplateName()
    {
        return "frr_temp/noticias/index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  98 => 35,  84 => 27,  78 => 24,  72 => 23,  68 => 21,  64 => 19,  58 => 17,  56 => 16,  51 => 13,  47 => 12,  38 => 5,  35 => 4,  29 => 2,);
    }
}

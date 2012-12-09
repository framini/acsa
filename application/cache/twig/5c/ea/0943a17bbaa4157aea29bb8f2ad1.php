<?php

/* frr_temp/noticias/.html */
class __TwigTemplate_5cea0943a17bbaa4157aea29bb8f2ad1 extends Twig_Template
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
        if (isset($context["noticias"])) { $_noticias_ = $context["noticias"]; } else { $_noticias_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_noticias_);
        foreach ($context['_seq'] as $context["_key"] => $context["entrada"]) {
            // line 13
            echo "          
            <div class=\"media well well-small\">
              <a class=\"pull-left\" href=\"#\">
                ";
            // line 16
            if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
            if ($this->getAttribute($_entrada_, "imagen_noticias")) {
                // line 17
                echo "                <img class=\"media-object\" src=\"";
                if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_entrada_, "imagen_noticias"), "html", null, true);
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
            if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
            echo twig_escape_filter($this->env, Twig::url_sitio("noticias/item", $this->getAttribute($_entrada_, "entry_id")), "html", null, true);
            echo "\">";
            if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_entrada_, "titulo"), "html", null, true);
            echo "</a></h4>
                ";
            // line 24
            if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
            echo twig_escape_filter($this->env, Twig::longitud_max($this->getAttribute($_entrada_, "cuerpo_noticia"), 140), "html", null, true);
            echo "
                <div class=\"row\">
                    <div class=\"span12\">
                        <a class=\"btn btn-mini btn-info pull-right\" href=\"";
            // line 27
            if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
            echo twig_escape_filter($this->env, Twig::url_sitio("noticias/item", $this->getAttribute($_entrada_, "entry_id")), "html", null, true);
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
        return "frr_temp/noticias/.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 35,  90 => 27,  83 => 24,  75 => 23,  71 => 21,  67 => 19,  60 => 17,  57 => 16,  52 => 13,  47 => 12,  38 => 5,  35 => 4,  29 => 2,);
    }
}

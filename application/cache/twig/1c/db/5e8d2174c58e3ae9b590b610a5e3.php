<?php

/* frr_temp/includes/menu.html */
class __TwigTemplate_1cdb5e8d2174c58e3ae9b590b610a5e3 extends Twig_Template
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
        echo "<div class=\"container main-menu\">
    <div class=\"row\">
        <div class=\"navigation\">
            <div class=\"navbar navbar-inverse\">
              <div class=\"navbar-inner\">
                <a class=\"brand\" href=\"";
        // line 6
        echo twig_escape_filter($this->env, Twig::url_sitio("main/home"), "html", null, true);
        echo "\">TDC/TDD 2012</a>
                <ul class=\"nav\">
                  <li ";
        // line 8
        if (("" == "home")) {
            echo " class=\"active\" ";
        }
        echo ">
                    <a href=\"";
        // line 9
        echo twig_escape_filter($this->env, Twig::url_sitio("main/home"), "html", null, true);
        echo "\">Home</a>
                  </li>
                  <li>
                    <a href=\"";
        // line 12
        echo twig_escape_filter($this->env, Twig::url_sitio("articulos/"), "html", null, true);
        echo "\">Articulos</a>
                  </li>
                  <li>
                   <a href=\"";
        // line 15
        echo twig_escape_filter($this->env, Twig::url_sitio("noticias/"), "html", null, true);
        echo "\">Noticias</a>
                  </li>
                </ul>
              </div>
            </div>
        </div>
    </div><!---row-->
</div><!--header container -->";
    }

    public function getTemplateName()
    {
        return "frr_temp/includes/menu.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  49 => 15,  19 => 1,  75 => 14,  61 => 4,  53 => 20,  45 => 15,  43 => 12,  37 => 9,  31 => 8,  28 => 4,  26 => 6,  22 => 1,  98 => 35,  84 => 27,  78 => 24,  72 => 23,  68 => 21,  64 => 5,  58 => 17,  56 => 16,  51 => 19,  47 => 12,  38 => 5,  35 => 9,  29 => 2,);
    }
}

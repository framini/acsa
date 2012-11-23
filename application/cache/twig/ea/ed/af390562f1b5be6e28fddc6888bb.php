<?php

/* frr_temp/main/home.html */
class __TwigTemplate_eaedaf390562f1b5be6e28fddc6888bb extends Twig_Template
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
    <head>
        <meta charset=\"utf-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
        <title></title>
        <meta name=\"description\" content=\"\">
        <link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"http://localhost/argc/index.php/css/bootstrap\" />
        <link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"http://localhost/argc/index.php/css/custom\" />
    </head>
    <body>
        <div class=\"container main-menu\">
            <div class=\"row\">
                <div class=\"navigation\">
                    <div class=\"navbar navbar-inverse\">
                      <div class=\"navbar-inner\">
                        <a class=\"brand\" href=\"#\">TDC/TDD 2012</a>
                        <ul class=\"nav\">
                          <li class=\"active\"><a href=\"#\">Home</a></li>
                          <li><a href=\"#\">Link</a></li>
                          <li><a href=\"#\">Link</a></li>
                        </ul>
                      </div>
                    </div>
                </div>
            </div><!---row-->
        </div><!--header container -->
        
        <div class=\"container\">
            <div id=\"wrapper\">
                <div class=\"row-fluid\">
    \t\t\t\t
                    <div class=\"hero-unit\">
\t\t\t\t\t\t";
        // line 34
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["contenido_home"]) ? $context["contenido_home"] : null));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        foreach ($context['_seq'] as $context["_key"] => $context["entrada"]) {
            if (($this->getAttribute((isset($context["loop"]) ? $context["loop"] : null), "index") < 4)) {
                // line 35
                echo "\t\t\t\t\t\t\t<h1> ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "titulo"), "html", null, true);
                echo " </h1>
\t\t\t\t\t\t\t<p> ";
                // line 36
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entrada"]) ? $context["entrada"] : null), "contenido"), "html", null, true);
                echo " </p>
\t\t\t\t\t\t";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entrada'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 38
        echo "                      <!--<h1>Hello, world!</h1>
                      <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
                      <p><a class=\"btn btn-primary btn-large\">Learn more</a></p>-->
                    </div><!--hero unit-->
                    
                    <ul class=\"thumbnails\">
                      <li class=\"span4\">
                        <div class=\"thumbnail\">
                          <img src=\"http://placehold.it/300x200\" alt=\"\">
                          <div class=\"caption\">
                            <h3>Thumbnail label</h3>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                            <p><a href=\"#\" class=\"btn btn-primary\">Action</a> <a href=\"#\" class=\"btn\">Action</a></p>
                          </div>
                        </div>
                      </li>
                      
                      <li class=\"span4\">
                        <div class=\"thumbnail\">
                          <img src=\"http://placehold.it/300x200\" alt=\"\">
                          <div class=\"caption\">
                            <h3>Thumbnail label</h3>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                            <p><a href=\"#\" class=\"btn btn-primary\">Action</a> <a href=\"#\" class=\"btn\">Action</a></p>
                          </div>
                        </div>
                      </li>
                      
                     <li class=\"span4\">
                        <div class=\"thumbnail\">
                          <img src=\"http://placehold.it/300x200\" alt=\"\">
                          <div class=\"caption\">
                            <h3>Thumbnail label</h3>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                            <p><a href=\"#\" class=\"btn btn-primary\">Action</a> <a href=\"#\" class=\"btn\">Action</a></p>
                          </div>
                        </div>
                      </li>
                      
                    </ul>
                    
                </div>
            </div><!--wrapper-->
        </div><!--container main-->
        
    \t<script src=\"http://code.jquery.com/jquery-1.8.2.min.js\"></script>
        <script src=\"http://localhost/argc/index.php/js/bootstrap-min-js\"></script>
    </body>
</html>";
    }

    public function getTemplateName()
    {
        return "frr_temp/main/home.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  82 => 38,  70 => 36,  65 => 35,  54 => 34,  19 => 1,);
    }
}

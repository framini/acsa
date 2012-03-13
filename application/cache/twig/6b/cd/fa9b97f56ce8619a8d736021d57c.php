<?php

/* temp/prueba.html */
class __TwigTemplate_6bcdfa9b97f56ce8619a8d736021d57c extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<html>
<head>
<title>
PPPRUEBA
</title>
</head>
<body><div style=\"color:red\">";
        // line 7
        if (isset($context["title"])) { $_title_ = $context["title"]; } else { $_title_ = null; }
        echo twig_escape_filter($this->env, $_title_, "html", null, true);
        echo "</div></body>
</html>";
    }

    public function getTemplateName()
    {
        return "temp/prueba.html";
    }

    public function isTraitable()
    {
        return false;
    }
}

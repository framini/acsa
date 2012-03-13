<?php

/* frr_temp/prueba.html */
class __TwigTemplate_a1a69702d23491868df7e55c4acbe99a extends Twig_Template
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
        return "frr_temp/prueba.html";
    }

    public function isTraitable()
    {
        return false;
    }
}

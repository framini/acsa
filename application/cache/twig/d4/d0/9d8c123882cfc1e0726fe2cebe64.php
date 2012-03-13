<?php

/* prueba.html */
class __TwigTemplate_d4d09d8c123882cfc1e0726fe2cebe64 extends Twig_Template
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
        return "prueba.html";
    }

    public function isTraitable()
    {
        return false;
    }
}

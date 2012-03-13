<?php

/* frr_temp/pruebahtml */
class __TwigTemplate_7ba6c893db65d653f7b80a9c1acb199c extends Twig_Template
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
        return "frr_temp/pruebahtml";
    }

    public function isTraitable()
    {
        return false;
    }
}

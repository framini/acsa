<?php

/* frr_temp/test/prueba.html */
class __TwigTemplate_3f88e44942e444f3a49b9e165a310f0d extends Twig_Template
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
<body><div style=\"color:red\">
<p>sa</p>
";
        // line 9
        $context["entry_id"] = ('' === $tmp = "Sasdasdsaddsa
") ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 12
        if (isset($context["foo"])) { $_foo_ = $context["foo"]; } else { $_foo_ = null; }
        echo twig_escape_filter($this->env, $_foo_, "html", null, true);
        echo "
";
        // line 13
        if (isset($context["entry_id"])) { $_entry_id_ = $context["entry_id"]; } else { $_entry_id_ = null; }
        echo twig_escape_filter($this->env, $_entry_id_, "html", null, true);
        echo "

";
        // line 15
        if (isset($context["contenido_form"])) { $_contenido_form_ = $context["contenido_form"]; } else { $_contenido_form_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_contenido_form_);
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        foreach ($context['_seq'] as $context["_key"] => $context["entrada"]) {
            if (isset($context["loop"])) { $_loop_ = $context["loop"]; } else { $_loop_ = null; }
            if (($this->getAttribute($_loop_, "index") < 4)) {
                // line 16
                echo "        <li>";
                if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_entrada_, "titulo"), "html", null, true);
                echo " - ";
                if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_entrada_, "enlaces"), "html", null, true);
                echo " - ";
                if (isset($context["entrada"])) { $_entrada_ = $context["entrada"]; } else { $_entrada_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_entrada_, "autores"), "html", null, true);
                echo "</li>
    ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entrada'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 18
        echo "</div>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "frr_temp/test/prueba.html";
    }

    public function isTraitable()
    {
        return false;
    }
}

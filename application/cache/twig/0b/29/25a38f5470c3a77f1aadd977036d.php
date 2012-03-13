<?php

/* welcome_message.php */
class __TwigTemplate_0b2925a38f5470c3a77f1aadd977036d extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "

 <div class=\"block\">
\t\t\t
\t\t\t\t<div class=\"block_head\">
\t\t\t\t\t<div class=\"bheadl\"></div>
\t\t\t\t\t<div class=\"bheadr\"></div>
\t\t\t\t\t
\t\t\t\t\t<h2>";
        // line 9
        if (isset($context["title"])) { $_title_ = $context["title"]; } else { $_title_ = null; }
        echo twig_escape_filter($this->env, $_title_, "html", null, true);
        echo "</h2>
\t\t\t\t</div>\t\t
                                                                        <!-- .block_head ends -->
\t\t\t\t
\t\t\t\t
\t\t\t\t
\t\t\t\t<div class=\"block_content\">
                                                                              <p>The page you are looking at is being generated dynamically by CodeIgniter.</p>

<p>If you would like to edit this page you'll find it located at:</p>
<code>application/views/welcome_message.php</code>

<p>The corresponding controller for this page is found at:</p>
<code>application/controllers/welcome.php</code>

<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href=\"user_guide/\">User Guide</a>.</p>

<?php echo \$una['hola']; ?>
\t\t\t\t</div>\t\t
                                                                        <!-- .block_content ends -->
\t\t\t\t
\t\t\t\t<div class=\"bendl\"></div>
\t\t\t\t<div class=\"bendr\"></div>
\t\t\t\t\t
\t\t\t</div>\t\t
                <!-- .block ends -->


";
    }

    public function getTemplateName()
    {
        return "welcome_message.php";
    }

    public function isTraitable()
    {
        return false;
    }
}

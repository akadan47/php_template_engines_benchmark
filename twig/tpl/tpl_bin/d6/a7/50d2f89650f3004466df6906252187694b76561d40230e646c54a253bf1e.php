<?php

/* main.tpl */
class __TwigTemplate_d6a750d2f89650f3004466df6906252187694b76561d40230e646c54a253bf1e extends Twig_Template
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
<html>
<head>
    <title></title>
</head>
<body>
";
        // line 7
        echo (isset($context["data"]) ? $context["data"] : null);
        echo "
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "main.tpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  27 => 7,  19 => 1,);
    }
}

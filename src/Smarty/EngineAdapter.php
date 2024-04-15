<?php
namespace HexMakina\kadroPlugin\Smarty;

use \Smarty;

class EngineAdapter implements \HexMakina\BlackBox\Templating\EngineInterface
{
    private $smarty;
    private $primary_template_directory = null;

    public function __construct($settings)
    {
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir($settings['smarty']['template_path']);
        $this->smarty->setCompileDir($settings['smarty']['compiled_path']);
        $this->smarty->setCacheDir($settings['smarty']['compiled_path']);
        $this->smarty->setConfigDir($settings['smarty']['compiled_path']);
        $this->smarty->setCaching($settings['smarty']['debug']);
        $this->smarty->setDebugging($settings['smarty']['debug']);
    }

    public function render($template, $data = []): string
    {
        foreach ($data as $template_var_name => $value) {
            $this->smarty->assign($template_var_name, $value);
        }

        return $this->smarty->fetch($template);
    }

    public function locate(string $template): string
    {
        return $this->smarty->templateExists($template);
    }

    public function exists(string $template): bool
    {
        return $this->smarty->templateExists($template);
    }

    public function addDirectory(string $path)
    {
        if($this->primary_template_directory === null)
        {
            $this->primary_template_directory = $path;
            $this->smarty->setTemplateDir($path);
        }
        else
        {
            $this->smarty->addTemplateDir($path);
        }
    }

    public function assign(string $key, $value)
    {
        $this->smarty->assign($key, $value);
    }

    public function assignAssoc($assoc)
    {
        foreach ($assoc as $key => $value) {
            $this->smarty->assign($key, $value);
        }
    }

    public function registerClass($class_alias, $namespaced_class)
    {
        $this->smarty->registerClass($class_alias, $namespaced_class);
    }

    public function registerFunction($function_alias, $function)
    {
        $this->smarty->registerFunction($function_alias, $function);
    }
}
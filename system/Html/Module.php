<?php 

namespace Scaffold\Html;

/**
 * The base Scaffold Module
 */
class Module
{
    /**
     * The name of the template which this
     * module renders.
     * 
     * @var string
     */
    protected $template;

    /**
     * Does this template need to render?
     * 
     * @var boolean
     */
    protected $shouldRender = true;

    /**
     * The arguments for this module to be passed
     * to the template.
     * 
     * @var array
     */
    protected $arguments = [];

    /**
     * Construct our module.
     *
     * @param array $arguments
     * @return void
     */
    public function __construct($arguments = [])
    {
        $this->arguments = array_merge($this->arguments, $arguments);
        $this->before();

        if ($this->shouldRender) {
            $this->render();
        }

        $this->after();
    }

    /**
     * Called before the template has been
     * rendered.
     * 
     * @return void
     */
    public function before()
    {
    }

    /**
     * Called after the template has been 
     * rendered.
     * 
     * @return void
     */
    public function after()
    {   
    }

    /**
     * Handle rendering the template.
     * 
     * @return void
     */
    private function render()
    {
        $template = new Template('modules/' . $this->template, $this->arguments);

        echo $template->render();
    }

}
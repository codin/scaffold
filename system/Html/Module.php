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
     * Is this module cacheable?
     * 
     * @var boolean
     */
    protected $cacheable = false;

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
        $path = module_path() . '/' . $this->template;

        if ($this->cacheable) {
            $output = $this->getCached($path);
        }
        
        if (!$output) {
            $template = new Template($path, $this->arguments);
            $output = $this->setCached($path, $template->render());
        }

        echo $output;
    }

    /**
     * Get the cached module file based on the path
     * 
     * @param  string $path
     * @return string|boolean
     */
    private function getCached($path)
    {
        return cache()->get($path);
    }

    /**
     * Set the cached key for this modules
     * path to be an output.
     * 
     * @param string $path
     * @param string $output
     */
    private function setCached($path, $output)
    {
        cache()->set($path, $output);
        return $output;
    }

}
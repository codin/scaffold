<?php 

namespace Scaffold\Html;

/**
 * Handle loading templates into the system, parsing them
 * and returning the response.
 */
class Template
{   
    /**
     * Holds the templating engine instance
     * 
     * @var PhpEngine
     */
    protected $templater;

    /**
     * The name of the view to render
     * 
     * @var string
     */
    protected $name;

    /**
     * The arguments passed to the view
     * 
     * @var array
     */
    protected $arguments;

    /**
     * Construct our new template taking in
     * the name of the template we wish to
     * load.
     * 
     * @param string $name
     * @param array $arguments
     */
    public function __construct($name, array $arguments)
    {
        $this->templater = container('templater');
        $this->name = $name;
        $this->arguments = $arguments;
    }

    /**
     * Render the template
     * 
     * @return string
     */
    public function render()
    {
        return $this->templater->render($this->name, $this->arguments);
    }
}
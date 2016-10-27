<?php 

namespace Scaffold\Http;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Extend the existing response class so that we can
 * handle rending specific content types, processing
 * our templates etc.
 */
class Response extends SymfonyResponse
{

}
<?php
declare(strict_types=1);

namespace Nerdery\Action;

use Doctrine\ORM\EntityManager;
use Parsedown;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class Index
 * @package Nerdery\Action
 */
class Index
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * Constructor
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Request  $request
     * @param Response $response
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        $markdown = file_get_contents('README.md');

        /** @var Parsedown $parser */
        $parser = new Parsedown();
        $content = $parser->text($markdown);

        $response->getBody()->write($content);
        return $response;
    }
}
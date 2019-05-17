<?php
declare(strict_types=1);

namespace Nerdery\Action;

use Doctrine\ORM\EntityManager;
use Nerdery\Domain\User;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class ListUsers
 * @package Nerdery\Action
 */
class ListUsers
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
        try {
            /** @var User[] $users */
            $users = $this->em->getRepository(User::class)->findAll();
        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response->withJson($users, StatusCode::HTTP_OK);
    }
}
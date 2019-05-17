<?php
declare(strict_types=1);

namespace Nerdery\Action;

use Doctrine\ORM\EntityManager;
use Nerdery\Domain\User;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class CreateUser
 * @package Nerdery\Action
 */
class CreateUser
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
        $firstName = $request->getParsedBodyParam('first_name');
        $lastName = $request->getParsedBodyParam('last_name');
        $email = $request->getParsedBodyParam('email');
        $image = $request->getParsedBodyParam('image');

        /** @var User $user */
        $user = new User($firstName, $lastName, $email, $image);

        try {
            $this->em->persist($user);
            $this->em->flush();
        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response->withJson($user, StatusCode::HTTP_CREATED);
    }
}
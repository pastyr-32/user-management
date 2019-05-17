<?php
declare(strict_types=1);

namespace Nerdery\Action;

use Doctrine\ORM\EntityManager;
use Nerdery\Domain\User;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class UpdateUser
 * @package Nerdery\Action
 */
class UpdateUser
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
        $id = (int)$request->getAttribute('id');
        $firstName = $request->getParsedBodyParam('first_name');
        $lastName = $request->getParsedBodyParam('last_name');
        $email = $request->getParsedBodyParam('email');
        $image = $request->getParsedBodyParam('image');

        try {
            /** @var User|null $user */
            $user = $this->em->getRepository(User::class)->find($id);

            if (null === $user) {
                return $response->withStatus(StatusCode::HTTP_BAD_REQUEST);
            }

            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setEmail($email);
            $user->setImage($image);

            $this->em->persist($user);
            $this->em->flush();
        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response->withJson($user, StatusCode::HTTP_OK);
    }
}
<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiController extends AbstractController
{
    private $userRepository;
    private $em;
    private $serializer;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em, SerializerInterface $serializer, RequestStack $request)
    {   
        $this->userRepository = $userRepository;
        $this->em = $em;
        $this->serializer = $serializer;
    }

    #[Route('/account', name: 'app_user', methods: 'post')]
    public function post(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();

        $user->setEmail($data['email']);
        $user->setPassword($data['password']);

        $this->em->persist($user);
        $this->em->flush();

        $jsonContent = $this->serializer->serialize($user, 'json', SerializationContext::create()->setGroups(array('user:add')));

        return new Response($jsonContent, '201', [
            "Content-Type' => 'application/json"
        ]);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/account/{uid}', name: 'app_user_get', methods: 'get')]
    //#[Entity('post', options: ['id' => 'post_id'])]
    #[ParamConverter('user', options: ['mapping' => ['uid' => 'id']])]
    public function get(User $user, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['id' => $user]);
        $jsonContent = $this->serializer->serialize($user, 'json', SerializationContext::create()->setGroups(array('user:single')));

        return new Response($jsonContent, '200', [
            "Content-Type' => 'application/json"
        ]);
    }

    #[Route('/account/{uid}', name: 'app_user_put', methods: 'put')]
    #[ParamConverter('user', options: ['mapping' => ['uid' => 'id']])]
    public function put(User $user, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = $this->userRepository->findOneBy(['id' => $user]);

        if($user) {

            foreach($data as $key => $value) {

                if(!$key === 'password') {
                    $user->{'set'.ucfirst($key)}($value);
                    $this->em->persist($user);
                }

                $hashedPassword = $passwordHasher->hashPassword(
                    $user,
                    $value
                );
                $user->setPassword($hashedPassword);
                $this->em->persist($user);
            }

            $this->serializer->serialize($user, 'json', SerializationContext::create()->setGroups(array('user:put')));

            $this->em->flush();
            
            return new Response('L\'utilisateur a été modifié', '200', [
                "Content-Type' => 'application/json"
            ]);
        }

        return new Response('L\'utilisateur n\'a pas été trouvé', '404', [
            "Content-Type' => 'application/json"
        ]);
    }
}

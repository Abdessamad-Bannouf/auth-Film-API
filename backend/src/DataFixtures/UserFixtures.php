<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\Internet;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public $passwordHasher;
    
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');
        $roles = [
                    ['ROLE_USER'],
                    ['ROLE_ADMIN']
        ];

        // Créer 20 customers
        for ($i=0; $i<20; $i++)
        {
            if($i === 19) {
                $user = new User();
                $hashPassword = $this->passwordHasher->hashPassword($user, 'test1234');
    
                $user->setEmail('abdessamad.bannouf@laposte.net')
                    ->setRoles($roles[1])
                    ->setPassword($hashPassword);
    
                $manager->persist($user);

                break;
            }

            $user = new User();
            $hashPassword = $this->passwordHasher->hashPassword($user, 'password');

            $user->setEmail($faker->email)
                ->setRoles($roles[rand(0,1)])
                ->setPassword($hashPassword);

            $manager->persist($user);
        }
        
        $manager->flush();
    }
}
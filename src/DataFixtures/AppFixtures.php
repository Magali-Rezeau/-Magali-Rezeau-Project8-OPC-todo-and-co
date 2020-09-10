<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        
        $user  = new User();
        $user->setEmail($faker->email);
        $user->setUsername($faker->userName);
        $user->setPassword($this->encoder->encodePassword($user, 'password'));
        $user->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);

        $user1 = new User();
        $user1->setEmail($faker->email);
        $user1->setUsername($faker->userName);
        $user1->setPassword($this->encoder->encodePassword($user, 'password'));
        $user1->setRoles(["ROLE_USER"]);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail($faker->email);
        $user2->setUsername($faker->userName);
        $user2->setPassword($this->encoder->encodePassword($user, 'password'));
        $user2->setRoles(["ROLE_ANONYMOUS"]);
        $manager->persist($user2);



        for($i=0; $i<20; $i++){
            $users = [ $user, $user1, $user2];
            $task  = new Task();
            $task->setTitle('Tache : '. $i);
            $task->setContent($faker->text(200));
            $task->setCreatedAt($faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'));
            $task->setAuthor($faker->randomElement($users));
            $task->isDone($faker->boolean());
            $manager->persist($task);
        }
        $manager->flush();
    }
}

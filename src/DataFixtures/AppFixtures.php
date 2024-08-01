<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct( private UserPasswordHasherInterface $hasher)
    {
        $this->faker = Factory::create('fr_FR');
        
    }

    public function load(ObjectManager $manager): void
    {
        // Users
        $users = [];

        $admin = new Users();
        $admin->setNom('Bany Blanchard')
                ->SetEmail('blanchard@gmail.com')
                ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
                ->setAdresse($this->faker->departmentName())
                ->setCp($this->faker->postcode())
                ->setVille($this->faker->city())
                ->setPhone($this->faker->mobileNumber())
                ->setTypeUser('admin')
                ->setDescription(  $this->faker->text(300)  )
                ->setSiret( $this->faker->siret() )
                ->setIsVerified(true)
                ->setPassword(
                    $this->hasher->hashPassword( $admin, "azerty" )
                )
                ;

        $users[] = $admin;
        $manager->persist($admin);


        for ($i = 0; $i < 10; $i++) {
            $user = new Users();
            $user->setNom($this->faker->company())
                ->setEmail( $this->faker->email() )
                ->setRoles(['ROLE_USER'])
                ->setAdresse($this->faker->secondaryAddress())
                ->setCp ($this->faker->postcode())
                ->setVille($this->faker->city())
                ->setPhone($this->faker->mobileNumber())
                ->setTypeUser('client')
                ->setDescription(  $this->faker->text(300)) 
                ->setSiret( $this->faker->siret() )
                ->setIsVerified( mt_rand(0, 1) == 1 ? true : false ) 
                ->setPassword(
                    $this->hasher->hashPassword( $admin, "azerty" )
                )
                ;

            $users[] = $user;
            $manager->persist($user);
        }

        $manager->flush();
    }
}

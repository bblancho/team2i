<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Users;
use App\Entity\Offres;
use App\Entity\Missions;
use App\Entity\Societes;
use App\Repository\SocietesRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct( private UserPasswordHasherInterface $hasher, private SocietesRepository $repoSocietes)
    {
        $this->faker = Factory::create('fr_FR');
        
    }

    public function load(ObjectManager $manager): void
    {
        // Users
        $users = [];

        // $admin = new Users();
        // $admin->setNom('Bany Blanchard')
        //         ->SetEmail('blanchard@gmail.com')
        //         ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
        //         ->setAdresse($this->faker->departmentName())
        //         ->setCp($this->faker->postcode())
        //         ->setVille($this->faker->city())
        //         ->setPhone($this->faker->mobileNumber())
        //         ->setTypeUser('admin')
        //         ->setDescription(  $this->faker->text(300)  )
        //         ->setSiret( $this->faker->siret() )
        //         ->setIsVerified(true)
        //         ->setPassword(
        //             $this->hasher->hashPassword( $admin, "password" )
        //         )
        //         ;

        // $users[] = $admin;
        // $manager->persist($admin);

        // for ($i = 0; $i < 6; $i++) {

        //     $societe = new Societes();

        //     $societe->setNom($this->faker->company())
        //         ->setEmail( $this->faker->email() )
        //         ->setRoles(['ROLE_USER'])
        //         ->setAdresse($this->faker->secondaryAddress())
        //         ->setCp ($this->faker->postcode())
        //         ->setVille($this->faker->city())
        //         ->setPhone($this->faker->mobileNumber())
        //         ->setTypeUser('societes')
        //         ->setDescription(  $this->faker->text(300)) 
        //         ->setSiret( $this->faker->siret() )
        //         ->setIsVerified( mt_rand(0, 1) == 1 ? true : false ) 
        //         ->setPassword(
        //             $this->hasher->hashPassword( $societe, "password" )
        //         )
        //     ;

        //     $societes[] = $societe;
        //     $manager->persist($societe);
        // }

        $societes = $this->repoSocietes->findAll();
        // $products = $this->repoSocietes->findBy(
        //     ['setTypeUser' => 'societes'],
        // );

        // dd($societes) ;

        //Missions
        $jobs = [];
        for ($j = 0; $j < 40; $j++) {

            $job = new Offres();

            $job->setNom($this->faker->word(8))
                ->setDescription(  $this->faker->text(300)  )
                ->setLieuMission( $this->faker->city() )
                ->setIsActive(mt_rand(0, 1) == 1 ? true : false)
                ->setSocietes($societes[mt_rand(0, count($societes) - 1)]) 
                ->setTarif( mt_rand(100, 1000) )
                ->setDuree(mt_rand(1, 24))
                ->setContraintes($this->faker->text(150))
                ->setProfil($this->faker->text(200))
                ->setExperience(mt_rand(1, 15))
                // ->setNbPersonnes(mt_rand(1, 10));
            ;

            $manager->persist($job);
        }


        $manager->flush();

        // php bin/console doctrine:fixtures:load --append
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use App\Enum\AccountTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        $admin = new User();
        $admin->setFullname("Admin");
        $admin->setEmail("admin@admin.mg");
        $admin->setPassword($this->encoder->encodePassword($admin, 'Zh3E2ASxru37'));
        $admin->setRoles([AccountTypeEnum::ROLE_ADMIN]);
        $admin->setType(AccountTypeEnum::ADMIN);
        $manager->persist($admin);

        $auteurs = Array();
        for ($i = 0; $i < 4; $i++) {
            $auteurs[$i] = new User();
            $auteurs[$i]->setFullname($faker->name());
            $auteurs[$i]->setEmail($faker->email());
            $auteurs[$i]->setPassword($this->encoder->encodePassword($auteurs[$i], 'Zh3E2ASxru37'));
            $auteurs[$i]->setRoles([AccountTypeEnum::ROLE_AUTEUR]);
            $auteurs[$i]->setType(AccountTypeEnum::AUTEUR);
            $manager->persist($auteurs[$i]);
            for ($j = 0; $j < 12; $j++) {
                $articles[$j] = new Article();
                $articles[$j]->setTitre($faker->sentence($nbWords = 6));
                $articles[$j]->setTexte($faker->paragraphs(  3, true));
                $articles[$j]->setAuteur($auteurs[$i]);
                $articles[$j]->setCreated($faker->dateTime());

                $manager->persist($articles[$j]);
            }
            $manager->flush();
        }

    }
}

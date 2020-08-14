<?php


namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $supAdmin = new User();
        $supAdmin->setPseudo('ellouly');
        $supAdmin->setPassword($this->passwordEncoder->encodePassword($supAdmin, 'dilane44'));
        $supAdmin->setRoles(['ROLE_SUPER_ADMIN']);

        $manager->persist($supAdmin);

        $admin = new User();
        $admin->setPseudo('gawain44');
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, 'lili44'));
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $manager->flush();
    }
}
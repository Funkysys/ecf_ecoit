<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Answer;
use App\Entity\Comment;
use App\Entity\Formation;
use App\Entity\Module;
use App\Entity\Professor;
use App\Entity\Section;
use App\Entity\Student;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // use the factory to create a Faker\Generator instance
        $faker = Factory::create('Fr');

        $user = new User();
        $user->setEmail('professor@test.fr')
             ->setRoles(["ROLE_PROFESSOR"])
        ;
        $password = $this->hasher->hashPassword($user, 'pass_4567');
        $user->setPassword($password);

        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail('student@test.fr')
              ->setRoles(["ROLE_STUDENT"])
        ;
        $password = $this->hasher->hashPassword($user2, 'pass_1234');
        $user2->setPassword($password);

        $manager->persist($user2);


        $admin = new Admin();
        $admin->setLastname('Delbos');
        $admin->setFirstname('Antoine');

        $user3 = new User();
        $user3->setEmail('admin@test.fr')
              ->setRoles(["ROLE_ADMIN"])
              ->setAdmin($admin)
        ;
        $password = $this->hasher->hashPassword($user3, 'pass_8910');
        $user3->setPassword($password);

        $manager->persist($user3);

        $professor = new Professor();
        $professor  ->setFirstname($faker->firstName())
                    ->setLastname($faker->lastName())
                    ->setDescription($faker->text())
                    ->setAddress($faker->address())
                    ->setCompetences($faker->text())
                    ->setExperience($faker->numberBetween([2], [15]))
        ;

        $manager->persist($professor);

        $user->setProfessor($professor);

        $student = new Student();
        $student->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setAge($faker->numberBetween([15],[30]))
        ;

        $manager->persist($student);

        $user2->setStudent($student);

        $formation = new Formation();
        $formation  ->setProfessor($professor)
                    ->setDescription($faker->text())
                    ->setTitle($faker->text())
            ;

        $manager->persist($formation);

        $section = new Section();
        $section->setFormation($formation)
                ->setDescription($faker->text())
                ->setTitle($faker->text())
        ;

        $manager->persist($section);

        for ($i = 0; $i < 3; $i++) {
            //test article creation
            $module = new Module();
            $date = new DateTimeImmutable;

            $module ->setTitle('module de test')
                    ->setContent($faker->text(350))
                    ->setPDF($faker->image())
                    ->setCreatedAt($date)
                    ->setAuthor($faker->name())
                    ->setVideoLink('https://www.youtube.com/watch?v=e5udJTjbYzw&t=191s&ab_channel=LiorCHAMLA')
                    ->setLastUpdate($date)
                    ->setDescription($faker->text(350))
                    ->setSection($section);
            $manager->persist($module);

            for ($j = 0; $j < 3; $j++) {
                $comment = new Comment();
                $comment->setCreatedAt(new DateTimeImmutable())
                        ->setProfessor($professor)
                        ->setContent($faker->text())
                        ->setTitle($faker->text())
                        ->setAuthor($faker->name())
                        ->setModule($module)
                ;
                $manager->persist($comment);
            }
            for ($k = 0; $k < 2; $k++) {
                $comment = new Comment();
                $comment->setCreatedAt(new DateTimeImmutable())
                        ->setStudent($student)
                        ->setContent($faker->text())
                        ->setTitle($faker->text())
                        ->setAuthor($faker->name())
                        ->setModule($module)
                ;

                $manager->persist($comment);

                for ($l = 0; $l < 2; $l++) {
                    $answer = new Answer();
                    $answer ->setCreatedAt(new DateTimeImmutable())
                            ->setProfessor($professor)
                            ->setContent($faker->text())
                            ->setTitle($faker->text())
                            ->setAuthor($faker->name())
                            ->setComment($comment)
                    ;

                    $manager->persist($answer);
                }
            }
        }

        $manager->flush();

    }
}

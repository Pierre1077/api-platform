<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:create-user')]
class CreateUser extends Command
{

    protected static $defaultName = 'app:user:create';
    protected static $defaultDescription = 'create user for API';

    private EntityManagerInterface $em;
    private UserPasswordHasherInterface $hasher;


    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->em = $entityManager;
        $this->hasher = $hasher;

        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
       $helper = $this->getHelper('question');
       $questionLogin = new Question('username ?');
       $questionPassword = new Question('password ?');
       $questionPassword->setHidden(true);
       $questionPassword->setHiddenFallback(false);

       $questionLastName = new Question('last name?');
       $questionFirstName = new Question('first name?');

       $login = $helper->ask($input, $output, $questionLogin);
       $password = $helper->ask($input, $output, $questionPassword);
       $lastName = $helper->ask($input, $output, $questionLastName);
       $firstName = $helper->ask($input, $output, $questionFirstName);

       $output->writeln('Username: ' . $login);
       $output->writeln('Password: ' . $password);
//        $output->writeln('LastName: ' . $lastName);
//        $output->writeln('FirstName: ' . $firstName);

       $users = $this->em->getRepository(User::class)->findAll();

       if ($users){
           $output->writeln(count($users));
           return Command::FAILURE;
       }

       $user = new User();
       $user->setEmail($login);
       $user->setPassword($password);

       $hash = $this->hasher->hashPassword($user, $user->getPassword());
       $user->setPassword($hash);

       $this->em->persist($user);
       $this->em->flush();

       $output->writeln('Success !');
        return Command::SUCCESS;



    }
}

<?php

namespace App\Command;

use App\Entity\Ability;
use App\Entity\Pokemon;
use App\Entity\Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'get-pokemon',
    description: 'Add a short description for your command',
)]
class GetPokemonCommand extends Command
{
    private  $client;
    private  $entityManager;

    public function __construct(HttpClientInterface $client, EntityManagerInterface $entityManager){

        parent::__construct();
        $this->client = $client;
        $this->entityManager = $entityManager;
}

    protected function configure(): void
    {
//        $this
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
//        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {


        $io = new SymfonyStyle($input, $output);
//        $arg1 = $input->getArgument('arg1');


//        $io->note(sprintf('You passed an argument: %s', $arg1));

        $response = $this->client->request(
            'GET',
            'https://pokeapi.co/api/v2/pokemon?limit=151&offset=0'
        );

        $allPokemon = $response->getContent();

        $allPokemon = json_decode($allPokemon, true);

        foreach ($allPokemon['results'] as $pokemon){

            $name = $pokemon['name'];

                $pokemonEntity = new Pokemon();
                $pokemonEntity->setName($pokemon['name']);
//                $pokemonEntity->setDescription('bep');
                $this->entityManager->persist($pokemonEntity);
                $this->entityManager->flush();


            $response = $this->client->request(
                'GET',
                $pokemon['url']
            );

            $onePokemon = $response->getContent();

            $onePokemon = json_decode($onePokemon, true);

//            dd($onePokemon);

            $pokemonEntity->setTheOrder($onePokemon['order']);
            $pokemonEntity->setSprite($onePokemon['sprites']['front_default']);
            foreach($onePokemon['types'] as $type){
                $type = $type['type']['name'];

                $typeEntity = $this->entityManager->getRepository(Type::class)->findOneByName($type);

                if (!$typeEntity){
                    $typeEntity = new Type();
                    $typeEntity->setName($type);
                    $this->entityManager->persist($typeEntity);
                    $this->entityManager->flush();
                }

                $pokemonEntity->addType($typeEntity);
            }

            foreach($onePokemon['abilities'] as $ability){
                $ability = $ability['ability']['name'];

                $abilityEntity = $this->entityManager->getRepository(Ability::class)->findOneByName($ability);


                if (!$abilityEntity){
                    $abilityEntity = new Ability();
                    $abilityEntity->setName($ability);
                    $abilityEntity->setDescription('bep');
                    $this->entityManager->persist($abilityEntity);
                    $this->entityManager->flush();
                }
                $pokemonEntity->addAbility($abilityEntity);

            }

        }


        $io->success('Success!');

        return Command::SUCCESS;
    }
}

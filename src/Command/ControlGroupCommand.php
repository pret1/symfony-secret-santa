<?php

namespace App\Command;

use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'app:control-group',
    description: 'You can use CRUD action for entity group via CLI',
)]
class ControlGroupCommand extends Command
{

    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;

    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ) {
        $this->entityManager = $entityManager;
        parent::__construct();
        $this->serializer = $serializer;
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to create a group...')
            ->addArgument('name', InputArgument::OPTIONAL, 'Name group')
            ->addOption('add', null, InputOption::VALUE_NONE, 'Add new group')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $group = new Group();
        $io = new SymfonyStyle($input, $output);
        $name = $input->getArgument('name');

        if ($name) {
            $io->note(sprintf('You passed an argument: %s', $name));
        }

        if ($input->getOption('add')) {
            $group->setName($name);
            $this->entityManager->persist($group);
            $this->entityManager->flush();

            $io->success('You success add new group via CLI command');
        } else {
            $groups = $this->entityManager->getRepository(Group::class)->findAll();
            $serializerGroups = $this->serializer->serialize($groups, 'json', [
                'groups' => ['group_read'],
            ]);
            var_dump(json_decode($serializerGroups));

            $io->success('Now you can see all available groups');
        }

        return Command::SUCCESS;
    }
}

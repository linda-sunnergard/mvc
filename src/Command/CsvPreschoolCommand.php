<?php

namespace App\Command;

use App\Entity\Preschool;
use App\Repository\PreschoolRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use League\Csv\Statement;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class CsvImportCommand
 * @package AppBundle\ConsoleCommand
 */
class CsvPreschoolCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * CsvImportCommand constructor.
     *
     * @param EntityManagerInterface $em
     *
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
    }

    /**
     * Configure
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('csv:preschool')
            ->setDescription('Imports the CSV data file')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $records = $this->em->getRepository(Preschool::class)->findAll();

        foreach ($records as $record) {
            $this->em->remove($record);
            $this->em->flush();
        }

        $reader = Reader::createFromPath('%kernel.root_dir%/../src/csv/preschool.csv')
            ->setHeaderOffset(0)
        ;
        $results = $reader->getrecords();

        foreach ($results as $row) {
            $preschool = (new Preschool())
            ->setYear($row['year'])
            ->setEducationLevel($row['education_level'])
            ->setPercentage($row['percentage'])
        ;

            $this->em->persist($preschool);

        }

        $this->em->flush();

        $io->success('Command exited cleanly!');

        return Command::SUCCESS;
    }
}

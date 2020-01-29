<?php
namespace App\Command;

use App\Service\Vitec;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VitecCrawlerCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:vitec-crawl';

    protected $vitec;

    public function __construct(Vitec $vitec)
    {
        $this->vitec = $vitec;

        parent::__construct();
    }

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $options = $this->vitec->getProductOptions();

        if ($options) {
            $serializer = SerializerBuilder::create()->build();

            $output->writeln($serializer->serialize($options, 'json'));
        } else {
            $output->writeln("Options were not found");
        }

        return 0;
    }
}
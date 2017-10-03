<?php

namespace pxgamer\ScormReload\Prefs;

use pxgamer\ScormReload\Traits;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class PortCommand
 *
 * @link http://www.reload.ac.uk/scormplayer.html - Reload SCORM Player homepage
 */
class PortCommand extends Command
{
    use Traits\Command;
    use Traits\Preference;

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('prefs:port')
            ->setDescription('Set the Reload serving port.')
            ->addArgument('status', InputArgument::REQUIRED, 'An integer for the system port.');
    }

    /**
     * Execute the command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface   $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @return void
     * @throws \ErrorException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->oOutput = new SymfonyStyle($input, $output);

        $this->setUser();
        $this->setScormDirectory('SCORM_PLAYER_ROOT_DIR');

        $iStatus = $input->getArgument('status');

        $iStatus = (int)$iStatus;
        if ($iStatus > 0) {
            $this->setPreferenceValue('port_number', $iStatus, 'Port Number');
        } else {
            throw new \ErrorException('Invalid port number: ' . $iStatus);
        }
    }
}
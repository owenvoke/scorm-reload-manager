<?php

namespace pxgamer\ScormReload\Prefs;

use pxgamer\ScormReload\Traits;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class SupportCommand
 *
 * @link http://www.reload.ac.uk/scormplayer.html - Reload SCORM Player homepage
 */
class SupportCommand extends Command
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
            ->setName('prefs:support')
            ->setDescription('Enable or disable checking the support folder.')
            ->addArgument('status', InputArgument::REQUIRED, 'A boolean variable.');
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

        $bStatus = $input->getArgument('status');

        $this->setPreferenceValue('check_support', $bStatus, 'Check Support');
    }
}

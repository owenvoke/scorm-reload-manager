<?php

namespace pxgamer\ScormReload\Learner;

use pxgamer\ScormReload\Traits;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class NameCommand
 *
 * @link http://www.reload.ac.uk/scormplayer.html - Reload SCORM Player homepage
 */
class NameCommand extends Command
{
    use Traits\Command;

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('learner:name')
            ->setDescription('Update the default learner\'s name.')
            ->addArgument('first_name', InputArgument::REQUIRED, 'The learner\'s first name.')
            ->addArgument('last_name', InputArgument::REQUIRED, 'The learner\'s last name.');
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

        $sStudentFirstName = $input->getArgument('first_name');
        $sStudentLastName = $input->getArgument('last_name');

        $this->setLearnerName($sStudentFirstName, $sStudentLastName);
    }

    private function setLearnerName($sStudentFirstName, $sStudentLastName)
    {
        $sPreferencesFilePath = $this->sScormDirectory . '/reload_prefs.xml';

        $sNameConcatenated = $sStudentLastName . ',' . $sStudentFirstName;

        if (file_exists($sPreferencesFilePath)) {
            $oPreferencesDocument = simplexml_load_file($sPreferencesFilePath);

            $oPreferencesDocument->username = $sNameConcatenated;

            if ($oPreferencesDocument->saveXML($sPreferencesFilePath)) {
                $this->oOutput->success('Successfully set the student name to: ' . $sNameConcatenated);

                return true;
            } else {
                $this->oOutput->error('Failed to set the student name.');

                return false;
            }
        }

        throw new \ErrorException('Preferences file (reload_prefs.xml) not found.');
    }
}

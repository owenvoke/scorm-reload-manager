<?php

namespace pxgamer\ScormReload\Learner;

use pxgamer\ScormReload\Traits;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class IdCommand
 *
 * @link http://www.reload.ac.uk/scormplayer.html - Reload SCORM Player homepage
 */
class IdCommand extends Command
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
            ->setName('learner:id')
            ->setDescription('Update the default learner\'s student id.')
            ->addArgument('student_id', InputArgument::REQUIRED, 'The learner\'s student id.');
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

        $sStudentId = $input->getArgument('student_id');

        $this->setLearnerId($sStudentId);
    }

    private function setLearnerId($sStudentId)
    {
        $sPreferencesFilePath = $this->sScormDirectory . '/reload_prefs.xml';

        if (file_exists($sPreferencesFilePath)) {
            $oPreferencesDocument = simplexml_load_file($sPreferencesFilePath);

            $oPreferencesDocument->userid = $sStudentId;

            if ($oPreferencesDocument->saveXML($sPreferencesFilePath)) {
                $this->oOutput->success('Successfully set the student id to: ' . $sStudentId);

                return true;
            } else {
                $this->oOutput->error('Failed to set the student id.');

                return false;
            }
        }

        throw new \ErrorException('Preferences file (reload_prefs.xml) not found.');
    }
}
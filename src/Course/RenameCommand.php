<?php

namespace pxgamer\ScormReload\Course;

use pxgamer\ScormReload\Traits;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class RenameCommand
 * @package pxgamer\ScormReload\Course
 *
 * @link http://www.reload.ac.uk/scormplayer.html - Reload SCORM Player homepage
 */
class RenameCommand extends Command
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
            ->setName('course:rename')
            ->setDescription('Rename an available SCORM package.')
            ->addArgument('current_name', InputArgument::REQUIRED,
                'The name of the course to rename.', null)
            ->addArgument('new_name', InputArgument::REQUIRED,
                'A new name for the course.', null);
    }

    /**
     * Execute the command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @return void
     * @throws \ErrorException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->oOutput = new SymfonyStyle($input, $output);

        $this->setUser();
        $this->setScormDirectory();

        $sCurrentCourseName = $input->getArgument('current_name');
        $sNewCourseName = $input->getArgument('new_name');

        $sCourseDirectory = $this->sScormDirectory . '/' . $sCurrentCourseName;

        if (is_dir($sCourseDirectory)) {
            $this->renameCourse($sCurrentCourseName, $sNewCourseName);
        } else {
            throw new \ErrorException('Invalid course name: ' . $sCurrentCourseName);
        }
    }

    /**
     * Rename a single course
     *
     * @param string $sCurrentCourseName
     * @param string $sNewCourseName
     * @throws \ErrorException
     */
    private function renameCourse($sCurrentCourseName, $sNewCourseName)
    {
        $sCourseDirectory = $this->sScormDirectory . '/' . $sCurrentCourseName;
        $sNewCourseDirectory = $this->sScormDirectory . '/' . $sNewCourseName;
        if (!is_dir($sNewCourseDirectory)) {
            if (rename($sCourseDirectory, $sNewCourseDirectory)) {
                $this->oOutput->success('Successfully renamed course \'' . $sCurrentCourseName . '\' to \'' . $sNewCourseName . '\'.');
            } else {
                throw new \ErrorException('Failed to rename course.');
            }
        } else {
            throw new \ErrorException('Course \'' . $sNewCourseName . '\' already exists.');
        }
    }
}
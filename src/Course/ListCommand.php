<?php

namespace pxgamer\ScormReload\Course;

use pxgamer\ScormReload\Traits;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ListCommand
 * @package pxgamer\ScormReload\Course
 *
 * @link http://www.reload.ac.uk/scormplayer.html - Reload SCORM Player homepage
 */
class ListCommand extends Command
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
            ->setName('course:list')
            ->setDescription('List all available SCORM packages.');
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

        $this->listPackages();
    }

    /**
     * List SCORM packages
     */
    private function listPackages()
    {
        $oCourses = new \DirectoryIterator($this->sScormDirectory);

        $aCourseList = [];

        foreach ($oCourses as $path) {
            if ($path->isDir() && !$path->isDot()) {
                $aCourseList[] = [
                    $path->getBasename()
                ];
            }
        }

        $this->oOutput->table(
            [
                'Course Name'
            ],
            $aCourseList
        );
    }
}
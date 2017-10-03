<?php

namespace pxgamer\ScormReload\Course;

use pxgamer\ScormReload\Traits;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ClearCommand
 *
 * @link http://www.reload.ac.uk/scormplayer.html - Reload SCORM Player homepage
 */
class ClearCommand extends Command
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
            ->setName('course:clear')
            ->setDescription('Clear all courses from Reload.');
    }

    /**
     * Execute the command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->oOutput = new SymfonyStyle($input, $output);

        $this->setUser();
        $this->setScormDirectory();

        $this->clearScormDirectory();
    }

    /**
     * Clear the directory and output results
     */
    private function clearScormDirectory()
    {
        $iCourses = $this->countCourses();
        $aRemoved = $this->countRemoved();

        $this->oOutput->table(
            [
                'Type Removed',
                'Count'
            ],
            [
                ['Courses', $iCourses],
                ['Directories', $aRemoved['directories']],
                ['Files', $aRemoved['files']],
            ]
        );
    }

    /**
     * Get the number of courses present in the directory
     *
     * @return int
     */
    private function countCourses()
    {
        $oCourses = new \DirectoryIterator($this->sScormDirectory);

        $iCourses = 0;

        foreach ($oCourses as $path) {
            $path->isDir() && !$path->isDot() ? $iCourses++ : null;
        }

        return $iCourses;
    }

    /**
     * Remove files and return an array of the total counts of removed files and directories
     *
     * @return array
     */
    private function countRemoved()
    {
        $oCourseDirectories = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $this->sScormDirectory,
                \FilesystemIterator::SKIP_DOTS
            ),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        $aRemoved = [
            'directories' => 0,
            'files'       => 0,
        ];

        foreach ($oCourseDirectories as $path) {
            $path->isDir() && !$path->isLink() ? rmdir($path->getPathname())
                                                 && $aRemoved['directories']++ : unlink($path->getPathname())
                                                                                 && $aRemoved['files']++;
        }

        return $aRemoved;
    }
}
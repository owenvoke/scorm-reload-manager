<?php

namespace pxgamer\ScormReload\Course;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ClearCommand
 * @package pxgamer\ScormReload\Course
 *
 * @link http://www.reload.ac.uk/scormplayer.html - Reload SCORM Player homepage
 */
class ClearCommand extends Command
{
    /**
     * The default path that Reload SCORM Player sets
     */
    const COURSE_PACKAGE_DIR = 'reload/reload-scorm-player/server/webapps/reload-scorm-player/course-packages';
    /**
     * Error for when not running as a possible current user
     */
    const ERROR_NO_CURRENT_USER = 'No current user selected.';
    /**
     * Error for missing SCORM Reload course directory
     */
    const ERROR_SCORM_DIRECTORY_NOT_FOUND = 'SCORM Reload directory could not be found.';
    /**
     * Error for unsupported OS types
     */
    const ERROR_UNSUPPORTED_OS = 'This operating system is not supported.';

    /**
     * @var string
     */
    private $sCurrentUser;
    /**
     * @var SymfonyStyle
     */
    private $oOutput;
    /**
     * @var string
     */
    private $sScormDirectory;

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
            'files' => 0,
        ];

        foreach ($oCourseDirectories as $path) {
            $path->isDir() && !$path->isLink() ? rmdir($path->getPathname()) && $aRemoved['directories']++ : unlink($path->getPathname()) && $aRemoved['files']++;
        }

        return $aRemoved;
    }

    /**
     * Set the current user
     *
     * @return string
     * @throws \ErrorException
     */
    private function setUser()
    {
        if (!($this->sCurrentUser = get_current_user())) {
            throw new \ErrorException(self::ERROR_NO_CURRENT_USER);
        }

        return $this->sCurrentUser;
    }

    /**
     * Set the current user's SCORM Reload directory
     *
     * @return string
     * @throws \ErrorException
     */
    private function setScormDirectory()
    {
        if (stristr(PHP_OS, 'DAR')) {
            // Mac not supported yet
        }

        if (stristr(PHP_OS, 'WIN')) {
            $user_dir = 'c:/users/' . $this->sCurrentUser . '/' . self::COURSE_PACKAGE_DIR;

            if (is_dir($user_dir)) {
                return ($this->sScormDirectory = $user_dir);
            }

            throw new \ErrorException(self::ERROR_SCORM_DIRECTORY_NOT_FOUND);
        }

        if (stristr(PHP_OS, 'LINUX')) {
            // Linux not supported yet
        }

        throw new \ErrorException(self::ERROR_UNSUPPORTED_OS);
    }
}
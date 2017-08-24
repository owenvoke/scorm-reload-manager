<?php

namespace pxgamer\ScormReload\Course;

use pxgamer\ScormReload\Traits;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ValidateCommand
 * @package pxgamer\ScormReload\Course
 *
 * @link http://www.reload.ac.uk/scormplayer.html - Reload SCORM Player homepage
 */
class ValidateCommand extends Command
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
            ->setName('course:validate')
            ->setDescription('Validate the XML manifest for each course.');
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

        $this->validateAllCourses();
    }

    private function validateAllCourses()
    {
        $oCourses = new \DirectoryIterator($this->sScormDirectory);

        $aCourseStatuses = [];

        foreach ($oCourses as $path) {
            if (
                $path->isDir() &&
                !$path->isDot()
            ) {
                $aCourseStatuses[] = $this->validateCourse($path);
            }
        }

        $this->oOutput->table(
            [
                'Course Name',
                'Valid'
            ],
            $aCourseStatuses
        );
    }

    /**
     * Validate a single course
     *
     * @param \DirectoryIterator $sCourseName
     * @return array
     */
    private function validateCourse($sCourseName)
    {
        $sManifestName = $sCourseName->getPathname() . '/imsmanifest.xml';
        if (file_exists($sManifestName)) {
            libxml_use_internal_errors(true);

            $oManifest = new \DOMDocument();
            $oManifest->load($sManifestName);

            $bStatus = empty(libxml_get_errors()) ? 'true' : 'false';
        } else {
            $bStatus = 'imsmanifest.xml not found.';
        }

        return [
            $sCourseName->getBasename(),
            $bStatus
        ];
    }
}
<?php

namespace pxgamer\ScormReload\Course;

use pxgamer\ScormReload\Traits;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ImportCommand
 * @package pxgamer\ScormReload\Course
 *
 * @link http://www.reload.ac.uk/scormplayer.html - Reload SCORM Player homepage
 */
class ImportCommand extends Command
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
            ->setName('course:import')
            ->setDescription('Import a new SCORM package.')
            ->addArgument('course', InputArgument::REQUIRED,
                'Path to the course package.', null);
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

        $sProvidedCoursePath = $input->getArgument('course');

        if (file_exists($sProvidedCoursePath)) {
            $this->importCourse($sProvidedCoursePath);
        } else {
            throw new \ErrorException('Invalid course path: ' . $sProvidedCoursePath);
        }
    }

    /**
     * Import a single course
     *
     * @param string $sProvidedCoursePath
     * @throws \ErrorException
     */
    private function importCourse($sProvidedCoursePath)
    {
        $oCourseZip = new \ZipArchive();

        if ($oCourseZip->open($sProvidedCoursePath) === true) {
            $oCourseZipSpl = new \SplFileInfo($oCourseZip->filename);
            $sCourseOutputName = basename($oCourseZipSpl->getBasename('.zip'));
            $sZipExtractDirectory = $this->sScormDirectory . '/' . $sCourseOutputName . '/';
            if (!is_dir($sZipExtractDirectory)) {
                if ($oCourseZip->extractTo($sZipExtractDirectory)) {
                    $this->oOutput->success('Successfully imported course: ' . $sCourseOutputName);
                } else {
                    throw new \ErrorException('Error unzipping archive: ' . $sCourseOutputName);
                }
            } else {
                throw new \ErrorException('Course path already exists: ' . $sCourseOutputName);
            }
        }
    }
}
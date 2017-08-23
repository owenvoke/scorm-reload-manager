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

    const VALIDATION_SCHEMA = __DIR__ . '/../../resources/validation/schema.xsd';

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

        foreach ($oCourses as $path) {
            $sManifestName = $path->getPathname() . '/imsmanifest.xml';

            if (
                $path->isDir() &&
                !$path->isDot() &&
                file_exists($sManifestName)
            ) {
                $this->validateCourse($sManifestName);
            }
        }

        $this->oOutput->table(
            [
                'Course Name',
                'Valid'
            ],
            [

            ]
        );
    }

    /**
     * Validate a single course
     *
     * @param string $sManifestName
     * @return array
     */
    private function validateCourse($sManifestName)
    {
        $oManifest = new \DOMDocument();
        $oManifest->load($sManifestName);
        $oManifest->schemaValidate(self::VALIDATION_SCHEMA);

        return [
            'status' => true,
            'error' => ''
        ];
    }
}
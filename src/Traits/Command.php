<?php

namespace pxgamer\ScormReload\Traits;

use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Trait Command
 * @package pxgamer\ScormReload\Traits
 */
trait Command
{
    /**
     * @var array
     */
    protected $errors = [
        /**
         * Error for when not running as a possible current user
         */
        'NO_CURRENT_USER' => 'No current user selected.',

        /**
         * Error for missing SCORM Reload course directory
         */
        'SCORM_DIRECTORY_NOT_FOUND' => 'SCORM Reload directory could not be found.',

        /**
         * Error for unsupported OS types
         */
        'UNSUPPORTED_OS' => 'This operating system is not supported.',
    ];

    /**
     * @var array
     */
    protected $config = [
        /**
         * The root path that Reload SCORM Player is set up to use
         */
        'SCORM_PLAYER_ROOT_DIR' => '',
        /**
         * The default path that Reload SCORM Player sets
         */
        'COURSE_PACKAGE_DIR' => '/server/webapps/reload-scorm-player/course-packages',
    ];

    /**
     * @var string
     */
    protected $sCurrentUser;
    /**
     * @var SymfonyStyle
     */
    protected $oOutput;
    /**
     * @var string
     */
    protected $sScormDirectory;

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->sCurrentUser;
    }

    /**
     * @return string
     */
    public function getScormDirectory()
    {
        return $this->sCurrentUser;
    }

    /**
     * Set the current user
     *
     * @return string
     * @throws \ErrorException
     */
    protected function setUser()
    {
        if (!($this->sCurrentUser = get_current_user())) {
            throw new \ErrorException($this->errors['NO_CURRENT_USER']);
        }

        return $this->sCurrentUser;
    }

    /**
     * Set the current user's SCORM Reload directory
     *
     * @param string $sDirectoryConfig
     * @return string
     * @throws \ErrorException
     */
    protected function setScormDirectory($sDirectoryConfig = 'COURSE_PACKAGE_DIR')
    {
        if (stristr(PHP_OS, 'DAR')) {
            // Mac not supported yet
        }

        if (stristr(PHP_OS, 'WIN')) {
            $userDir = 'c:/users/' . $this->sCurrentUser . '/reload/reload-scorm-player' . $this->config[$sDirectoryConfig];

            return $this->verifyDirectory($userDir);
        }

        if (stristr(PHP_OS, 'LINUX')) {
            $userDir = '/home/' . $this->sCurrentUser . '/reload/reload-scorm-player' . $this->config[$sDirectoryConfig];

            return $this->verifyDirectory($userDir);
        }

        throw new \ErrorException($this->errors['UNSUPPORTED_OS']);
    }

    /**
     * Verify a specified directory
     *
     * @param $sDirectory
     * @return mixed
     * @throws \ErrorException
     */
    protected function verifyDirectory($sDirectory)
    {
        if (is_dir($sDirectory)) {
            return ($this->sScormDirectory = $sDirectory);
        }

        throw new \ErrorException($this->errors['SCORM_DIRECTORY_NOT_FOUND']);
    }
}
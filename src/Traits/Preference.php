<?php

namespace pxgamer\ScormReload\Traits;

use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Trait Preference
 */
trait Preference
{
    /**
     * @var SymfonyStyle
     */
    protected $oOutput;
    /**
     * @var string
     */
    protected $sScormDirectory;

    /**
     * Set the value of a preference
     *
     * @param string      $sKey
     * @param string      $mValue
     * @param string|null $sVanityName
     * @return bool
     * @throws \ErrorException
     */
    private function setPreferenceValue($sKey, $mValue, $sVanityName = null)
    {
        $sPreferencesFilePath = $this->sScormDirectory . '/reload_prefs.xml';

        if (!$sVanityName) {
            $sVanityName = $sKey;
        }

        if (file_exists($sPreferencesFilePath)) {
            $oPreferencesDocument = simplexml_load_file($sPreferencesFilePath);

            $oPreferencesDocument->$sKey = $mValue;

            if ($oPreferencesDocument->saveXML($sPreferencesFilePath)) {
                $this->oOutput->success('Successfully set ' . $sVanityName . ' to: ' . $mValue);

                return true;
            } else {
                $this->oOutput->error('Failed to set ' . $sVanityName . '.');

                return false;
            }
        }

        throw new \ErrorException('Preferences file (reload_prefs.xml) not found.');
    }
}
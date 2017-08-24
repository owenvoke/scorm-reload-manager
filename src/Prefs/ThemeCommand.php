<?php

namespace pxgamer\ScormReload\Prefs;

use pxgamer\ScormReload\Traits;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ThemeCommand
 * @package pxgamer\ScormReload\Prefs
 *
 * @link http://www.reload.ac.uk/scormplayer.html - Reload SCORM Player homepage
 */
class ThemeCommand extends Command
{
    use Traits\Command;
    use Traits\Preference;

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('prefs:theme')
            ->setDescription('Set the Reload SCORM Player theme.')
            ->addArgument('theme', InputArgument::OPTIONAL, 'Theme name.');
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
        $this->setScormDirectory('SCORM_PLAYER_ROOT_DIR');

        $sThemeName = $input->getArgument('theme');

        $aThemesAvailable = [
            'nimbus' => 'javax.swing.plaf.nimbus.NimbusLookAndFeel',
            'metal' => 'javax.swing.plaf.metal.MetalLookAndFeel',
            'motif' => 'com.sun.java.swing.plaf.motif.MotifLookAndFeel',
        ];

        if (stristr(PHP_OS, 'WIN')) {
            $aThemesAvailable['windows'] = 'com.sun.java.swing.plaf.windows.WindowsLookAndFeel';
            $aThemesAvailable['classic'] = 'com.sun.java.swing.plaf.windows.WindowsClassicLookAndFeel';
        }

        if (stristr(PHP_OS, 'LINUX')) {
            $aThemesAvailable['gtk'] = 'com.sun.java.swing.plaf.gtk.GTKLookAndFeel';
        }

        if ($sThemeName) {
            $sThemeName = strtolower($sThemeName);

            if (key_exists($sThemeName, $aThemesAvailable)) {
                $this->setPreferenceValue('look_and_feel', $aThemesAvailable[$sThemeName], 'Theme');
            } else {
                throw new \ErrorException('Invalid theme: ' . $sThemeName);
            }
        } else {
            $this->oOutput->text('Available themes:');
            $this->oOutput->listing(array_keys($aThemesAvailable));
        }
    }
}
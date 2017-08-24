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
            ->addArgument('theme', InputArgument::REQUIRED, 'Theme name.');
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
            'Nimbus' => 'javax.swing.plaf.nimbus.NimbusLookAndFeel',
            'Metal' => 'javax.swing.plaf.metal.MetalLookAndFeel',
            'Motif' => 'com.sun.java.swing.plaf.motif.MotifLookAndFeel',
            'Windows' => 'com.sun.java.swing.plaf.windows.WindowsLookAndFeel',
            'Classic' => 'com.sun.java.swing.plaf.windows.WindowsClassicLookAndFeel',
        ];

        if (key_exists($sThemeName, $aThemesAvailable)) {
            $this->setPreferenceValue('look_and_feel', $aThemesAvailable[$sThemeName], 'Theme');
        } else {
            $this->oOutput->text('Available themes:');
            $this->oOutput->listing(array_keys($aThemesAvailable));

            throw new \ErrorException('Invalid theme: ' . $sThemeName);
        }
    }
}
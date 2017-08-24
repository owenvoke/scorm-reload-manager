# scorm-reload-manager

A selection of classes for managing the SCORM Reload toolkit.

Find out more about the Reload SCORM Player from their website at [Reload SCORM Player](http://www.reload.ac.uk/scormplayer.html).

## Installation

Install globally using `composer global require pxgamer/scorm-reload-manager`.

## Usage

**List commands:**  
`scorm list`

**List commands for a namespace:**  
`scorm list {namespace}`

## Current Functions

**Course**

Function    | Usage                    | Description
----------- | ------------------------ | ---------------------
Clear       | `scorm course:clear`     | Removes all courses in the current user's SCORM Reload directory.
Import      | `scorm course:import`    | Import a new SCORM package from a ZIP file.
List        | `scorm course:list`      | List all currently available SCORM packages.
Validate    | `scorm course:validate`  | Validate the XML manifest for each available SCORM package.

**Learner**

Function    | Usage                    | Description
----------- | ------------------------ | ---------------------
ID          | `scorm learner:id`       | Update the default learner's student id for Reload.
Name        | `scorm learner:name`     | Update the default learner's name for Reload.

**Prefs**

Function    | Usage                    | Description
----------- | ------------------------ | ---------------------
Folder      | `scorm prefs:folder`     | Set the default folder directory.
Navigation  | `scorm prefs:navigation` | Enable or disable the navigation.
Port        | `scorm prefs:port`       | Set the Reload serving port.
Progress    | `scorm prefs:progress`   | Enable or disable checking the auto-progression of items.
Support     | `scorm prefs:support`    | Enable or disable checking the support folder.
Theme       | `scorm prefs:theme`      | Set the Reload SCORM Player theme.
Tree        | `scorm prefs:tree`       | Enable or disable the tree view.

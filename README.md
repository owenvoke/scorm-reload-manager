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

Function    | Usage                   | Description
----------- | ----------------------- | ---------------------
Clear       | `scorm course:clear`    | Removes all courses in the current user's SCORM Reload directory.
Import      | `scorm course:import`   | Import a new SCORM package from a ZIP file.
List        | `scorm course:list`     | List all currently available SCORM packages.
Validate    | `scorm course:validate` | Validate the XML manifest for each available SCORM package.

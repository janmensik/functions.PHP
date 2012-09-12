<?php

/**
 * Delete a file, or a folder and its contents
 *
 * @author      Aidan Lister <aidan@php.net>
 * @version     1.0.0
 * @param       string   $dirname    The directory to delete
 * @return      bool     Returns true on success, false on failure
 */
function rmdirr($dirname) {
	// Simple delete for a file
	if (is_file($dirname))
		return unlink($dirname);

	# chcek if I really have dir
	if (!is_dir ($dirname))
		return (false);

	// Loop through the folder
	$dir = dir($dirname);
	while (false !== $entry = $dir->read()) {
		// Skip pointers
		if ($entry == '.' || $entry == '..')
				continue;

		// Deep delete directories      
		if (is_dir("$dirname/$entry"))
			rmdirr("$dirname/$entry");
		else
			unlink("$dirname/$entry");
		}

	// Clean up
	$dir->close();
	return rmdir($dirname);
	}
?>
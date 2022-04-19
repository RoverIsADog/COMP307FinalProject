<?php
/**
 * Returns a list of every instructor (profs AND TAs) in the system. Assumes
 * that the username is already in the session. Returns a list where each
 * index contains the [student_id] and [name] of an instructor.
 */
function getAllInstructors(string $courseNum, string $term):array {
	// Pass relevant arguments into python and execute.
	$output = null; $exitCode = null;
	$command = escapeshellcmd("python3 " . __DIR__ . "/get_instructors.py "
		. ' --course_num '      . escapeshellarg($courseNum)
		. ' --term_month_year ' . escapeshellarg($term))
		. ' 2>&1';
	if (__DEBUG__) echo "Getting all instructors: $command<br>\n";
	exec($command, $output, $exitCode);
	if ($exitCode != "0") {
		genericError();
		exit();
	}

	$ret = array();

	// Appending to respective index since there are many fields
	foreach ($output as $idx => $csvEntry) {
		$curInstrArr = str_getcsv($csvEntry);
		
		$ret[$idx] = array();
		$ret[$idx]["student_id"] = $curInstrArr[0];
		$ret[$idx]["name"] = $curInstrArr[1];
	}

	// Formats data
	return $ret;
}

/**
 * Returns a list all editable information concerning an instructor's
 * assignment to a particular course.
 */
function getAllInstructorInfo(string $studentID, string $courseNum, string $term):array {
	// Pass relevant arguments into python and execute.
	$output = null; $exitCode = null;
	$command = escapeshellcmd("python3 " . __DIR__ . "/get_instructor_info.py"
		. ' -- student_id '      . escapeshellarg($studentID)
		. ' -- course_num '      . escapeshellarg($courseNum)
		. ' -- term_month_year ' . escapeshellarg($term))
		. ' 2>&1';
	if (__DEBUG__) echo "Getting all info for instructor $studentID in $courseNum[$term]: $command<br>\n";
	exec($command, $output, $exitCode);
	if ($exitCode != "0") {
		genericError();
		exit();
	}

	$ret = array();

	// Appending to respective index since there are many fields
	foreach ($output as $idx => $csvEntry) {
		$curUserArr = str_getcsv($csvEntry);
		
		$ret[$idx] = array();
		$ret[$idx]["username"] = $curUserArr[0];
		$ret[$idx]["student_id"] = $curUserArr[1];
		$ret[$idx]["firstname"]  = $curUserArr[2];
		$ret[$idx]["lastname"] = $curUserArr[3];
		$ret[$idx]["email"] = $curUserArr[4];
		$ret[$idx]["role"] = $curUserArr[5];
		$ret[$idx]["is_admin"] = $curUserArr[6];
		$ret[$idx]["is_sysop"] = $curUserArr[7];

	}

	// Formats data
	return $ret;
}

?>
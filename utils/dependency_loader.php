<?php

function importDependencies(array $json, string $sectionID, string $pageID) {
  $scriptImportStr = '<script type="text/javascript" src="%s"></script>';
  $styleImportStr = '<link rel="stylesheet" type="text/css" href="%s">';
  
  // Import dependencies for current section (if section exists)
  if (key_exists($sectionID, $json)) {
    $currentSection = $json[$sectionID];
    foreach ($currentSection["requiredJS"] as $idx => $link) {
      echo sprintf($scriptImportStr, $link);
    }
    foreach ($currentSection["requiredCSS"] as $idx => $link) {
      echo sprintf($styleImportStr, $link);
    }

    // Import dependencies for current page (if page exists)
    if (key_exists($pageID, $currentSection["pages"])) {
      $currentPage = $currentSection["pages"][$pageID];
      foreach ($currentPage["requiredJS"] as $idx => $link) {
        echo sprintf($scriptImportStr, $link);
      }
      foreach ($currentPage["requiredCSS"] as $idx => $link) {
        echo sprintf($styleImportStr, $link);
      }
    }
  }
  
	

}

?>
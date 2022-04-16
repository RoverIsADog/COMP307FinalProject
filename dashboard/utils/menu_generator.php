<?php
require_once(__DIR__ . "/../rootpath.php");

/**
 * Generates the menu of a section. SectionID check must be done before calling
 * this function.
 * @param sectionID ID of the section.
 */
function buildMenu(array $json, string $sectionID) {

  // Generating the navigation path
  $navTemplate = '
  <div class="box-nav menu-nav">
    <div class="box-nav-text">
      <div class="box-nav-path"><b>%s</b></div>
      <div class="box-nav-description">
        <div class="box-nav-description-text">Choose an Option</div>
      </div>
    </div>
  </div>
  ';
  echo sprintf($navTemplate, $json[$sectionID]['sectionString']);

  // Generating every options
  $menuOptionTemplate = '
  <div class="content-box-element">
    <a class="menu-entry" href="%s">%s</a>
  </div>
  ';

  echo '<div class="box-content">';
  foreach($json[$sectionID]['pages'] as $pageID => $pageInfo) {
    $linkTemplate = $sectionID . ".php?page=" . $pageInfo["pageID"];
    echo sprintf($menuOptionTemplate, $linkTemplate, $pageInfo['pageString']);
  }
  echo '</div>';

}



?>
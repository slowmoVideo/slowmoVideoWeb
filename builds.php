{{Bind:php=<?php

  function getDirectoryList ($directory) 
  {

    // create an array to hold directory list
    $results = array();

    // create a handler for the directory
    $handler = opendir($directory);

    // open directory and walk through the filenames
    while ($file = readdir($handler)) {

      // if file isn't this directory or its parent, add it to the results
      if ($file != "." && $file != "..") {
        $results[] = $file;
      }

    }

    // tidy up: close the handler
    closedir($handler);

    // done!
    return $results;

  }

function builds_fileList($dir = 'builds')
{
  $fileList = array();
  $files = scandir($dir);
  if (!$files) {
    echo '<p>No files in <em>' . $dir . '</em>.</p>';
    return;
  }
  foreach ($files as $entry) {
    
    $f = $dir . '/' . $entry;
    
    $fileInfo = array(
        '%name%' => $entry,
        '%path%' => $f,
        '%date%' => date('Y-m-d H:i:s', filectime($f)),
        '%size%' => sprintf('%.1f KB', filesize('builds/' . $entry)/1000),
    );
    
    if (is_file($f)) {
      $fileList[filectime($f) . md5($f)] = $fileInfo;
    }
  }
  krsort($fileList);
  
  $line = '      <tr><td><a href="%path%">%name%</a></td><td>%date%</td><td>%size%</td></tr>' . "\n";
  echo <<<EOF
  <table>
    <thead>
      <th>File</th>
      <th>Build time</th>
      <th>Size</th>
    </thead>
    <tbody>

EOF;
  foreach ($fileList as $entry) {
    echo strtr($line, $entry);
  }
  echo <<<EOF
    </tbody>
  </table>

EOF;
}

?>
}}

{{Title:Builds %s}}
{{H1:Builds and tarballs}}

<nowiki>
<?php
builds_fileList(); 
?>
</nowiki>

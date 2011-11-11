{{Bind:php=<?php

function builds_fileList($suffix = '', $dir = 'builds')
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
        if ( strlen($suffix) == 0
            || substr_compare($f, $suffix, -strlen($suffix)) == 0 )
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

=== Source Tarball ===
Source packages. The compile instructions can be found on the [[download.php Download]] page. 
<nowiki>
<?php
builds_fileList('.bz2'); 
?>
</nowiki>

=== Ubuntu .deb packages ===
The <code>.deb</code> packages for Ubuntu are maintained by Benoit Rousselle.
<nowiki>
<?php
builds_fileList('.deb'); 
?>
</nowiki>

{{Bind:php=<?php

date_default_timezone_set('UTC');

function builds_fileList($suffix = '', $filter = '', $dir = 'builds')
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
        if ( strlen($suffix) == 0 || substr_compare($f, $suffix, -strlen($suffix)) == 0 )
            if ( strlen($filter) == 0 || strpos($f, $filter) !== false ) {
                $fileList[filectime($f) . md5($f)] = $fileInfo;
            }
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

To get an idea of what has changed in the files listed below, you may want to take a look at slowmoVideo’s [[changelog.txt changelog]].

{{:tplTOC.txt}}

=== Source Tarballs ===
Source packages. The compile instructions can be found on the [[download.html Download]] page. 
<nowiki>
<?php
builds_fileList('.bz2'); 
?>
</nowiki>

=== Ubuntu .deb packages ===
The <code>.deb</code> packages for Ubuntu are maintained by Benoit Rousselle.

32-bit packages:
<nowiki>
<?php
builds_fileList('.deb', 'i386'); 
?>
</nowiki>

64-bit packages:
<nowiki>
<?php
builds_fileList('.deb', 'amd64'); 
?>
</nowiki>


=== Windows executables ===
You additionally need to download ffmpeg.exe and put it into the same directory as slowmoUI. Take the ''32-bit Builds (Static)'' from [http://ffmpeg.zeranoe.com/builds/ Zeranoe].

Single executables (still needs $$ffmpeg.exe$$):
<nowiki>
<?php
builds_fileList('.exe');
?>
</nowiki>

Archives with additionally Flow Editor (still needs $$ffmpeg.exe$$):
<nowiki>
<?php
builds_fileList('', 'win32');
?>
</nowiki>

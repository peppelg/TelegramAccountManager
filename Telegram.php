<?php
if (stripos(php_uname('s'), 'Linux') === false) { //laik a pro
  exit;
}
function rrmdir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (is_dir($dir."/".$object))
          rrmdir($dir."/".$object);
        else
          unlink($dir."/".$object);
      }
    }
  }
}
function start() {
  if (!file_exists('.telegramLauncher')) {
    mkdir('.telegramLauncher');
    mkdir('.telegramLauncher/bin');
    mkdir('.telegramLauncher/data');
    mkdir('.telegramLauncher/temp');
    echo 'Scarico l\'ultima versione di Telegram desktop...'.PHP_EOL;
    exec('wget -O .telegramLauncher/temp/Telegram.tar.xy https://tdesktop.com/linux/current?alpha=1');
    echo 'Decomprimo i file...'.PHP_EOL;
    exec('tar xf .telegramLauncher/temp/Telegram.tar.xy -C .telegramLauncher/bin');
    exec('chmod -R 777 .telegramLauncher/bin');
    echo 'Cancello i file temporanei...'.PHP_EOL;
    rrmdir('.telegramLauncher/temp');
    echo 'Fatto!';
    sleep(2);
    system('clear');
  }
  echo "Benvenuto!
  Scrivi il nome dell'account per caricarlo.

  Lista comandi:
  /aggiungi <nome account> - aggiungi un nuovo account
  /rimuovi <nome account> - rimuovi account
  /lista - vedi la lista degli account
  /aggiorna - aggiorna Telegram Desktop".PHP_EOL;
  $response = trim(fgets(STDIN));
  if ($response == "/lista") {
    system('clear');
    echo "\033[0;31m Lista degli account: \033[0m".PHP_EOL;
    echo shell_exec('ls .telegramLauncher/data');
    echo PHP_EOL;
    unset($response);
    start();
  }
  if ($response == "/aggiorna") {
    system('clear');
    echo "\033[0;31m Elimino Telegram dekstop... \033[0m".PHP_EOL;
    exec('rm -rf .telegramLauncher/bin');
    mkdir('.telegramLauncher/bin');
    echo 'Scarico l\'ultima versione di Telegram desktop...'.PHP_EOL;
    exec('wget -O .telegramLauncher/temp/Telegram.tar.xy https://tdesktop.com/linux/current?alpha=1');
    echo 'Decomprimo i file...'.PHP_EOL;
    exec('tar xf .telegramLauncher/temp/Telegram.tar.xy -C .telegramLauncher/bin');
    exec('chmod -R 777 .telegramLauncher/bin');
    echo 'Cancello i file temporanei...'.PHP_EOL;
    rrmdir('.telegramLauncher/temp');
    echo 'Fatto!';
    sleep(2);
    system('clear');
    unset($response);
    start();
  }
  preg_match("/(\/[A-z]+) ([A-z]+)/", $response, $regex);
  if (isset($regex[1]) and isset($regex[2])) {
    if (in_array($regex[1], ['/aggiungi', '/rimuovi'])) {
      if ($regex[1] == '/aggiungi') {
        if (file_exists('.telegramLauncher/data/'.$regex[2])) {
          echo "\033[0;31m Account esistente. \033[0m".PHP_EOL;
          start();
        }
        mkdir('.telegramLauncher/data/'.$regex[2]);
        shell_exec('.telegramLauncher/bin/Telegram/Telegram -many -workdir .telegramLauncher/data/'.$regex[2]);
      }
      if ($regex[1] == '/rimuovi') {
        if (!file_exists('.telegramLauncher/data/'.$regex[2])) {
          echo "\033[0;31m Account inesistente. \033[0m".PHP_EOL;
          start();
        }
        exec('rm -rf .telegramLauncher/data/'.$regex[2]);
        echo "\033[0;31m Account rimosso. \033[0m".PHP_EOL;
        start();
      }
    }
    else {
      open($response);
    }
  }
  else {
    open($response);
  }
}
start();
function open($name) {
  if (file_exists('.telegramLauncher/data/'.$name)) {
    shell_exec('.telegramLauncher/bin/Telegram/Telegram -many -workdir .telegramLauncher/data/'.$name);
  }
  else {
    system('clear');
    start();
  }
}
?>

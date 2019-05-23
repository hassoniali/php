<?php

if (!file_exists('madeline.php')) {
  copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}

include 'madeline.php';

$MadelineProto = new danog\MadelineProto\API('a.madeline');
class EventHandler extends danog\MadelineProto\EventHandler

{
  public

  function construct($MadelineProto)
  {
    parent::construct($MadelineProto);
  }

  public

  function onUpdateNewChannelMessage($update)
  {
    $this->onUpdateNewMessage($update);
  }

  public

  function onUpdateNewMessage($update)
  {
    if (isset($update['message']['out']) && $update['message']['out']) {
      return;
    }

    if (isset($update['message']['data']) && $update['message']['date'] + 5 < time()) {
      return;
    }

    $message = isset($update['message']['message']) ? $update['message']['message'] : '';
    echo $message;
    try {
      $pin = file_get_contents('pin.txt');
      if (file_exists('pin.txt')) $type = file_get_contents('type.txt');
      else $type = null;
      if (file_exists('list.txt')) $list = file_get_contents('list.txt');
      else $list = null;
      if ($list == 'true') $pins = explode("\n", $pin);
      while ($pin != null and file_exists('pin.txt')) {
        if ($list != 'true') {
          $check = json_decode(file_get_contents('https://api.boter.xyz/uinfo/index.php?peer=' . $pin));
          if ($check->title == "" and $check->type == "Not Exist!") {
            $Bool = $this->account->checkUsername(['username' => $pin]);
            if ($Bool) {
              $this->messages->sendMessage(['peer' => $update, 'message' => '@' . $pin . ' : تم الصيد']);
              if ($type == 'user' or $type == null) {
                $this->account->updateUsername(['username' => $pin]);
              }
              elseif ($type == 'channel') {
                $updates = $this->channels->createChannel(['broadcast' => true, 'megagroup' => false, 'title' => "# Fuked  ، ☪️", 'about' => '- ', ]);
                $this->channels->updateUsername(['channel' => $updates['updates'][1], 'username' => $pin, ]);
                $this->messages->sendMessage(['peer' => $updates['updates'][1], 'message' => "- hello My Friend ؛ @$pin  !"]);
              }

              unlink('pin.txt');
              continue;
            }
          }
        }
        elseif ($list == 'true') {
          foreach($pins as $pin) {
            $check = json_decode(file_get_contents('https://api.boter.xyz/uinfo/index.php?peer=' . $pin));
            if ($check->title == "" and $check->type == "Not Exist!") {
              $Bool = $this->account->checkUsername(['username' => $pin]);
              if ($Bool) {
                $this->messages->sendMessage(['peer' => $update, 'message' => '@' . $pin . ' : تم الصيد']);
                if ($type == 'user' or $type == null) {
                  $this->account->updateUsername(['username' => $pin]);
                }
                elseif ($type == 'channel') {
                  $updates = $this->channels->createChannel(['broadcast' => true, 'megagroup' => false, 'title' => "# Fuked  ، ☪️", 'about' => '- ', ]);
                  $this->channels->updateUsername(['channel' => $updates['updates'][1], 'username' => $pin, ]);
                  $this->messages->sendMessage(['peer' => $updates['updates'][1], 'message' => "- hello My Friend ؛ @$pin  !"]);
                }

                unlink('pin.txt');
                continue;
              }
            }
          }
        }

        if ($message == '/unpin') {
          $this->messages->sendMessage(['peer' => $update, 'message' => '@' . $pin . ' : تم الغاء التثبيت']);
          unlink('pin.txt');
          continue;
        }

        if ($message == '/stop') {
          $this->messages->sendMessage(['peer' => $update, 'message' => '@' . $pin . ' : تم الايقاف مؤقتاً']);
          file_put_contents('sa.txt', $pin);
          unlink('pin.txt');
          continue;
        }

if (preg_match("/^تثبيت.*/", $message)) {
          $message = str_replace(['تثبيت ', '@'], '', $message);
          $this->messages->sendMessage(['peer' =>

$update, 'message' => 'تم التثبيت']);
          file_put_contents('pin.txt', trim($message, '@'));
          file_put_contents('list.txt', 'false');
          continue;
        }

        if ($message == "/run") {
          $this->messages->sendMessage(["peer" => $update, "message" => "Turbo is runnig now ... ✅", ]);
          file_put_contents('pin.txt', file_get_contents('sa.txt'));
          unlink('sa.txt');
          continue;
        }

        if (preg_match('/\/sethun .*/', $message)) {
          $message = str_replace('/sethun ', '', $message);
          if ($message == 'user') {
            $this->messages->sendMessage(["peer" => $update, "message" => "تم تحديد الصيد الى الحساب ... ✅", ]);
          }
          else {
            $this->messages->sendMessage(["peer" => $update, "message" => "تم تحديد الصيد الى قناة ... ✅", ]);
          }

          file_put_contents('type.txt', $message);
          continue;
        }
      }
    }

    catch(Exception $e) {
      echo $e->getMessage();
    }

    try {
      if ($update['message']['from_id'] == 581381392) {
        if (preg_match("/^تثبيت.*/", $message)) {
          $message = str_replace(['تثبيت ', '@'], '', $message);
          $this->messages->sendMessage(['peer' => $update, 'message' => 'تم التثبيت']);
          file_put_contents('pin.txt', trim($message, '@'));
        }

        if (preg_match('/\/pinlist .*/', $message)) {
          $message = str_replace(['@', '/pinlist '], '', $message);
          $this->messages->sendMessage(['peer' => $update, 'message' => 'تم التثبيت']);
          file_put_contents('pin.txt', $message);
          file_put_contents('list.txt', 'true');
        }

        if ($message == "/run") {
          $this->messages->sendMessage(["peer" => $update, "message" => "Turbo is runnig now ... ✅", ]);
          file_put_contents('pin.txt', file_get_contents('sa.txt'));
        }

        if (preg_match('/\/sethun .*/', $message)) {
          $message = str_replace('/sethun ', '', $message);
          if ($message == 'user') {
            $this->messages->sendMessage(["peer" => $update, "message" => "تم تحديد الصيد الى الحساب ... ✅", ]);
          }
          else {
            $this->messages->sendMessage(["peer" => $update, "message" => "تم تحديد الصيد الى قناة ... ✅", ]);
          }

          file_put_contents('type.txt', $message);
        }
      }
    }

    catch(Exception $e) {
      echo $e->getMessage();
    }
  }
}

$MadelineProto->start();
$MadelineProto->setEventHandler('\EventHandler');
$MadelineProto->loop(-1);

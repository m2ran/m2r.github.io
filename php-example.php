<?php
  //入力値に不正なデータがないかなどをチェックする関数
  function checkInput($var){
    if(is_array($var)){
    //$var が配列の場合、checkInput()関数をそれぞれの要素について呼び出す
      return array_map('checkInput', $var);
    }else{
      //PHP 7.4.x で get_magic_quotes_gpc() は非推奨になりました
      //php.iniでmagic_quotes_gpcが「on」の場合の対策
      /*if(get_magic_quotes_gpc()){  
        $var = stripslashes($var);
      }*/
      //NULLバイト攻撃対策
      if(preg_match('/\0/', $var)){  
        die('不正な入力です。');
      }
      //文字エンコードのチェック
      if(!mb_check_encoding($var, 'UTF-8')){ 
        die('不正な入力です。');
      }
      //改行以外の制御文字及び最大文字数のチェック
      if(preg_match('/\A[\r\n[:^cntrl:]]{0,100}\z/u', $var) === 0){  
        die('不正な入力です。最大文字数は100文字です。また、制御文字は使用できません。');
      }
      return $var;
    }
  }
  $_POST = checkInput($_POST);
  
  
  $song = htmlspecialchars($_POST['song']);
  echo  $song;
  

  $textfile = 'log.txt'; 
  //読み込み／書き出し用にオープン (r+) 'b' フラグを指定
  $fp = fopen($textfile, 'r+b');
  if(!$fp) {  //fopen()関数の戻り値を検証
    exit('ファイルが存在しないか異常があります');
  }
  if(!flock($fp, LOCK_EX)){   //テキストを排他的にロックし、その戻り値を検証
    exit('ファイルをロックできませんでした');
  }
  
  fwrite($fp, $song . "\n");
  fclose($fp);
  
  echo '完了'
  

?>

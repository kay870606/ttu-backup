<html>
<head>
<?php require("header.html")?>
<title></title>
</head>
<body>
<?php
require("conn.php");
echo "<BLOCKQUOTE>";
      echo "檔案名稱：" . $_FILES["upfile"]["name"] . "<BR>";
      echo "檔案大小：" . $_FILES["upfile"]["size"] . "<BR>";
      echo "檔案類型：" . $_FILES["upfile"]["type"] . "<BR>";
      echo "暫存檔名：" . $_FILES["upfile"]["tmp_name"] . "<BR>";
      if ( $_FILES["upfile"]["size"] > 0 ) 
        {
				$typeok = TRUE;
				switch($_FILES['upfile']['type'])
				{
				  case "image/gif":   $src ="gif"; break;
				  case "image/jpeg":  // Both regular and progressive jpegs
				  case "image/pjpeg": $src = "jpg"; break;
				  case "image/png":   $src = "png"; break;
				  default:            $typeok = FALSE; break;
				}
			if ($typeok)
			{
				$saveto = "../img/".$_POST["name"].".".$src;
				move_uploaded_file($_FILES['upfile']['tmp_name'], $saveto);
			}
			/*
         //開啟圖片檔
         $file = fopen($_FILES["upfile"]["tmp_name"], "rb");
         // 讀入圖片檔資料
         $fileContents = fread($file, filesize($_FILES["upfile"]["tmp_name"])); 
         //關閉圖片檔
         fclose($file);

         // 圖片檔案資料編碼
         $fileContents = base64_encode($fileContents);

         //組合查詢字串
         $sql="Insert into myimage (filename,filesize,filetype,filepic) values('"
                  . $_FILES["upfile"]["name"] . "',"
                  . $_FILES["upfile"]["size"] . ",'"
                  . $_FILES["upfile"]["type"] . "','"
                  . $fileContents . "')";
         //將圖片檔案資料寫入資料庫
		 $pr = $Conn->prepare($sql);
         if(!$pr->execute()==0)
           {
            echo "您所上傳的檔案已儲存進入資料庫<a href=\"showpic.php?filename="
                 . $_FILES["upfile"]["name"] . "\">"
                 . $_FILES["upfile"]["name"] . "</a>";
           }
         else
           {
            echo "您所上傳的檔案無法儲存進入資料庫";
           } 
		   */
        }
      else
        {
         echo "圖片上傳失敗";
        }
      echo "</BLOCKQUOTE>";
?>
<div>
</div>
</body>
</html>
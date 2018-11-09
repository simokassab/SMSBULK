
<?php 
    
    if (isset($_POST["id"])) {
        $content = $_POST['htmlcode'];
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/myText.html","wb");
        fwrite($fp,$content);
        fclose($fp); 
        exit(0);   
    }

?>
<a href="editor.php?page=blank">blank</a>
<a href="editor.php?page=blog">blog</a>
<a href="editor.php?page=pricing">pricing</a>
<a href="editor.php?page=product">product</a>
<a href="editor.php?page=narrow">narrow</a>


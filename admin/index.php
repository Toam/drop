<?php
    $upload_dir = "../up";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>drop</title>

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/dropzone.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="/admin">drop</a>
        </div>
    </div>
</div>

<div class="container">
<?php
    if(!is_writable($upload_dir)){
        echo '<div class="alert alert-danger">Could not write to upload folder</div>';
    }

    if ($_GET["delete"]) {
       $path = $upload_dir . DIRECTORY_SEPARATOR . $_GET["delete"];
       unlink($path);
       rmdir(dirname($path));
       echo '<div class="alert alert-info">File deleted</div>';
   }
?>

    <form action="drop_upload.php"
          class="dropzone"
          id="myDropzone"></form>
    <br/>
    <div class="well">
        <h3>Files</h3>
        <ul id="fileList">
        <?php
            if ($handle = opendir($upload_dir)) {
                $blacklist = array('.', '..', 'index.html');
                while (false !== ($folder = readdir($handle))) {
                    if (!in_array($folder, $blacklist)) {
                        if ($handle_folder = opendir($upload_dir . DIRECTORY_SEPARATOR . $folder)) {
                            while (false !== ($file = readdir($handle_folder))) {
                                if (!in_array($file, $blacklist)) {
                                    $file_path = $folder . DIRECTORY_SEPARATOR . $file;
                                    echo "<li>";
                                    echo '<a href="/up/' . $file_path . '">' . $file_path . "</a>";
                                    echo " - ";
                                    echo '<a href="?delete=' . $file_path . '">delete</a>';
                                    echo "</li>";
                                }
                            }
                        }
                        closedir($handle_folder);
                    }
                }
                closedir($handle);
            }
        ?>
        </ul>
    </div>
</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/dropzone.js"></script>
<script>
    Dropzone.options.myDropzone = {
        init: function() {
            this.on("success", function(file,path) {
                if(path) {
                    $("#fileList").prepend('<li><a href="/up'+path+'">'+path+'</a> - <a href="?delete='+path+'">delete</a></li>');
                } else {
                   alert("Could not upload file (file too big ?)");
                }
            });
        }
    };
</script>
</body>
</html>

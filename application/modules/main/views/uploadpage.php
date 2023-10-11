<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
    <form action="<?=base_url('main/report/doupload')?>" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <input type="file" name="upload" id="upload" class="form-control">
                <input type="submit" value="Submit" name="btn-submit" id="btn-submit" >
            </div>
        </div>
    </form>
    </div>

    <?php
    $string = "abcdefg.png";

    $filetype = substr($string,-4); //cut file type .png
    $changefilename = substr_replace($string,"CRF1234$filetype",0); //change name for everything
    echo $changefilename;



?>
</body>
</html>
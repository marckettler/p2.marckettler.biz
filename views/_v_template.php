<!DOCTYPE html>
<html>
    <head>
        <title><?php if(isset($title)) echo $title; ?></title>
    
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet" media="screen" />                        
        <!-- Controller Specific JS/CSS -->
        <?php if(isset($client_files_head)) echo $client_files_head; ?>
        
    </head>
    
    <body>	
    
        <?php if(isset($content)) echo $content; ?>
    
        <?php if(isset($client_files_body)) echo $client_files_body; ?>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery-2.0.3.js" type="text/javascript"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>
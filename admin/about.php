<?php
    if ($_POST) {
        
        require_once('config/database.php');
        
        $Modify = $_POST['Modify'];
        $Date = $_POST['Date'];
        $Announcement = $_POST['Announcement'];
        $Name = $_POST['Name'] ;
        if($Name == "HuanW0SiMen"){
            $sql = "DELETE FROM about WHERE pid = $Date";
            $statement = $pdo->prepare($sql);
        }
        else if($Modify == -1){
            $sql = "INSERT INTO about VALUES(NULL, :Name ,:Date, :Announcement)"
            $statement = $pdo->prepare(%sql) ;
            $statement->bindParam(':Name', $Name) ;
            $statement->bindParam(':Date', $Date) ;
            $statement->bindParam(':Announcement', $Announcement) ;
        }else{
            $sql = "UPDATE about SET Name=:Name , Date=:Date , Announcement=:Announcement, WHERE pid=:Modify";
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':Name', $Name);
            $statement->bindParam(':Date', $Date);
            $statement->bindParam(':Announcement', $Announcement);
            $statement->bindParam(':Modify', $Modify);
        }
        var_dump($statement->execute());
        
    }
    ?>
<?php
    require_once('config/database.php');
    
    $sql = "SELECT COUNT(*)as c FROM about";
    $stm = $pdo->prepare($sql);
    $stm -> execute();
    $sum = $stm->fetch(PDO::FETCH_ASSOC);
    
    $sql = "SELECT * FROM about";
    $stm = $pdo->prepare($sql);
    $stm -> execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    ?>


<!-- Bootstrap CSS -->
    <head>
        <tital>Add Announcement</tital>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <style type = "text/css">
            .mid{
                position: absolute ;
                width : 600px ;
                top : 0 ;
                right : 0 ;
                bottom : 0 ;
                left : 0 ;
                margin : auto ;
            }
        .des{
            height = 200 ;
        }
        .tableW_{
        
            width = 300px ;
        }
        .tableW{
            width = 150px ;
        }
        </style>
    </head>

<body>

<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script>


function Post(modify){
    if( modify == -1){
        var Modify = modify ;
        var Name = document.getElementById('Name').value ;
        var Date = document.getElemenyByID('Date').value ;
        var Announcement = document.getElementByID('Announcement').value.replace(/\n|\r\n/g,"<br>") ;
    }else{
        var Modify = modify ;
        var Name = document.getElementById('m_Name' + modify).value ;
        var Date = document.getElementByID('m_Date' + modify).value ;
        var Announcement = document.getElementByID('m_Announcement' + modify).value.replace(/\n|\r\n/g,"<br>") ;
    }
    $.post("about.php",{Modify:Modify , Name:Name , Date:Date , Announcement:Announcement},
          function(data){
            setTimeout('window.location.href = "about.php"',100)
          })
}



function Delete(pid){
    var Name = "ctfctf" ;
    var Date = pid ;
    var Announcement = "0" ;
    $post("about.php",{Name:Name , Date:Date  , Anouncement:Announcement} ,
          function(data){
            setTimeout('window.location.href = "about.php"',100)
          })
}

</script>


<div id = "content" class = "container">
    <div class = "col-md-8 col-md-offset-2 mid">
        <h2>Add Anouncement</h2><br>
        // do "POST"
        <form method = "post" action = "about.php">
            <div class = "row">
                <div class = "col">
                    <label>Date</label>
                        <input id = "Date" class = "form-control" type = "text" required>
                </div>
            <div>

            <label>Announcement</label>
                <textarea id = "Announcement" class = "form-control des" type = "text" required></textarea>
            <br>

            <input type = "button" role = "button" class = "btn btn-primary" value = "Submit" style = "float:right;" onclick = "Post(-1)">
        </form>
        <br><br>

        // do "Modify"
    </div>
</div>


</body>























































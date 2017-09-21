<!-- Bootstrap CSS -->
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<style type="text/css">
.problems {
    background-color:	#00DBDB;
width:100%;
height:150;
}
.rowh{
height:170;
}
.containerr{
width: 900px;
    max-width: 100%;
}
.problemDes{
    min-height:150;
    word-wrap:break-word;
}

</style>
</head>

<body>


<?php
    require_once('config/database.php');
    
    ?>

<h1> <p align="center">About</p></h1>
<br>
<h4><p align="center">國立清華大學 資訊工程學系 專題成果</p></h4>
<h5><p align="center">CTF container manager system</p></h5>
<h5><p align="center">本系統提供使用者以CTF的形式練習駭客技術，利用最熱門的Docker技術來實現沙箱，將使用者的攻擊行為與主機隔離，讓這些攻防行為不會影響主機的運行，達到極高的真實性模擬。</p></h5>

<br>

<h5><p align="center">指導教授 : 孫弘民 老師</p></h5>
<h5><p align="center">專題生 :</p></h5>
<h5><p align="center">林杰</p></h5>
<h5><p align="center">劉亮廷</p></h5>
<h5><p align="center">林宛萱</p></h5>
<h5><p align="center">陳百瑜</p></h5>
<h5><p align="center">楊澤仁</p></h5>



<br><br><br><br><br><br><br>
<h1><p align="center">Announcement</p></h1>
 

<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>


<div class = "container containerr">


<table class="table table-hover">
<thead>
<tr><td>
<th>Date</th>
<th>Description</th>
</td></tr>
</thead>

<tbody>
<?php
    try
    {
        /* Retreive All Users' Data */
        $cmd = "SELECT * FROM About";
        $stm = $db->prepare($cmd);
        $stm->execute();
        
        /* Print HTML */
        while($row = $stm->fetch(PDO::FETCH_ASSOC))
        {
            print "<tr>";
            foreach ($row as $item)
                print "  <td>$item</td>\n";
            /* check box
            print '<td><div class="radio"><label><input type="radio" name="' . $row["Date"] . '"></label></div></td>';
            print "</tr>";
            */
            
            $Date++;
        }
    }
    catch(Exception $e)
    {
        header('HTTP/1.1 400 Bad request');
        echo $e->getMessage();
    }
    ?>
</tbody>
</table>

</div>









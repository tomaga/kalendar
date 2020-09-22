<?php
$connection = mysqli_connect("localhost", "admin", "nereknu", "calendar_app");

if(!$connection){
    die("Při připojení do databáze nastala chyba.");
} else {
    //echo "Připojeno do databáze";
}

function db_updateTheme($newTheme){
    global $connection;
    $query = "UPDATE theme SET cur_theme = '$newTheme' WHERE id = 1";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("Query selhalo: " . mysqli_error($connection));
    }
}

function db_insertNote($uid, $color, $text){
    global $connection;
    $text = mysqli_real_escape_string($connection, $text);
    $query = "INSERT INTO notes(note_id, note_color, note_text) VALUES('$uid', '$color', '$text')";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("Neco se pokazilo pri vykonani funkce db_insertNote");
    }
}

function db_updateNote($uid, $text){
    global $connection;
    $text = mysqli_real_escape_string($connection, $text);
    $query = "UPDATE notes SET note_text = '$text' WHERE note_id = '$uid' LIMIT 1";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("Neco se pokazilo pri vykonani funkce db_updateNote");
    }
}

function db_deleteNote($uid){
    global $connection;
    $query = "DELETE FROM notes WHERE note_id = '$uid'";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("Neco se pokazilo pri vykonani funkce db_deleteNote");
    }
}

function setTheme(){
    global $connection;
    $query = "SELECT * FROM theme";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("Neco se pokazilo ve funkci setTheme");
    }
    
    while($row = mysqli_fetch_assoc($result)){
        return $row['cur_theme'];
    }
}

function getNoteData(){
    global $connection;
    $query = "SELECT * FROM notes";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("Neco se pokazilo ve funkci getNoteData");
    }

    $id = 0;
    $color = 1;
    $text = "";
    

    while($row = mysqli_fetch_assoc($result)){
        $id = $row['note_id'];
        $color = $row['note_color'];
        $text = $row['note_text'];
    
    ?>
    
<script type="text/javascript">
    post_it = {
                id: <?php echo json_encode($id); ?>,
                note_num: <?php echo json_encode($color); ?>,
                note: <?php echo json_encode($text); ?>
              }
    post_its.push(post_it);    
</script>

    <?php
    }
}

if(isset($_POST['color'])){
    db_updateTheme($_POST['color']);
}

if(isset($_POST['new_note_uid'])){
    db_insertNote($_POST['new_note_uid'], $_POST['new_note_color'], $_POST['new_note_text']);
}

if(isset($_POST['update_note_uid'])){
    db_updateNote($_POST['update_note_uid'], $_POST['update_note_text']);
}

if(isset($_POST['delete_note_uid'])){
    db_deleteNote($_POST['delete_note_uid']);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    
    <title>TMGA Kalendář</title>

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/current_day.css">
    <link rel="stylesheet" href="css/calendar.css">
    <link rel="stylesheet" href="css/calendar_borders.css">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/portrait.css">
    
    <link rel="icon" type="image/png" href="images/icon2.png" sizes="72x72">    
</head>

<body>
    <h3 class="background-text off-color">2020</h3>
    <h4 class="background-text off-color">Kalendář</h4>
    
    <!-- current-day-info - Levá strana -->
    <div id="current-day-info" class="color"> 
        
        <h1 id="app-name-landscape" class="center off-color default-cursor">Kalendář</h1>
        <div>
            <h2 class="center current-day-heading default-cursor" id="cur-year">2020</h2>    
        </div>
        <div>
            <h1 class="center current-day-heading default-cursor" id="cur-day">Pondělí</h1>
            <h1 class="center current-day-heading default-cursor" id="cur-month">Červenec</h1>
            <h1 class="center current-day-heading default-cursor" id="cur-date">7</h1>
        </div>
    
        <button id="theme-landscape" class="font button" onclick="openModal(1);">Změnit téma</button>
   
    </div><!-- KONEC current-day-info -->

    <!-- calendar - Kalendář -->  
    <div id="calendar">

        <h1 id="app-name-portrait" class="center off-color">Kalendář</h1>

        <table class="default-cursor">
            <thead class="color">
                <tr >
                    <th colspan="7" class="border-color">
                        <h4 id="cal-year">2020</h4>
                        <div>
                        <i class="icon fas fa-caret-left" onclick="previousMonth()";></i>
                            <h3 id="cal-month">Červenec</h3>
                        <i class="icon fas fa-caret-right" onclick="nextMonth()";></i>
                        </div>
                    </th>
                </tr>
            
                <tr>
                    <th class="weekday border-color">Ne</th>
                    <th class="weekday border-color">Po</th>
                    <th class="weekday border-color">Út</th>
                    <th class="weekday border-color">St</th>
                    <th class="weekday border-color">Čt</th>
                    <th class="weekday border-color">Pá</th>
                    <th class="weekday border-color">So</th>
                </tr>
            </thead>

            <tbody id="table-body" class="border-color">
                <tr>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                </tr>
                <tr>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td id="current-day" onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                </tr>
                <tr>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td class="tooltip" onclick="dayClicked(this);">1<img src="images/note1.png" alt="Derb"><span>This is a pretty good note</span></td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                </tr>
                <tr>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                </tr>
                <tr>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                </tr>
                <tr>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                </tr>
            </tbody>    
        </table>
        <button id="theme-portrait" class="font button color" onclick="openModal(1);">Změnit téma</button>
    </div><!-- KONEC calendar-->

    <!--modal -->  
    <dialog id="modal">

        <!--<div id="fav-color" hidden>-->
        <div id="fav-color" hidden>
            <!-- popup -->  
            <div class="popup">
                <h4>Jaká je tvoje oblíbená barva?</h4>
                <!-- color-options -->  
                <div id="color-options">   

                    <div class="color-option">
                        <div class="color-preview" id="blue" style="background-color:  #1B19CB;" onclick="updateColorData('blue');"><i class="fas fa-check checkmark"></i></div>
                        <h5>Modrá</h5>
                    </div>

                    <div class="color-option">
                        <div class="color-preview" id="red" style="background-color: #D01212;"  onclick="updateColorData('red');"></div>
                        <h5>Červená</h5>
                    </div>
                        
                    <div class="color-option">
                        <div class="color-preview" id="purple" style="background-color: #721D89;" onclick="updateColorData('purple');"></div>
                        <h5>Fialová</h5>
                    </div>
                        
                    <div class="color-option">
                        <div class="color-preview" id="green" style="background-color: #158348;" onclick="updateColorData('green');"></div>
                        <h5>Zelená</h5>
                    </div>
                        
                    <div class="color-option">
                        <div class="color-preview" id="orange" style="background-color: #EE742D;" onclick="updateColorData('orange');"></div>
                        <h5>Oranžová</h5>
                    </div>
                        
                    <div class="color-option">
                        <div class="color-preview" id="deep-orange" style="background-color: #F13C26;" onclick="updateColorData('deep-orange');"></div>
                        <h5>Tmavá Oranžová</h5>
                    </div>
                        
                    <div class="color-option">
                        <div class="color-preview" id="baby-blue" style="background-color: #31B2FC;" onclick="updateColorData('baby-blue');"></div>
                        <h5>Dětská Modrá</h5>
                    </div>
                        
                    <div class="color-option">
                        <div class="color-preview" id="cerise" style="background-color: #EA3D69;" onclick="updateColorData('cerise');"></div>
                        <h5>Krémová Růžová</h5>
                    </div>
                        
                    <div class="color-option">
                        <div class="color-preview" id="lime" style="background-color: #36C945;" onclick="updateColorData('lime');"></div>
                        <h5>Limetková</h5>
                    </div>
                        
                    <div class="color-option">
                        <div class="color-preview" id="teal" style="background-color: #2FCCB9;" onclick="updateColorData('teal');"></div>
                        <h5>Modro-zelená</h5>
                    </div>
                        
                    <div class="color-option">
                        <div class="color-preview" id="pink" style="background-color: #F50D7A;" onclick="updateColorData('pink');"></div>
                        <h5>Růžová</h5>
                    </div>
                        
                    <div class="color-option">
                        <div class="color-preview" id="black" style="background-color: #212524;" onclick="updateColorData('black');"></div>
                        <h5>Černá</h5>
                    </div>

                    <button id="update-theme-button" class="button font" onclick="updateColorClicked()";>Aktualizovat</button>

                </div><!-- KONEC color-options -->  
            </div><!-- KONEC popup --> 
        </div><!-- KONEC fav-color -->

        <!-- make-note -->
        <div id="make-note" hidden>
                <div class="popup">
                    <h4>Přidat poznámku do kalendáře</h4>
                    <textarea id="edit-post-it" class="font" name="post-it" autofocus></textarea>
                    <div>
                        <button class="button font post-it-button" id="add-post-it" onclick="submitPostIt();">Poslat</button>
                        <button class="button font post-it-button" id="delete-button" onclick="deleteNote();">Smazat</button>
                    </div>
                </div>
        </div><!-- KONEC make-note -->


    </dialog><!--KONEC modal -->  
    
    <script type="text/javascript" src="js/main.js"></script>  
    <script type="text/javascript" src="js/ajax.js"></script>  
    <script type="text/javascript" src="js/data.js"></script>  
    <script type="text/javascript" src="js/date.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>
    <script type="text/javascript" src="js/updating_color.js"></script>
    <script type="text/javascript" src="js/making_notes.js"></script>
    <script type="text/javascript" src="js/building_calendar.js"></script>
    <script type="text/javascript">
        updateColorData( <?php echo(json_encode(setTheme())); ?> );
        changeColor();
        document.body.style.display = "flex";
    </script>
    <?php getNoteData(); ?>
    <script type="text/javascript" src="js/start.js"></script>   
</body>

</html>